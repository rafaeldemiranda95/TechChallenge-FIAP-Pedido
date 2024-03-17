/* eslint-disable prettier/prettier */
import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Pedido } from './pedido.entity/pedido.entity';
import { CreatePedidoDto } from './pedido.dto';
import { Produto } from 'src/produto/produto.entity/produto.entity';
import { PubSub } from '@google-cloud/pubsub';

@Injectable()
export class PedidoService {
  constructor(
    @InjectRepository(Pedido)
    private pedidoRepository: Repository<Pedido>,
    @InjectRepository(Produto)
    private produtoRepository: Repository<Produto>,
    private pubSubClient = new PubSub()
  ) { }

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

    await this.publishPedidoCriado(savedPedido);

    return savedPedido;
  }

  private async publishPedidoCriado(pedido: Pedido) {
    const topicName = process.env.TOPIC_NAME;
    const dataBuffer = Buffer.from(JSON.stringify(pedido));

    try {
      await this.pubSubClient.topic(topicName).publish(dataBuffer);
      console.log(`Mensagem publicada para o tópico ${topicName}`);
    } catch (error) {
      console.error(`Erro ao publicar mensagem: ${error.message}`);
    }
  }

  async findAll(): Promise<Pedido[]> {
    return this.pedidoRepository.find({
      relations: ['produtos'],
    });
  }

  async findId(id: number): Promise<Pedido> {
    return this.pedidoRepository.findOne({
      where: { id },
      relations: ['produtos'],
    });
  }
}
