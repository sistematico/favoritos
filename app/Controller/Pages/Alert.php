<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Alert
{
    public static function getSuccess($message) {
        return View::render('components/alert/status', [
            'typo' => 'success',
            'message' => $message
        ]);
    }

    public static function getError($message) {
        return View::render('components/alert/status', [
            'typo' => 'danger',
            'message' => $message
        ]);
    }
}