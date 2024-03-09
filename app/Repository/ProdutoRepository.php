<?php

namespace App\Repository;

use App\Models\Produto;

class ProdutoRepository
{

    public function listarProdutos()
    {
        $produtos = Produto::all();
        return $produtos;
    }
    public function listarProdutosId(string $id)
    {
        $produto = Produto::find($id);
        return $produto;
    }
    public function listarProdutosCategoria(string $categoria)
    {
        $produtos = Produto::where("categoria", $categoria)
            ->orderBy('name')
            ->get();
        return $produtos;
    }
    public function apagarProdutos(string $id)
    {
        $produto = Produto::destroy($id);
        return $produto;
    }
    public function cadastrarProduto($request)
    {
        $produto = Produto::firstOrCreate($request);

        return $produto;
    }
    public function alterarProduto($request, string $id)
    {
        $produto = Produto::find($id)
            ->update($request);
        return $produto;
    }
}
