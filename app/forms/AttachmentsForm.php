<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;

class AttachmentsForm extends Form {

    public function initialize($contacts) {

        // create select contact_details for contacts
        $select = new Select('select', $contacts, array(
            'using' => array('id', 'name'),
            'name' => 'select-contact',
            'id' => 'select-contact',
            'class' => 'form-control',
            'useEmpty' => True,
            'emptyText' => 'Select a Contact',
            'emptyValue' => -1
        ));

        $this->add($select);

        $submit = new Submit('Attach Contact', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}