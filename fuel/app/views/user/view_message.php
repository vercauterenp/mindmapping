<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h1>Message - <?php echo $title; ?></h1>
            <blockquote>
                <p><?php echo $message; ?></p>
                <small>From: '<?php echo $user_name; ?>' at <?php echo Date::forge($created_at)->format("%m/%d/%Y - %H:%M"); ?></small>
            </blockquote>
            <?php echo Html::anchor('user/inbox', 'Back', array('class' => 'btn btn-info')); ?>
        </div>
    </div>
</div>