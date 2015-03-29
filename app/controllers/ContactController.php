<?php

class ContactController extends \Phalcon\Mvc\Controller
{

    public function indexAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('overview/');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function createAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $this->view->pick('contact/create');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function editAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $this->view->pick('contact/edit');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

}

