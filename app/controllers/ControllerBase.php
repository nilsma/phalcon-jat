<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    public function setViewTypeAction() {

        $this->view->disable();

        if($this->session->has('user') && $this->session->get('auth') == True) {

            $user = unserialize($this->session->get('user'));

            $controllerName = $this->router->getControllerName();

            if($user->view_type == "OVERVIEW") {
                $user->view_type = "LIST";
            } else {
                $user->view_type = "OVERVIEW";
            }

            $user->save();
            $this->session->set('user', serialize($user));
            $this->response->redirect($controllerName . '/overview');

        }

    }

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
