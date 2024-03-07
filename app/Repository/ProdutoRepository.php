<?php

namespace App\Repository;

use App\Models\Produto;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Laravel\Firebase\Facades\Firebase;

class ProdutoRepository
{
    private $firestore;
    private $database;
    public function __construct(Firestore $firestore)
    {
        $this->firestore = $firestore;
        $this->database = $this->firestore->database();
    }
    public function listarProdutos()
    {
        $data = [
            'nome' => 'João',
            'idade' => 30,
            'email' => 'joao@example.com'
        ];

        $this->database->collection('usuarios')->add($data);
        // $produtos = Produto::all();
        return response()->json(['data' => "Funciona"], 200);
    }
    public function listarProdutosId(string $id)
    {
        $produtos = Produto::where('id', $id)
            ->orderBy('categoria')
            ->get();
        return response()->json(['data' => $produtos], 200);
    }
    public function listarProdutosCategoria(string $categoria)
    {
        $produtos = Produto::where("categoria", $categoria)
            ->orderBy('name')
            ->get();
        return response()->json(['data' => $produtos], 200);
    }
    public function apagarProdutos(string $id)
    {
        $produto = Produto::destroy($id);
        return response()->json(['message' => 'Produto excluido com sucesso!', 'data' => $produto], 201);
    }
    public function cadastrarProduto(Request $request)
    {
        $produto = Produto::firstOrCreate($request);

        return $produto;
    }
    public function alterarProduto(Request $request, string $id)
    {
        $produto = Produto::find("id", $id)
            ->update($request);
        return $produto;
    }
}