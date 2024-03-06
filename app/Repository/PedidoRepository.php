<?php

namespace App\Repository;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoRepository
{

    public function listarPedidos()
    {
        $pedidos = Pedido::all();
        return $pedidos;
    }
    public function enviarPedido(Request $request)
    {
        $pedido = Pedido::firstOrCreate($request);
        return $pedido;
    }
}
