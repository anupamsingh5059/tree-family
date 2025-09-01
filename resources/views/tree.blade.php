<!DOCTYPE html>
<html>
<head>
    <title>Responsive Family Tree</title>
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
        #father{top:5%;left:50%;transform:translateX(-50%);}
        #mother{top:5%;left:50%;transform:translateX(-50%) translateY(65px);}
        #spouse{left:5%;top:50%;transform:translateY(-50%);}
        #self{left:50%;top:50%;transform:translate(-50%,-50%);}
        #siblings{right:5%;top:50%;transform:translateY(-50%);}
        #children{bottom:5%;left:50%;transform:translateX(-50%);}

        .line{position:absolute;background:#0d6efd;z-index:-1; height:2px;}

        /* Responsive adjustments */
        @media(max-width:768px){
            #spouse{left:20%;top:40%;}
            #siblings{right:20%;top:40%;}
            #children{bottom:10%;left:50%;}
        }
    </style>
</head>
<body>

<h2>Family Tree</h2>
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
    loadTree(1); // Root = Anupam

    function makeNode(member){
        if(!member) return "";
        const imgSrc = member.image ? member.image : 'https://via.placeholder.com/60';
        return `<div data-id="${member.id}">
                    <img src="uploads/${imgSrc}" alt="${member.name}">
                    ${member.name}<br>
                    <span class="relation">(${member.relation})</span>
                </div>`;
    }

    function drawLine(from, to){
        if(!from || !to) return;
        const $from=$(from), $to=$(to);
        const f=$from.offset(), t=$to.offset();
        const x1=f.left+f.width/2, y1=f.top+f.height/2;
        const x2=t.left+t.width/2, y2=t.top+t.height/2;
        const length=Math.sqrt((x2-x1)**2+(y2-y1)**2);
        const angle=Math.atan2(y2-y1,x2-x1)*180/Math.PI;
        $('<div class="line"></div>').appendTo('#tree-wrapper').css({
            width:length+'px',
            height:'2px',
            top:y1+'px',
            left:x1+'px',
            transform:`rotate(${angle}deg)`,
            transformOrigin:'0 0'
        });
    }

    function loadTree(id){
        $("#tree-wrapper").fadeOut(200,function(){
            $(".line").remove();

            $.get('/tree/'+id,function(res){
                if(res.error){ alert(res.error); return; }

                // Clear nodes
                $("#father,#mother,#spouse,#self,#siblings,#children").html("");

                $("#self").html(makeNode(res.root)).attr("data-id",res.root.id);
                $("#father").html(makeNode(res.relations.father)).attr("data-id",res.relations.father?.id||"");
                $("#mother").html(makeNode(res.relations.mother)).attr("data-id",res.relations.mother?.id||"");
                $("#spouse").html(makeNode(res.relations.spouse)).attr("data-id",res.relations.spouse?.id||"");

                let sibsHtml="";
                (res.relations.siblings||[]).forEach(s=>{sibsHtml+=makeNode(s)});
                $("#siblings").html(sibsHtml);

                let chHtml="";
                (res.relations.children||[]).forEach(c=>{chHtml+=makeNode(c)});
                $("#children").html(chHtml);

                $("#tree-wrapper").fadeIn(200,function(){
                    drawLine("#father","#self");
                    drawLine("#mother","#self");
                    drawLine("#spouse","#self");
                    drawLine("#self","#children");

                    // Sibling connectors
                    $('#siblings div[data-id]').each(function(){
                        drawLine("#self",this);
                    });
                });
            });
        });
    }

    $(document).on("click",".node div[data-id]",function(){
        let id=$(this).data("id");
        if(id) loadTree(id);
    });
});
</script>

</body>
</html>
