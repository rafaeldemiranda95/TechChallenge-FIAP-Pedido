/* eslint-disable prettier/prettier */
import { Produto } from 'src/produto/produto.entity/produto.entity';
import { Entity, Column, PrimaryGeneratedColumn, ManyToMany } from 'typeorm';

@Entity()
export class Pedido {
  @PrimaryGeneratedColumn()
  id: number;

  @Column()
  tempoTotal: number;

  @Column()
  status: string;

  @Column()
  idCliente: number;

  @Column('decimal')
  precoTotal: number;

  @ManyToMany(() => Produto, (produto) => produto.pedidos)
  produtos: Produto[];
}
