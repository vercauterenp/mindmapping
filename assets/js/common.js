$(function() {
    $("#toolbox").draggable({
        handle: '#toolboxHandle'
    });
                
    $("#clickme").toggle(function () {
        $(this).parent().parent().parent().animate({
            left:'0px'
        }, {
            queue: false, 
            duration: 500
        });
    }, function () {
        $(this).parent().parent().parent().animate({
            left:'-267px'
        }, {
            queue: false, 
            duration: 500
        });
    });
    
    $("#exportPng").click(function () {
        loadImage(makeImage());
    });
    
    $('#saveIdea').addClass("disabled").attr("disabled", "disabled");
    $('#previewButton').addClass("disabled").attr("disabled", "disabled");
    $('#loadButton').addClass("disabled").attr("disabled", "disabled");
});

function saveAsIdea(){
    var str = myDiagram.model.toJson();
    var title = document.getElementById('ideaTitle').value;
    var description = document.getElementById('ideaDescription').value;
    var img = makeImage();
    $.ajax({
        type : "POST",
        url : "ajax/save_as",
        dataType : "html",
        data: {
            saveData:str,
            saveTitle:title,
            saveDescription:description,
            savePreview:img
        },
        success: function(data){
            $('#saveModal').modal('toggle');
            $('#saveIdea').removeClass("disabled").removeAttr("disabled", "disabled");
            document.getElementById("saveIdea").onclick = function() {
                saveIdea(data);
            }
        } 
    });
}
            
function saveIdea(id){
    var str = myDiagram.model.toJson();
    var description = document.getElementById('ideaDescription').value;
    var img = makeImage();
    $.ajax({
        type : "POST",
        url : "ajax/save",
        data: {
            saveId:id,
            saveData:str,
            saveDescription:description,
            savePreview:img
        },
        success: function(){
            $('#saveModal').modal('toggle');
        } 
    });
}

function loadAllIdeas(){
    $.ajax({
        type : "POST",
        url : "ajax/load_all",
        dataType : "html",
        success: function(data){
            $('#loadModal .modal-body .list').html(data);
            $('#previewButton').addClass("disabled").attr("disabled", "disabled");
            $('#loadButton').addClass("disabled").attr("disabled", "disabled");
            addSelectChange();
            $('#loadModal').modal('toggle');
        } 
    });
}

function loadIdea(){
    var selState = $("input[name='loadOption']:checked").val();
    $.ajax({
        type : "POST",
        url : "ajax/load",
        data : {
            optionval:selState
        },
        dataType : "json",
        success: function(data){
            $('#saveIdea').removeClass("disabled").removeAttr("disabled", "disabled");
            myDiagram.model = go.Model.fromJson(data[1]);
            $('#ideaDescription').val(data[2]);
            $('#loadModal').modal('toggle');
            document.getElementById("saveIdea").onclick = function() {
                saveIdea(data[0]);
            }
        } 
    });
}
            
function addSelectChange(){
    $('#loadOptions').bind('change', function(){
        var selState = $("input[name='loadOption']:checked").val();
        $.ajax({
            type : "POST",
            url : "ajax/load_image",
            data : {
                optionval:selState
            },
            dataType : "text",
            success: function(data){
                loadImage(data);
            }
        });
        $('#previewButton').removeClass("disabled").removeAttr("disabled", "disabled");
        $('#loadButton').removeClass("disabled").removeAttr("disabled", "disabled");
    });
}
            
function makeImage(){
    img = myDiagram.makeImageData({
        type:"image/png"
    });
    return img;
}

function loadImage(img){
    $('.lightbox-content').html("<img width='1300px' height='1000px' src=" + img + " />");
}