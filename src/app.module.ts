/* eslint-disable prettier/prettier */
import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { ProdutoModule } from './produto/produto.module';
import { PedidoModule } from './pedido/pedido.module';
import { Produto } from './produto/produto.entity/produto.entity';
import { Pedido } from './pedido/pedido.entity/pedido.entity';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql',
      host: '127.0.0.1',
      port: 3306,
      username: 'root',
      password: 'root',
      database: 'pedido',
      autoLoadEntities: true,
      synchronize: true, // Use apenas em desenvolvimento
      entities: [Produto, Pedido],
    }),
    ProdutoModule,
    PedidoModule,
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule {}
