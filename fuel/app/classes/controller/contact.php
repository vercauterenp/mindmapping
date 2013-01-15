<?php

class Controller_Contact extends Controller_Common {

    public function action_index() {
        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add('email', 'Email')->add_rule('required')->add_rule('valid_email');
            $val->add('message', 'Message')->add_rule('required');

            if ($val->run()) {
                $email = Email::forge();
                $email->from(Input::post('email'));
                $email->to(array(
                    'peter@vercauteren.info',
                ));
                $email->subject('Mindmapping - contact (' . Input::post('category') . ')');
                $email->body(Input::post('message'));

                try {
                    $email->send();
                } catch (\EmailValidationFailedException $e) {
                    Session::set_flash('error', 'The validation failed');
                    Response::redirect('contactus');
                } catch (\EmailSendingFailedException $e) {
                    Session::set_flash('error', 'The driver could not send the email');
                    Response::redirect('contactus');
                }

                Session::set_flash('success', 'Message sent.');
                Response::redirect('contact');
            } else {
                Session::set_flash('error', $val->show_errors());
                Response::redirect('contact');
            }
        }

        $this->template->title = 'Contact us';
        $this->template->content = View::forge('contact/index');
    }

}

