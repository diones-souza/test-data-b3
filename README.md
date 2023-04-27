# test

Criar o projeto em Laravel com os seguintes requisitos:
- Dados: arquivo de Posições em Aberto de Empréstimo de Ativos - https://www.b3.com.br/pt_br/market-data-e-indices/servicos-de-dados/market-data/consultas/boletim-diario/dados-publicos-de-produtos-listados-e-de-balcao/
- Um comando Artisan para baixar dados da B3 através de um Job (queue), e salvar os dados no banco de dados. Necessário salvar os valores de múltiplos dias.
- Implemente algum teste unitário no PHP se encontrar alguma possibilidade
- Uma página para exibir os dados com pelo menos um gráfico relacionado usando Vue.js. Ideia: ter um Dropdown para escolher um ativo e ao selecioná-lo exibir um gráfico mostrando a evolução da quantidade de saldo do ativo e do preço médio.
- Descrever o que achar pertinente no readme.md e enviar junto uma screenshot da interface
- A entrega pode ser um repositório privado no GitHub.


### Docker - Project Setup Laravel

```sh
cd api
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up -d
```

### Docker - Project Setup Vuejs

```sh
cd client
docker build -t client .
docker run -it -p 8080:80 --rm --name app client
```
