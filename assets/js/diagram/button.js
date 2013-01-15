function makeStandardButton() {
  var $ = go.GraphObject.make;
  // standard brushes used by "Button"
  var buttonFillNormal = 'dodgerblue';
  var buttonStrokeNormal = 'dodgerblue';

  var buttonFillOver = 'skyblue';
  var buttonStrokeOver = 'dodgerblue';

  var button =
    $(go.Panel, go.Panel.Auto,
      { isActionable: true },  // handle mouse events without involving other tools
      $(go.Shape,  // the border
        {name: 'ButtonBorder',
        figure: 'Border',
        fill: buttonFillNormal,
        stroke: buttonStrokeNormal
      }));

  // There's no GraphObject inside the button shape --
  // it must be added as part of the button definition.
  // This way the button object could be a TextBlock or a Shape or a Picture or whatever.

  // mouse-over behavior
  button.mouseEnter = function(e, obj, prev) {
    var button = obj;
    var diagram = button.diagram;
    var shape = button.elt(0);  // the border Shape
    var brush = button['_buttonFillOver'];
    if (brush === undefined) brush = buttonFillOver;
    button['_buttonFillNormal'] = shape.fill;
    shape.fill = brush;
    brush = button['_buttonStrokeOver'];
    if (brush === undefined) brush = buttonStrokeOver;
    button['_buttonStrokeNormal'] = shape.stroke;
    shape.stroke = brush;
  };
  button.mouseLeave = function(e, obj, next) {
    var button = obj;
    var diagram = button.diagram;
    var shape = button.elt(0);  // the border Shape
    var brush = button['_buttonFillNormal'];
    if (brush === undefined) brush = buttonFillNormal
    shape.fill = brush;
    brush = button['_buttonStrokeNormal'];
    if (brush === undefined) brush = buttonStrokeNormal;
    shape.stroke = brush;
  };
  return button;
}