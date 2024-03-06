<?php

namespace App\Service;

use App\Repository\PedidoRepository;
use Illuminate\Http\Request;

class PedidoService
{
    protected $pedidoRepository;
    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function enviarPedido(Request $request)
    {
        //
        $pedido = $this->pedidoRepository->enviarPedido($request);
        return $pedido;
    }
    public function listarPedidos()
    {
        $pedidos = $this->pedidoRepository->listarPedidos();
        return $pedidos;
    }
}
