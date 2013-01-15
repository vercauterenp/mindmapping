<?php

class Controller_Home extends Controller_Common {
    public function action_index() {
        if(input::is_ajax()){
            return parent::before();
        }
        
        $this->template->title = 'Example Page';
        $this->template->savemodal = View::forge('common/save_modal');
        $this->template->loadmodal = View::forge('common/load_modal');
        $this->template->content = View::forge('draw/index');
    }
}
