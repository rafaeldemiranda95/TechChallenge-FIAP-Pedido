<?php

namespace App\Repository;

use App\Models\Pedido;

class PedidoRepository
{

    public function listarPedidos()
    {
        $pedidos = Pedido::with(['produtos' => function ($query) {
            $query->select('produtos.id', 'name', 'preco')->withPivot('quantidade');
        }])->get();
        return $pedidos;
    }
    public function enviarPedido($request)
    {
        $pedido = Pedido::create([
            'idCliente' => $request['idCliente'],
            'status' => $request['status'],
            'precoTotal' => 0,
            'tempoTotal' => 0,
        ]);
        return $pedido;
    }
    public function anexarProdutos($pedido, $produto, $quantidade)
    {
        $pedido->produtos()->attach($produto->id, ['quantidade' => $quantidade]);
        return $pedido;
    }
}
