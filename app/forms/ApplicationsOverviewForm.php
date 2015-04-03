<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\StringLength;

class ApplicationsOverviewForm extends Form {

    public function initialize(Applications $application) {

        // create text contact_details for application company name
        $company = new Text('company', array(
            'placeholder' => 'Company Name',
            'maxlength' => 50,
            'disabled' => 'disabled',
            'class' => 'form-control',
            'value' => $application->company
        ));

        $company->setLabel('Company Name: ');

        $company->addValidators(array(
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
            'disabled' => 'disabled',
            'class' => 'form-control',
            'value' => $application->position
        ));

        $position->setLabel('Position: ');

        $company->addValidators(array(
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
            'disabled' => 'disabled',
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
            'disabled' => 'disabled',
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
        $applied = new Date('applied', array(
            'placeholder' => 'Enter a Date',
            'disabled' => 'disabled',
            'class' => 'form-control',
            'value' => $application->applied
        ));

        $applied->setLabel('Applied: ');

        $this->add($applied);

        // create date contact_details for due date
        $due_date = new Date('due_date', array(
            'placeholder' => 'Enter a Date',
            'disabled' => 'disabled',
            'class' => 'form-control',
            'value' => $application->due
        ));

        $due_date->setLabel('Due Date: ');

        $this->add($due_date);

        // create date contact_details for due date
        $follow_up = new Date('follow_up', array(
            'placeholder' => 'Enter a Date',
            'disabled' => 'disabled',
            'class' => 'form-control',
            'value' => $application->follow_up
        ));

        $follow_up->setLabel('Follow-Up: ');

        $this->add($follow_up);

        // create hidden contact_details for application id
        $app_id = new Hidden('app_id', array(
            'value' => $application->id
        ));

        $this->add($app_id);

        // create submit contact_details for application edit
        $submit = new Submit('Edit', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}