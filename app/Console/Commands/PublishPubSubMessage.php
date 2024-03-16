<?php

namespace App\Console\Commands;

use Google\Cloud\PubSub\PubSubClient;
use Illuminate\Console\Command;

class PublishPubSubMessage extends Command
{
    // Topicos
    // techchallenge-fiap-producao
    // techchallenge-fiap-pagamento
    // techchallenge-fiap-pedido
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-pub-sub-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $pubSub = new PubSubClient(['projectId' => env('FIREBASE_PROJECT_ID')]);

        $topic = $pubSub->topic('techchallenge-fiap-pagamento');

        // Publish a message to the topic.
        $topic->publish([
            'data' => 'My new message.',
            'attributes' => [
                'location' => 'Detroit'
            ]
        ]);
    }
}
