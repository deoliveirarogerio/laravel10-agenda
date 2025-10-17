# Laravel 10 Agenda

Aplicação Laravel 10 com frontend em Vue 3, Pinia, Vue Router e Tailwind CSS (via Vite). Gerencia contatos com listagem, cadastro/edição, deleção e exportação CSV.

## Requisitos

- PHP 8.1+
- Composer 2.x
- Node.js 18+ e npm
- SQLite (utilizado por padrão)
- Opcional: Docker/Docker Compose

## Instalação

1. Clone o repositório:
    - git clone https://github.com/deoliveirarogerio/laravel10-agenda
    - cd laravel10-agenda

2. Dependências PHP:
    - composer install

3. Variáveis de ambiente:
    - cp .env.example .env
    - php artisan key:generate

4. Banco de dados (SQLite):
    - Crie o arquivo: touch database/database.sqlite
    - No .env garanta:
        - DB_CONNECTION=sqlite
        - DB_DATABASE=./database/database.sqlite
    - Execute migrações (e seeds se houver):
        - php artisan migrate

5. Dependências JS:
    - npm install

6. Build/Dev do frontend:
    - Ambiente de desenvolvimento (hot reload): npm run dev
    - Build de produção: npm run build

7. Servidor Laravel:
    - php artisan serve
    - Acesse http://127.0.0.1:8000

Obs.: Em ambiente local com Vite, garanta que Vite (npm run dev) esteja rodando para carregar os assets.

## Stack

- Backend:
    - Laravel 10.x
    - Banco: SQLite (padrão)
    - Queue: database (padrão)
    - Testes: PHPUnit
- Frontend:
    - Vue 3 (^3.5.22)
    - Vue Router (^4.6.2)
    - Pinia (^3.0.3)
    - Axios (^1.6.4)
    - Tailwind CSS (^4.1.14) + @tailwindcss/postcss
    - Vite (^5.0.0) + @vitejs/plugin-vue (^6.0.1)
    - Internacionalização: vue-i18n (^9.14.5)

## Estrutura relevante

- resources/js/app.js: bootstrap do Vue e Vite
- resources/js/admin_router.js: rotas do frontend
- resources/views/admin:
    - AdminLayout.vue: layout das páginas do admin (contém header e <router-view />)
    - ContactList.vue: listagem de contatos
    - ContactForm.vue: criação/edição de contato
    - LoginView.vue: view de login (apenas UI)
- resources/js/contacts_store.js: store Pinia para contatos
- routes/: rotas Laravel (API/backend)
- tests/: testes PHPUnit

## Rotas do Frontend (Vue Router)

Arquivo: resources/js/admin_router.js

- Pública (fora do layout):
    - GET /admin/login
        - name: admin.login
        - component: LoginView

- Área Admin (com layout AdminLayout e <router-view />):
    - GET /admin
        - name: admin.contacts
        - component: ContactList
    - GET /admin/contacts/new
        - name: admin.contacts.new
        - component: ContactForm
    - GET /admin/contacts/:id
        - name: admin.contacts.edit
        - component: ContactForm
        - props: true

- Fallback:
    - Redireciona qualquer rota não encontrada para admin.login.

Observação:
- O login foi isolado em LoginView.vue e não é renderizado dentro do AdminLayout.vue. Assim, páginas do admin usam o layout sem exibir o formulário de login.

## Rotas da API (contrato utilizado no frontend)

Base: /api/v1/contacts

- GET /api/v1/contacts
    - Lista paginada, aceita ?q= para busca
- GET /api/v1/contacts/{id}
    - Detalhe do contato
- POST /api/v1/contacts
    - Criação
- PUT /api/v1/contacts/{id}
    - Edição
- DELETE /api/v1/contacts/{id}
    - Deleção
- POST /api/v1/contacts/export/csv
    - Body: { ids: number[] }
    - Retorna CSV (Content-Type: text/csv)

Obs.: Ajuste conforme seus controllers/rotas reais no Laravel.

## Desenvolvimento

- Inicie Vite:
    - npm run dev
- Inicie o servidor Laravel:
    - php artisan serve
- Acesse o frontend pelo blade que instancia o app (normalmente http://127.0.0.1:8000). As rotas SPA são tratadas pelo Vue Router.

## Testes

- Executar todos:
    - php artisan test
    - ou vendor/bin/phpunit

- Dicas:
    - Use RefreshDatabase nos testes.
    - SQLite em memória acelera a suíte.
    - Factories ajudam na criação de dados consistentes.

## Build de Produção

- Compile assets:
    - npm run build
- Configure APP_ENV=production e APP_DEBUG=false no .env
- Sirva os arquivos pelo servidor web apontando para public/

## Docker (opcional)

- docker-compose up -d
- Ajuste as variáveis de ambiente conforme seu setup.

## Internacionalização

- Componente LocaleSwitcher para alternar idioma.
- vue-i18n configurado em resources/js/i18n.js (ajuste mensagens/idiomas conforme necessário).

## Suporte e Contribuição

- Issues e PRs são bem-vindos.
- Padrão de código: Laravel Pint/PSR-12 e ESLint/Prettier (se configurados).
