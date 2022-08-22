CREATE DATABASE myfinances CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

use myfinances;

/* Usuários */
CREATE TABLE IF NOT EXISTS users(
	id_user INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id do usuário',
    name VARCHAR(100) NOT NULL COMMENT 'nome do usuário',
    lastname VARCHAR(200) NOT NULL COMMENT 'sobrenome do usuário',
	email VARCHAR(255) NOT NULL COMMENT 'email do usuário',
    password VARCHAR(255) NOT NULL COMMENT 'senha do usuário',
    creation_date DATETIME NOT NULL DEFAULT NOW() COMMENT 'data de criação do registro'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Histórico de login */
CREATE TABLE IF NOT EXISTS history_login(
	id_history_login INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id do histórico de login',
    id_user INT UNSIGNED NOT NULL COMMENT 'referência do id do usuário, chave estrangeira',
    FOREIGN KEY (id_user) 
		REFERENCES users(id_user)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
	browser VARCHAR(100) NOT NULL COMMENT 'navegador utilizado para o login',
    ip VARCHAR(80) NOT NULL COMMENT 'ip do login',
    login_date DATETIME NOT NULL DEFAULT NOW() COMMENT 'data do login',
    attemp_login INT NOT NULL COMMENT 'tentativas de login',
    city VARCHAR(255) NOT NULL COMMENT 'cidade em que foi feito o login'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Categoria */
CREATE TABLE IF NOT EXISTS category(
	id_category INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id da categoria',
    name VARCHAR(80) NOT NULL COMMENT 'nome da categoria',
    color VARCHAR(50) NOT NULL COMMENT 'cor da categoria'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Meta de gastos*/
CREATE TABLE IF NOT EXISTS spending_goal(
	id_spending_goal INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id da meta de gastos',
    money DECIMAL(10,2) NOT NULL COMMENT 'valor da meta de gastos',
    id_category INT UNSIGNED NOT NULL COMMENT 'referencia id da categoria, chave estrangeira',
    FOREIGN KEY (id_category) 
		REFERENCES category(id_category)
			ON DELETE CASCADE
			ON UPDATE CASCADE
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Tipo de Conta bancária */
CREATE TABLE IF NOT EXISTS bank_account_type(
	id_bank_account_type INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id do tipo de conta bancária',
    type VARCHAR(200) NOT NULL COMMENT 'tipo de conta bancária (poupança, corrente, outros)'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Instituição Financeira */
CREATE TABLE IF NOT EXISTS financial_institution(
	id_financial_institution INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id da instituição financeira',
    name VARCHAR(45) NOT NULL COMMENT 'nome do banco',
    img VARCHAR(255) NOT NULL COMMENT 'caminho da imagem/icon do banco'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Contas do banco */
CREATE TABLE IF NOT EXISTS bank_accounts(
	id_bank_accounts INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id da conta do banco',
    id_financial_institution INT UNSIGNED NOT NULL COMMENT 'chave estrangeira, referência a instituição financeira',
    FOREIGN KEY (id_financial_institution) 
		REFERENCES financial_institution(id_financial_institution)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
    annotation TEXT COMMENT 'Anotações sobre a conta bancária',
    initial_balance DECIMAL(10,2) COMMENT 'Saldo inicial da conta',
    id_bank_account_type INT UNSIGNED NOT NULL COMMENT 'chave estrangeira, referencia tipo de conta bancária',
    FOREIGN KEY (id_bank_account_type) 
		REFERENCES bank_account_type(id_bank_account_type)
			ON DELETE CASCADE
			ON UPDATE CASCADE
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Cartão de Crédito */
CREATE TABLE IF NOT EXISTS credit_cards(
	id_credit_cards INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id do cartão de crédito',
    name VARCHAR(200) NOT NULL COMMENT 'nome do cartão de crédito',
    limit_card DECIMAL(10,2) NOT NULL COMMENT 'limite do cartão de crédito',
    invoice_closing_day DATE NOT NULL COMMENT 'data de fechamento da fatura',
    invoice_due_date DATE NOT NULL COMMENT 'data de vencimento da fatura',
    id_bank_accounts INT UNSIGNED NOT NULL COMMENT 'chave estrangeira, referencia conta bancária, para selecionar a conta utilizada para pagar a fatura do cartão de crédito',
    FOREIGN KEY (id_bank_accounts) 
		REFERENCES bank_accounts(id_bank_accounts)
			ON DELETE CASCADE
			ON UPDATE CASCADE
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/* Contas Financeiras */
CREATE TABLE IF NOT EXISTS financial_accounts(
	id_financial_accounts INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT 'id da conta financeira',
    money DECIMAL(10,2) NOT NULL COMMENT 'valor do dinheiro da conta a ser paga/receber',
	id_user INT UNSIGNED NOT NULL COMMENT 'referência do id do usuário, chave estrangeira',
    FOREIGN KEY (id_user) 
		REFERENCES users(id_user)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
	entry_date DATETIME NOT NULL DEFAULT NOW() COMMENT 'data de entrada da receita (dinheiro)',
    id_category INT UNSIGNED NOT NULL COMMENT 'referencia id da categoria, chave estrangeira',
    FOREIGN KEY (id_category) 
		REFERENCES category(id_category)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
	description VARCHAR(255) COMMENT 'Descrição',
    id_bank_account_type INT UNSIGNED NOT NULL COMMENT 'chave estrangeira, referencia tipo de conta bancária',
    FOREIGN KEY (id_bank_account_type) 
		REFERENCES bank_account_type(id_bank_account_type)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
	attachment VARCHAR(255)  COMMENT 'Caminho do Anexo',
    financial_type CHAR(2) NOT NULL COMMENT 'Define o tipo de conta, CP = "Contas à Pagar", CR = "Contas à Receber"',
    creation_date DATETIME NOT NULL DEFAULT NOW() COMMENT 'Data de crição do registro'
)ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;