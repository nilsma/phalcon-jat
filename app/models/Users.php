<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;

class Users extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $sorting;

    /**
     *
     * @var string
     */
    public $filter;

    /**
     * Validations and business logic
     */
    public function validation() {

        $this->validate(new UniquenessValidator(array(
                'field' => 'username',
                'message' => 'That username is already registered'
            ))
        );

        $this->validate(new UniquenessValidator(array(
                'field' => 'email',
                'message' => 'That email is already registered'
            ))
        );

        $this->validate(new Email(array(
                'field'    => 'email',
                'required' => true,
            ))
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
