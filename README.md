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
cp .env.example .env
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan app:download {start_date} {end_date?}
```

### Observation
- example used in test
    - docker-compose exec app php artisan app:download 2023-05-25 2023-05-27
- you can follow the download log at storege/logs/download.log

### Test battery

```sh
docker-compose exec app php artisan key:generate --env=testing
docker-compose exec app php artisan migrate --env=testing
docker-compose exec app php artisan test
```

![App](https://uploaddeimagens.com.br/images/004/455/001/original/app.png?1683305090)
