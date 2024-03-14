<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    /**
     * O nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'pedidos';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'tempoTotal', 'status', 'idCliente', 'precoTotal', 'listaProdutos'
    ];

    /**
     * Indica se o modelo deve usar timestamps (created_at e updated_at).
     *
     * @var bool
     */
    public $timestamps = true;

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'pedidos_produtos')->withPivot('quantidade');
    }
}
