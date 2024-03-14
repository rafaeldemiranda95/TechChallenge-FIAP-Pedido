<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    /**
     * O nome da tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'produtos';

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'categoria', 'descricao', 'preco', 'tempoPreparo',
    ];

    /**
     * Indica se o modelo deve usar timestamps (created_at e updated_at).
     *
     * @var bool
     */
    public $timestamps = true;

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot('quantidade');
    }
}
