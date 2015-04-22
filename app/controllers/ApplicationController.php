<?php

use Phalcon\Exception;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class ApplicationController extends ControllerBase {

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

            $user = unserialize($this->session->get('user'));

            $application_id = $this->request->get('app_id', array('int', 'striptags', 'trim'));
            $application = Applications::findFirst('id = "' . $application_id . '"');

            if($application->owner_id == $user->id) {

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
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/bootstrap.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/application.js');

            $user = unserialize($this->session->get('user'));

            $order = $this->getApplicationOrder();

            $applications = Applications::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id),
                'order' => $order
            ));

            $contacts = Contacts::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id)
            ));

            if(count($applications) > 0) {
                $missing_entries_class = 'container';
            } else {
                $missing_entries_class = 'container hidden';
            }

            $this->view->pick('application/overview');
            $this->view->setVar('user', $user);
            $this->view->setVar('view_types', $this->getUserViewTypes($user));
            $this->view->setVar('email', $user->email);
            $this->view->setVar('applications', $applications);
            $this->view->setVar('contacts', $contacts);
            $this->view->setVar('inner_text', "New Application");
            $this->view->setVar('missing_entries_class', $missing_entries_class);
            $this->view->setVar('entry_type', 'application');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function setApplicationOrderAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $app_order = $this->request->get('app_order', array('string', 'striptags', 'trim'));

            $new_order = '';

            switch($app_order) {

                case 'applied':

                    if($current_order = $this->session->get('app_order')) {
                        if($current_order == $app_order) {
                            $new_order = 'applied desc';
                        } else {
                            $new_order = $app_order;
                        }
                    } else {
                        $new_order = 'applied';
                    }

                    break;

                case 'due':

                    if($current_order = $this->session->get('app_order')) {
                        if($current_order == $app_order) {
                            $new_order = 'due desc';
                        } else {
                            $new_order = $app_order;
                        }
                    } else {
                        $new_order = 'due';
                    }

                    break;

                case 'follow_up':

                    if($current_order = $this->session->get('app_order')) {
                        if($current_order == $app_order) {
                            $new_order = 'follow_up desc';
                        } else {
                            $new_order = $app_order;
                        }
                    } else {
                        $new_order = 'follow_up';
                    }

                    break;

                case 'company':

                    if($current_order = $this->session->get('app_order')) {
                        if($current_order == $app_order) {
                            $new_order = 'company desc';
                        } else {
                            $new_order = $app_order;
                        }
                    } else {
                        $new_order = 'company';
                    }

                    break;

                case 'position':

                    if($current_order = $this->session->get('app_order')) {
                        if($current_order == $app_order) {
                            $new_order = 'position desc';
                        } else {
                            $new_order = $app_order;
                        }
                    } else {
                        $new_order = 'position';
                    }

                    break;

                default:
                    $new_order = 'due';
                    break;

            }

            $this->session->set('app_order', $new_order);
            $this->response->redirect('application/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    private function getApplicationOrder() {

        if($this->session->has('app_order')) {
            $order = $this->session->get('app_order');
        } else {
            $order = '';
        }

        return $order;
    }

    public function createAction() {

        $this->assets->addCss('css/main.css');
        $this->assets->addCss('css/application.css');
        $this->assets->addCss('css/application-create.css');
        $this->assets->addCss('css/bootstrap.min.css');
        $this->assets->addCss('css/jquery-ui.min.css');
        $this->assets->addJs('js/jquery-2.1.3.min.js');
        $this->assets->addJs('js/bootstrap.min.js');
        $this->assets->addJs('js/main.js');
        $this->assets->addJs('js/application.js');
        $this->assets->addJs('js/jquery-ui.min.js');

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            $application_form = new CreateApplicationForm();
            $contact_form = new CreateContactForm();

            $contacts = Contacts::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id)
            ));

            $this->view->setVar('contacts', $contacts);
            $this->view->application_form = $application_form;
            $this->view->contact_form = $contact_form;
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
            $this->assets->addCss('css/jquery-ui.min.css');
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/bootstrap.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/application.js');
            $this->assets->addJs('js/jquery-ui.min.js');

            $user = unserialize($this->session->get('user'));

            //TODO check if current user owns app_id
            $app_id = $this->request->get('app_id', array('int', 'striptags', 'trim'));
            $application = Applications::findFirst('id = "' . $app_id . '"');

            if($application->owner_id != $user->id) {

                $this->view->disable();
                $this->flash->error('You do not own that application.');
                $this->response->redirect('application/overview');

            } else {

                $contacts = Contacts::find(array(
                    'conditions' => 'owner_id = ?1',
                    'bind' => array(1 => $user->id)
                ));

                $form = new EditApplicationForm(Applications::findFirst('id = "' . $app_id . '"'));

                $this->view->pick('application/edit');
                $this->view->form = $form;
                $this->view->setVar('application', $application);
                $this->view->setVar('contacts', $contacts);

            }

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    //TODO generalize and refactor to helpers class
    private function isOwnerContacts($user, Array $contacts) {

        $isOwner = true;

        foreach($contacts as $id) {

            $contact = Contacts::findFirst('id = "' . $id . '"');

            if($user->id != $contact->owner_id) {

                $isOwner = false;

            }

        }

        return $isOwner;

    }

    //TODO refactor to helpers class
    private function sanitizeContacts(Array $contacts) {

        $filter = new \Phalcon\Filter();

        $sanitized = array();

        foreach($contacts as $contact) {

            $entry = $filter->sanitize($contact, 'int');
            array_push($sanitized, $entry);

        }

        return $sanitized;

    }

    public function saveAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            if($this->request->has('contacts')) {
                $contacts = $this->sanitizeContacts($this->request->getPost('contacts'));
            } else {
                $contacts = array();
            }

            if($this->isOwnerContacts($user, $contacts)) {

                if($this->request->has('app_id')) {
                    $app_id = $this->request->get('app_id', array('int', 'striptags', 'trim'));
                    $application = Applications::findFirst('id = "' . $app_id . '"');

                    if($application->owner_id != $user->id) {

                        $this->flash->error('You do not own that application.');
                        $this->response->redirect('application/overview');

                    } else {

                        $application->company = $this->request->getPost('company', array('string', 'striptags', 'trim'));
                        $application->position = $this->request->getPost('position', array('string', 'striptags', 'trim'));
                        $application->recruitment_company = $this->request->getPost('recruitment', array('string', 'striptags', 'trim'));
                        $application->notes = $this->request->getPost('notes', array('string', 'striptags', 'trim'));

                        if($this->validateDate($this->request->getPost('applied'))) {
                            $application->applied = date("Y-m-d", strtotime($this->request->getPost('applied')));
                        } else {
                            $application->applied = date("Y-m-d");
                        }

                        if($this->validateDate($this->request->getPost('due_date'))) {
                            $application->due = date("Y-m-d", strtotime($this->request->getPost('due_date')));
                        } else {
                            $application->due = date("Y-m-d");
                        }

                        if($this->validateDate($this->request->getPost('follow_up'))) {
                            $application->follow_up = date("Y-m-d", strtotime($this->request->getPost('follow_up')));
                        } else {
                            $application->follow_up = date("Y-m-d");
                        }

                    }

                } else {

                    $application = new Applications();
                    $application->id = null;
                    $application->owner_id = $user->id;
                    $application->created = date("Y-m-d");
                    $application->company = $this->request->getPost('company', array('string', 'striptags', 'trim'));
                    $application->position = $this->request->getPost('position', array('string', 'striptags', 'trim'));
                    $application->recruitment_company = $this->request->getPost('recruitment', array('string', 'striptags', 'trim'));
                    $application->notes = $this->request->getPost('notes', array('string', 'striptags', 'trim'));

                    if($this->validateDate($this->request->getPost('applied'))) {
                        $application->applied = date("Y-m-d", strtotime($this->request->getPost('applied')));
                    } else {
                        $application->applied = date("Y-m-d");
                    }

                    if($this->validateDate($this->request->getPost('due_date'))) {
                        $application->due = date("Y-m-d", strtotime($this->request->getPost('due_date')));
                    } else {
                        $application->due = date("Y-m-d");
                    }

                    if($this->validateDate($this->request->getPost('follow_up'))) {
                        $application->follow_up = date("Y-m-d", strtotime($this->request->getPost('follow_up')));
                    } else {
                        $application->follow_up = date("Y-m-d");
                    }

                }

                var_dump($application->applied);

                $this->writeAction($application, $contacts);

            } else {

                $this->flash->error('You do not own these contacts');
                $this->response->redirect('application/overview');

            }

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    private function writeAction(Applications $application, Array $contacts) {

        $transactionManager = new TransactionManager();
        $transaction = $transactionManager->get();

        try {

            // try saving the application first, the resulting application->id is needed for the subsequent
            // contact_attachments entries
            if($application->save() == false) {
                $transaction->rollback('Failed to save application');
            }

            // remove current contact_attachments
            $current_attachments = ContactAttachments::find(array(
                'conditions' => 'app_id = ?1',
                'bind' => array(1 => $application->id)
            ));

            // check if there actually are any current attachemnts, to avoid errors
            // when trying to delete non-existing records
            if(count($current_attachments) > 0) {

                // iterate resultset for current attachments and remove all
                foreach($current_attachments as $attachment) {
                    if($attachment->delete() == false) {
                        $transaction->rollback('Something went wrong removing current attachments');
                    }
                }

            }

            // check if there are any contacts to be saved
            if(count($contacts) > 0) {

                // iterate the array of contact_ids received from the ajax/post and add all
                foreach($contacts as $contact_id) {

                    $attachment = new ContactAttachments();
                    $attachment->id = null;
                    $attachment->contact_id = $contact_id;
                    $attachment->app_id = $application->id;

                    if($attachment->save() == false) {
                        $transaction->rollback('Failed to save application attachment');
                    }

                }

            }

            $transaction->commit();

        } catch(Exception $e) {

            $error_message = 'Something went wrong while writing application to database: ' . $e->getMessage();
            $this->flash->error($error_message);
            $this->response->redirect('application/overview');

        }

    }

    public function getContactDetailsAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $contact_id = $this->request->getPost('contact_id');
            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            echo json_encode($contact, JSON_FORCE_OBJECT);

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

}