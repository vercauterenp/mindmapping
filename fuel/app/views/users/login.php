<div class="container">
    <div class="row-fluid">
        <div class="page-header">
            <h1>Sign In</h1>
            <p>To sign into your account, fill the form below with your account information.</p>
        </div>

        <?php echo Form::open(array('action' => 'users/login', 'class' => 'form-horizontal')); ?>
            <div class="control-group">
                <label class="control-label" for="username">Username</label>
                <div class="controls">
                    <input type="text" id="username" name="username" placeholder="Username">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
            </div>

            <button type="submit" class="btn">Login</button>
        <?php echo Form::close(); ?>
    </div>
</div>