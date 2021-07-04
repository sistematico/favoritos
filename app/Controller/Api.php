<?php

namespace App\Controller;

class Api
{
    protected static function getPagination($request, $obPagination) {
        $queryParams = $request->getQueryParams();
        $pages = $obPagination->getPages();

        return [
            'paginaAtual' => isset($queryParams['page']) ? (int) $queryParams : 1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];
    }
}