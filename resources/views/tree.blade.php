<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Responsive Family Tree</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      overflow: hidden;
    }
    #tree-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      width: 100%;
      position: relative;
    }
    #tree-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
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
    .tree-member:hover {
      transform: scale(1.05);
    }
    .tree-member img {
      width: 50%;
      border-radius: 50%;
      object-fit: cover;
    }
    .tree-member div {
      margin-top: 5px;
      font-size: 14px;
      font-weight: bold;
    }
    .relation {
      font-size: 12px;
      color: #555;
    }
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
    .view-btn:hover {
      background: #0056b3;
    }
    svg.connector-svg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 1;
    }
  </style>
</head>
<body>
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
    const rootId = 1;

    function makeNode(member, left, top, relation) {
      if (!member) return null;
      const div = document.createElement("div");
      div.className = "tree-member";
      div.id = "member-" + member.id;
      div.style.left = left;
      div.style.top = top;

      let buttonHtml = "";
      if (relation !== "Self") {   // ✅ root (Self) node pe button nahi aayega
        buttonHtml = `<br><button class="view-btn" onclick="loadTree(${member.id})">View</button>`;
      }

      div.innerHTML = `
        <img src="uploads/${member.image || 'https://via.placeholder.com/100'}" alt="${member.name}">
        <div>${member.name}</div>
        <span class="relation">${relation}</span>
        ${buttonHtml}
      `;

      document.getElementById("tree-wrapper").appendChild(div);
      return div;
    }

    function connectNodes(fromId, toId, label, startFromTop = false) {
      const from = document.getElementById(fromId).getBoundingClientRect();
      const to = document.getElementById(toId).getBoundingClientRect();
      const wrapper = document.getElementById("tree-wrapper").getBoundingClientRect();

      const x1 = from.left + from.width / 2 - wrapper.left;
      const y1 = startFromTop ? from.top - wrapper.top : from.top + from.height / 2 - wrapper.top;
      const x2 = to.left + to.width / 2 - wrapper.left;
      const y2 = to.top + to.height / 2 - wrapper.top;

      // Draw straight line
      const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
      line.setAttribute("x1", x1);
      line.setAttribute("y1", y1);
      line.setAttribute("x2", x2);
      line.setAttribute("y2", y2);
      line.setAttribute("stroke", "#007bff");
      line.setAttribute("stroke-width", "2");
      line.setAttribute("marker-end", "url(#arrow)");

      // Add label above the line
      const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
      const midX = (x1 + x2) / 2;
      const midY = (y1 + y2) / 2 - 8;
      text.setAttribute("x", midX);
      text.setAttribute("y", midY);
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

      // Root node
      const root = makeNode(data.root, "45%", "40%", "Self");

      // Father
      if (data.relations.father) {
        const father = makeNode(data.relations.father, "20%", "15%", "Father");
        connectNodes(father.id, root.id, "Father");
      }

      // Mother
      if (data.relations.mother) {
        const mother = makeNode(data.relations.mother, "70%", "15%", "Mother");
        connectNodes(mother.id, root.id, "Mother", true);
      }

      // Spouse
      if (data.relations.spouse) {
        const spouse = makeNode(data.relations.spouse, "20%", "40%", "Spouse");
        connectNodes(root.id, spouse.id, "Spouse");
      }

      // Siblings
      if (data.relations.siblings) {
        let x = 25;
        data.relations.siblings.forEach(sib => {
          const sibNode = makeNode(sib, `${x}%`, "60%", "Sibling");
          connectNodes(root.id, sibNode.id, "Sibling");
          x += 15;
        });
      }

      // Children
      if (data.relations.children) {
        let x = 35;
        data.relations.children.forEach(child => {
          const childNode = makeNode(child, `${x}%`, "75%", "Child");
          connectNodes(root.id, childNode.id, "Child");
          x += 15;
        });
      }
    }

    async function loadTree(memberId = rootId) {
      try {
        const res = await fetch(`/tree/${memberId}`);
        if (!res.ok) throw new Error("Failed to load tree data");
        const data = await res.json();
        renderTree(data);
      } catch (err) {
        console.error(err);
        alert("Error loading family tree data!");
      }
    }

    loadTree(rootId);
    window.addEventListener("resize", () => loadTree(rootId));
  </script>
</body>
</html>
