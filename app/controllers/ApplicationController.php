<?php

class ApplicationController extends \Phalcon\Mvc\Controller {

    public function indexAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('overview/');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function createAction() {

        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/application.css');
        $this->assets->addJs('js/jquery-2.1.3.min.js');
        $this->assets->addJs('js/main.js');
        $this->assets->addJs('js/application.js');

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $this->view->pick('application/create');

            $contacts = $this->getContacts($user);
            $app_state = $this->getApplicationState();
            $application_form = new ApplicationCreateForm($app_state);
            $stored_ids = $this->getStoredIds();

            $this->view->application = $application_form;
            $this->view->setVar('contacts', $contacts);
            $this->view->setVar('stored_ids', $stored_ids);

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function cancelApplicationAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->clearApplicationState();
            $this->response->redirect('overview/');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    protected function clearApplicationState() {

        if($this->session->has('app_state')) {

            $this->session->remove('app_state');

        }

        if($this->session->has('contacts_ids')) {

            $this->session->remove('contact_ids');

        }

    }

    private function getApplicationState() {

        if($this->session->has('app_state')) {

            $app_state = $this->session->get('app_state');

            $application = new Applications();
            $application->company = $app_state['company'];
            $application->position = $app_state['position'];
            $application->recruitment_company = $app_state['recruitment_company'];
            $application->notes = $app_state['notes'];
            $application->applied = $app_state['applied'];
            $application->due = $app_state['due'];
            $application->follow_up = $app_state['follow_up'];

        } else {

            $application = new Applications();

        }

        return $application;

    }

    private function getStoredIds() {

        if($this->session->has('contact_ids')) {

            return $this->session->get('contact_ids');

        } else {

            $stored_ids = array();

            return $stored_ids;

        }

    }

    private function getContacts(Users $user) {
        $contacts = Contacts::find(array(
            "conditions" => "owner_id = ?1",
            "bind" => array(1 => $user->id)
        ));

        return $contacts;

    }

    public function getContactDetailsAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $contact_id = $this->request->getPost('contact_id');

            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            echo json_encode($contact, JSON_FORCE_OBJECT);

        } else {
            //TODO add else-block
        }

    }

    public function storeApplicationStateAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $app_state = $this->request->getPost('application');

            $application = new Applications();
            $application->company = $app_state['company'];
            $application->name = $app_state['name'];
            $application->recruitment_company = $app_state['recruitment'];
            $application->notes = $app_state['notes'];
            $application->applied = $app_state['applied'];
            $application->due = $app_state['due_date'];
            $application->follow_up = $app_state['follow_up'];

            $this->session->set('app_state', $app_state);

        }

    }

    public function storeContactAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $contact_id = $this->request->getPost('contact_id');
            $this->sessionStoreContactId($contact_id);

        } else {

            echo 0;

        }

    }

    private function sessionStoreContactId($contact_id) {

        if($this->session->has('contact_ids')) {

            $contact_ids = $this->session->get('contact_ids');

            if(!in_array($contact_id, $contact_ids)) {

                $contact_ids = $this->session->get('contact_ids');
                array_push($contact_ids, $contact_id);

            }

        } else {

            $contact_ids = array();
            array_push($contact_ids, $contact_id);

        }

        $this->session->set('contact_ids', $contact_ids);
        echo 1;

    }

    public function editAction() {

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $this->view->pick('application/edit');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function saveAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

}

