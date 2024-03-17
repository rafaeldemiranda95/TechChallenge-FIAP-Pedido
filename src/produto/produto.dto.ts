/* eslint-disable prettier/prettier */
export class CreateProdutoDto {
  readonly name: string;
  readonly categoria: string;
  readonly descricao: string;
  readonly preco: number;
  readonly tempoPreparo: number;
}

export class UpdateProdutoDto {
  readonly name?: string;
  readonly categoria?: string;
  readonly descricao?: string;
  readonly preco?: number;
  readonly tempoPreparo?: number;
}
