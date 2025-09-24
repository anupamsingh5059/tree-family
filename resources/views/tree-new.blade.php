<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Family Tree</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      text-align: center;
    }
    h1 { margin: 20px 0; }

    .circle-tree {
      position: relative;
      width: 800px;
      height: 800px;
      margin: auto;
    }

    .node {
      position: absolute;
      width: 110px;
      text-align: center;
      transform: translate(-50%, -50%);
      border: 1px solid #000;
      padding: 10px;
      border-radius: 10px;
      background: #fff;
      z-index: 9;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .node img {
      width: 65px;
      border-radius: 50%;
      border: 2px solid #4CAF50;
      padding: 4px;
      background: white;
    }

    .name {
      font-weight: bold;
      margin-top: 6px;
      font-size: 14px;
    }

    .plus-icon {
      position: absolute;
      bottom: -9px;
      left: 45%;
      width: 20px;
      height: 20px;
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
    }

    .line {
      position: absolute;
      height: 2px;
      background: #999;
      transform-origin: left center;
      z-index: 1;
    }

    .label {
      position: absolute;
      font-size: 13px;
      color: #333;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      white-space: nowrap;
    }
  </style>
</head>
<body>

<h1>Family Tree</h1>
<div class="circle-tree"></div>

<script>
const apiUrl = '/api/tree'; // Laravel API
const defaultSlug = 'me'; // default member slug

// Fetch data from API
async function loadTree(slug = defaultSlug) {
    try {
        const res = await fetch(`${apiUrl}/${slug.toLowerCase()}`);
        if (!res.ok) throw new Error('Failed to load data');
        const data = await res.json();
        renderTree(data);
    } catch(err) {
        console.error(err);
        alert('Error loading family tree!');
    }
}

// Render tree dynamically
function renderTree(data) {
    const container = document.querySelector('.circle-tree');
    container.innerHTML = ''; // clear old nodes

    const centerX = 400, centerY = 400; // center coordinates

    // Center node
    const rootNode = createNode(data.root, centerX, centerY, true);
    container.appendChild(rootNode);

    // Collect all relations in order
    const relations = [
        {key: 'father', nodes: data.relations.father ? [data.relations.father] : []},
        {key: 'mother', nodes: data.relations.mother ? [data.relations.mother] : []},
        {key: 'spouse', nodes: data.relations.spouse ? [data.relations.spouse] : []},
        {key: 'siblings', nodes: data.relations.siblings || []},
        {key: 'children', nodes: data.relations.children || []},
    ];

    const radius = {
        father: 250,
        mother: 250,
        spouse: 250,
        siblings: 200,
        children: 200
    };

    for (const rel of relations) {
        const count = rel.nodes.length;
        if (count === 0) continue;

        const startAngle = -90; // starting angle
        const angleStep = 180 / (count + 1); // spread evenly

        rel.nodes.forEach((node, i) => {
            const angle = startAngle + angleStep*(i+1);
            const {x, y} = polarToCartesian(angle, radius[rel.key]);
            const childNode = createNode(node, centerX + x, centerY + y);
            container.appendChild(childNode);
            createLine(rootNode, childNode, rel.key);
        });
    }
}

// Convert polar to cartesian
function polarToCartesian(angle, radius){
    const rad = angle * (Math.PI/180);
    return {x: radius*Math.cos(rad), y: radius*Math.sin(rad)};
}

// Create a node element
function createNode(member, x, y, isRoot=false){
    const div = document.createElement('div');
    div.className = 'node';
    div.style.left = x + 'px';
    div.style.top = y + 'px';
    div.innerHTML = `
        <img src="${member.image ? '/uploads/'+member.image : 'https://via.placeholder.com/65'}">
        <div class="name">${member.name}</div>
        ${!isRoot && member.has_more ? `<div class="plus-icon" onclick="loadTree('${member.name}')">+</div>` : ''}
    `;
    return div;
}

// Draw line between two nodes
function createLine(fromNode, toNode, labelText=''){
    const line = document.createElement('div');
    line.className = 'line';
    const fromRect = fromNode.getBoundingClientRect();
    const toRect = toNode.getBoundingClientRect();
    const containerRect = document.querySelector('.circle-tree').getBoundingClientRect();

    const x1 = fromRect.left + fromRect.width/2 - containerRect.left;
    const y1 = fromRect.top + fromRect.height/2 - containerRect.top;
    const x2 = toRect.left + toRect.width/2 - containerRect.left;
    const y2 = toRect.top + toRect.height/2 - containerRect.top;

    const dx = x2 - x1;
    const dy = y2 - y1;
    const length = Math.sqrt(dx*dx + dy*dy);
    const angle = Math.atan2(dy, dx) * 180 / Math.PI;

    line.style.width = length + 'px';
    line.style.left = x1 + 'px';
    line.style.top = y1 + 'px';
    line.style.transform = `rotate(${angle}deg)`;

    if(labelText){
        const label = document.createElement('span');
        label.className = 'label';
        label.textContent = labelText;
        line.appendChild(label);
    }

    document.querySelector('.circle-tree').appendChild(line);
}

// Initialize
loadTree();
</script>

</body>
</html>
