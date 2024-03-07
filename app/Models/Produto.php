<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
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
}
