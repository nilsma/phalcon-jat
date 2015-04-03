<?php

/**
 * Created by PhpStorm.
 * User: nilsma
 * Date: 3/26/15
 * Time: 7:10 AM
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Filter;

class RegisterUserForm extends Form {

    public function initialize() {

        // create new text contact_details for username
        $username = new Text('username', array(
            'maxlength' => 30,
            'placeholder' => 'Username'
        ));

        $username->setLabel('Username: ');

        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'Username is required'
            )),
            new StringLength(array(
                'min' => 3,
                'max' => 20
            ))
        ));

        $this->add($username);

        // create new email contact_details
        $email = new Email('email', array(
            'maxlength' => 50,
            'placeholder' => 'Email'
        ));

        $email->setLabel('Email: ');

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'Email is required'
            )),
            new StringLength(array(
                'min' => 3,
                'max' => 50
            ))
        ));

        $email->addFilter('email');

        $this->add($email);

        // create new password contact_details
        $password = new Password('password', array(
            'maxlength' => 16,
            'placeholder' => 'Password'
        ));

        $password->setLabel('Password: ');

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'A password is required'
            )),
            new StringLength(array(
                'min' => 6,
                'max' => 16
            ))
        ));

        $this->add($password);

        // create new repeat password contact_details
        $repeat = new Password('repeat', array(
            'maxlength' => 16,
            'placeholder' => 'Repeat password'
        ));

        $repeat->setLabel('Repeat Password: ');

        $repeat->addValidators(array(
            new PresenceOf(array(
                'message' => 'You must repeat the password'
            )),
            new StringLength(array(
                'min' => 6,
                'max' => 16
            )),
            new Confirmation(array(
                'message' => 'The passwords must match',
                'with' => 'password'
            ))
        ));

        $this->add($repeat);

        // create new submit contact_details
        $submit = new Submit('Register', array(
            'class' => 'btn btn-success'
        ));

        $this->add($submit);

    }

    public function beforeValidation() {

        $username = $this->request->getPost('username', array('string', 'trim', 'striptags'));
        $_POST['username'] = $username;
        
        $email = $this->request->getPost('email', array('string', 'trim', 'striptags'));
        $_POST['email'] = $email;

    }

}