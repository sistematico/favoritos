<?php

namespace App\Model;

use App\Utils\Database;

class Post
{
  public $id;
  public $title;
  public $description;
  public $author;
  public $category;
  public $type;
  public $file;

  public function cadastrar(): bool
  {
    $this->id = (new Database('posts'))->insert([
        'title' => $this->title,
        'description' => $this->description,
        'author' => $this->author,
        'category' => $this->category,
        'tags' => '',
        'type' => $this->type,
        'file' => $this->file,
        'likes' => 0,
        'unlikes' => 0,
        'created' => date('Y-m-d H:i:s'),
        'updated' => date('Y-m-d H:i:s')
    ]);

    return true;
  }

  public function atualizar(): bool
  {
    return (new Database('posts'))->update('id = ' . $this->id, [
      'title' => $this->title,
      'description' => $this->description,
      'author' => $this->author,
      'category' => $this->category,
      'tags' => '',
      'type' => $this->type,
      'file' => $this->file,
      'updated' => date('Y-m-d H:i:s')
    ]);
  }

  public function excluir(): bool
  {
    return (new Database('posts'))->delete('id = ' . $this->id);
  }

  public static function getPosts($where = null, $order = null, $limit = null, $field = '*')
  {
    return (new Database('posts'))->select($where, $order, $limit, $field);
  }

  public static function getPostById($id)
  {
    return self::getPosts('id = ' . $id)->fetchObject(self::class);
  }
}
