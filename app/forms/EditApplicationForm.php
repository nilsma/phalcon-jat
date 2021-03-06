<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;

class EditApplicationForm extends Form {

    public function initialize(Applications $application) {

        // create text contact_details for application company name
        $company = new Text('company', array(
            'placeholder' => 'Company Name',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $application->company
        ));

        $company->setLabel('Company: ');

        $company->addValidators(array(
            new PresenceOf(array(
                'message' => 'Company name is required'
            )),
            new StringLength(array(
                'max' => 50,
                'message' => 'Company Name may not exceed 50 characters'
            ))
        ));

        $this->add($company);

        // create text contact_details for application position name
        $position = new Text('position', array(
            'placeholder' => 'Position',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $application->position
        ));

        $position->setLabel('Position: ');

        $position->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Position may not exceed 50 characters'
            ))
        ));

        $this->add($position);

        // create text contact_details for application recruitment company
        $recruitment = new Text('recruitment', array(
            'placeholder' => 'Recruitment Company',
            'maxlength' => 50,
            'class' => 'form-control',
            'value' => $application->recruitment_company
        ));

        $recruitment->setLabel('Recruitment Company: ');

        $recruitment->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Recruitment Company may not exceed 50 characters'
            ))
        ));

        $this->add($recruitment);

        // create textArea contact_details for application notes
        $notes = new TextArea('notes', array(
            'placeholder' => 'Notes ...',
            'maxlength' => 500,
            'class' => 'form-control',
            'value' => $application->notes
        ));

        $notes->setLabel('Notes: ');

        $notes->addValidators(array(
            new StringLength(array(
                'max' => 500,
                'message' => 'Notes may not exceed 500 characters'
            ))
        ));

        $this->add($notes);

        // create date contact_details for applied date
        $applied = new Text('applied', array(
            'placeholder' => 'Enter a Date',
            'class' => 'form-control date-field',
            'value' => $application->applied
        ));

        $applied->setLabel('Applied: ');

        $this->add($applied);

        // create date contact_details for due date
        $due_date = new Text('due_date', array(
            'placeholder' => 'Enter a Date',
            'class' => 'form-control date-field',
            'value' => $application->due
        ));

        $due_date->setLabel('Due Date: ');

        $this->add($due_date);

        // create date contact_details for due date
        $follow_up = new Text('follow_up', array(
            'placeholder' => 'Enter a Date',
            'class' => 'form-control date-field',
            'value' => $application->follow_up
        ));

        $follow_up->setLabel('Follow-Up: ');

        $this->add($follow_up);

        // create hidden contact_details for application id
        $app_id = new Hidden('app_id', array(
            'value' => $application->id
        ));

        $app_id->addValidators(array(
            new Numericality(array(
                'message' => 'An application ID is required',
                'field' => 'app_id'
            ))
        ));

        $this->add($app_id);

        // create submit contact_details for application edit
        $submit = new Submit('Save', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}