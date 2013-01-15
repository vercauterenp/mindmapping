<div class="container">
    <div class="row-fluid">
        <div class="page-header">
            <h1>Create Account</h1>
            <p>To sign up for a new account, fill the form below with your account information.</p>
        </div>

        <?php echo isset($errors) ? $errors : false; ?>
        <?php echo Form::open(array('action' => 'users/signup', 'class' => 'form-horizontal')); ?>

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

        <div class="control-group">
            <label class="control-label" for="email">E-Mail</label>
            <div class="controls">
                <input type="text" id="email" name="email" placeholder="E-Mail">
            </div>
        </div>

        <button type="submit" class="btn">Create Account</button>

        <?php echo Form::close(); ?>
    </div>
</div>