<?php

class OverviewController extends \Phalcon\Mvc\Controller {

    public function indexAction() {

        $this->view->disable();
        $this->response->redirect('overview/applications');

    }

    public function contactsAction() {

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $this->view->pick('overview/contacts');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function applicationsAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/application.css');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/application.js');

            $user = unserialize($this->session->get('user'));

            $this->clearApplicationState();

            $cookie = $this->cookies->get('remember-me');

            $this->view->pick('overview/applications');

            $this->view->setVar('cookie', $cookie);
            $this->view->setVar('email', $user->email);

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    protected function clearApplicationState() {

        if($this->session->has('app_state')) {

            $this->session->remove('app_state');

        }

        if($this->session->has('contact_ids')) {

            $this->session->remove('contact_ids');

        }

    }

}

