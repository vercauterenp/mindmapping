function init() {
    // ADD TRANSACTIONS!
    var GO = go.GraphObject.make;  // for conciseness in defining templates

    myDiagram =
    GO(go.Diagram, "myDiagram", // create a Diagram for the DIV HTML element
    {
        initialContentAlignment: go.Spot.Center
    });// position the graph in the middle of the diagram

    // These nodes have text surrounded by a rounded rectangle
    // whose fill color is bound to the node data.
    // The user can drag a node by dragging its TextBlock label.
    // Dragging from the Shape will start drawing a new link.
    myDiagram.nodeTemplate =
    GO(go.Node, go.Panel.Auto,{
        selectionChanged: onSelectionChanged
    },
    GO(go.Shape,
    {
        figure: "RoundedRectangle", 
        name: "shape", 
        fill: "white",
        portId: "", 
        cursor: "pointer", // the Shape is the port, not the whole Node
        // allow all kinds of links from and to this port
        fromLinkable: true, 
        fromLinkableSelfNode: true, 
        fromLinkableDuplicates: true,
        toLinkable: true, 
        toLinkableSelfNode: true, 
        toLinkableDuplicates: true
    },
    new go.Binding("fill", "fill").makeTwoWay()), //2nd parameter was color
        GO(go.TextBlock,
        {
            margin: 10, // make some extra space for the shape around the text
            isMultiline: true, // don't allow newlines in text
            editable: true,
            textAlign: "center",
            name: "text"
        }, // allow in-place editing by user
        new go.Binding("text", "text").makeTwoWay(),
        new go.Binding("scale", "scale").makeTwoWay(),
        new go.Binding("stroke", "stroke").makeTwoWay(),
        new go.Binding("textAlign", "textAlign").makeTwoWay(),
        new go.Binding("font", "font").makeTwoWay()),
        // remember the locations of each node in the node data
        new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify));  // the label shows the node data's text;	

    myDiagram.addChangedListener(function (e){
        var sel = e.diagram.selection;
        
        if(sel.count === 0){
            return;
        } else if (sel.count > 1){
            return;
        } else {
            var elem = sel.first();
            if(elem instanceof go.Link){
                return;
            }
            var shape = elem.findObject("shape");
            var txtblock = elem.findObject("text");
            $("#flat").spectrum({
                color: shape.fill,
                flat: true,
                showInput: true,
                preferredFormat: "name",
                showInitial: true,
            
                move: function(color){
                    //iterate
                    var c = color.toRgb();
                    var r, g, b;
                    r = Math.min(c.r, 255);
                    g = Math.min(c.g, 255);
                    b = Math.min(c.b, 255);
                    shape.fill = color.toHexString();
                    var stroke = (r < 100 && g < 100 && b < 100) ? "white" : "black";
                    txtblock.stroke = stroke;
                    shape.stroke = stroke;
                }
            });
        }        
    });

    myDiagram.nodeTemplate.selectionAdornmentTemplate =
    GO(go.Adornment, go.Panel.Spot,
        GO(go.Panel, go.Panel.Auto,
            // this Adornment has a rectangular blue Shape around the selected node
            GO(go.Shape, {
                figure: "RoundedRectangle", 
                fill: null, 
                stroke: "#0081c2", 
                strokeWidth: 3
            }),
            GO(go.Placeholder)),
        // and this Adornment has a Button to the right of the selected node
        GO(makeStandardButton,
        {
            alignment: go.Spot.Right, 
            alignmentFocus: go.Spot.Left,
            click: addNodeAndLink
        }, // define click behavior for this Button in the Adornment
        GO(go.TextBlock, "+", // the Button content
        {
            font: "bold 10pt sans-serif", 
            stroke: "white", 
            margin: 5
        })));

    myDiagram.linkTemplate =
    GO(go.Link, // the whole link panel
    {
        routing: go.Link.Normal,
        curve: go.Link.Bezier,
        toShortLength: 2,
        name: "link"
    },
    GO(go.Shape, // the link shape
    {
        isPanelMain: true,
        strokeWidth: 1.5
    }),
    GO(go.Shape, // the arrowhead
    {
        toArrow: "standard",
        stroke: null
    }));

    // allow double-click in background to create a new node
    myDiagram.toolManager.clickCreatingTool.archetypeNodeData =
    {
        text: "Node", 
        fill: "white"
    };

    // Create the Diagram's Model:
    var nodeDataArray = [
    {
        key: 1, 
        text: "Edit me!", 
        fill: "SkyBlue"
    },
    ];

    var linkDataArray = [];

    myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);

    // now enable undo/redo, only after setting the Diagram.model
    myDiagram.undoManager.isEnabled = true;
    
}

// Add Node
function addNodeAndLink(e, obj) {
    var adorn = obj.part;
    var diagram = adorn.diagram;
    diagram.startTransaction("Add Node");
    var oldnode = adorn.adornedPart;
    var olddata = oldnode.data;
    
    var pos = oldnode.location.copy();
    pos.x += randomFromInterval();
    pos.y += randomFromInterval();

    var newdata = {
        text: "idea", 
        brush: olddata.brush, 
        loc: pos.x + " " + pos.y
    };
    diagram.model.addNodeData(newdata);
    diagram.model.addLinkData({
        from: olddata.key, 
        to: newdata.key
    });
    diagram.commitTransaction("Add Node");
}

function onSelectionChanged(node) {
    if(!node.isSelected){
        $("#toolbox button").removeClass("active");
    } else {
        $('button[value="'+getAlignment(node)+'"]').addClass("active");
        if(isNodeBold(node)){
            $("#bold").addClass("active");
        }
        if(isNodeItalic(node)){
            $("#italic").addClass("active");
        }
    }
}

function textManipulation(feature){
    var sel = myDiagram.selection;
    if(sel.count === 0){
        return;
    }
    var obj = sel.first();
    switch(feature){
        case "bold":
            toggleTextWeight(obj);
            break;
        case "italic":
            toggleTextItalic(obj);
            break;
        case "bigger":
            changeTextSize(obj, 1.1);
            break;
        case "smaller":
            changeTextSize(obj, 1/1.1);
            break;
        default:
            if(feature === "left" || feature === "center" || feature === "right"){
                setAlignment(obj, feature);
            }
            break;
    }
}

function changeTextSize(node, factor) {
    var tb = node.findObject("text");
    tb.scale *= factor;
}

function setAlignment(node, alignment){
    var tb = node.findObject("text");
    tb.textAlign = alignment;
}

function getAlignment(node){
    var tb = node.findObject("text");
    return tb.textAlign;
}

function isNodeBold(node){
    var tb = node.findObject("text");
    var idx = tb.font.indexOf("bold");
    return idx > -1;
}

function toggleTextWeight(node) {
    var tb = node.findObject("text");
    if (isNodeBold(node)) {
        var idx = tb.font.indexOf("bold");
        tb.font = tb.font.substr(idx + 5);
    } else {
        tb.font = "bold " + tb.font;
    }
}

function isNodeItalic(node){
    var tb = node.findObject("text");
    var idx = tb.font.indexOf("italic");
    return idx > -1;
}

function toggleTextItalic(node) {
    var tb = node.findObject("text");
    if (isNodeItalic(node)) {
        var idx = tb.font.indexOf("italic");
        tb.font = tb.font.substr(idx + 7);
    } else {
        tb.font = "italic " + tb.font;
    }
}

function randomFromInterval()
{
    var r = Math.random() < 0.5 ? -1 : 1;
    var range = Math.floor((Math.random()*100)+35);
    return Math.floor(r * range);
}