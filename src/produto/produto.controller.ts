/* eslint-disable prettier/prettier */
import {
  Controller,
  Post,
  Body,
  Get,
  Param,
  Put,
  Delete,
} from '@nestjs/common';
import { ProdutoService } from './produto.service';
import { CreateProdutoDto, UpdateProdutoDto } from './produto.dto';
import { Produto } from './produto.entity/produto.entity';

@Controller('produtos')
export class ProdutoController {
  constructor(private readonly produtoService: ProdutoService) {}

  @Post()
  async create(@Body() createProdutoDto: CreateProdutoDto): Promise<Produto> {
    return this.produtoService.create(createProdutoDto);
  }

  @Get()
  async findAll(): Promise<Produto[]> {
    return this.produtoService.findAll();
  }

  @Get(':id')
  async findId(@Param('id') id: number): Promise<Produto> {
    return this.produtoService.findId(id);
  }

  @Get('categoria/:categoria')
  async findByCategoria(
    @Param('categoria') categoria: string,
  ): Promise<Produto[]> {
    return this.produtoService.findByCategoria(categoria);
  }

  @Put(':id')
  async update(
    @Param('id') id: number,
    @Body() updateProdutoDto: UpdateProdutoDto,
  ): Promise<Produto> {
    return this.produtoService.update(id, updateProdutoDto);
  }

  @Delete(':id')
  async delete(@Param('id') id: number): Promise<void> {
    return this.produtoService.delete(id);
  }
}
