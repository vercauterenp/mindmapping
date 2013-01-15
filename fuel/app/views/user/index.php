<div id="demoLightbox" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class='lightbox-header'>
        <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
    </div>
    <div class='lightbox-content'>
        
    </div>
</div>
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h1>Saved files</h1>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ideas as $idea): ?>
                        <tr>
                            <td><?php echo $idea['title']; ?></td>
                            <td><?php echo Date::forge($idea['created_at'])->format("%m/%d/%Y"); ?></td>
                            <td><?php echo Date::forge($idea['updated_at'])->format("%m/%d/%Y") . " - (" . Date::time_ago($idea['updated_at']) . ")"; ?></td>
                            <td>
                                <a class="btn btn-small btn-info" href="#demoLightbox" onclick="loadImage('<?php echo $idea['preview']; ?>');" data-toggle="lightbox" ><i class="icon-search icon-white"></i></a>
                                <a class="btn btn-small btn-danger" href="delete_file/<?php echo $idea['id'] ?>" onclick="if (! confirm('Confirm delete?')) { return false; }"><i class="icon-remove icon-white"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>