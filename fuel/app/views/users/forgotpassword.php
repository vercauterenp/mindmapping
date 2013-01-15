<div class="container">
    <div class="row-fluid">
        <div class="page-header">
            <h1>Forgot Password</h1>
            <p>To reset your password, fill the form below with your account information.</p>
        </div>

        <?php echo Form::open(array('action' => 'users/forgotpassword', 'class' => 'form-horizontal')); ?>

            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="email" id="email" name="email"placeholder="Email">
                </div>
            </div>

            <button type="submit" class="btn">Submit</button>
        <?php echo Form::close(); ?>
    </div>
</div>