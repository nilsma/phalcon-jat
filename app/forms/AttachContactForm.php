<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;

class AttachContactForm extends Form {

    public function initialize($contacts) {

        // create select element for contacts
        $select = new Select('select', $contacts, array(
            'using' => array('id', 'name'),
            'name' => 'contacts',
            'class' => 'form-control',
            'useEmpty' => True,
            'emptyText' => 'Select a Contact',
            'emptyValue' => 'empty'
        ));

        $this->add($select);

        $submit = new Submit('Attach Contact', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}