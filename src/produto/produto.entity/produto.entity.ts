/* eslint-disable prettier/prettier */
import { Pedido } from 'src/pedido/pedido.entity/pedido.entity';
import {
  Entity,
  Column,
  PrimaryGeneratedColumn,
  ManyToMany,
  JoinTable,
} from 'typeorm';

@Entity()
export class Produto {
  @PrimaryGeneratedColumn()
  id: number;

  @Column()
  name: string;

  @Column()
  categoria: string;

  @Column()
  descricao: string;

  @Column('decimal')
  preco: number;

  @Column()
  tempoPreparo: number;

  @ManyToMany(() => Pedido, (pedido) => pedido.produtos)
  @JoinTable()
  pedidos: Pedido[];
}
