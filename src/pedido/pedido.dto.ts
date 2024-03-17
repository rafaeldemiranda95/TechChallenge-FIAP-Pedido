/* eslint-disable prettier/prettier */
export class CreatePedidoDto {
  readonly status: string;
  readonly idCliente: number;
  readonly produtos: ProdutoPedidoDto[];
}

class ProdutoPedidoDto {
  readonly idProduto: number;
  readonly tempoPreparo: number;
  readonly preco: number;
}
