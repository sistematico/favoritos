<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\Post as EntityPost;
use \App\Utils\Pagination;

class Post extends Page
{
    private static function getStatus($request) {
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Post criado com sucesso');
                break;
            case 'updated':
                return Alert::getSuccess('Post atualizado com sucesso');
                break;
            case 'deleted':
                return Alert::getSuccess('Post apagado com sucesso');
                break;
            default:
                return '';
                break;
        }
    }

    public static function getPostItems($request, &$obPagination)
    {
        $itens = '';
        
        $quantidadeTotal = EntityPost::getPosts(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
       
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;
        $perPage = $queryParams['pp'] ?? PER_PAGE;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, $perPage);

        $results = EntityPost::getPosts(null, 'id DESC', $obPagination->getLimit());

        while ($row = $results->fetchObject(EntityPost::class)) {
            $itens .= View::render('admin/modules/posts/item', [
                'id' => $row->id,
                'nome' => $row->nome,
                'mensagem' => $row->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($row->data))
            ]);
        }
        return $itens;
    }

    public static function getPosts($request) {
        $content = View::render('admin/modules/posts/index', [
            'itens' => self::getPostItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);
        return parent::getPanel('Depoimentos', $content, 'posts');
    }

    public static function getNewPost($request) {
        $content = View::render('admin/modules/posts/form', [
            'title' => 'Cadastro',
            'nome' => '',
            'mensagem' => '',
            'status' => ''
        ]);
        return parent::getPanel('Cadastrar depoimento', $content, 'posts');        
    }

    public static function setNewPost($request) {
        $postVars = $request->getPostVars();
        $obPost = new EntityPost;
        $obPost->nome = $postVars['nome'] ?? '';
        $obPost->mensagem = $postVars['mensagem'] ?? '';
        $obPost->cadastrar();

        $request->getRouter()->redirect('/admin/posts/' . $obPost->id . '/edit?status=created');
    }

    public static function getEditPost($request, $id) {
        $obPost = EntityPost::getPostById($id);

        if (!$obPost instanceof EntityPost) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $content = View::render('admin/modules/posts/form', [
            'title' => 'Editar depoimento',
            'nome' => $obPost->nome,
            'mensagem' => $obPost->mensagem,
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Editar depoimento', $content, 'posts');
    }

    public static function setEditPost($request, $id) {
        $obPost = EntityPost::getPostById($id);

        if (!$obPost instanceof EntityPost) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $postVars = $request->getPostVars();

        $obPost->nome = $postVars['nome'] ?? $obPost->nome;
        $obPost->mensagem = $postVars['mensagem'] ?? $obPost->mensagem;
        $obPost->atualizar();

        $request->getRouter()->redirect('/admin/posts/' . $obPost->id . '/edit?status=updated');
    }

    public static function getDeletePost($request, $id) {
        $obPost = EntityPost::getPostById($id);

        if (!$obPost instanceof EntityPost) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $content = View::render('admin/modules/posts/delete', [
            'nome' => $obPost->nome,
            'mensagem' => $obPost->mensagem
        ]);

        return parent::getPanel('Excluir depoimento', $content, 'posts');
    }

    public static function setDeletePost($request, $id) {
        $obPost = EntityPost::getPostById($id);

        if (!$obPost instanceof EntityPost) {
            $request->getRouter()->redirect('/admin/posts');
        }

        $obPost->excluir();

        $request->getRouter()->redirect('/admin/posts?status=deleted');
    }
}