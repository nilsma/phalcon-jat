<?php

class RegisterController extends ControllerBase {

    public function indexAction() {

        $form = new RegisterUserForm();

        $this->view->form = $form;

    }

}