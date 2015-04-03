<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class EditContactForm extends Form {

    public function initialize(Contacts $contact) {

        // create text contact_details for contact name
        $name = new Text('name', array(
            'placeholder' => 'Contact Name',
            'maxlength' => 50,
            'value' => $contact->name,
            'class' => 'form-control'
        ));

        $name->setLabel('Name: ');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Contact name is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message'=> 'Contact name may not exceed 50 characters'
            ))
        ));

        $this->add($name);

        // create new text contact_details for contact position
        $position = new Text('position', array(
            'placeholder' => 'Contact Position',
            'class' => 'form-control',
            'value' => $contact->position,
            'maxlength' => 50
        ));

        $position->setLabel('Position: ');

        $position->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Contact Position may not exceed 50 characters'
            ))
        ));

        $this->add($position);

        // create email contact_details for contact email
        $email = new Email('email', array(
            'placeholder' => 'Contact Email',
            'class' => 'form-control',
            'value' => $contact->email,
            'maxlength' => 50
        ));

        $email->setLabel('Email: ');

        $email->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Contact Email may not exceed 50 characters'
            ))
        ));

        $this->add($email);

        // create text contact_details for contact phone
        $phone = new Text('phone', array(
            'placeholder' => 'Contact Phone',
            'class' => 'form-control',
            'value' => $contact->phone,
            'maxlength' => 20
        ));

        $phone->setLabel('Phone: ');

        $phone->addValidators(array(
            new StringLength(array(
                'max' => 20,
                'message' => 'Contact Phone may not exceed 20 characters'
            ))
        ));

        $this->add($phone);

        // create textArea contact_details for contact notes
        $notes = new TextArea('notes', array(
            'placeholder' => 'Notes',
            'class' => 'form-control',
            'value' => $contact->notes,
            'maxlength' => 500
        ));

        $notes->setLabel('Notes: ');

        $notes->addValidators(array(
            new StringLength(array(
                'max' => 500,
                'message' => 'Notes can not be more than 500 characters'
            ))
        ));

        $this->add($notes);

        // create hidden element for contact id
        $contact_id = new Hidden('contact_id', array(
            'value' => $contact->id
        ));

        $this->add($contact_id);

        // create submit contact_details for the form
        $submit = new Submit('Save', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}