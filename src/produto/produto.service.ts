/* eslint-disable prettier/prettier */
import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { CreateProdutoDto, UpdateProdutoDto } from './produto.dto';
import { Produto } from './produto.entity/produto.entity';

@Injectable()
export class ProdutoService {
  constructor(
    @InjectRepository(Produto)
    private produtoRepository: Repository<Produto>,
  ) {}

  async create(createProdutoDto: CreateProdutoDto): Promise<Produto> {
    const produto = this.produtoRepository.create(createProdutoDto);
    return this.produtoRepository.save(produto);
  }

  async findAll(): Promise<Produto[]> {
    return this.produtoRepository.find();
  }

  async findId(id: number): Promise<Produto> {
    return this.produtoRepository.findOneBy({ id });
  }

  async findByCategoria(categoria: string): Promise<Produto[]> {
    return this.produtoRepository.find({
      where: {
        categoria: categoria,
      },
    });
  }

  async update(
    id: number,
    updateProdutoDto: UpdateProdutoDto,
  ): Promise<Produto> {
    await this.produtoRepository.update(id, updateProdutoDto);
    return this.produtoRepository.findOneBy({ id });
  }

  async delete(id: number): Promise<void> {
    await this.produtoRepository.delete(id);
  }
}
