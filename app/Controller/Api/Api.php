<?php

namespace App\Controller\Api;

class Api
{
    public static function getDetails($request) {
        return [
            'nome' => 'API PrivateHub',
            'versao' => 'v1.0.0',
            'autor' => 'Lucas Saliés Brum',
            'email' => 'lucas@archlinux.com.br'
        ];
    }

    protected static function getPagination($request, $obPagination) {
        $queryParams = $request->getQueryParams();
        $pages = $obPagination->getPages();

        return [
            'paginaAtual' => isset($queryParams['page']) ? (int) $queryParams : 1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];
    }
}