<?php

class Controller_Common extends Controller_Hybrid {

    public function before() {
        parent::before();
        
        $count = 0; 
        if (Auth::check()) {
            $id_info = Auth::get_user_id();
            $new_messages = Model_Messages::query()->where('receiver_id', $id_info[1])->where('is_read', 0)->count();
            
            if($new_messages > 0){
                $count = $new_messages;
            }
        }
        $this->template->new_messages = $count;
    }

    public function action_404() {
        $this->template->title = "404";
        return Response::forge(View::forge('common/404'), 404);
    }

}