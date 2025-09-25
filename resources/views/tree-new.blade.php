<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Family Tree</title>
<style>
.circle-tree {
    position: relative;
    width: 900px;
    height: 900px;
    margin: 40px auto;
}
.node {
    position: absolute;
    width: 120px;
    text-align: center;
    transform: translate(-50%, -50%);
    border: 1px solid #000;
    padding: 10px;
    border-radius: 12px;
    background: #fff;
    z-index: 9;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.node img {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    border: 2px solid #4CAF50;
    padding: 4px;
    object-fit: cover;
}
.name { font-weight: bold; margin-top: 6px; font-size: 14px; }
.plus-icon {
    position: absolute;
    top: -10px;
    left: 45%;
    width: 18px;
    height: 18px;
    background: #000;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    z-index: 10;
}
.connector-svg {
    position: absolute;
    top:0; left:0;
    width:100%; height:100%;
    pointer-events:none;
    z-index:1;
}
</style>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>

<h1 style="text-align:center;">Family Tree</h1>

<div class="circle-tree">
    <!-- Root Node -->
    <div class="node center" data-id="{{ $member->id }}">
        @if($member->children()->count() > 0)
            <div class="plus-icon">+</div>
        @endif
        <img src="{{ asset('uploads/'.$member->image) }}" alt="{{ $member->name }}">
        <div class="name">{{ $member->name }}</div>
        <div class="children-container"></div>
    </div>

    <!-- Parents & Spouse -->
    @if($father)
    <div class="node" style="top: calc(50% - 220px); left: 50%;" data-id="{{ $father->id }}">
        @if($father->children()->count() > 0)
            <div class="plus-icon">+</div>
        @endif
        <img src="{{ asset('uploads/'.$father->image) }}" alt="{{ $father->name }}">
        <div class="name">{{ $father->name }}</div>
        <div class="children-container"></div>
    </div>
    @endif

    @if($mother)
    <div class="node" style="top: calc(50% - 220px); left: calc(50% + 140px);" data-id="{{ $mother->id }}">
        @if($mother->children()->count() > 0)
            <div class="plus-icon">+</div>
        @endif
        <img src="{{ asset('uploads/'.$mother->image) }}" alt="{{ $mother->name }}">
        <div class="name">{{ $mother->name }}</div>
        <div class="children-container"></div>
    </div>
    @endif

    @if($spouse)
    <div class="node" style="top: 50%; left: calc(50% + 200px);" data-id="{{ $spouse->id }}">
        @if($spouse->children()->count() > 0)
            <div class="plus-icon">+</div>
        @endif
        <img src="{{ asset('uploads/'.$spouse->image) }}" alt="{{ $spouse->name }}">
        <div class="name">{{ $spouse->name }}</div>
        <div class="children-container"></div>
    </div>
    @endif

    <!-- Children -->
    @foreach($children as $i => $child)
    @php
        $angle = ($i - ($children->count()-1)/2) * 40; 
        $radius = 200;
        $x = $radius * cos(deg2rad($angle));
        $y = $radius * sin(deg2rad($angle));
    @endphp
    <div class="node" style="top: calc(50% + {{ $y }}px); left: calc(50% + {{ $x }}px);" data-id="{{ $child->id }}">
        @if($child->children()->count() > 0)
            <div class="plus-icon">+</div>
        @endif
        <img src="{{ asset('uploads/'.$child->image) }}" alt="{{ $child->name }}">
        <div class="name">{{ $child->name }}</div>
        <div class="children-container"></div>
    </div>
    @endforeach
</div>

<svg class="connector-svg"></svg>

<script>
function drawLine(parentEl, childEl){
    const parentRect = parentEl.getBoundingClientRect();
    const childRect = childEl.getBoundingClientRect();
    const svg = document.querySelector('.connector-svg');
    const svgRect = svg.getBoundingClientRect();

    const x1 = parentRect.left + parentRect.width/2 - svgRect.left;
    const y1 = parentRect.top + parentRect.height/2 - svgRect.top;
    const x2 = childRect.left + childRect.width/2 - svgRect.left;
    const y2 = childRect.top + childRect.height/2 - svgRect.top;

    const line = document.createElementNS("http://www.w3.org/2000/svg","line");
    line.setAttribute("x1",x1);
    line.setAttribute("y1",y1);
    line.setAttribute("x2",x2);
    line.setAttribute("y2",y2);
    line.setAttribute("stroke","#007bff");
    line.setAttribute("stroke-width","2");
    svg.appendChild(line);
}

$(document).ready(function(){
    $('.plus-icon').on('click', function(e){
        e.stopPropagation();
        let icon = $(this);
        let node = icon.closest('.node');
        let container = node.find('.children-container');

        if(container.is(':empty')){
            let memberId = node.data('id');
            $.get('/api/children/' + memberId, function(children){
                let angleStep = 45;
                let radius = 150;
                children.forEach((child, i)=>{
                    let angle = (-children.length/2 + i) * angleStep;
                    let rad = angle * Math.PI/180;
                    let x = radius * Math.cos(rad);
                    let y = radius * Math.sin(rad);

                    let childHtml = $(`
                        <div class="node" data-id="${child.id}" style="top: calc(50% + ${y}px); left: calc(50% + ${x}px);">
                            ${child.has_more ? '<div class="plus-icon">+</div>' : ''}
                            <img src="/uploads/${child.image}" alt="${child.name}">
                            <div class="name">${child.name}</div>
                            <div class="children-container"></div>
                        </div>
                    `);

                    container.append(childHtml);
                    drawLine(node[0], childHtml[0]);
                });

                container.slideDown();
                icon.text('-');

                container.find('.plus-icon').off('click').on('click', function(){ $(this).trigger('click'); });
            });
        } else {
            container.slideToggle();
            icon.text(container.is(':visible') ? '-' : '+');
        }
    });

    // Draw initial lines between root & parents/spouse/children
    $('.node.center').each(function(){
        const root = this;
        $('.node').not(root).each(function(){
            drawLine(root, this);
        });
    });
});
</script>

</body>
</html>
