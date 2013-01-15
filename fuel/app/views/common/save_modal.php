<div id="saveModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Save Mindmap</h3>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span6" style="border-right: 1px solid darkgray">
                    <p>Would you like to overwrite the current idea?</p>
                </div>
                <div class="span6">
                    <p>Saving a new idea</p>
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" id="ideaTitle" name="ideaTitle" placeholder="Title">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row-fluid">
            <div class="span6">
                <button type="submit" id="saveIdea" onclick="" class="btn btn-primary">Save</button>
            </div>
            <div class="span6">
                <button type="submit" id="saveAsIdea" onclick="saveAsIdea();" class="btn btn-primary">Save As</button>
            </div>
        </div>
    </div>
</div>