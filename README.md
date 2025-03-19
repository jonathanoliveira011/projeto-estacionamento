# Projeto de Controle de Estacionamento

## 📌 Sobre o Projeto
Este projeto foi desenvolvido para a **Etec de Monte Mor** com o objetivo de criar um sistema de controle de estacionamento. O sistema permite o gerenciamento de veículos, motoristas e alertas relacionados ao estacionamento da instituição.

O sistema utiliza a linguagem **PHP** para o desenvolvimento do backend, o **Framework Bootstrap** para estilização e responsividade, e o **MySQL** como banco de dados para armazenar as informações.

## 🚀 Tecnologias Utilizadas
- **PHP**: Linguagem principal para o backend e lógica do sistema.
- **Bootstrap**: Framework CSS para um design moderno e responsivo.
- **MySQL**: Banco de dados para armazenamento e gerenciamento das informações.
- **HTMLe CSS**: Complementos para a interface e interatividade do sistema.

## 🔧 Funcionalidades do Sistema
1. **Cadastro de Veículos** 🚗
   - Permite a inserção de novos veículos no sistema com placa atrelado ao proprietário.

2. **Busca de Placas** 🔍
   - Permite pesquisar veículos cadastrados no banco de dados.

3. **Cadastro de Usuários** 👤
   - Gerenciamento de motoristas e seus veículos vinculados.

4. **Alertas e Notificações** ⚠️
   - Sistema de alerta para eventos como farol ligado, pneu furado, carro destrancado e alarme disparado.

5. **CRUD Completo** 🛠️
   - **C**reate: Cadastro de novos registros.
   - **R**ead: Visualização de informações cadastradas.
   - **U**pdate: Atualização de dados dos veículos e usuários.
   - **D**elete: Remoção de registros do sistema.

## 📂 Estrutura de Diretórios
```
projeto-estacionamento/
│── assets/                 # Arquivos CSS e imagens
│── config/                 # Arquivos de configuração do sistema
│── public/                 # Scripts de ações
│   ├── actions/            # Lógica de backend (inserir, editar, deletar)
│── views/                  # Interface do usuário
│   ├── components/         # Componentes reutilizáveis (navbar, formulários, tabelas)
│   ├── pages/              # Páginas principais do sistema
│── index.php               # Página inicial
│── README.md               # Documentação do projeto
```

## 🔄 Instalação e Configuração
### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/seu-usuario/projeto-estacionamento.git
cd projeto-estacionamento
```

### 2️⃣ Configurar o banco de dados
- Criar um banco de dados no MySQL com o nome `bdestacionamento`
- Importar o arquivo `database.sql` com a estrutura e os dados iniciais
- Configurar a conexão no arquivo `config/db.php`:
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdestacionamento";
$conn = new mysqli($servername, $username, $password, $dbname);
```

## 📌 Contribuição
Segue abaixo todos os alunos que co

## 📜 Licença
Este projeto é de uso acadêmico e foi desenvolvido para a **Etec de Monte Mor**.

