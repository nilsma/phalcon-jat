<?php

class RegisterController extends ControllerBase {

    public function indexAction() {

        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/register.css');
        $this->assets->addJs('js/jquery-2.1.3.min.js');
        $this->assets->addJs('js/main.js');

        $form = new RegisterUserForm();

        $this->view->form = $form;

    }

}