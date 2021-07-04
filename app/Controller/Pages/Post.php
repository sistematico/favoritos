<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Post as EntityPost;
use \App\Utils\Pagination;

class Post extends Page
{
    // CREATE TABLE "posts" (
    //     id INTEGER primary key autoincrement,
    //     title TEXT not null,
    //     description TEXT,
    //     author INTEGER references users,
    //     type TEXT,
    //     file TEXT,
    //     likes INTEGER,
    //     unlikes INTEGER,
    //     created TEXT default CURRENT_DATE,
    //     updated TEXT default CURRENT_DATE
    // )

    private static function getStatus($request) {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Post criado com sucesso');
            case 'updated':
                return Alert::getSuccess('Post atualizado com sucesso');
            case 'deleted':
                return Alert::getSuccess('Post apagado com sucesso');
            default:
                return '';
        }
    }

    public static function getPostItems($request, &$obPagination): string
    {
        $itens = '';
        
        $quantidadeTotal = EntityPost::getPosts(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
        
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        $perPage = $queryParams['pp'] ?? PER_PAGE;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, $perPage);

        $results = EntityPost::getPosts(null, 'id DESC', $obPagination->getLimit());

        while ($row = $results->fetchObject(EntityPost::class)) {
            $itens .= View::render('pages/post/item', [
                'title' => $row->title,
                'description' => $row->description,
                'author' => $row->author,
                'type' => $row->type,
                'file' => $row->file,
                'likes' => $row->likes,
                'unlikes' => $row->unlikes,
                'updated' => date('d/m/Y H:i:s', strtotime($row->updated)),
                'created' => date('d/m/Y H:i:s', strtotime($row->created))
            ]);
        }
        return $itens;
    }

    public static function getPosts($request)
    {
        $content = View::render('pages/post/posts', [
            'itens' => self::getPostItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('Posts', $content);
    }

    public static function addPost()
    {
        $content = View::render('pages/post/form');
        return parent::getPage('Posts', $content);
    }

    public static function addImage($request)
    {
        $content = View::render('pages/post/image', [
            'itens' => self::getPostItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('Posts', $content);
    }

    public static function addVideo($request)
    {
        $content = View::render('pages/post/video', [
            'itens' => self::getPostItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('Posts', $content);
    }

    public static function insertPost($request)
    {
        $postVars = $request->getPostVars();

        $obPost = new EntityPost;
        $obPost->title = $postVars['title'];
        $obPost->description = $postVars['description'];
        $obPost->author = $postVars['author'];
        $obPost->type = $postVars['type'];
        $obPost->file = UPLOAD_DIR . '/' . basename($_FILES['userfile']['name']) ?? NULL;
        
        $obPost->cadastrar();

        $status = View::render('components/alert/status', [
            'status' => self::getStatus($request)
        ]);

        return View::render('pages/post/form', ['status' => $status]);

        //return parent::getPage('Posts', $status);
        //return self::getPosts($request);
    }

    public static function uploadFile($dir): bool
    {
        $uploadfile = $dir . basename($_FILES['userfile']['name']);
        
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            return true;
        }

        return false;
    }

}