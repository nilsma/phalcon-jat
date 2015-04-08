<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\PresenceOf;

class CreateApplicationForm extends Form {

    public function initialize() {

        // create date contact_details for applied date
        $applied = new Date("applied", array(
            'placeholder' => 'Application Date',
            'class' => 'form-control'
        ));

        $applied->setLabel('Applied: ');

        $applied->addValidators(array(
            new StringLength(array(
                'max' => 10,
                'message' => 'A date cannot exceed 10 characters'
            ))
        ));

        $this->add($applied);

        // create date contact_details for due_date
        $due_date = new Date("due_date", array(
            'placeholder' => 'Application Due Date',
            'class' => 'form-control'
        ));

        $due_date->setLabel('Due Date: ');

        $due_date->addValidators(array(
            new StringLength(array(
                'max' => 10,
                'message' => 'A date cannot exceed 10 characters'
            ))
        ));

        $this->add($due_date);

        // create date contact_details for follow-up
        $follow_up = new Date("follow_up", array(
            'placeholder' => 'Application Follow-Up Date',
            'class' => 'form-control'
        ));

        $follow_up->setLabel('Follow-Up: ');

        $follow_up->addValidators(array(
            new StringLength(array(
                'max' => 10,
                'message' => 'A date cannot exceed 10 characters'
            ))
        ));

        $this->add($follow_up);

        // create text contact_details for company name
        $company = new Text('company', array(
            'placeholder' => 'Company',
            'maxlength' => 50,
            'class' => 'form-control'
        ));

        $company->setLabel('Company: ');

        $company->addValidators(array(
            new PresenceOf(array(
                'message' => 'Company name is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message' => 'Company name can not be more than 50 characters'
            ))
        ));

        $this->add($company);

        // create text contact_details for position
        $position = new Text('position', array(
            'placeholder' => 'Position',
            'maxlength' => 50,
            'class' => 'form-control'
        ));

        $position->setLabel('Position: ');

        $position->addValidators(array(
            new PresenceOf(array(
                'message' => 'Position is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message' => 'Position can not be more than 50 characters'
            ))
        ));

        $this->add($position);

        // create text contact_details for recruitment company name
        $recruitment = new Text('recruitment', array(
            'placeholder' => 'Recruitment Company',
            'maxlength' => 50,
            'class' => 'form-control'
        ));

        $recruitment->setLabel('Recruitment Company: ');

        $recruitment->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Recruitment Company can not be more than 50 characters'
            ))
        ));

        $this->add($recruitment);

        // create textArea contact_details for notes
        $notes = new TextArea('notes', array(
            'placeholder' => 'Notes',
            'maxlength' => 500,
            'class' => 'form-control'
        ));

        $notes->setLabel('Notes: ');

        $notes->addValidators(array(
            new StringLength(array(
                'max' => 500,
                'message' => 'Notes can not be more than 500 characters'
            ))
        ));

        // create hidden contact_details for application id
        $app_id = new Hidden('app_id', array(
            'value' => ''
        ));

        $this->add($app_id);

        $this->add($notes);

        // create submit contact_details for the form
        $submit = new Submit('Save', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}