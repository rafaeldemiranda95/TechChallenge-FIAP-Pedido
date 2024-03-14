<?php

namespace App\Service;

use App\Repository\ProdutoRepository;
use Illuminate\Http\Request;

class ProdutoService
{
    protected $produtoRepository;
    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function cadastrarProduto($request)
    {
        $produto = $this->produtoRepository->cadastrarProduto($request);
        return $produto;
    }
    public function alterarProduto($request, string $id)
    {
        $produto = $this->produtoRepository->alterarProduto($request, $id);
        return $produto;
    }
    public function listarProdutos()
    {
        $produtos = $this->produtoRepository->listarProdutos();
        return $produtos;
    }
    public function listarProdutosId(string $id)
    {
        $produtos = $this->produtoRepository->listarProdutosId($id);
        return $produtos;
    }
    public function listarProdutosCategoria(string $categoria)
    {
        $produtos = $this->produtoRepository->listarProdutosCategoria($categoria);
        return $produtos;
    }
    public function apagarProdutos(string $id)
    {
        $produtos = $this->produtoRepository->apagarProdutos($id);
        return $produtos;
    }
}
