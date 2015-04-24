<?php

class IndexController extends ControllerBase {

    public function indexAction() {

        if($this->cookies->has('remember-me')) {

            $this->view->disable();

            $user_id = $this->cookies->get('remember-me')->getValue();
            $user = Users::findFirst("id = {$user_id}");
            $this->session->set("user", serialize($user));
            $this->session->set("auth", true);

            $this->response->redirect('application/overview');

        } else {

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/login.css');
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/main.js');

            $form = new LoginForm();
            $this->view->form = $form;

        }

    }

}

