-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Set-2022 às 04:32
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `technart`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `email`, `password`) VALUES
(1, 'Admin_teste', 'admin@admin.pt', '$2y$10$MH.i8UlpN1khB48yDkfby.a.nI9KjPEO8SH6N4NC/MOR2D.oYcGW2'),
(7, 'Admin2', 'admin2@admin.com', '$2y$10$bH.1jT89ydQAU8UFVwKQ..UOOw6deHjNPY5v9UM8y1szBq5M4GAae'); 

-- --------------------------------------------------------

--
-- Estrutura da tabela `investigadores`
--

CREATE TABLE `investigadores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ciencia_id` varchar(100) NOT NULL,
  `sobre` mediumtext NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `fotografia` varchar(100) NOT NULL,
  `areasdeinteresse` mediumtext NOT NULL,
  `orcid` varchar(255) NOT NULL,
  `scholar` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ultimologin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `investigadores`
--

INSERT INTO `investigadores` (`id`, `nome`, `email`, `ciencia_id`, `sobre`, `tipo`, `fotografia`, `areasdeinteresse`, `orcid`, `scholar`, `password`, `ultimologin`) VALUES
(11, 'Joana', 'R.micaela@live.com.pt', '0C1F-9648-2A48', 'miniin inininii ununun ininini', 'Integrado', 'FotoRapariga.png', 'xcvbnmuexrcfvgbhnjmkrxrcvgbhnjm', 'https://noticias.uc.pt/artigos/estudo-da-universidade-de-coimbra-aponta-desigualdades-sociais-no-acesso-a-ciclovias-e-sistema-de-bicicletas-partilhadas-de/', 'https://www.uc.pt/estudantes', ' $2y$10$2SLVhIPbYFAyoczEuL4vUeoJKE5S/um4Qy8fs1lc2tu9Yj7p9/uRm', NULL),
(12, 'Berto', 'berto_bertinho@gmail.com', '2A13-632C-D743', 'a', 'Integrado', '480006581462697f48b6ff44be2ea3d141def7edr1-334-441v2_uhq.jpg', '', '', '', '', NULL),
(19, 'Marta', 'marta@hotmail.com', '2A13-632C-D743', 'nao', 'Aluno', 'o_exorcista_remake.jpg', 'Ciências da natureza', 'https://noticias.uc.pt/artigos/estudo-da-universidade-de-coimbra-aponta-desigualdades-sociais-no-acesso-a-ciclovias-e-sistema-de-bicicletas-partilhadas-de/', 'https://www.uc.pt/estudantes', '$2y$10$vJmmYnaGTRcHw7X.bLYC1e9GQC5wG4as1ikXUgaZYP592x0n46D7S', NULL); 

-- --------------------------------------------------------

--
-- Estrutura da tabela `investigadores_projetos`
--

CREATE TABLE `investigadores_projetos` (
  `investigadores_id` int(11) NOT NULL,
  `projetos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `investigadores_projetos`
--

INSERT INTO `investigadores_projetos` (`investigadores_id`, `projetos_id`) VALUES
(11, 23),
(11, 24),
(12, 20),
(12, 24),
(12, 25),
(12, 26),
(19, 21),
(19, 26);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `sobreprojeto` mediumtext NOT NULL,
  `referencia` varchar(100) NOT NULL,
  `areapreferencial` varchar(255) NOT NULL,
  `financiamento` varchar(20) NOT NULL,
  `ambito` varchar(100) NOT NULL,
  `fotografia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id`, `nome`, `descricao`, `sobreprojeto`, `referencia`, `areapreferencial`, `financiamento`, `ambito`, `fotografia`) VALUES
(20, 'Figura', 'Integer a erat massa. Nunc sed pretium nulla. Donec tempor velit dui, sagittis gravida erat hendrerit ut.', 'A história de todos sobre o euismod. Diz-se que viveu nesta rua. Até os ultricies na urna, a massa da garganta, mas sempre diam. Fãs de futebol ao vivo, suaves ou justos, ele quer colocá-lo no ringue.', '543212345', 'Maecenas', '4321€', 'Phasellus', 'P1310166.JPG'),
(21, 'INSIGNIA', 'Morbi mauris sem, convallis ut commodo quis, consequat ac velit.', 'Phasellus dapibus eros vel fringilla ullamcorper. Donec sit amet tempor neque, sit amet facilisis ligula. Fusce eget lacinia lectus. Morbi laoreet auctor vehicula. Cras eget semper sem.', '123456789', 'Aliquam', '3333€', 'Vivamus', 'Castelo de Abrantes1.jpg'),
(23, 'FesTab', 'Proin blandit sagittis dolor quis porttitor. Phasellus tortor felis, eleifend at nisi ac, pulvinar malesuada lectus.', 'Nunc non justo vel mauris semper rutrum. Curabitur at feugiat felis, nec cursus leo. Vivamus euismod sollicitudin tempor. Nunc non augue diam. Mauris rutrum, lorem a pellentesque finibus, tellus ante vulputate elit, at venenatis lorem nunc nec risus.', '123454321', 'Scelerisque', '1234€', 'Phasellus', 'IMG_6431.JPG'),
(24, 'MurArte', 'Donec in urna ultricies, faucibus massa sed, semper diam.', 'Maecenas auctor semper metus consectetur malesuada. Phasellus feugiat tellus tellus, eu convallis turpis malesuada id. Nullam ac laoreet neque, sed euismod augue.', '123456789', 'Fringilla', '3214€', 'Volutpat', '5c.JPG'),
(25, 'NATBIO', 'Quisque pellentesque euismod condimentum. In hac habitasse platea dictumst.', 'Donec in urna ultricies, faucibus massa sed, semper diam. Vivamus turpis nisl, mollis vel justo consectetur, fringilla posuere velit. Maecenas auctor semper metus consectetur malesuada.', '654321789', 'Pellentesque', '7453€', 'Porttitor', '20220208_103402.jpg'),
(26, 'POR1FIO', 'Nullam ac laoreet neque, sed euismod augue.', 'Nunc non justo vel mauris semper rutrum. Curabitur at feugiat felis, nec cursus leo. Vivamus euismod sollicitudin tempor. Nunc non augue diam.', '56787654', 'Consectetur', '4760€', 'Lacinia', 'DSC_0010.JPG');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `investigadores`
--
ALTER TABLE `investigadores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `investigadores_projetos`
--
ALTER TABLE `investigadores_projetos`
  ADD PRIMARY KEY (`investigadores_id`,`projetos_id`),
  ADD KEY `projetos_id` (`projetos_id`);

--
-- Índices para tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `investigadores`
--
ALTER TABLE `investigadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `investigadores_projetos`
--
ALTER TABLE `investigadores_projetos`
  ADD CONSTRAINT `investigadores_projetos_ibfk_1` FOREIGN KEY (`investigadores_id`) REFERENCES `investigadores` (`id`),
  ADD CONSTRAINT `investigadores_projetos_ibfk_2` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(100) NOT NULL,
  `conteudo` mediumtext NOT NULL,
  `imagem` VARCHAR(100) NOT NULL,
  `data` DATE  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dados da tabela `noticias`
--
INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `imagem`, `data`) VALUES
(1,"Visita do Prof. Dr. Silviu Marian Miloiu, Vice-Reitor da Valahia Targoviste University na Roménia", "O TECHN&ART recebeu a visita do Prof. Dr. Silviu Marian Miloiu, Vice-Reitor da Valahia Targoviste University na Roménia. A visita realizou-se no seguimento da reunião transnacional no âmbito da KreativEU, Knowledge and Creativity European University, liderada pelo Instituto Politécnico de Tomar", "310055055_584688733449528_4008002950286842705_n.jpg", "2022-10-03"),
(2,"OPExCATer na Roda de conversa sobre Ruralidade do Museu Agrícola de Riachos", "Na passada 5ª feira, dia 21 de julho, decorreu no Museu Agrícola de Riachos (entidade parceira do projeto OPExCATer) uma atividade denominada “Roda de conversa sobre Ruralidade”. Contou com a presença de Mário Antunes (coordenador da Reserva da Biosfera do Paul do Boquilobo e parceiro do Projeto), José Cunha Barros e Carlos Simões Nuno (antropólogos) e Luiz Oosterbeek ( coordenador da Cátedra UNESCO de Humanidades e Paisagens Culturais). A sessão foi dinamizada por Luís Mota Figueira – investigador encarregue da Tarefa 3 do referido projeto. Também esteve integrada nos trabalhos a Investigadora responsável – Cecília Baptista.", "20220721_203209.jpg", "2022-07-25");


CREATE TABLE `admissoes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome_completo` VARCHAR(255) NOT NULL,
    `nome_profissional` VARCHAR(255) NOT NULL,
    `ciencia_id` VARCHAR(100) NOT NULL,
    `orcid` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(20) NOT NULL,
    `grau_academico` VARCHAR(255) NOT NULL,
    `ano_conclusao_academico` VARCHAR(255) NOT NULL,
    `area_academico` VARCHAR(255) NOT NULL,
    `area_investigacao` VARCHAR(255) NOT NULL,
    `instituicao_vinculo` VARCHAR(255) NOT NULL,
    `percentagem_dedicacao` VARCHAR(255) NOT NULL,
    `pertencer_outro` boolean NOT NULL,
    `outro_texto` TEXT,
    `biografia` TEXT NOT NULL,
    `ficheiro_motivacao` varchar(255) NOT NULL,
    `ficheiro_recomendacao` varchar(255) NOT NULL,
    `ficheiro_cv` varchar(255) NOT NULL,
    `ficheiro_fotografia` varchar(255) NOT NULL,
    `data_criacao` TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `investigadores`
ADD `research_gate` VARCHAR(255) NOT NULL AFTER `scholar`,
ADD `scopus_id` VARCHAR(255)  NOT NULL AFTER `research_gate`;


ALTER TABLE `projetos` ADD `concluido` boolean NOT NULL default false;

ALTER TABLE `projetos`
ADD `site` VARCHAR(255) NOT NULL AFTER `ambito`,
ADD `facebook` VARCHAR(255) NOT NULL AFTER `site`;

CREATE TABLE `oportunidades` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `imagem` VARCHAR(100) NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `conteudo` MEDIUMTEXT NOT NULL,
  `visivel` boolean NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `investigadores`
ADD COLUMN `sobre_en` mediumtext NOT NULL AFTER `sobre`,
ADD COLUMN `areasdeinteresse_en` mediumtext NOT NULL AFTER `areasdeinteresse`;

ALTER TABLE `projetos`
ADD COLUMN `nome_en` varchar(100) NOT NULL AFTER `nome`,
ADD COLUMN `descricao_en` mediumtext NOT NULL AFTER `descricao`,
ADD COLUMN `sobreprojeto_en` mediumtext NOT NULL AFTER `sobreprojeto`,
ADD COLUMN `referencia_en` varchar(100) NOT NULL AFTER `referencia`,
ADD COLUMN `areapreferencial_en` varchar(255) NOT NULL AFTER `areapreferencial`,
ADD COLUMN `financiamento_en` varchar(20) NOT NULL AFTER `financiamento`,
ADD COLUMN `ambito_en` varchar(100) NOT NULL AFTER `ambito`,
ADD COLUMN `site_en` varchar(100) NOT NULL AFTER `site`,
ADD COLUMN `facebook_en` varchar(100) NOT NULL AFTER `facebook`;


ALTER TABLE `noticias`
ADD COLUMN `titulo_en` VARCHAR(100) NOT NULL AFTER `titulo`,
ADD COLUMN `conteudo_en` MEDIUMTEXT NOT NULL AFTER `conteudo`;


ALTER TABLE `oportunidades`
ADD COLUMN `titulo_en` VARCHAR(255) NOT NULL AFTER `titulo`,
ADD COLUMN `conteudo_en` MEDIUMTEXT NOT NULL AFTER `conteudo`;

ALTER TABLE `noticias`
ADD COLUMN `ultimo_editor` INT(11) NULL,
ADD COLUMN `timestamp_editado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD CONSTRAINT `noticias_administrador_ibfk_1` FOREIGN KEY (`ultimo_editor`) REFERENCES `administradores` (`id`) ON DELETE SET NULL;

ALTER TABLE `oportunidades`
ADD COLUMN `ultimo_editor` INT(11) NULL,
ADD COLUMN `timestamp_editado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
ADD CONSTRAINT `oportunidades_administrador_ibfk_1` FOREIGN KEY (`ultimo_editor`) REFERENCES `administradores` (`id`) ON DELETE SET NULL;


UPDATE `administradores` SET `password` = '$2y$10$MH.i8UlpN1khB48yDkfby.a.nI9KjPEO8SH6N4NC/MOR2D.oYcGW2' WHERE `id` = 1;
UPDATE `administradores` SET `password` = '$2y$10$bH.1jT89ydQAU8UFVwKQ..UOOw6deHjNPY5v9UM8y1szBq5M4GAae' WHERE `id` = 7;

UPDATE `investigadores` SET `password` = '$2y$10$2SLVhIPbYFAyoczEuL4vUeoJKE5S/um4Qy8fs1lc2tu9Yj7p9/uRm' WHERE `id` = 11;
UPDATE `investigadores` SET `password` = '$2y$10$vJmmYnaGTRcHw7X.bLYC1e9GQC5wG4as1ikXUgaZYP592x0n46D7S' WHERE `id` = 19;


INSERT INTO `oportunidades` (`id`, `imagem`, `titulo`, `titulo_en`, `conteudo`, `conteudo_en`, `visivel`, `ultimo_editor`, `timestamp_editado`) VALUES
(1, '64ac9a2d5beec_investigacao.jpg', 'Bolsa de Investigação em Conservação de Obras de Arte', 'Research Fellowship in Art Conservation', '<p>A unidade TECHN&amp;ART está oferecendo uma bolsa de pesquisa para a conservação de obras de arte. Como bolsista de pesquisa, você trabalhará em estreita colaboração com nossos pesquisadores, aplicando metodologias avançadas para preservar e restaurar obras de arte. Seu trabalho contribuirá para a valorização do patrimônio artístico e cultural, garantindo a sua preservação para as futuras gerações.</p>', '<p>The TECHN&amp;ART unit is offering a research fellowship in art conservation. As a research fellow, you will work closely with our researchers, applying advanced methodologies to preserve and restore artworks. Your work will contribute to the enhancement of artistic and cultural heritage, ensuring its preservation for future generations.</p>', 1, 1, '2023-07-10 23:54:21'),
(2, '64ac9a6d1e566_repair.jpg', 'Estágio em Tecnologia Aplicada à Conservação de Patrimônio', 'Internship in Technology Applied to Heritage Conservation', '<p>Estamos em busca de estagiários entusiasmados em aplicar tecnologia à conservação de patrimônio. Como estagiário, você terá a oportunidade de trabalhar em projetos emocionantes que combinam arte, ciência e tecnologia. Colabore com nossa equipe multidisciplinar para desenvolver soluções inovadoras que preservem e valorizem o patrimônio artístico e cultural, utilizando ferramentas e técnicas de última geração.</p>', '<p>We are looking for enthusiastic interns to apply technology to heritage conservation. As an intern, you will have the opportunity to work on exciting projects that combine art, science, and technology. Collaborate with our multidisciplinary team to develop innovative solutions that preserve and enhance artistic and cultural heritage, using state-of-the-art tools and techniques.</p>', 0, 1, '2023-07-10 23:55:25'),
(3, '64ac9a68070ab_img.jpg', 'Bolsa de Pesquisa em Patrimônio Cultural Imaterial', 'Research Fellowship in Intangible Cultural Heritage', '<p>O TECHN&amp;ART oferece uma bolsa de pesquisa em patrimônio cultural imaterial. Como pesquisador, você terá a oportunidade de investigar e documentar tradições culturais intangíveis, preservando-as para as futuras gerações. Contribua para a valorização e divulgação desses elementos culturais únicos, promovendo a sua compreensão e apreciação na sociedade contemporânea.</p>', '<p>TECHN&amp;ART offers a research fellowship in intangible cultural heritage. As a researcher, you will have the opportunity to investigate and document intangible cultural traditions, preserving them for future generations. Contribute to the enhancement and dissemination of these unique cultural elements, promoting their understanding and appreciation in contemporary society.</p>', 1, 1, '2023-07-10 23:57:54');


UPDATE `investigadores` SET `fotografia` = '64ae620054719_55918.jpg' WHERE `id` = 19;
