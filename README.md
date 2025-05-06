# 📖 Minidicionario

Este é um dicionário online que utiliza que permite incluir termos, seus significados e a matéria relacionada á ela. A aplicação permite realizar **consulta** por meio de uma barra de pesquisa; **leitura** atráves da lista que é formada pelas palavras incluídas; **atualização**, sendo possível editar palavras seus conceitos e a matéria relacionada; e **exclusão**, deletando palabras que não deseja mais na lista. 

**EXTRA**: a página extra `Dicionário API` integra diferentes APIs para fornecer definições e traduções de palavras entre o inglês e o português. Quando o usuário faz uma consulta em português, o termo é traduzido para o inglês por meio da API MyMemory Translation. Em seguida, a palavra traduzida é enviada para a API DictionaryAPI.dev, que opera em inglês. O significado obtido é então traduzido de volta para o português e exibido ao usuário. É possível pesquisar termos em ambos os idiomas, recebendo definições claras em português. Quando a palavra original está em inglês, recursos adicionais são disponibilizados, como a pronúncia em áudio (quando disponível).

# 🛠️ Tecnologias

- PHP
- HTML
- CSS
- JavaScript
- MySQL
- DictionaryAPI.dev API (para definições em inglês)
  - Fornece definições, fonética e áudio de pronúncia
  - Endpoint: https://api.dictionaryapi.dev/api/v2/entries/en/{word}
- MyMemory Translation API (para traduções)
  - Realiza traduções entre inglês e português
  - Endpoint: https://api.mymemory.translated.net/get?q={text}&langpair={source}|{target}


# 🌐 Demostração

Demonstração do projeto funcionando. Exibição da tabela com os dados do banco e permissões, logado como cliente:

<p align="center">
  <img src="README/demo.gif" alt="GIF de demonstração">
</p>


# 📦 Estrutura do Projeto

Estrutura dos arquivos e explicação de suas funções:

```
minidicionario/
├── api.html            # Estrutura para consumo e consulta em APIs
├── db.sql              # Modelo lógico do banco de dados MariaDB
└── index.php           # Arquivo principal com a estrutura de inserção de palavras
```

# 🛢️ Modelagem de Dados

Representação da estrutura de um sistema de vendas. Ele permite gerenciar usuários, pedidos e produtos, além de relacionar pedidos a produtos específicos.

### Tratamento de Dados

- Modelo Conceitual: [MySQL WorkBench](https://dev.mysql.com/downloads/workbench/).
- Modelo Lógico: [DBeaver](https://dbeaver.io/download/)
- Modelo Físico: [DBeaver](https://dbeaver.io/download/).

### Modelo Conceitual
DER (Diagrama Entidade-Relacionamento)

![Modelo Conceitual](README/modelo-conceitual.png)

 O Arquivo do modelo conceitual desenvolvido no [MySQL WorkBench](https://dev.mysql.com/downloads/workbench/), se encontra na pasta principal do projeto com o titulo `modelagem-conceitual.mwb`

### Modelo Lógico

#### 1. **Tabela `palavras`**
Armazena informações sobre os usuários do sistema.

- **Campos:**
  - `id`: Identificador único do usuário (chave primária).
  - `palavra`: termo a ser adicionado no dicionário.
  - `disciplina`: matéria do 3° semestre a qual pertende.
  - `conceito`: significado do termo apresentado.

### Modelo Físico

```
CREATE DATABASE IF NOT EXISTS minidicionario;

USE minidicionario;

CREATE TABLE IF NOT EXISTS palavras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    palavra VARCHAR(50) NOT NULL,
    disciplina VARCHAR(50) NOT NULL,
    conceito VARCHAR(1000) NOT NULL
);
```
O arquivo SQL do **Modelo Físico**, se encontra nas dependências do projeto ([banco.sql](https://github.com/alanaqueiroz/minidicionario/blob/main/db.sql)).

### Operações CRUD

CRUD `index.php`: Criar, alterar, deletar e listar

- **Criar**: é possível inserir novas palavras com seus respectivos conceitos.
  - `INSERT INTO palavras (palavra, disciplina, conceito) VALUES (?, ?, ?)`
- **Ler**: é possível visualizar as palavras incluídas em uma lista.
  - `SELECT * FROM palavras`
- **Atualizar**: é possivel editar as palavras cadastradas, seus conceitos ou disciplinas.
  - `UPDATE palavras SET palavra = ?, disciplina = ?, conceito = ? WHERE id = ?`
- **Deletar**: é possível deletar uma palavra do cadastro. 
  - `DELETE FROM palavras WHERE id = ?`
`

## Acesso ao projeto

### 1. Requisitos: 

Para rodar o projeto, certifique-se de ter um simulador de servidor web local, como o [XAMPP](https://www.apachefriends.org/download.html):

1. **Servidor Local**  
   Certifique-se de ter um simulador de servidor web local, como o XAMPP.  
   - [Download XAMPP](https://www.apachefriends.org/download.html)

2. **Pasta htdocs**  
   Utilizar os projetos dentro do diretório padrão:
   - `C:\xampp\htdocs\projects`

3. **Apache e MySQL**  
   Abrir o painel do XAMPP e dar um start nas portas Apache e MySQL.

### 2. Clonagem

Clonar o projeto:
```bash
cd \xampp\htdocs\
git clone https://github.com/alanaqueiroz/minidicionario.git
```

### 3. Banco de Dados

- No diretório principal desse projeto, o arquivo SQL [banco.sql](https://github.com/alanaqueiroz/minidicionario/blob/main/bd.sql), contem os comandos necessarios para criar o banco. Rode-os em um gerenciador de banco de dados da sua preferência. Exemplo: [DBeaver](https://dbeaver.io/download/).

### 4. Rodando o Projeto

- No navegador, acesse o localhost com a porta padrão 80 ou a que estiver configurada em `http://localhost:80/minidicionario/`. Para funcionar é necessário ligar as portas Apache e MySQL.

### 5. Utilização

- Acesse a aplicação e digite uma palavra no campo de pesquisa, pressione Enter ou clique no botão "Pesquisar" e será possível visualizar a palavra pesquisada. Conterá sua tradução (se for em inglês) e definição em português, com player de áudio (para palavras em inglês, quando disponível).