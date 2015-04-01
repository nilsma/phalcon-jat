<?php

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
use Phalcon\Exception;

class ApplicationsController extends \Phalcon\Mvc\Controller {

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
        $this->assets->addCss('css/applications.css');
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
            $application->recruitment_company = $app_state['recruitment'];
            $application->notes = $app_state['notes'];
            $application->applied = $app_state['applied'];
            $application->due = $app_state['due_date'];
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

            $app_state = $this->request->getPost('app_state');

            $application = new Applications();
            $application->company = $app_state['company'];
            $application->position = $app_state['position'];
            $application->recruitment_company = $app_state['recruitment'];
            $application->notes = $app_state['notes'];
            $application->applied = $app_state['applied'];
            $application->due_date = $app_state['due_date'];
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

            $contact_ids = array();

            if($this->session->has('contact_ids')) {

                $contact_ids = $this->session->get('contact_ids');

            }

            $application = new Applications();
            $application->id = null;
            $application->owner_id = $user->id;
            $application->created = date("Y-m-d");
            $application->company = $this->request->getPost('company');
            $application->position = $this->request->getPost('position');
            $application->recruitment_company = $this->request->getPost('recruitment');
            $application->notes = $this->request->getPost('notes');
            $application->applied = date("Y-m-d", strtotime($this->request->getPost('applied')));
            $application->due = date("Y-m-d", strtotime($this->request->getPost('due_date')));
            $application->follow_up = date("Y-m-d", strtotime($this->request->getPost('follow_up')));

            $test_id = $this->writeApplication($application, $contact_ids);

            $this->flash->success('Application added!');
            $this->response->redirect('overview/');

            echo $test_id;

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    private function writeApplication(Applications $application, Array $contact_ids) {

        if(empty($contact_ids) || count($contact_ids) < 1) {

            $application->save();
            return $application->id;

        } else {

            $transactionManager = new TransactionManager();
            $transaction = $transactionManager->get();

            try {

                $application_id = null;

                if($application->save() == false) {
                    $transaction->rollback('Failed to write application');
                } else {
                    $application_id = $application->id;
                }

                foreach($contact_ids as $contact_id) {

                    $attachment = new ContactAttachments();
                    $attachment->id = null;
                    $attachment->contact_id = $contact_id;
                    $attachment->app_id = $application_id;

                    if($attachment->save() == false) {
                        $transaction->rollback('Failed to write contact attachment');
                    }

                }

                $transaction->commit();

            } catch(Exception $e) {

                $error_message = 'Something went wrong while writing application to database: ' . $e->getMessage();
                $this->flash->error($error_message);
                $this->response->redirect('overview/');

            }

        }

    }

}

