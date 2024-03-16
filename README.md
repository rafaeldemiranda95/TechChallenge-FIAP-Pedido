# Pós Tech - Software Architecture

## TechChallenge

### TURMA 2SOAT

#### Grupo 21

349463 - Airton Patrocínio da Silva Junior  
349308 - Rafael de Miranda

### Links:

[Miro](https://miro.com/app/board/uXjVMGvVfHc=/)  
[Serviço Pedidos](https://github.com/rafaeldemiranda95/TechChallenge-FIAP-Pedido)  
[Serviço Pagamento](https://github.com/rafaeldemiranda95/TechChallenge-FIAP-Pagamento)  
[Serviço Produção](https://github.com/rafaeldemiranda95/TechChallenge-FIAP-Producao)

### API

| Endpoint                                            | Método | Parâmetros                                                                                  |
| --------------------------------------------------- | ------ | ------------------------------------------------------------------------------------------- |
| `localhost:8000/api/pedido`                         | GET    |                                                                                             |
| `localhost:8000/api/pedido`                         | POST   | `{idCliente: string, status: string, produtos: [{id: number, quantidade: number}]}`         |
| `localhost:8000/api/produtos`                       | GET    |                                                                                             |
| `localhost:8000/api/produtos`                       | POST   | `{name: string, categoria: string, descricao: string, preco: number, tempoPreparo: number}` |
| `localhost:8000/api/produtos/{id}`                  | GET    |                                                                                             |
| `localhost:8000/api/produtos/{id}`                  | PUT    | `{name: string, categoria: string, descricao: string, preco: number, tempoPreparo: number}` |
| `localhost:8000/api/produtos/{id}`                  | DELETE |                                                                                             |
| `localhost:8000/api/produtos/categoria/{categoria}` | GET    |                                                                                             |
