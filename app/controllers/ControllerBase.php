<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
