<?php

namespace App\Controller\Pages;

use App\Utils\View;
use \App\Session\User\Login as SessionUserLogin;

class Profile extends Page
{

  public static function getHome() {
    $logged = SessionUserLogin::isLogged() ? 'sim' : 'nao';    
    $content = View::render('user/profile',['logged' => $logged]);
    return parent::getPage('PrivateHub - Seu Perfil', $content);
  }

}
