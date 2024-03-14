<?php

namespace App\Service;

use App\Repository\PedidoRepository;
use App\Repository\ProdutoRepository;

class PedidoService
{
    protected $pedidoRepository;
    protected $produtoRepository;
    public function __construct(PedidoRepository $pedidoRepository, ProdutoRepository $produtoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->produtoRepository = $produtoRepository;
    }

    public function enviarPedido($request)
    {
        $pedido = $this->pedidoRepository->enviarPedido($request);
        $precoTotal = 0;
        $tempoTotal = 0;

        foreach ($request['produtos'] as $produtoData) {
            $produto = $this->produtoRepository->listarProdutosId($produtoData['id']);
            $quantidade = $produtoData['quantidade'];
            $precoTotal += $produto->preco * $quantidade;
            $tempoTotal += $produto->tempoPreparo * $quantidade;

            // Attach produto ao pedido com quantidade
            $pedido = $this->pedidoRepository->anexarProdutos($pedido, $produto, $quantidade);
        }

        // Atualização do preço total e tempo total do pedido
        $pedido->update(['precoTotal' => $precoTotal]);
        $pedido->update(['tempoTotal' => $tempoTotal]);

        return $pedido;
    }
    public function listarPedidos()
    {
        $pedidos = $this->pedidoRepository->listarPedidos();
        return $pedidos;
    }
}
