<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class OverviewContactForm extends Form {

    public function initialize(Contacts $contact) {

        // create text new element for contact name
        $name = new Text('name', array(
            'placeholder' => 'Contact Name',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $contact->name,
            'disabled' => 'disabled'
        ));

        $name->setLabel('Name: ');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message' => 'Contact Name may not exceed 50 characters'
            ))
        ));

        $this->add($name);

        // create new text element for contact position
        $position = new Text('position', array(
            'placeholder' => 'Position',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $contact->position,
            'disabled' => 'disabled'
        ));

        $position->setLabel('Position: ');

        $position->addValidators(array(
            new PresenceOf(array(
                'message' => 'Contact Position is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message' => 'Contact Position may not exceed 50 characters'
            ))
        ));

        $this->add($position);

        // create new email element for contact email
        $email = new Email('email', array(
            'placeholder' => 'Email',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $contact->email,
            'disabled' => 'disabled'
        ));

        $email->setLabel('Email: ');

        $email->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Contact Email may not exceed 50 characters'
            ))
        ));

        $this->add($email);

        // create new text element for contact phone
        $phone = new Text('phone', array(
            'placeholder' => 'Phone',
            'maxlength' => 20,
            'class' => 'form-control',
            'value' => $contact->phone,
            'disabled' => 'disabled'
        ));

        $phone->setLabel('Phone: ');

        $phone->addValidators(array(
            new StringLength(array(
                'max' => 20,
                'message' => 'Contact Phone may not exceed 20 characters'
            ))
        ));

        $this->add($phone);

        // create new textarea element for contact notes
        $notes = new TextArea('notes', array(
            'placeholder' => 'Notes',
            'maxlength' => 20,
            'class' => 'form-control',
            'value' => $contact->notes,
            'disabled' => 'disabled'
        ));

        $notes->setLabel('Notes: ');

        $notes->addValidators(array(
            new StringLength(array(
                'max' => 500,
                'message' => 'Contact Notes may not exceed 500 characters'
            ))
        ));

        $this->add($notes);

        // create new submit element for the form
        $submit = new Submit('Edit', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}