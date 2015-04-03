<?php

use Phalcon\Exception;
use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class ContactsController extends \Phalcon\Mvc\Controller {

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

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/contact.css');
            $this->assets->addCss('css/contact-overview.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $contact_id = $this->request->get('contact_id');
            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            $contact_attachments = ContactAttachments::find(array(
                'conditions' => 'contact_id = ?1',
                'bind' => array(1 => $contact_id)
            ));

            try {

                $transactionManager = new TransactionManager();
                $transaction = $transactionManager->get();

                foreach($contact_attachments as $attachment) {

                    if($attachment->delete() == false) {

                        $transaction->rollback('Failed to delete attachment');

                    }

                }

                $contact->delete();

                $this->flash->success('Contact deleted!');
                $this->response->redirect('contacts/overview');

            } catch(Exception $e) {

                $this->flash->error('Something went wrong while deleting contact: ' . $e->getMessage());
                $this->response->redirect('contacts/overview');

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
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $user = unserialize($this->session->get('user'));

            $contacts = Contacts::find(array(
                'conditions' => 'owner_id = ?1',
                'bind' => array(1 => $user->id)
            ));

            $this->view->setVar('contacts', $contacts);
            $this->view->pick('contact/overview');

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
                $contact_id = $this->request->get('contact_id');
            } else {
                $contact_id = null;
            }

            $contact = new Contacts();
            $contact->id = $contact_id;
            $contact->owner_id = $user->id;
            $contact->name = $this->request->getPost('name');
            $contact->position = $this->request->getPost('position');
            $contact->email = $this->request->getPost('email');
            $contact->phone = $this->request->getPost('phone');
            $contact->notes = $this->request->getPost('notes');

            try {

                $contact->save();
                $this->flash->success('Contact saved');
                $this->response->redirect('contacts/overview');

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
            $this->assets->addCss('css/contact-create.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
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

            $this->assets->addCss('css/main.css');
            $this->assets->addCss('css/contact.css');
            $this->assets->addCss('css/contact-edit.css');
            $this->assets->addJs('js/jquery-2.1.3.min.js');
            $this->assets->addJs('js/main.js');
            $this->assets->addJs('js/contact.js');

            $contact_id = $this->request->get('contact_id');
            $contact = Contacts::findFirst('id = "' . $contact_id . '"');

            $form = new EditContactForm($contact);

            $this->view->form = $form;
            $this->view->pick('contact/edit');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

}

