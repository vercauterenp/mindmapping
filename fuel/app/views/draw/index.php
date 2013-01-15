<div id="toolbox" class="draggable ui-draggable">
    <div id="toolboxHandle" class="handle"><i class="icon-move icon-white"></i> Toolbox:</div>
    <div class="btn-toolbar">
        <div class="btn-group" id="textAlignment" data-toggle="buttons-radio" style="margin: 0 13px;">
            <button class="btn" type="button" value="left" onclick="textManipulation('left');"><i class="icon-align-left"></i></button>
            <button class="btn" type="button" value="center" onclick="textManipulation('center');"><i class="icon-align-center"></i></button>
            <button class="btn" type="button" value="right" onclick="textManipulation('right');"><i class="icon-align-right"></i></button>
        </div>
        <div class="btn-group" id="textManiupaltion" style="margin: 5px 13px;">
            <button id="bold" class="btn" type="button" onclick="textManipulation('bold');" data-toggle="buttons-checkbox"><i class="icon-bold"></i></button>
            <button id="italic" class="btn" type="button" onclick="textManipulation('italic');" data-toggle="buttons-checkbox"><i class="icon-italic"></i></button>
            <button class="btn" type="button" onclick="textManipulation('bigger');"><i class="icon-plus"></i></button>
            <button class="btn" type="button" onclick="textManipulation('smaller');"><i class="icon-minus"></i></button>
        </div>
    </div>
    <input type="text" id="flat" />
    <script>
        $("#flat").spectrum({
            flat: true,
            showInput: true,
            preferredFormat: "name",
            showInitial: true
        });
    </script>
    <a data-toggle="lightbox" href="#demoLightbox" class="btn btn-block" id="exportPng"><i class="icon-share-alt"></i> Export to PNG</a>
</div>
<div id="myDiagram" style="width:100%; height: 800px; overflow: hidden;"></div>