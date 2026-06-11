# 🚀 Aplicação Web CodeIgniter 4

## ✨ Diferenciais Implementados

- [x] **Autenticação:** Sistema seguro utilizando *CodeIgniter Shield*.
- [x] **View Layouts:** Renderização moderna nativa do CI4 (eliminando a repetição de cabeçalhos e rodapés).
- [x] **Alta Performance:** Listagens de dados utilizando *DataTables* com processamento *Server-Side*.
- [x] **UX Avançada:** Buscas dinâmicas implementadas com *Select2* e requisições AJAX.
- [x] **Segurança de Dados:** Deleção lógica configurada utilizando *Soft Deletes* nativo do framework.

---

## 📐 Decisões Arquiteturais

* **Skinny Controllers, Fat Models:**
  As validações de formulário e regras de negócio (como impedir a exclusão de categorias com produtos vinculados) foram isoladas nos Models via *Callbacks* (`beforeDelete`). Isso garante a integridade dos dados independentemente da origem da requisição (Interface Web, API REST ou CLI).

* **Proteção contra SQL Injection:**
  Utilização estrita do *Query Builder* do CI4, garantindo o *escaping* automático e seguro de todos os inputs e queries do sistema.

* **API RESTful Padronizada:**
  Implementação orientada pelo `ResourceController`, devolvendo respostas JSON estruturadas e com o *casting* adequado de tipos de dados (booleanos e inteiros).

---

## ⚙️ Como Executar o Projeto

**Pré-requisitos:** PHP 8.0+, Composer e MySQL. 
*(Testado e homologado em ambientes **Laragon**).*

### 1. Configuração do Ambiente

Clone o repositório e instale as dependências do projeto:

```bash
git clone [https://github.com/iRoberTLK/tech-test.git](https://github.com/iRoberTLK/tech-test.git)
cd tech-test
composer install
```

Crie o arquivo de ambiente a partir do exemplo fornecido:

```bash
cp env .env
```

Abra o arquivo `.env` e ajuste as credenciais do seu banco de dados MySQL para refletir o seu ambiente (Laragon):

```env
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = nome_da_sua_base
database.default.username = root
database.default.password = sua_senha
database.default.DBDriver = MySQLi
```

### 2. Migrations e Autenticação

Para gerar as tabelas de domínio do sistema (`tab_categoria`, `tab_produto`) e construir a estrutura de segurança do CodeIgniter Shield, execute no terminal:

```bash
php spark migrate --all
```

### 3. Iniciar o Servidor

Suba a aplicação utilizando o servidor embutido do Spark:

```bash
php spark serve
```
> **Nota:** A aplicação estará disponível em `http://localhost:8080`.

---

## 🧪 Como Testar

### 🖥️ Interface Web

1. Acesse `http://localhost:8080` no seu navegador.
2. O filtro de sessão irá redirecioná-lo automaticamente para a tela de login. 
3. Clique em **Register** e crie um usuário de teste (ex: `Usuário: Avaliador` | `Senha: 12345678`).
4. Navegue entre os módulos de **Categorias** e **Produtos** para testar as operações de CRUD e o comportamento do filtro *Select2* via AJAX.

### 🛡️ Regra de Negócio (Integridade Relacional)

1. Cadastre uma categoria nova no sistema.
2. Cadastre um produto e vincule-o a essa categoria recém-criada.
3. Volte à listagem de categorias e tente excluí-la. 
4. **Resultado esperado:** O sistema deve interceptar a ação no Model e exibir um bloqueio com a mensagem amigável estabelecida nos requisitos, impedindo a exclusão.

### 🔌 API REST

Realize uma requisição `GET` para o endpoint de categorias utilizando ferramentas como Postman, Insomnia ou cURL:

```bash
curl -X GET http://localhost:8080/api/categorias
```

**Resposta Esperada:**
```json
[
  {
    "id": 1,
    "nome": "Eletrônicos",
    "ativo": true
  }
]
```