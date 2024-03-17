import { Module } from '@nestjs/common';
import { PedidoService } from './pedido.service';
import { PedidoController } from './pedido.controller';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Pedido } from './pedido.entity/pedido.entity';
import { Produto } from 'src/produto/produto.entity/produto.entity';

@Module({
  imports: [TypeOrmModule.forFeature([Pedido, Produto])],
  providers: [PedidoService],
  controllers: [PedidoController],
})
export class PedidoModule {}
