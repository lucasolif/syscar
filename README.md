# Syscar - Sistema para Oficina Mecânica

Sistema web desenvolvido em PHP puro para gerenciamento de oficina mecânica, contemplando cadastros, estoque, ordens de serviço, financeiro e controle de usuários.

## Tecnologias Utilizadas

- PHP 8+
- MySQL
- PDO
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- Composer / PSR-4

## Funcionalidades

### Autenticação

- Login de usuários
- Logout
- Controle de sessão
- Alteração de senha
- Validação de senha atual
- Criptografia de senha com `password_hash`
- Verificação com `password_verify`

### Cadastros

- Usuários
- Pessoas / Clientes
- Produtos
- Serviços
- Veículos
- Conta Caixa
- Forma de Pagamento

### Estoque

- Entrada de produtos
- Saída de produtos
- Consulta de estoque
- Consulta de movimentações
- Controle de quantidade disponível

### Ordem de Serviço

- Cadastro de ordem de serviço
- Inclusão de produtos
- Inclusão de serviços
- Cálculo de valor total
- Status da OS
- Faturamento da ordem de serviço

### Financeiro

- Geração de contas a receber
- Consulta de contas a receber com filtros
- Baixa de contas
- Baixa parcial
- Estorno de baixa
- Cancelamento de contas
- Integração com conta caixa

## Estrutura do Projeto

```text
syscar/
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Repositories/
│   ├── Services/
│   └── Views/
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── index.php
├── vendor/
├── composer.json
└── README.md
