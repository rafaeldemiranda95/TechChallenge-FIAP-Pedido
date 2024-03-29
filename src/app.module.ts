/* eslint-disable prettier/prettier */
import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { ProdutoModule } from './produto/produto.module';
import { PedidoModule } from './pedido/pedido.module';
import { Produto } from './produto/produto.entity/produto.entity';
import { Pedido } from './pedido/pedido.entity/pedido.entity';
import { ConfigModule, ConfigService } from '@nestjs/config';
import { JwtModule } from '@nestjs/jwt';

@Module({
  imports: [
    JwtModule.register({
      secret: process.env.JWT_SECRET, // Use uma variável de ambiente para o segredo
      signOptions: { expiresIn: '60s' }, // Defina o tempo de expiração do token
    }),
    ConfigModule.forRoot({
      isGlobal: true, // Torna o ConfigModule disponível globalmente
    }),
    TypeOrmModule.forRootAsync({
      imports: [ConfigModule],
      inject: [ConfigService],
      useFactory: async (configService: ConfigService) => ({
        type: 'mysql', // ou outro banco de dados
        host: configService.get('DB_HOST'),
        port: +configService.get('DB_PORT'), // o operador '+' converte a string para número
        username: configService.get('DB_USERNAME'),
        password: configService.get('DB_PASSWORD'),
        database: configService.get('DB_DATABASE'),
        entities:  [Produto, Pedido],
        // outras configurações necessárias...
      }),
    }),
    ProdutoModule,
    PedidoModule,
  ],
  controllers: [AppController],
  providers: [AppService],
})
export class AppModule { }
