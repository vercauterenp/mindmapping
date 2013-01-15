<?php

class Controller_Users extends Controller_Common {

    public function before() {
        parent::before();
    }

    public function action_index() {
        Response::redirect('/');
    }

    public function action_login() {
        if (Auth::check()) {
            Response::redirect('/');
        }

        if (Input::post()) {
            $auth = Auth::instance();

            if ($auth->login()) {
                Session::set_flash('notice', 'Logged in');
                Response::redirect('/');
            } else {
                Session::set_flash('error', 'Wrong username/password combo. Try again');
            }
        }

        $this->template->title = 'Sign In';
        $this->template->content = View::forge('users/login');
    }

    public function action_logout() {
        Auth::instance()->logout();
        Session::set_flash('notice', 'Logged out');
        Response::redirect('/');
    }

    public function action_signup() {
        if (Auth::check()) {
            Response::redirect('/');
        }

        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_callable('MyRules');
            $val->add_field('username', 'Username', 'required|trim|valid_string[alpha,numeric]');
            $val->add_field('password', 'Password', 'required|trim');
            $val->add_field('email', 'Email', 'required|trim|valid_email');

            if ($val->run()) {
                if (Auth::create_user($val->validated('username'), $val->validated('password'), $val->validated('email'))) {
                    Session::set_flash('success', 'Your account has been created');
                    Response::redirect('/');
                } else {
                    Session::set_flash('error', 'This should not happen');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Sign Up';
        $this->template->content = View::forge('users/signup');
    }

    public function action_forgotpassword() {
        if (Auth::check()) {
            Response::redirect('/');
        }

        if (Input::method() == 'POST') {
            $val = Validation::forge();
            $val->add_field('email', 'Email', 'required|trim|valid_email');

            if ($val->run()) {
                if ($val->validated()) {
                    $mailaddress = $val->validated('email');
                    $query = Model_Users::query()->where('email', $mailaddress);
                    $user = $query->get_one();

                    if (!empty($user)) {
                        $link = Uri::create('users/passwordrecovery/' . Crypt::encode($mailaddress));

                        $email = Email::forge();
                        $email->from('no-reply@scripttesting.com', 'Mindmapping');
                        $email->to($mailaddress);
                        $email->subject('Password recovery');
                        $email->body('Hi,\n
                            a password recovery has been asked.\n
                            If this is correct please surf to the following link:\n
                            ' . $link . '\n
                            If for some reason you did not ask for it,\n
                            you may ignore this email.\n\n
                            Kind Regards,\n
                            The Admin');

                        try {
                            $email->send();
                            Session::set_flash('success', 'An email has been sent with further details');
                        } catch (\EmailValidationFailedException $e) {
                            Session::set_flash('error', 'Email validation failed.');
                        } catch (\EmailSendingFailedException $e) {
                            Session::set_flash('error', 'Email sending failed.');
                        }

                        Response::redirect('/');
                    } else {
                        Session::set_flash('error', 'Email does not match with an existing user');
                    }
                } else {
                    Session::set_flash('error', 'This should not happen');
                }
            } else {
                Session::set_flash('error', $val->error());
            }
        }

        $this->template->title = 'Forgot Password';
        $this->template->content = View::forge('users/forgotpassword');
    }

    public function action_passwordrecovery($encodedemail) {
        if (Auth::check()) {
            Response::redirect('/');
        }

        $email = Crypt::decode($encodedemail);
        $query = Model_Users::query()->where('email', $email);
        $user = $query->get_one();
        if (!empty($user)) {
            $data['temp'] = Auth::reset_password($user->username);
        } else {
            Session::set_flash('error', 'An error occured, please contact the administrator');
            Response::redirect('/');
        }
        $this->template->title = 'Sign Up';
        $this->template->content = View::forge('users/passwordrecovery', $data);
    }

}