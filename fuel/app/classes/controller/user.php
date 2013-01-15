<?php

class Controller_User extends Controller_Common {

    public function before() {
        parent::before();

        if (!Auth::check()) {
            Session::set_flash('error', 'You need to be logged in to view this page.');
            Response::redirect('users/login');
        }
    }

    public function action_index() {
        Response::redirect('user/files');
    }

    public function action_files() {
        $id_info = Auth::get_user_id();
        $data['ideas'] = Model_Ideas::find('all', array('where' => array(array('user_id', $id_info[1]))));

        $this->template->title = 'Example Page';
        $this->template->content = View::forge('user/index', $data);
    }

    public function action_delete_file($id) {
        $idea = Model_Ideas::find($id);
        $id_info = Auth::get_user_id();

        if ($idea->user_id == $id_info[1]) {
            $idea->delete();
            Session::set_flash('success', 'Your idea has been deleted.');
            Response::redirect('user/files');
        } else {
            Session::set_flash('error', 'You shall be punished!');
            Response::redirect('user/files');
        }
    }

    public function action_inbox() {
        $id_info = Auth::get_user_id();
        $data['inbox'] = Model_Messages::find('all', array('where' => array(array('receiver_id', $id_info[1]))));
        $data['sent'] = Model_Messages::find('all', array('where' => array(array('user_id', $id_info[1]))));

        $this->template->title = 'Inbox';
        $this->template->content = View::forge('user/inbox', $data);
    }

    public function action_view_message($id) {
        $message = Model_Messages::find($id);
        $id_info = Auth::get_user_id();

        if (!$message->receiver_id == $id_info[1]) {
            Session::set_flash('error', 'You shall be punished!');
            Response::redirect('/user/inbox');
        }

        $message->is_read = 1;
        $message->save();

        $data['title'] = $message->title;
        $data['message'] = $message->message;
        $data['user_name'] = $message->user_name;
        $data['created_at'] = $message->created_at;

        $this->template->title = 'View message - ' . $data['title'];
        $this->template->content = View::forge('user/view_message', $data);
    }

    public function action_send_message() {
        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_field('receiver', 'Receiver', 'required|trim');
            $val->add_field('title', 'Title', 'required|trim');
            $val->add_field('message', 'Message', 'required|trim');

            if ($val->run()) {
                $id_info = Auth::get_user_id();
                $receiver = Model_Users::query()->where('username', $val->validated('receiver'))->get_one();

                if (!$receiver) {
                    Session::set_flash('error', 'User does not exists!');
                    Response::redirect('/user/inbox');
                }

                $props = array('user_id' => $id_info[1],
                    'user_name' => Auth::get_screen_name(),
                    'receiver_id' => $receiver->id,
                    'receiver_name' => $receiver->username,
                    'title' => $val->validated('title'),
                    'message' => $val->validated('message'),
                    'created_at' => Date::time()->get_timestamp());

                $message = Model_Messages::forge($props);

                if ($message->save()) {
                    Session::set_flash('success', 'Message sent!');
                    Response::redirect('/user/inbox');
                } else {
                    Session::set_flash('error', 'This should not happen');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }
    }

    public function action_delete_message($id) {
        $id_info = Auth::get_user_id();
        $message = Model_Messages::query()->where('id', $id)->get_one();
        
        if ($message->user_id == null && $message->receiver_id == null) {
            $message->delete();
        } else {
            if ($message->user_id == $id_info[1]) {
                $message->user_id = null;
            } elseif ($message->receiver_id == $id_info[1]) {
                $message->receiver_id = null;
            }
            $message->save();
        }
        Session::set_flash('success', 'Message deleted!');
        Response::redirect('/user/inbox');
    }

}
