/* eslint-disable prettier/prettier */
import { Controller, Post, Body, Get, Param } from '@nestjs/common';
import { PedidoService } from './pedido.service';
import { CreatePedidoDto } from './pedido.dto';
import { Pedido } from './pedido.entity/pedido.entity';

@Controller('pedidos')
export class PedidoController {
  constructor(private readonly pedidoService: PedidoService) {}

  @Post()
  async create(@Body() createPedidoDto: CreatePedidoDto): Promise<Pedido> {
    return this.pedidoService.create(createPedidoDto);
  }

  @Get()
  async findAll(): Promise<Pedido[]> {
    return this.pedidoService.findAll();
  }

  @Get(':id')
  async findId(@Param('id') id: number): Promise<Pedido> {
    return this.pedidoService.findId(id);
  }
}
