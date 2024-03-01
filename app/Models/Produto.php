<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
     * Indica se os IDs são incrementados automaticamente.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * O tipo de dados da chave primária.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indica se o modelo deve usar timestamps (created_at e updated_at).
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * O evento de "booting" do modelo.
     *
     * Este método será chamado automaticamente pelo Eloquent quando um novo
     * modelo é instanciado. Aqui, registramos um callback para o evento "creating",
     * que será disparado antes de um registro ser criado. Dentro deste callback,
     * verificamos se o campo da chave primária (neste caso, 'id') já está preenchido.
     * Se não estiver, geramos um UUID e o atribuímos como o 'id' do modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}
