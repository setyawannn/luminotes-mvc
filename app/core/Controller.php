<?php

class Controller {
    public function view($view, $data = [])
    {
        // Pastikan view ada
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            exit('Error: View ' . $view . '.php not found.');
        }
    }

    public function model($model)
    {
        // Pastikan model ada
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model;
        } else {
            exit('Error: Model ' . $model . '.php not found.');
        }
    }
}