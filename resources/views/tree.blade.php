<!DOCTYPE html>
<html>
<head>
    <title>Family Tree with All Relation Arrows</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body{font-family:Arial;text-align:center;margin:20px;background:#f0f2f5;}
        .tree-wrapper{position:relative;min-height:500px;width:100%;max-width:1200px;margin:auto;}
        .node{
            padding:8px 12px;border-radius:10px;background:#fff;border:2px solid #0d6efd;
            cursor:pointer;display:flex;flex-direction:column;align-items:center;transition:0.3s;
            position:absolute;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.15);
        }
        .node:hover{background:#0d6efd;color:#fff;}
        .relation{font-size:12px;color:#555;margin-top:3px;}
        .node img{width:60px;height:60px;border-radius:50%;margin-bottom:5px;object-fit:cover;}

        /* Node positions */
        #father{top:5%;left:40%;transform:translateX(-50%);}
        #mother{top:5%;left:60%;transform:translateX(-50%);}
        #spouse{left:5%;top:50%;transform:translateY(-50%);}
        #self{left:50%;top:50%;transform:translate(-50%,-50%);}
        #siblings{right:5%;top:50%;transform:translateY(-50%);}
        #children{bottom:5%;left:50%;transform:translateX(-50%); display:flex; justify-content:center; flex-wrap:wrap; gap:15px;}

        /* Connector lines */
        .line{position:absolute;z-index:-1;background:#0d6efd;}
        .line.horizontal{height:2px;}
        .line.vertical{width:2px;}
        .arrow-tip{width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:10px solid #0d6efd;position:absolute;}

        /* Tooltip */
        .tree-member{position:relative;}
        .tree-member .tooltip{
            visibility:hidden;width:100px;background-color:#333;color:#fff;text-align:center;
            border-radius:5px;padding:4px 6px;position:absolute;z-index:10;bottom:125%;left:50%;
            transform:translateX(-50%);opacity:0;transition:opacity 0.3s;font-size:12px;
        }
        .tree-member:hover .tooltip{visibility:visible;opacity:1;}

        @media(max-width:768px){
            #spouse{left:20%;top:40%;}
            #siblings{right:20%;top:40%;}
            #children{bottom:10%;left:50%;}
        }
    </style>
</head>
<body>

<h2>Family Tree with Relation Arrows</h2>
<div class="tree-wrapper" id="tree-wrapper">
    <div class="node" id="father"></div>
    <div class="node" id="mother"></div>
    <div class="node" id="spouse"></div>
    <div class="node" id="self"></div>
    <div class="node" id="siblings"></div>
    <div class="node" id="children"></div>
</div>

<script>
$(document).ready(function(){
    loadTree(1);

    function makeNode(member){
        if(!member) return "";
        const imgSrc = member.image ? member.image : 'https://via.placeholder.com/60';
        return `<div data-id="${member.id}" class="tree-member">
                    <img src="uploads/${imgSrc}" alt="${member.name}">
                    ${member.name}<br>
                    <span class="relation">(${member.relation})</span>
                    <div class="tooltip">${member.relation}</div>
                </div>`;
    }

    function drawElbow(from, to){
        if(!from || !to) return;
        const $from=$(from), $to=$(to);
        const f=$from.offset(), t=$to.offset();
        const x1=f.left+f.width/2, y1=f.top+f.height/2;
        const x2=t.left+t.width/2, y2=t.top+t.height/2;
        const midX = x2;
        const midY = y1;

        $('<div class="line horizontal"></div>').appendTo('#tree-wrapper').css({
            top:y1+'px', left:Math.min(x1, midX)+'px', width:Math.abs(midX-x1)+'px'
        }).hide().fadeIn(300);

        $('<div class="line vertical"></div>').appendTo('#tree-wrapper').css({
            left:midX+'px', top:Math.min(y1, y2)+'px', height:Math.abs(y2-y1)+'px'
        }).hide().fadeIn(300);

        $('<div class="arrow-tip"></div>').appendTo('#tree-wrapper').css({
            top:y2+'px', left:(x2-6)+'px'
        });
    }

    function loadTree(id){
        $("#tree-wrapper").fadeOut(200,function(){
            $(".line,.arrow-tip").remove();

            $.get('/tree/'+id,function(res){
                if(res.error){ alert(res.error); return; }

                $("#father,#mother,#spouse,#self,#siblings,#children").html("");

                $("#self").html(makeNode(res.root)).attr("data-id",res.root.id);
                $("#father").html(makeNode(res.relations.father)).attr("data-id",res.relations.father?.id||"");
                $("#mother").html(makeNode(res.relations.mother)).attr("data-id",res.relations.mother?.id||"");
                $("#spouse").html(makeNode(res.relations.spouse)).attr("data-id",res.relations.spouse?.id||"");

                let sibsHtml="";(res.relations.siblings||[]).forEach(s=>{sibsHtml+=makeNode(s)});
                $("#siblings").html(sibsHtml);

                let chHtml="";(res.relations.children||[]).forEach(c=>{chHtml+=makeNode(c)});
                $("#children").html(chHtml);

                $("#tree-wrapper").fadeIn(200,function(){
                    // Relation arrows between all
                    if(res.relations.father && res.relations.mother) drawElbow("#father","#mother");
                    if(res.relations.father && res.relations.spouse) drawElbow("#father","#spouse");
                    if(res.relations.mother && res.relations.spouse) drawElbow("#mother","#spouse");
                    if(res.relations.father) drawElbow("#father","#self");
                    if(res.relations.mother) drawElbow("#mother","#self");
                    if(res.relations.spouse) drawElbow("#spouse","#self");

                    $('#children div[data-id]').each(function(){ drawElbow("#self",this); });
                    $('#siblings div[data-id]').each(function(){ drawElbow("#self",this); });
                });
            });
        });
    }

    $(document).on("click",".tree-member",function(){
        let id=$(this).data("id");
        if(id) loadTree(id);
    });
});
</script>

</body>
</html>
