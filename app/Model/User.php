<?php

namespace App\Model;

use \App\Utils\Database;

class User
{
  public $id;
  public $nome;
  public $email;
  public $password;  

  public function cadastrar() {
    $this->id = (new Database('users'))->insert([
      'name' => $this->nome,
      'email' => $this->email,
      'password' => $this->password
    ]);

    return true;
  }

  public function atualizar() {
    return (new Database('users'))->update('id = ' . $this->id, [
        'nome' => $this->nome,
        'email' => $this->email,
        'password' => $this->password
    ]);
  }

  public function excluir() {
    return (new Database('users'))->delete('id = ' . $this->id);
  }
  
  public static function getUsers($where = null, $order = null, $limit = null, $field = '*') {
    return (new Database('users'))->select($where, $order, $limit, $field);
  }

  public static function getUserById($id) {
    return self::getUsers('id = ' . $id)->fetchObject(self::class);
  }

  public static function getUserByEmail($email) {
    return (new Database('users'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }
}