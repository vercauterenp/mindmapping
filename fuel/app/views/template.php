<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?php echo $title; ?></title>
        <?php echo Asset::css('bootstrap.css'); ?>
        <?php echo Asset::css('bootstrap-responsive.css'); ?>
        <?php echo Asset::css('bootstrap-lightbox.min.css'); ?>
        <?php echo Asset::css('common.css'); ?>

        <?php echo Asset::js('jquery-1.8.2.min.js'); ?>
        <?php echo Asset::js('jquery-ui-1.9.2.min.js'); ?>
        <?php echo Asset::js('bootstrap.js'); ?>
        <?php echo Asset::js('common.js'); ?>
        <?php echo Asset::js('bootstrap-lightbox.min.js'); ?>
        <?php if (Uri::main() == Uri::base()): ?>
            <?php echo Asset::js('diagram/go.js'); ?>
            <?php echo Asset::js('diagram/button.js'); ?>
            <?php echo Asset::js('diagram/diagram.js'); ?>
            <?php echo Asset::js('diagram/spectrum.js'); ?>
            <?php echo Asset::css('spectrum.css'); ?>
        <?php endif; ?>
    </head>
    <body style="background-color: #E8E8E8;" <?php if (Uri::main() == Uri::base()): ?>onload="init()"<?php endif; ?>>
        <div id="demoLightbox" class="lightbox hide fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class='lightbox-header'>
                <button type="button" class="close" data-dismiss="lightbox" aria-hidden="true">&times;</button>
            </div>
            <div class='lightbox-content'></div>
        </div>
        <?php if (Auth::Check() && Uri::main() == Uri::base()): ?>
            <?php echo $savemodal; ?>
            <?php echo $loadmodal; ?>
            <div id="slideout" class="container">
                <h6 style="margin-left: 25px;"><i class="icon-comment"></i> Idea description</h6>
                <div class="controls">
                    <div class="input-append">
                        <textarea class="span3" rows="17" id="ideaDescription" name="ideaDescription" placeholder="Comment"></textarea>
                        <span class="add-on" id="clickme"><i class="icon-arrow-right"></i></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="navbar navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a href="<?php echo Uri::base(false); ?>" class="brand">Mindmapper</a><div id="loaded"></div>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active"><a href="<?php echo Uri::base(false); ?>">Home</a></li>
                            <?php if (Auth::Check() && Uri::main() == Uri::base()): ?>
                                <li><a href="#saveModal" id="saveIdea" data-toggle="modal">Save</a></li>
                                <li><a href="#" id="loadIdea" onclick="loadAllIdeas();return false;">Load</a></li>
                            <?php endif; ?>
                            <?php if (Agent::is_mobiledevice()): ?>
                                <li><a href="contact">Contact</a></li>
                            <?php endif; ?>
                        </ul>
                        <?php if (Uri::main() == Uri::base() && !Agent::is_mobiledevice()): ?>
                            <div class="nav">
                                <div class="btn-group">
                                    <button class="btn" onclick="myDiagram.commandHandler.increaseZoom()"><i class="icon-zoom-in"></i></button>
                                    <button class="btn" onclick="myDiagram.commandHandler.resetZoom()"><i class="icon-refresh"></i></button>
                                    <button class="btn" onclick="myDiagram.commandHandler.decreaseZoom()"><i class="icon-zoom-out"></i></button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!Auth::Check()): ?>
                            <?php echo Form::open(array('action' => 'users/login', 'method' => 'post', 'class' => 'navbar-form form-inline pull-right')); ?>
                            <div class="btn-group">
                                <button class="login btn btn-primary" type="submit">Sign In</button>
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
                                    <i class="icon-arrow-down icon-white"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><?php echo Html::anchor('users/signup', '<i class="icon-map-marker"></i> Create Account'); ?></li>
                                    <li class="divider"></li>
                                    <li><?php echo Html::anchor('users/forgotpassword', '<i class="icon-refresh"></i> Forgot Password'); ?></li>
                                </ul>
                            </div>
                            <input type="text" placeholder="Username" id="username" name="username" class="span2">
                            <input type="password" placeholder="Password" id="password" name="password" class="span2">
                            <?php echo Form::close(); ?>
                        <?php else: ?>
                            <div class="nav form-inline pull-right">
                                <div class="btn-group">
                                    <button class="login btn btn-primary">Account <strong>(<?php echo Auth::get_screen_name(); ?>)</strong></button>
                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
                                        <i class="icon-arrow-down icon-white"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><?php echo Html::anchor('/user/files', '<i class="icon-list"></i> Files'); ?></li>
                                        <li><?php echo Html::anchor('/user/inbox', '<i class="icon-inbox"></i> Inbox ' . (($new_messages > 0) ? '<span class="label label-warning">' . $new_messages . '</span' : '')); ?></li>
                                        <li class="divider"></li>
                                        <li><?php echo Html::anchor('users/logout', '<i class="icon-off"></i> Logout'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="padding: 0;">
            <?php if (Session::get_flash('success')): ?>
                <div class="row-fluid">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo Session::get_flash('success'); ?>
                    </div>
                </div>
            <?php elseif (Session::get_flash('notice')): ?>
                <div class="row-fluid">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo Session::get_flash('notice'); ?>
                    </div>
                </div>  
            <?php elseif (Session::get_flash('error')): ?>
                <div class="row-fluid">
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo Session::get_flash('error'); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row-fluid">
                <?php echo $content; ?>
            </div>
        </div>
        <?php if (!Agent::is_mobiledevice()): ?>
            <div class="navbar navbar-inverse navbar-fixed-bottom">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <ul class="nav">
                            <li><a href="contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </body>
</html>