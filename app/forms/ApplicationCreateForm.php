<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\PresenceOf;

class ApplicationCreateForm extends Form {

    public function initialize(Applications $app_state) {

        // create date element for applied date
        $applied = new Date("applied", array(
            'placeholder' => 'Application Date',
            'value' => $app_state->applied
        ));

        $applied->setLabel('Applied: ');

        $this->add($applied);

        // create date element for due_date
        $due_date = new Date("due_date", array(
            'placeholder' => 'Application Due Date',
            'value' => $app_state->due
        ));

        $due_date->setLabel('Due Date: ');

        $this->add($due_date);

        // create date element for follow-up
        $follow_up = new Date("follow_up", array(
            'placeholder' => 'Application Follow-Up Date',
            'value' => $app_state->follow_up
        ));

        $follow_up->setLabel('Follow-Up Date: ');

        $this->add($follow_up);

        // create text element for company name
        $company = new Text('company', array(
            'placeholder' => 'Company',
            'maxlength' => 50,
            'value' => $app_state->company
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

        // create text element for position
        $position = new Text('position', array(
            'placeholder' => 'Position',
            'maxlength' => 50,
            'value' => $app_state->position
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

        // create text element for recruitment company name
        $recruitment = new Text('recruitment', array(
            'placeholder' => 'Recruitment Company',
            'maxlength' => 50,
            'value' => $app_state->recruitment_company
        ));

        $recruitment->setLabel('Recruitment Company: ');

        $recruitment->addValidators(array(
            new StringLength(array(
                'max' => 50,
                'message' => 'Recruitment Company can not be more than 50 characters'
            ))
        ));

        $this->add($recruitment);

        // create textArea element for notes
        $notes = new TextArea('notes', array(
            'placeholder' => 'Notes',
            'maxlength' => 500,
            'value' => $app_state->notes
        ));

        $notes->setLabel('Notes: ');

        $notes->addValidators(array(
            new StringLength(array(
                'max' => 500,
                'message' => 'Notes can not be more than 500 characters'
            ))
        ));

        $this->add($notes);

        // create submit element for the form
        $submit = new Submit('Save Application', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}