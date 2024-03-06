<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Service\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

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
        //
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
                    'tempoTotal' => 'required|integer',
                    'status' => 'required|string|max:25',
                    'idCliente' => 'required|string',
                    'precoTotal' => 'required|numeric',
                    'listaProdutos' => 'required|json',
                ],
                [
                    'status.required' => 'O campo status é obrigatório.',
                    'status.string' => 'O campo status deve ser um texto.',
                    'status.max' => 'O campo status deve ter no máximo 25 caracteres.',
                    'idCliente.required' => 'O campo idCliente é obrigatório.',
                    'idCliente.string' => 'O campo idCliente deve ser um texto.',
                    'precoTotal.required' => 'O campo Preço Total é obrigatório.',
                    'precoTotal.numeric' => 'O campo Preço Total deve ser um número.',
                    'tempoTotal.required' => 'O campo Tempo Todal é obrigatório.',
                    'tempoTotal.integer' => 'O campo Tempo Todal deve ser um número inteiro.',
                ]
            );

            $produtos = json_decode($request->listaProdutos, true);

            foreach ($produtos['produtos'] as $produto) {
                if (!isset($produto['id']) || !isset($produto['quantidade']) || !isset($produto['preco']) || !isset($produto['produto'])) {
                    return response()->json(['error' => 'A estrutura da lista de produtos é inválida.'], 422);
                }
            }
            // $pedio = Pedido::firstOrCreate($validatedData);
            $pedio =  $this->pedidoService->enviarPedido($request);
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
