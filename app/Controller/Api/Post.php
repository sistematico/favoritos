<?php

namespace App\Controller\Api;

use \App\Model\Entity\Post as EntityPost;
use \App\Utils\Pagination;

class Post extends Api
{
    public static function getPostItems($request, &$obPagination)
    {
        $itens = [];
        
        $quantidadeTotal = EntityPost::getPosts(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
       
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        $results = EntityPost::getPosts(null, 'id DESC', $obPagination->getLimit());

        while ($row = $results->fetchObject(EntityPost::class)) {
            $itens[] = [
                'id' => (int) $row->id,
                'nome' => $row->nome,
                'mensagem' => $row->mensagem,
                'data' => $row->data
            ];
        }
        return $itens;
    }

    public static function getPosts($request) {
        return [
            'depoimentos' => self::getPostItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getPost($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O ID: " . $id . " não é válido", 400);            
        }

        $obPost = EntityPost::getPostById($id);

        if (!$obPost instanceof EntityPost) {
            throw new \Exception("O depoimento ID: " . $id . " não foi encontrado.", 404);            
        }

        return [
            'id' => (int) $obPost->id,
            'nome' => $obPost->nome,
            'mensagem' => $obPost->mensagem,
            'data' => $obPost->data
        ];
    }

    public static function setNewPost($request) {
        $postVars = $request->getPostVars();

        if (!isset($postVars['nome']) || !isset($postVars['mensagem'])) {
            throw new \Exception("Os campos nome e mensagem são obrigatórios", 400);            
        }

        $obPost = new EntityPost;
        $obPost->nome = $postVars['nome'];
        $obPost->mensagem = $postVars['mensagem'];
        $obPost->cadastrar();
        
        return [ 
            'id' => (int) $obPost->id,
            'nome' => $obPost->nome,
            'mensagem' => $obPost->mensagem,
            'data' => $obPost->data
        ];
    }

    public static function setEditPost($request, $id) {
        $postVars = $request->getPostVars();

        if (!isset($postVars['nome']) || !isset($postVars['mensagem'])) {
            throw new \Exception("Os campos nome e mensagem são obrigatórios", 400);            
        }

        $obPost = EntityPost::getPostById($id);
        
        if (!$obPost instanceof EntityPost) {
            throw new \Exception("O depoimento ID: " . $id . " não foi encontrado.", 404);
        }

        $obPost->nome = $postVars['nome'];
        $obPost->mensagem = $postVars['mensagem'];
        $obPost->atualizar();
        
        return [ 
            'id' => (int) $obPost->id,
            'nome' => $obPost->nome,
            'mensagem' => $obPost->mensagem,
            'data' => $obPost->data
        ];
    }

    public static function setDeletePost($request, $id) {
        $obPost = EntityPost::getPostById($id);
        
        if (!$obPost instanceof EntityPost) {
            throw new \Exception("O depoimento ID: " . $id . " não foi encontrado.", 404);
        }

        $obPost->excluir();
        
        return [ 
            'success' => true
        ];
    }
}