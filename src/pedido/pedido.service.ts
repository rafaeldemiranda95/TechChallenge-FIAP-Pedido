/* eslint-disable prettier/prettier */
import { Injectable, OnModuleInit } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Pedido } from './pedido.entity/pedido.entity';
import { CreatePedidoDto, EditPedidoDto } from './pedido.dto';
import { Produto } from 'src/produto/produto.entity/produto.entity';
import { PubSub } from '@google-cloud/pubsub';

@Injectable()
export class PedidoService implements OnModuleInit {
  private pubSubClient: PubSub;
  private subscriptionName = process.env.SUBSCRIPTION_STATUS_ATUALIZADO || 'subscription-pedido-realizado';

  constructor(
    @InjectRepository(Pedido)
    private pedidoRepository: Repository<Pedido>,
    @InjectRepository(Produto)
    private produtoRepository: Repository<Produto>,
  ) {
    this.pubSubClient = new PubSub({
      // opcional: especificar credenciais aqui
      // keyFilename: 'path/to/your/credentials-file.json',
  });
  }

  async onModuleInit() {
    this.listenForStatusPedidoAtualizadoMessages();
  }

  private listenForStatusPedidoAtualizadoMessages() {
    const subscription = this.pubSubClient.subscription(this.subscriptionName);

    subscription.on('message', async message => {
      console.log('Recebida mensagem:', message.data.toString());
      const editPedidoData: EditPedidoDto = JSON.parse(message.data.toString());

      await this.editPedido(editPedidoData);
      message.ack();
    });

    subscription.on('error', error => {
      console.error('Erro ao receber mensagem:', error);
    });
  }
  async editPedido(editPedidoDto: EditPedidoDto): Promise<void>{
    const pedidoId = editPedidoDto.id;
    const pedido = await this.pedidoRepository.findOneBy({id: pedidoId}) 

    if (!pedido) {
      throw new Error('Pedido not found');
    }

    pedido.status = editPedidoDto.status;

    await this.pedidoRepository.save(pedido);
  }

  async create(createPedidoDto: CreatePedidoDto): Promise<Pedido> {
    const produtos = await Promise.all(
      createPedidoDto.produtos.map(async ({ idProduto }) => {
        return this.produtoRepository.findOneBy({ id: idProduto });
      }),
    );

    const precoTotal = createPedidoDto.produtos.reduce(
      (acc, produto) => acc + produto.preco,
      0,
    );
    const tempoTotal = Math.max(
      ...createPedidoDto.produtos.map((produto) => produto.tempoPreparo),
    );

    const pedido = this.pedidoRepository.create({
      ...createPedidoDto,
      produtos,
      precoTotal,
      tempoTotal,
    });

    const savedPedido = await this.pedidoRepository.save(pedido);

    // Enviar mensagem para o tópico do Pub/Sub
    await this.publishPedidoCriado(savedPedido);

    return savedPedido;
  }

  private async publishPedidoCriado(pedido: Pedido) {
    const topicName = process.env.TOPIC_NAME; // Assegure-se de que esta variável de ambiente está configurada
    const dataBuffer = Buffer.from(JSON.stringify(pedido));

    try {
      const messageId = await this.pubSubClient.topic(topicName).publishMessage({
        data: dataBuffer,
    });
      console.log(`Mensagem ${messageId} publicada para o tópico ${topicName}`);
    } catch (error) {
      console.error(`Erro ao publicar mensagem: ${error.message}`);
    }
  }

  async findAll(): Promise<Pedido[]> {
    return this.pedidoRepository.find({
      relations: ['produtos'], // Caso você queira trazer os produtos relacionados a cada pedido
    });
  }

  async findId(id: number): Promise<Pedido> {
    return this.pedidoRepository.findOne({
      where: { id },
      relations: ['produtos'],
    });
  }
}
