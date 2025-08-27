<!DOCTYPE html>
<html>
<head>
    <title>Family Tree</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; text-align: center; }
        .tree-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 40px;
        }
        .level {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin: 20px 0;
        }
        .node {
            padding: 10px 15px;
            background: #fff;
            border: 2px solid #0d6efd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: 0.3s;
            min-width: 140px;
        }
        .node:hover { background: #0d6efd; color: #fff; }
        .connector {
            width: 2px;
            height: 30px;
            background: #0d6efd;
            margin: auto;
        }
        .relation-label {
            font-size: 12px;
            font-weight: bold;
            color: #6c757d;
            display: block;
        }
    </style>
</head>
<body>

<h2>Family Tree</h2>

<div id="tree-wrapper">
    <div class="tree-container">
        <!-- Parents -->
        <div class="level" id="parents"></div>
        <div class="connector" id="p-connector" style="display:none"></div>

        <!-- Root Self -->
        <div class="level">
            <div class="node" id="spouse"></div>
            <div class="node" id="self"></div>
            <div class="node" id="siblings"></div>
        </div>
        <div class="connector" id="c-connector" style="display:none"></div>

        <!-- Children -->
        <div class="level" id="children"></div>
    </div>
</div>

<script>
    var baseUrl = "{{ url('family') }}";

    $(document).ready(function(){
        loadFamily(1); // Root -> Anupam
    });

    function loadFamily(id){
        $("#tree-wrapper").fadeOut(200, function(){
            $.get(baseUrl + "/" + id, function(res){
                if(res.error){
                    alert(res.error);
                    return;
                }

                // Self
                $("#self").html(`<span class='relation-label'>${res.self.relation}</span>${res.self.name}`)
                          .attr("onclick","loadFamily("+res.self.id+")");

                // Parents
                let parentHtml = "";
                if(res.father) parentHtml += `<div class="node" onclick="loadFamily(${res.father.id})"><span class='relation-label'>${res.father.relation}</span>${res.father.name}</div>`;
                if(res.mother) parentHtml += `<div class="node" onclick="loadFamily(${res.mother.id})"><span class='relation-label'>${res.mother.relation}</span>${res.mother.name}</div>`;
                $("#parents").html(parentHtml);
                $("#p-connector").toggle(parentHtml !== "");

                // Spouse
                $("#spouse").html(res.spouse ? `<span class='relation-label'>${res.spouse.relation}</span>${res.spouse.name}` : "")
                            .attr("onclick", res.spouse ? "loadFamily("+res.spouse.id+")" : "");

                // Siblings
                let siblingsHtml = "";
                res.siblings.forEach(s => {
                    siblingsHtml += `<div class="node" onclick="loadFamily(${s.id})"><span class='relation-label'>${s.relation}</span>${s.name}</div>`;
                });
                $("#siblings").html(siblingsHtml);

                // Children
                let childrenHtml = "";
                res.children.forEach(c => {
                    childrenHtml += `<div class="node" onclick="loadFamily(${c.id})"><span class='relation-label'>${c.relation}</span>${c.name}</div>`;
                });
                $("#children").html(childrenHtml);
                $("#c-connector").toggle(childrenHtml !== "");

                $("#tree-wrapper").fadeIn(300);
            });
        });
    }
</script>

</body>
</html>
