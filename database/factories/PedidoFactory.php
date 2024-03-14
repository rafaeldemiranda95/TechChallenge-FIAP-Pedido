<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pedido;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idCliente' => $this->faker->randomNumber(), // Ou $this->faker->unique()->numberBetween(1,1000) para um ID de cliente específico
            'status' => $this->faker->randomElement(['agardando pagamento', 'em preparo', 'concluído']), // Exemplo de status
            'precoTotal' => $this->faker->randomFloat(2, 10, 100), // Gera um valor entre 10.00 e 100.00
            'tempoTotal' => $this->faker->numberBetween(10, 60), // Tempo em minutos
        ];
    }
}
