-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Jun-2021 às 23:13
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `id` int(11) NOT NULL,
  `banco` varchar(50) NOT NULL,
  `agencia` varchar(10) NOT NULL,
  `conta` varchar(50) NOT NULL,
  `saldo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `conta`
--

INSERT INTO `conta` (`id`, `banco`, `agencia`, `conta`, `saldo`) VALUES
(2, 'Caixa Ecomonica', '125811', '11111', '23061.73'),
(3, 'Bradesco', '1255', '122', '0.00'),
(4, 'Banco Do Brasil', '1256', '33233', '0.00'),
(5, 'Sicredi', '0125', '363656', '0.00'),
(6, 'Nubank', '1251', '15544', '33.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_pagar`
--

CREATE TABLE `conta_pagar` (
  `id` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `documento` varchar(25) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_pendente` decimal(10,2) NOT NULL,
  `juros_multa` decimal(10,2) DEFAULT NULL,
  `data_lancamento` date NOT NULL,
  `data_baixa` date DEFAULT NULL,
  `data_vencimento` date NOT NULL,
  `pago` char(1) NOT NULL DEFAULT 'N',
  `id_lancamento` int(11) DEFAULT NULL,
  `observacao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_pagar_fluxo`
--

CREATE TABLE `conta_pagar_fluxo` (
  `id` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  `id_conta_pagar` int(11) NOT NULL,
  `id_fluxo` int(11) NOT NULL,
  `id_despesa` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_receber`
--

CREATE TABLE `conta_receber` (
  `id` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `documento` varchar(25) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_pendente` decimal(10,2) NOT NULL,
  `juros_multa` decimal(10,2) DEFAULT NULL,
  `data_lancamento` date NOT NULL,
  `data_baixa` date DEFAULT NULL,
  `data_vencimento` date NOT NULL,
  `pago` char(1) NOT NULL DEFAULT 'N',
  `id_lancamento` int(11) DEFAULT NULL,
  `observacao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_receber_fluxo`
--

CREATE TABLE `conta_receber_fluxo` (
  `id` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  `id_conta_receber` int(11) NOT NULL,
  `id_fluxo` int(11) NOT NULL,
  `id_despesa` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesa`
--

CREATE TABLE `despesa` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `despesa`
--

INSERT INTO `despesa` (`id`, `nome`, `tipo`) VALUES
(2, '(-) Despesas Com Mercado', 'Saida'),
(3, '(-) Despesas Com Oficina De Moto', 'Saida'),
(4, '(-) Boleto Faculdade', 'Saida'),
(5, '(-) Despesas Com Farmacia', 'Saida'),
(6, '(-) Fatura Cartão De Credito', 'Saida'),
(8, '(+) Entrada De Dinheiro', 'Entrada'),
(9, '(+) Salario', 'Entrada'),
(10, '(+) 13º Salario', 'Entrada'),
(11, '(+) INSS', 'Entrada'),
(12, '(+) FGTS', 'Entrada'),
(13, '(-) Despesas Com Assinatura De TV A Cabo ', 'Saida'),
(14, '(-) Despesa Com Plano De Celular Pré-pago', 'Saida'),
(15, '(-) Despesa Conta De Aluguel', 'Saida'),
(16, '(-) Despesa Com Mensalidade Da Academia', 'Saida'),
(17, '(-) Despesa Com Mensalidade De Internet', 'Saida'),
(18, '(-) Despesa Com Conta De água E Energia;', 'Saida'),
(19, '(-) Gastos Com Alimentação', 'Saida'),
(20, '(-) Gastos Com Transporte', 'Saida'),
(21, '(-) Gastos Com Lazer', 'Saida'),
(22, '(-) Mensalidade Escolar', 'Saida'),
(23, '(-) Prestação Do Carro Ou Moto', 'Saida'),
(24, '(-) Faxineira/empregada Doméstica', 'Saida'),
(25, '(-) Cursos De Profissionalizante ', 'Saida'),
(26, '(-) Despesa Com Combustível', 'Saida'),
(27, '(-) Despesa Com Gás', 'Saida'),
(28, '(-) Despesa Com Roupas', 'Saida'),
(29, '(-) Despesa Com Calçados', 'Saida'),
(30, '(-) Despesa Com Bares E Restaurantes.', 'Saida'),
(31, '(-) Despesa Com Teatro, Cinema E Shows.', 'Saida'),
(32, '(-) Despesa Com Viagens', 'Saida'),
(33, '(-) Despesa Com Presentes', 'Saida'),
(34, '(-) Despesa Com Salão De Beleza.', 'Saida');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dre`
--

CREATE TABLE `dre` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dre`
--

INSERT INTO `dre` (`id`, `nome`) VALUES
(1, 'Fluxo De Caixa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fluxo`
--

CREATE TABLE `fluxo` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fluxo`
--

INSERT INTO `fluxo` (`id`, `nome`) VALUES
(1, '(-) Gastos Com Pessoal'),
(2, '(+) Entradas'),
(3, '(-) Despesas Variáveis'),
(4, '(-) Deduções E Impostos'),
(5, '(+) Receita De Vendas'),
(6, '(-) Despesas Operacionais'),
(7, '(-) Outras Receitas E Despesas'),
(8, '(-) Despesas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`) VALUES
(4, 'Sol Maquina'),
(5, 'Ecocentauro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamento`
--

CREATE TABLE `lancamento` (
  `id` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  `id_despesa` int(11) NOT NULL,
  `id_dre` int(11) NOT NULL,
  `id_fluxo` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `observacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `lancamento`
--

INSERT INTO `lancamento` (`id`, `id_conta`, `id_despesa`, `id_dre`, `id_fluxo`, `valor`, `data`, `observacao`) VALUES
(18, 2, 9, 1, 2, '2194.99', '2021-06-10', 'salario'),
(19, 2, 6, 1, 1, '78.38', '2021-06-10', 'fatura do cartão de credito'),
(20, 2, 4, 1, 1, '244.60', '2021-06-10', 'boleto da faculdade'),
(21, 2, 17, 1, 1, '80.00', '2021-06-10', 'pagamento mensalidade internet '),
(22, 2, 27, 1, 1, '130.00', '2021-06-10', 'gas casa'),
(23, 2, 28, 1, 1, '70.00', '2021-06-10', 'parcela da roupa americana '),
(24, 2, 2, 1, 1, '5.00', '2021-06-11', 'lanche salgado');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `conta_pagar`
--
ALTER TABLE `conta_pagar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fornecedor` (`id_fornecedor`);

--
-- Índices para tabela `conta_pagar_fluxo`
--
ALTER TABLE `conta_pagar_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_pagar_fluxo` (`id_fluxo`),
  ADD KEY `FK_pagar_despesa` (`id_despesa`),
  ADD KEY `FK_conta_pagar` (`id_conta_pagar`);

--
-- Índices para tabela `conta_receber`
--
ALTER TABLE `conta_receber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fornecedor` (`id_fornecedor`);

--
-- Índices para tabela `conta_receber_fluxo`
--
ALTER TABLE `conta_receber_fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_conta_receber_2` (`id_conta_receber`),
  ADD KEY `FK_id_despesar_receber_2` (`id_despesa`),
  ADD KEY `FK_id_fluxo_receber` (`id_fluxo`);

--
-- Índices para tabela `despesa`
--
ALTER TABLE `despesa`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dre`
--
ALTER TABLE `dre`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fluxo`
--
ALTER TABLE `fluxo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_despesa` (`id_despesa`),
  ADD KEY `fk_id_fluxo` (`id_fluxo`),
  ADD KEY `fk_id_dre` (`id_dre`),
  ADD KEY `fk_id_conta` (`id_conta`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `conta_pagar`
--
ALTER TABLE `conta_pagar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `conta_pagar_fluxo`
--
ALTER TABLE `conta_pagar_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `conta_receber`
--
ALTER TABLE `conta_receber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `conta_receber_fluxo`
--
ALTER TABLE `conta_receber_fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `despesa`
--
ALTER TABLE `despesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `dre`
--
ALTER TABLE `dre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fluxo`
--
ALTER TABLE `fluxo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `lancamento`
--
ALTER TABLE `lancamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `conta_pagar`
--
ALTER TABLE `conta_pagar`
  ADD CONSTRAINT `fk_fornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id`);

--
-- Limitadores para a tabela `conta_pagar_fluxo`
--
ALTER TABLE `conta_pagar_fluxo`
  ADD CONSTRAINT `FK_conta_pagar` FOREIGN KEY (`id_conta_pagar`) REFERENCES `conta_pagar` (`id`),
  ADD CONSTRAINT `FK_pagar_despesa` FOREIGN KEY (`id_despesa`) REFERENCES `despesa` (`id`),
  ADD CONSTRAINT `FK_pagar_fluxo` FOREIGN KEY (`id_fluxo`) REFERENCES `fluxo` (`id`);

--
-- Limitadores para a tabela `conta_receber_fluxo`
--
ALTER TABLE `conta_receber_fluxo`
  ADD CONSTRAINT `FK_conta_receber_2` FOREIGN KEY (`id_conta_receber`) REFERENCES `conta_pagar` (`id`),
  ADD CONSTRAINT `FK_id_despesar_receber_2` FOREIGN KEY (`id_despesa`) REFERENCES `despesa` (`id`),
  ADD CONSTRAINT `FK_id_fluxo_receber` FOREIGN KEY (`id_fluxo`) REFERENCES `fluxo` (`id`);

--
-- Limitadores para a tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD CONSTRAINT `fk_id_banco` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `fk_id_conta` FOREIGN KEY (`id_conta`) REFERENCES `conta` (`id`),
  ADD CONSTRAINT `fk_id_despesa` FOREIGN KEY (`id_despesa`) REFERENCES `despesa` (`id`),
  ADD CONSTRAINT `fk_id_dre` FOREIGN KEY (`id_dre`) REFERENCES `dre` (`id`),
  ADD CONSTRAINT `fk_id_fluxo` FOREIGN KEY (`id_fluxo`) REFERENCES `fluxo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
