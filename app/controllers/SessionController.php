<?php

class SessionController extends \Phalcon\Mvc\Controller
{

    public function indexAction() {

        $this->view->disable();

        $this->response->redirect('');

    }

    public function loginAction() {

        $this->view->disable();

        $form = new LoginForm();

        if($form->isValid($this->request->getPost())) {

            $user = Users::findFirst('username = "' . $this->request->getPost('username', array('string', 'striptags', 'trim')) . '"');

            if($user && $this->security->checkHash($this->request->getPost('password'), $user->password)) {

                $this->cookies->set('remember-me', $user->id, time() + 15 * 86400);
                $this->session->set('user', serialize($user));
                $this->session->set('auth', True);

                $this->response->redirect('application/overview');

            } else {

                $this->flash->error('Wrong username or password');
                $this->response->redirect('');

            }

        } else {

            foreach($form->getMessages() as $message) {

                $this->flash->error($message);

            }

            $this->response->redirect('');

        }

    }

    public function registerAction() {

        $this->view->disable();

        $form = new RegisterUserForm();

        if($form->isValid($this->request->getPost())) {

            if(!preg_match('/\s/',$this->request->getPost('username'))) {

                $user = new Users();
                $user->id = NULL;
                $user->username = $this->request->getPost('username', array('string', 'striptags', 'trim'));
                $user->email = $this->request->getPost('email', array('email', 'striptags', 'trim'));
                $user->password = $this->security->hash($this->request->getPost('password'));
                $user->sorting = "DEFAULT";
                $user->filter = "ALL";

                if($user->save()) {

                    $this->flash->success('You are registered!');
                    $this->response->redirect('application/overview');

                } else {

                    //TODO refactor to use for-loop over $e->getMessages()
                    $user = Users::findFirst('username = "' . $user->username . '"');

                    if($user) {
                        $this->flash->error('That username is already registered');
                    }

                    $user = Users::findFirst('email = "' . $user->email . '"');

                    if($user) {
                        $this->flash->error('That email is already registered');
                    }

                    $this->response->redirect('register/');

                }

            } else {

                $this->flash->error('Username may not contain any white-space characters');
                $this->response->redirect('register/');

            }

        } else {

            foreach($form->getMessages() as $message) {

                $this->flash->error($message);

            }

            $this->response->redirect('register/');

        }

    }

    public function logoutAction() {

        $this->view->disable();

        if(
            //TODO refactor to auth-check method
            !$this->session->has('user') ||
            !$this->session->has('auth') ||
            $this->session->get('auth') == null ||
            $this->session->get('auth') == false
        ) {

            $this->flash->error('You have to login first');
            return $this->response->redirect('');

        } else {

            $cookie = $this->cookies->get('remember-me');
            $cookie->delete();
            $this->session->destroy();

            return $this->response->redirect('');

        }


    }

}

