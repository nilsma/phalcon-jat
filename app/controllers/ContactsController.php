<?php

use Phalcon\Exception;

class ContactsController extends \Phalcon\Mvc\Controller {

    public function indexAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('contacts/create');

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function saveAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            $contact = new Contacts();
            $contact->id = null;
            $contact->owner_id = $user->id;
            $contact->name = $this->request->getPost('name');
            $contact->position = $this->request->getPost('position');
            $contact->email = $this->request->getPost('email');
            $contact->phone = $this->request->getPost('phone');
            $contact->notes = $this->request->getPost('notes');

            try {

                $contact->save();
                $this->flash->success('Contact saved');
                $this->response->redirect('overview/contacts');

            } catch(Exception $e) {

                $error_message = 'Something went wrong while saving contact: ' . $e->getMessage();
                $this->flash->error($error_message);
                $this->response->redirect('overview/contacts');

            }

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function createAction() {

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));
            $form = new ContactCreateForm();

            $this->view->pick('contact/create');
            $this->view->form = $form;

        } else {

            $this->flash->error('You have to login first');
            $this->response->redirect('');

        }

    }

    public function cancelAction() {

        $this->view->disable();

        //TODO refactor to auth-check method
        if($this->session->has('user') && $this->session->get('auth') == True) {

            $this->response->redirect('overview/contacts');

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

