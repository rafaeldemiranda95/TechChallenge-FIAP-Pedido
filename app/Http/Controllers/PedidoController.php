<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Service\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    protected $pedidoService;
    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::all();
        $pedidos =  $this->pedidoService->listarPedidos();
        return response()->json(['data' => $pedidos], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate(
                [
                    'idCliente' => 'required',
                    'status' => 'required|string',
                    'produtos' => 'required|array',
                    'produtos.*.id' => 'required|exists:produtos,id',
                    'produtos.*.quantidade' => 'required|integer|min:1',
                ],
                [
                    'status.required' => 'O campo status é obrigatório.',
                    'status.string' => 'O campo status deve ser um texto.',
                    'idCliente.required' => 'O campo idCliente é obrigatório.',
                    'produtos.*.id.required' => 'O id do produto é obrigatório.',
                    'produtos.*.id.exists' => 'O id de produto fornecido não existe.',
                    'produtos.*.quantidade.required' => 'A quantidade do produto é obrigatório.',
                    'produtos.*.quantidade.integer' => 'A quantidade do produto deve ser um número inteiro.',
                    'produtos.*.quantidade.min' => 'A quantidade do produto deve ser no mínimo 1.',
                ]
            );

            $pedio =  $this->pedidoService->enviarPedido($validatedData);
            return response()->json(['success' => 'Pedido realizado com sucesso.', 'data' => $pedio], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
