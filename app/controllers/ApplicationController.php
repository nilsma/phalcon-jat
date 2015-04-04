<?php

use Phalcon\Exception;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class ApplicationController extends \Phalcon\Mvc\Controller {

    public function indexAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('application/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function deleteAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $application_id = $this->request->get('app_id');
            $application = Applications::findFirst('id = "' . $application_id . '"');

            $contact_attachments = ContactAttachments::find(array(
                'conditions' => 'app_id = ?1',
                'bind' => array(1 => $application_id)
            ));

            try {

                $transactionManager = new TransactionManager();
                $transaction = $transactionManager->get();

                if(count($contact_attachments) > 0) {

                    foreach($contact_attachments as $attachment) {

                        if($attachment->delete() == false) {

                            $transaction->rollback('Failed to delete attachment');

                        }

                    }

                }

                $application->delete();

                $this->flash->success('Application deleted!');
                $this->response->redirect('application/overview');

            } catch(Exception $e) {

                $this->flash->error('Something went wrong while deleting application: ' . $e->getMessage());
                $this->response->redirect('application/overview');

            }


        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function overviewAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/application.css');
            $this->assets->addCss('css/application-overview.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/application-overview.js');

            $user = unserialize($this->session->get('user'));
            $applications = Applications::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id)
            ));

            $contacts = Contacts::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id)
            ));

            $this->view->pick('application/overview');
            $this->view->setVar('email', $user->email);
            $this->view->setVar('applications', $applications);
            $this->view->setVar('contacts', $contacts);

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function createAction() {

        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/application.css');
        $this->assets->addCss('css/application-create.css');
        $this->assets->addJs('js/jquery-2.1.3.min.js');
        $this->assets->addJs('js/main.js');
        $this->assets->addJs('js/application.js');

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $form = new CreateApplicationForm();

            $this->view->form = $form;
            $this->view->pick('application/create');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function cancelAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('application/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function editAction() {

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/application.css');
            $this->assets->addCss('css/application-edit.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/application.js');

            //TODO check if current user owns app_id
            $app_id = $this->request->get('app_id');

            $form = new EditApplicationForm(Applications::findFirst('id = "' . $app_id . '"'));

            $this->view->pick('application/edit');
            $this->view->form = $form;

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

            if($this->request->has('app_id')) {
                $app_id = $this->request->get('app_id');
            } else {
                $app_id = null;
            }

            $application = new Applications();
            $application->id = $app_id;
            $application->owner_id = $user->id;
            $application->created = date("Y-m-d");
            $application->company = $this->request->getPost('company');
            $application->position = $this->request->getPost('position');
            $application->recruitment_company = $this->request->getPost('recruitment');
            $application->notes = $this->request->getPost('notes');
            $application->applied = date("Y-m-d", strtotime($this->request->getPost('applied')));
            $application->due = date("Y-m-d", strtotime($this->request->getPost('due_date')));
            $application->follow_up = date("Y-m-d", strtotime($this->request->getPost('follow_up')));

            $this->writeAction($application);

            $this->flash->success('Application saved!');
            $this->response->redirect('application/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    private function writeAction(Applications $application) {

        try {

            $application->save();


        } catch(Exception $e) {

            $error_message = 'Something went wrong while writing application to database: ' . $e->getMessage();
            $this->flash->error($error_message);
            $this->response->redirect('application/createApplication');

        }

    }

}