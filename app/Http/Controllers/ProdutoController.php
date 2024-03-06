<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Service\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProdutoController extends Controller
{
    protected $produtoService;
    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produtos = $this->produtoService->listarProdutos();
        // $produtos = Produto::all();
        return response()->json(['data' => $produtos], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return response()->json(['message' => 'Produto criado com sucesso!', 'data' => $produto], 201);
        try {
            // Validação dos dados
            $validatedData = $request->validate(
                [
                    'name' => 'required|string|max:100',
                    'categoria' => 'required|string|max:255',
                    'descricao' => 'required|string',
                    'preco' => 'required|numeric',
                    'tempoPreparo' => 'required|integer',
                ],
                [
                    'name.required' => 'O campo nome é obrigatório.',
                    'name.string' => 'O campo nome deve ser um texto.',
                    'name.max' => 'O campo nome deve ter no máximo 100 caracteres.',
                    'categoria.required' => 'O campo categoria é obrigatório.',
                    'categoria.string' => 'O campo categoria deve ser um texto.',
                    'categoria.max' => 'O campo categoria deve ter no máximo 255 caracteres.',
                    'descricao.required' => 'O campo descrição é obrigatório.',
                    'descricao.string' => 'O campo descrição deve ser um texto.',
                    'preco.required' => 'O campo preço é obrigatório.',
                    'preco.numeric' => 'O campo preço deve ser um número.',
                    'tempoPreparo.required' => 'O campo Tempo de Preparo é obrigatório.',
                    'tempoPreparo.integer' => 'O campo Tempo de Preparo deve ser um número inteiro.',
                ]
            );

            // $produto = Produto::firstOrCreate($validatedData);
            $produto = $this->produtoService->cadastrarProduto($request);
            return response()->json(['message' => 'Produto criado com sucesso!', 'data' => $produto], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $produtos = $this->produtoService->listarProdutosId($id);
        $produto = Produto::find($id);
        return response()->json(['data' => $produto], 200);
    }
    /**
     * Display the specified resource.
     */
    public function showCategoria(string $categoria)
    {
        //
        $produtos = $this->produtoService->listarProdutosCategoria($categoria);
        // $produtos = Produto::where("categoria", $categoria)
        //     ->orderBy('name')
        //     ->get();
        return response()->json(['data' => $produtos], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //
            $validatedData = $request->validate(
                [
                    'name' => 'required|string|max:100',
                    'categoria' => 'required|string|max:255',
                    'descricao' => 'required|string',
                    'preco' => 'required|numeric',
                    'tempoPreparo' => 'required|integer',
                ],
                [
                    'name.required' => 'O campo nome é obrigatório.',
                    'name.string' => 'O campo nome deve ser um texto.',
                    'name.max' => 'O campo nome deve ter no máximo 100 caracteres.',
                    'categoria.required' => 'O campo categoria é obrigatório.',
                    'categoria.string' => 'O campo categoria deve ser um texto.',
                    'categoria.max' => 'O campo categoria deve ter no máximo 255 caracteres.',
                    'descricao.required' => 'O campo descrição é obrigatório.',
                    'descricao.string' => 'O campo descrição deve ser um texto.',
                    'preco.required' => 'O campo preço é obrigatório.',
                    'preco.numeric' => 'O campo preço deve ser um número.',
                    'tempoPreparo.required' => 'O campo Tempo de Preparo é obrigatório.',
                    'tempoPreparo.integer' => 'O campo Tempo de Preparo deve ser um número inteiro.',
                ]
            );
            // $produto = Produto::find("id", $id)
            //     ->update($validatedData);

            $produto = $this->produtoService->alterarProduto($request, $id);
            return response()->json(['message' => 'Produto alterado com sucesso!', 'data' => $produto], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // $produto = Produto::destroy($id);
        $produto = $this->produtoService->apagarProdutos($id);
        return response()->json(['message' => 'Produto excluido com sucesso!', 'data' => $produto], 201);
    }
}
