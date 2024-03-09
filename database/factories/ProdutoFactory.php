<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * Este atributo diz à factory qual modelo ela deve criar.
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'categoria' => $this->faker->randomElement(['Bebida', 'Lanche', 'Sobremesa', 'Acompanhamento']),
            'descricao' => $this->faker->sentence(),
            'preco' => $this->faker->randomFloat(2, 5, 100), // Preço entre 5.00 e 100.00
            'tempoPreparo' => $this->faker->numberBetween(5, 40), // Tempo de preparo entre 5 e 40 minutos
        ];
    }
}
