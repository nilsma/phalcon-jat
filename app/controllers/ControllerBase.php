<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    protected function getUserViewTypes(Users $user) {

        $view_types = new stdClass();

        $base_classes = "btn btn-default";
        $view_types->details_classes = $base_classes;
        $view_types->list_classes = $base_classes;

        if($user->view_type == "OVERVIEW") {
            $view_types->details_classes = $base_classes .= ' active';
        } else {
            $view_types->list_classes = $base_classes .= ' active';
        }

        return $view_types;
    }

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
