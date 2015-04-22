<?php

use Phalcon\Exception;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class ContactsController extends ControllerBase {

    public function indexAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('contacts/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function deleteAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            $contact_id = $this->request->get('contact_id', array('int', 'striptags', 'trim'));
            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            if($contact->owner_id != $user->id) {

                $this->view->disable();
                $this->flash->error('You do not own that contact.');
                $this->response->redirect('contacts/overview');

            } else {

                $contact_attachments = ContactAttachments::find(array(
                    'conditions' => 'contact_id = ?1',
                    'bind' => array(1 => $contact_id)
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

                    $contact->delete();

                    $this->flash->success('Contact deleted!');
                    $this->response->redirect('contacts/overview');

                } catch(Exception $e) {

                    $this->flash->error('Something went wrong while deleting contact: ' . $e->getMessage());
                    $this->response->redirect('contacts/overview');

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
            $this->assets->addCss('css/contact.css');
            $this->assets->addCss('css/contact-overview.css');
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/bootstrap.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $user = unserialize($this->session->get('user'));

            $order = $this->getContactsOrder();

            $contacts = Contacts::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id),
                'order' => $order
            ));

            if(count($contacts) > 0) {
                $missing_entries_class = 'container';
            } else {
                $missing_entries_class = 'container hidden';
            }

            $this->view->pick('contact/overview');
            $this->view->setVar('view_types', $this->getUserViewTypes($user));
            $this->view->setVar('user', $user);
            $this->view->setVar('contacts', $contacts);
            $this->view->setVar('inner_text', "New Contact");
            $this->view->setVar('missing_entries_class', $missing_entries_class);
            $this->view->setVar('entry_type', 'contact');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    private function getContactsOrder() {

        if($this->session->has('contacts_order')) {
            $order = $this->session->get('contacts_order');
        } else {
            $order = '';
        }

        return $order;
    }

    public function setContactsOrderAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $contacts_order = $this->request->get('contacts_order', array('string', 'striptags', 'trim'));

            $new_order = '';

            switch($contacts_order) {

                case 'name':

                    if($current_order = $this->session->get('contacts_order')) {
                        if($current_order == $contacts_order) {
                            $new_order = 'name desc';
                        } else {
                            $new_order = $contacts_order;
                        }
                    } else {
                        $new_order = 'name';
                    }

                    break;

                case 'position':

                    if($current_order = $this->session->get('contacts_order')) {
                        if($current_order == $contacts_order) {
                            $new_order = 'position desc';
                        } else {
                            $new_order = $contacts_order;
                        }
                    } else {
                        $new_order = 'position';
                    }

                    break;

                default:
                    $new_order = 'name';
                    break;

            }

            $this->session->set('contacts_order', $new_order);
            $this->response->redirect('contacts/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function saveAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            if($this->request->has('contact_id')) {
                $contact_id = $this->request->get('contact_id', array('int', 'striptags', 'trim'));
                $contact = Contacts::findFirst('id = "' . $contact_id . '"');

                if($contact->owner_id != $user->id) {

                    $this->view->disable();
                    $this->flash->error('You do not own that contact.');
                    $this->response->redirect('contacts/overview');

                } else {

                    $contact->name = $this->request->getPost('name', array('string', 'striptags', 'trim'));
                    $contact->position = $this->request->getPost('position', array('string', 'striptags', 'trim'));
                    $contact->email = $this->request->getPost('email', array('string', 'striptags', 'trim'));
                    $contact->phone = $this->request->getPost('phone', array('string', 'striptags', 'trim'));
                    $contact->notes = $this->request->getPost('notes', array('string', 'striptags', 'trim'));

                }

            } else {

                $contact = new Contacts();
                $contact->id = null;
                $contact->owner_id = $user->id;
                $contact->name = $this->request->getPost('name', array('string', 'striptags', 'trim'));
                $contact->position = $this->request->getPost('position', array('string', 'striptags', 'trim'));
                $contact->email = $this->request->getPost('email', array('email', 'striptags', 'trim'));
                $contact->phone = $this->request->getPost('phone', array('string', 'striptags', 'trim'));
                $contact->notes = $this->request->getPost('notes', array('string', 'striptags', 'trim'));

            }

            //TODO refactor to own write-method
            try {

                $contact->save();

                if(!$this->request->isAjax()) {
                    $this->flash->success('Contact saved');
                    $this->response->redirect('contacts/overview');
                } else {
                    echo json_encode($contact->id, JSON_FORCE_OBJECT);
                    //$this->response->redirect('contacts/overview');
                }

            } catch(Exception $e) {

                $error_message = 'Something went wrong while saving contact: ' . $e->getMessage();
                $this->flash->error($error_message);
                $this->response->redirect('contacts/overview');

            }

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function createAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/contact.css');
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/bootstrap.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $form = new CreateContactForm();

            $this->view->form = $form;
            $this->view->pick('contact/create');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function cancelAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('contacts/overview');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function editAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/contact.css');
            $this->assets->addCss('css/bootstrap.min.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/bootstrap.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $contact_id = $this->request->get('contact_id', array('int', 'striptags', 'trim'));
            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            if($contact->owner_id != $user->id) {

                $this->view->disable();
                $this->flash->error('You do not own that contact.');
                $this->response->redirect('contacts/overview');

            } else {

                $form = new EditContactForm($contact);

                $this->view->form = $form;
                $this->view->pick('contact/edit');

            }

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

}

