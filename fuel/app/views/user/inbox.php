<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <h1>Messages</h1>
            <div class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li><a href="#tab1" data-toggle="tab">New Message</a></li>
                    <li class="active"><a href="#tab2" data-toggle="tab">Inbox</a></li>
                    <li><a href="#tab3" data-toggle="tab">Sent</a></li>
                </ul>
                <div class="tab-content" style="background-color: white; padding: 0 20px;">
                    <div class="tab-pane" id="tab1">
                        <h4>New Message</h4>
                        <?php echo Form::open(array('action' => 'user/send_message', 'class' => 'form-horizontal')); ?>
                        <div class="control-group">
                            <label class="control-label" for="receiver">Receiver</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="receiver" name="receiver" placeholder="Receiver">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="title">Title</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="title" name="title" placeholder="Title">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="message">Message</label>
                            <div class="controls">
                                <textarea rows="6" class="input-xlarge" id="message" name="message" placeholder="Message"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Send</button>
                        <?php echo Form::close(); ?>
                    </div>
                    <div class="tab-pane active" id="tab2">
                        <h4>Inbox</h4>
                        <?php if ($inbox): ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Received</th>
                                        <th>Sender</th>
                                        <th>Title</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inbox as $item): ?>
                                        <tr<?php echo ($item['is_read'] == 0) ? ' class="text-info"': ""; ?>>
                                            <td><?php echo Date::forge($item['created_at'])->format("%m/%d/%Y") . " - (" . Date::time_ago($item['created_at']) . ")"; ?></td>
                                            <td><?php echo $item['user_name']; ?></td>
                                            <td><?php echo ($item['is_read'] == 0) ? '<strong>'.$item['title'].'</strong>': $item['title']; ?></td>
                                            <td>
                                                <a class="btn btn-small btn-info" href="view_message/<?php echo $item['id'] ?>"><i class="icon-search icon-white"></i></a>
                                                <a class="btn btn-small btn-danger" href="delete_file/<?php echo $item['id'] ?>" onclick="if (! confirm('Confirm delete?')) { return false; }"><i class="icon-remove icon-white"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No messages!</p>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <h4>outbox</h4>
                        <?php if ($sent): ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sent</th>
                                        <th>To</th>
                                        <th>Title</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sent as $item): ?>
                                        <tr>
                                            <td><?php echo Date::forge($item['created_at'])->format("%m/%d/%Y") . " - (" . Date::time_ago($item['created_at']) . ")"; ?></td>
                                            <td><?php echo $item['receiver_name']; ?></td>
                                            <td><?php echo $item['title']; ?></td>
                                            <td>
                                                <a class="btn btn-small btn-info" href="view_message/<?php echo $item['id'] ?>"><i class="icon-search icon-white"></i></a>
                                                <a class="btn btn-small btn-danger" href="delete_file/<?php echo $item['id'] ?>" onclick="if (! confirm('Confirm delete?')) { return false; }"><i class="icon-remove icon-white"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No messages!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>