# Soul Society Store — Bleach

Loja virtual fictícia inspirada no universo de Bleach, desenvolvida para a atividade final do 4º bimestre.

## Tecnologias
- HTML5, CSS3, Bootstrap 5 e JavaScript
- PHP 8+ com Apache/XAMPP
- MySQL/MariaDB com PDO
- Sessões PHP, prepared statements e `password_hash` / `password_verify`

## Como executar no XAMPP
1. Copie a pasta `soul_society_store` para `C:\xampp\htdocs\`.
2. Inicie Apache e MySQL no painel do XAMPP.
3. Acesse `http://localhost/phpmyadmin` e importe `database/schema.sql`.
4. Copie `.env.example` para `.env` e ajuste host, banco, usuário e senha.
5. Acesse `http://localhost/soul_society_store`.

## Criar o primeiro administrador
1. Faça cadastro normal pela loja.
2. No phpMyAdmin, abra a tabela `users`.
3. Altere o campo `role` do seu usuário de `customer` para `admin`.
4. Entre novamente e abra **Painel** no menu.

## Funcionalidades
- Catálogo dinâmico, busca e filtro por categoria
- Página de detalhes e disponibilidade
- Cadastro/login com senha criptografada
- Carrinho em `$_SESSION`, atualização e remoção
- Checkout com pagamento simulado (PIX, boleto e cartão)
- Pedido, itens do pedido e baixa transacional de estoque
- Painel administrativo protegido, CRUD de produtos e consulta de pedidos

## Segurança e observações
- Credenciais ficam no `.env`, que é ignorado pelo Git.
- `.env.example` documenta as variáveis necessárias.
- As operações SQL usam prepared statements.
- O checkout usa transação e bloqueio de estoque (`FOR UPDATE`).
- Pagamentos são apenas simulação acadêmica; não há integração com gateway real.
- As imagens externas são ilustrativas e podem ser substituídas por imagens próprias com direitos de uso.

## Git
Faça commits progressivos (estrutura, banco, catálogo, autenticação, carrinho, checkout, painel e ajustes), não um único commit com tudo pronto.
