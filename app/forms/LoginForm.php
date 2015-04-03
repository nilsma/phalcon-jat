<?php
/**
 * Created by PhpStorm.
 * User: nilsma
 * Date: 3/26/15
 * Time: 6:57 AM
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class LoginForm extends Form {

    public function initialize() {

        // create new text contact_details for username
        $username = new Text('username', array(
            'placeholder' => 'Username',
            'maxlength' => 30
        ));

        $username->setLabel('Username: ');

        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'Username is required'
            )),
            new StringLength(array(
                'max' => 30,
                'message' => 'The username cannot be more than 30 characters'
            ))
        ));

        $this->add($username);

        // create password contact_details for password
        $password = new Password('password', array(
            'placeholder' => 'Password',
            'maxlength' => 16
        ));

        $password->setLabel('Password: ');

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'Password is required'
            )),
            new StringLength(array(
                'max' => 16,
                'message' => 'The password cannot be more than 16 characters'
            ))
        ));

        $this->add($password);

        // create submit contact_details for the form
        $submit = new Submit('Login', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

}