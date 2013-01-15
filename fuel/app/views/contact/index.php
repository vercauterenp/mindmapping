<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h1>Contact</h1>
            <?php echo Form::open(array('action' => 'contact', 'class' => 'form-horizontal')); ?>

            <div class="control-group">
                <label class="control-label" for="category">Category:</label>
                <div class="controls">
                    <?php
                    echo Form::select('category', 'none', array(
                        'none' => 'Please choose:',
                        'bug' => 'Bugs or issues',
                        'feature' => 'Improvements',
                        'other' => 'Other',
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="text" id="email" name="email" class="span5" placeholder="Email">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">Message</label>
                <div class="controls">
                    <?php echo Form::textarea('message', Input::post('message'), array('placeholder' => 'Your message', 'class' => 'span6', 'rows' => 8)); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?php echo Form::submit('submit', 'Send', array('class' => 'btn btn-primary')); ?>
                </div>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>