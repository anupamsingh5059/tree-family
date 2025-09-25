<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Responsive Family Tree</title>
<style>
body { font-family: Arial,sans-serif; margin:0; padding:0; background:#f8f9fa; }
h1 { text-align:center; margin:20px 0; font-size:20px; }

#tree-wrapper { width:100%; height:90vh; overflow:auto; position:relative; border:1px solid #ccc; background:white; }
#tree-container { position:relative; transform-origin:top left; }

.node {
    position:absolute;
    width:120px;
    text-align:center;
    transform:translate(-50%,-50%);
    border:1px solid #000;
    padding:10px;
    border-radius:12px;
    background:#fff;
    z-index:10;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
}
.node img { width:65px; height:65px; border-radius:50%; border:2px solid #4CAF50; padding:4px; background:white; }
.name { font-weight:bold; margin-top:6px; font-size:14px; }
.btn { display:inline-block; margin-top:4px; padding:4px 10px; font-size:12px; background:#002b80; color:white; border-radius:5px; text-decoration:none; }
.plus-icon {
    position:absolute; top:-10px; left:50%;
    width:18px; height:18px; background:#000; color:#fff;
    font-size:14px; font-weight:bold; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.2);
    transform:translateX(-50%);
}
.line {
    position:absolute;
    height:2px;
    background:#333;
    transform-origin:left center;
}
.line-label {
    position:absolute;
    font-size:13px;
    font-weight:bold;
    color:#333;
    background:#fff;
    padding:2px 5px;
    border-radius:4px;
    white-space:nowrap;
    transform:none !important;
}

@media (max-width:768px){
    .node { width:100px; }
    .node img { width:50px; height:50px; }
    .name { font-size:12px; }
    .btn { font-size:10px; padding:3px 6px; }
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1>Family Tree</h1>
<div id="tree-wrapper">
    <div id="tree-container"></div>
</div>

<script>
$(function(){
    let defaultSlug = "anupam"; // Root member slug

    if(defaultSlug) loadTree(defaultSlug);

    function updateURL(slug){
        if(history.pushState){
            let newUrl = '/tree/' + slug;
            window.history.pushState({path:newUrl},'',newUrl);
        }
    }

    function loadTree(slug){
        $.getJSON("/api/tree/"+slug,function(data){
            renderTree(data);
            updateURL(slug);
            scaleTree();
        });
    }

    function renderTree(data){
        const container = $("#tree-container");
        container.empty();

        $("h1").text("Family Tree of " + data.root.name);

        const width = $("#tree-wrapper").width();
        const height = $("#tree-wrapper").height();
        const centerX = width/2;
        const centerY = height/2;

        function createNode(member, x, y, parentNode=null, relationLabel=""){
            if(!member) return null;

            let hasRelations = (member.has_more || (member.children && member.children.length>0));

            let html = `<div class="node" style="left:${x}px; top:${y}px;" data-slug="${member.slug}">
                ${hasRelations?'<div class="plus-icon">+</div>':''}
                <img src="/uploads/${member.image}">
                <div class="name">${member.name}</div>
                ${hasRelations?'<a href="#" class="btn">more</a>':''}
            </div>`;

            const node = $(html);
            container.append(node);

            if(parentNode && relationLabel){
                drawLine(parentNode, node, relationLabel);
            }

            node.find(".btn, .plus-icon").click(function(e){
                e.preventDefault();
                if(member.slug) loadTree(member.slug);
            });

            return node;
        }

        const rootNode = createNode(data.root, centerX, centerY);
        const rel = data.relations;

        if(rel.father) createNode(rel.father, centerX - 250, centerY - 250, rootNode, "Father");
        if(rel.mother) createNode(rel.mother, centerX + 250, centerY - 250, rootNode, "Mother");
        if(rel.spouse) createNode(rel.spouse, centerX - 300, centerY, rootNode, "Spouse");

        if(rel.children && rel.children.length > 0){
            const step = 220;
            const verticalGap = 250;
            rel.children.forEach((child,i)=>{
                const offsetX = (i - (rel.children.length-1)/2) * step;
                const offsetY = centerY + verticalGap;
                createNode(child, centerX + offsetX, offsetY, rootNode, "Child");
            });
        }
    }

    function drawLine(fromNode,toNode,relation){
        const f = fromNode[0].getBoundingClientRect();
        const t = toNode[0].getBoundingClientRect();
        const container = $("#tree-container")[0].getBoundingClientRect();

        const x1 = f.left + f.width/2 - container.left;
        const y1 = f.top + f.height/2 - container.top;
        const x2 = t.left + t.width/2 - container.left;
        const y2 = t.top + t.height/2 - container.top;

        const length = Math.sqrt((x2-x1)**2 + (y2-y1)**2);
        const angle = Math.atan2(y2-y1, x2-x1) * 180/Math.PI;

        const line = $(`<div class="line" style="width:${length}px; top:${y1}px; left:${x1}px; transform: rotate(${angle}deg);"></div>`);
        $("#tree-container").append(line);

        const midX = (x1 + x2) / 2;
        const midY = (y1 + y2) / 2;

        const label = $(`<div class="line-label">${relation}</div>`);
        label.css({ left: midX, top: midY - 20 });
        $("#tree-container").append(label);
    }

    function scaleTree(){
        const wrapper = $("#tree-wrapper");
        const container = $("#tree-container");
        const wScale = wrapper.width() / container.width();
        const hScale = wrapper.height() / container.height();
        const scale = Math.min(wScale, hScale, 1);
        container.css("transform","scale("+scale+")");
    }

    $(window).on("resize", scaleTree);
});
</script>
</body>
</html>
