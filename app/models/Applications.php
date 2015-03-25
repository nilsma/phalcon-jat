<?php

class Applications extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $owner_id;

    /**
     *
     * @var string
     */
    public $created;

    /**
     *
     * @var string
     */
    public $applied;

    /**
     *
     * @var string
     */
    public $due;

    /**
     *
     * @var string
     */
    public $follow_up;

    /**
     *
     * @var string
     */
    public $recruitment_company;

    /**
     *
     * @var string
     */
    public $company;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var string
     */
    public $notes;

}
