<?php

class IndexController extends ControllerBase {

    public function indexAction() {

        if($this->cookies->has('remember-me')) {

            $this->view->disable();

            $user_id = $this->cookies->get('remember-me')->getValue();
            $user = Users::findFirst("id = {$user_id}");
            $this->session->set("user", serialize($user));
            $this->session->set("auth", true);

            $this->flash->success('Welcome back!');
            $this->response->redirect('overview/');

        } else {

            $form = new LoginForm();
            $this->view->form = $form;

        }

    }

}

