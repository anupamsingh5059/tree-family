<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Family Tree</title>
<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    overflow-y: auto;
}
#header {
    text-align: center;
    padding: 12px;
    font-size: 20px;
    font-weight: bold;
    background: #e54457ff;
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}
#tree-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    width: 100%;
    position: relative;
}
#tree-wrapper {
    position: relative;
    width: 100%;
    min-height: 600px;
}
.tree-member {
    position: absolute;
    text-align: center;
    padding: 10px;
    background: #fff;
    border: 2px solid #007bff;
    border-radius: 12px;
    width: 140px;
    cursor: default;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    z-index: 2;
}
.tree-member:hover { transform: scale(1.05); }
.tree-member img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
.tree-member div { margin-top: 5px; font-size: 14px; font-weight: bold; }
.relation { font-size: 12px; color: #555; }
.view-btn {
    margin-top: 6px;
    background: #007bff;
    color: #fff;
    border: none;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.2s;
}
.view-btn:hover { background: #0056b3; }
svg.connector-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}
.expand-btn {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    background: transparent;
    color: #000;
    border: none;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    font-size: 30px;
    cursor: pointer;
    line-height: 20px;
    text-align: center;
    padding: 0px;
}
</style>
</head>
<body>

<div id="header">Family Tree</div>
<div id="tree-container">
  <div id="tree-wrapper">
    <svg class="connector-svg">
      <defs>
        <marker id="arrow" markerWidth="12" markerHeight="12" refX="10" refY="3" orient="auto" markerUnits="strokeWidth">
          <path d="M0,0 L0,6 L9,3 z" fill="#007bff" />
        </marker>
      </defs>
    </svg>
  </div>
</div>

<script>
const defaultName = "{{ $default_name ?? '' }}";

function getUrlParams() {
    const path = window.location.pathname.split('/');
    const name = path[2] || '';
    const relation = path[3] || 'self';
    return { name, relation };
}

function updateUrl(member) {
    const slug = member.name.toLowerCase().replace(/\s+/g, '-');
    const newUrl = `/tree/${slug}`;
    window.history.pushState({ id: member.id }, '', newUrl);
}

function makeNode(member, left, top, relation, isRoot = false) {
    if (!member) return null;
    const div = document.createElement("div");
    div.className = "tree-member";
    div.id = "member-" + member.id;
    div.style.left = left;
    div.style.top = top;

    div.innerHTML = `
        <img src="${member.image ? '/uploads/' + member.image : 'https://via.placeholder.com/100'}" alt="${member.name}">
        <div>${member.name}</div>
        <span class="relation">${relation}</span>
        ${relation !== "Self" && member.has_more ? `<br><button class="view-btn" onclick="loadTree('${member.name}')">Read More</button>` : ""}
    `;

    if (!isRoot && member.has_more) {
        const btn = document.createElement("button");
        btn.className = "expand-btn";
        btn.innerText = "+";
        btn.onclick = () => loadTree(member.name);
        div.appendChild(btn);
    }

    document.getElementById("tree-wrapper").appendChild(div);
    return div;
}

function connectNodes(fromId, toId, label, startFromTop = false) {
    const from = document.getElementById(fromId).getBoundingClientRect();
    const to = document.getElementById(toId).getBoundingClientRect();
    const wrapper = document.getElementById("tree-wrapper").getBoundingClientRect();

    const x1 = from.left + from.width/2 - wrapper.left;
    const y1 = startFromTop ? from.top - wrapper.top : from.top + from.height/2 - wrapper.top;
    const x2 = to.left + to.width/2 - wrapper.left;
    const y2 = to.top + to.height/2 - wrapper.top;

    const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line.setAttribute("x1", x1);
    line.setAttribute("y1", y1);
    line.setAttribute("x2", x2);
    line.setAttribute("y2", y2);
    line.setAttribute("stroke", "#007bff");
    line.setAttribute("stroke-width", "2");
    line.setAttribute("marker-end", "url(#arrow)");

    const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
    text.setAttribute("x", (x1+x2)/2);
    text.setAttribute("y", (y1+y2)/2 - 8);
    text.setAttribute("fill", "#007bff");
    text.setAttribute("font-size", "12");
    text.setAttribute("text-anchor", "middle");
    text.textContent = label;

    const svg = document.querySelector(".connector-svg");
    svg.appendChild(line);
    svg.appendChild(text);
}

function renderTree(data) {
    const wrapper = document.getElementById("tree-wrapper");
    wrapper.querySelectorAll(".tree-member").forEach(el => el.remove());
    document.querySelector(".connector-svg").innerHTML = `
        <defs>
          <marker id="arrow" markerWidth="12" markerHeight="12" refX="10" refY="3" orient="auto" markerUnits="strokeWidth">
            <path d="M0,0 L0,6 L9,3 z" fill="#007bff" />
          </marker>
        </defs>
    `;

    document.getElementById("header").innerText = "Family Tree of " + data.root.name;
    updateUrl(data.root);

    const root = makeNode(data.root, "45%", "40%", "Self", true);

    if (data.relations.father) {
        const father = makeNode(data.relations.father, "20%", "8%", "Father");
        connectNodes(father.id, root.id, "Father");
    }
    if (data.relations.mother) {
        const mother = makeNode(data.relations.mother, "70%", "8%", "Mother");
        connectNodes(mother.id, root.id, "Mother", true);
    }
    if (data.relations.spouse) {
        const spouse = makeNode(data.relations.spouse, "20%", "40%", "Spouse");
        connectNodes(root.id, spouse.id, "Spouse");
    }
    if (data.relations.siblings && data.relations.siblings.length > 0) {
        let x = 25;
        data.relations.siblings.forEach(sib => {
            const sibNode = makeNode(sib, `${x}%`, "60%", "Sibling");
            connectNodes(root.id, sibNode.id, "Sibling");
            x += 15;
        });
    }
    if (data.relations.children && data.relations.children.length > 0) {
        let x = 35;
        data.relations.children.forEach(child => {
            const childNode = makeNode(child, `${x}%`, "75%", "Child");
            connectNodes(root.id, childNode.id, "Child");
            x += 15;
        });
    }
}

async function loadTree(name, relation = 'self') {
    if(!name) return;
    const slug = name.toLowerCase().replace(/\s+/g, '-');
    try {
        const res = await fetch(`/api/tree/${slug}`);
        if (!res.ok) throw new Error("Failed to load tree data");
        const data = await res.json();
        renderTree(data);
    } catch(err) {
        console.error(err);
        alert("Error loading family tree data!");
    }
}

const urlParams = getUrlParams();
const memberName = urlParams.name || defaultName;
if(memberName) loadTree(memberName, urlParams.relation);

window.addEventListener("resize", () => {
    if(memberName) loadTree(memberName, urlParams.relation);
});
</script>

</body>
</html>
