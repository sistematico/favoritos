<?php

namespace App\Controller\Api;

use \App\Model\Entity\User as EntityUser;
use \App\Utils\Pagination;

class User extends Api
{
    public static function getUserItems($request, &$obPagination)
    {
        $itens = [];
        
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
       
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        $results = EntityUser::getUsers(null, 'id ASC', $obPagination->getLimit());

        while ($row = $results->fetchObject(EntityUser::class)) {
            $itens[] = [
                'id' => (int) $row->id,
                'nome' => $row->nome,
                'email' => $row->email
            ];
        }
        return $itens;
    }

    public static function getUsers($request) {
        return [
            'depoimentos' => self::getUserItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)
        ];
    }

    public static function getUser($request, $id) {
        if (!is_numeric($id)) {
            throw new \Exception("O ID: " . $id . " não é válido", 400);            
        }

        $obUser = EntityUser::getUserById($id);
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ID: " . $id . " não foi encontrado.", 404);            
        }

        return [
            'id' => (int) $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];
    }

    public static function getCurrentUser($request) {
        $obUser = $request->user;
        
        return [
            'id' => (int) $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];
    }

    public static function setNewUser($request) {
        $postVars = $request->getPostVars();

        if (!isset($postVars['nome']) || !isset($postVars['email']) || !isset($postVars['password'])) {
            throw new \Exception("Os campos nome, email e senha são obrigatórios", 400);            
        }

        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if ($obUserEmail instanceof EntityUser) {
            throw new \Exception("O e-mail: " . $postVars['email'] . " já está em uso.", 400);            
        }

        $obUser = new EntityUser;
        $obUser->nome = $postVars['nome'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $obUser->cadastrar();
        
        return [ 
            'id' => (int) $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email
        ];
    }

    public static function setEditUser($request, $id) {
        $postVars = $request->getPostVars();

        if (!isset($postVars['nome']) || !isset($postVars['email']) || !isset($postVars['password'])) {
            throw new \Exception("Os campos nome, email e senha são obrigatórios", 400);            
        }

        $obUser = EntityUser::getUserById($id);
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ID: " . $id . " não foi encontrado.", 404);            
        }

        $obUserEmail = EntityUser::getUserByEmail($postVars['email']);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id) {
            throw new \Exception("O e-mail: " . $postVars['email'] . " já está em uso.", 400);            
        }

        $obUser->nome = $postVars['nome'];
        $obUser->email = $postVars['email'];
        $obUser->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $obUser->atualizar();
        
        return [ 
            'id' => (int) $obUser->id,
            'name' => $obUser->name,
            'email' => $obUser->email
        ];
    }

    public static function setDeleteUser($request, $id) {
        $obUser = EntityUser::getUserById($id);
        
        if (!$obUser instanceof EntityUser) {
            throw new \Exception("O usuário ID: " . $id . " não foi encontrado.", 404);
        }

        if ($obUser->id == $request->user->id) {
            throw new \Exception("Não é possível excluir o cadastro atualmente conectado.", 400);
        }

        $obUser->excluir();
        
        return [ 
            'success' => true
        ];
    }
}