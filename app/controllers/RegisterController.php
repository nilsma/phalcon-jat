<?php

class RegisterController extends ControllerBase {

    public function indexAction() {

        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/register.css');
        $this->assets->addJs('js/main.js');

        $form = new RegisterForm();

        $this->view->form = $form;

    }

}