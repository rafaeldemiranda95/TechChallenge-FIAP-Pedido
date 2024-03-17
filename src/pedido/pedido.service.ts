/* eslint-disable prettier/prettier */
import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Pedido } from './pedido.entity/pedido.entity';
import { CreatePedidoDto } from './pedido.dto';
import { Produto } from 'src/produto/produto.entity/produto.entity';

@Injectable()
export class PedidoService {
  constructor(
    @InjectRepository(Pedido)
    private pedidoRepository: Repository<Pedido>,
    @InjectRepository(Produto)
    private produtoRepository: Repository<Produto>,
  ) {}

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

    return this.pedidoRepository.save(pedido);
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
