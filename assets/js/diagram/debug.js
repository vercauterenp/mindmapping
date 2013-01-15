myDiagram.addChangedListener(function (e) {

	var sel = e.diagram.selection;
	var str = "Total nodes: " + e.diagram.nodes.count;
	str += "<p>-----------------------------</p>";
	if (sel.count === 0) {
		str += "Selecting nodes in the main Diagram will display information here.";
		info.innerHTML = str;
		return;
	} else if (sel.count > 1) {
		str += sel.count + " objects selected.";
		info.innerHTML = str;
		return;
	}
  
	str += "<h3>Selected Nodes:</h3>";
	str += "<ul>";
	for (var i=0;i<sel.count;i++) 
	{
		str += "<li><p>Element: " + i + "</p>";
		str += "<p>Figure: " + sel[i].findObject('shape').figure + "</p>";
		str += "<p>Text: " + sel[i].findObject('text').text + "</p></li>";
	}
	str += "</ul>";
	info.innerHTML = str;

});