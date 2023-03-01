
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
(2,"OPExCATer na Roda de conversa sobre Ruralidade do Museu Agrícola de Riachos", "Na passada 5ª feira, dia 21 de julho, decorreu no Museu Agrícola de Riachos (entidade parceira do projeto OPExCATer) uma atividade denominada “Roda de conversa sobre Ruralidade”. Contou com a presença de Mário Antunes (coordenador da Reserva da Biosfera do Paul do Boquilobo e parceiro do Projeto), José Cunha Barros e Carlos Simões Nuno (antropólogos) e Luiz Oosterbeek ( coordenador da Cátedra UNESCO de Humanidades e Paisagens Culturais). A sessão foi dinamizada por Luís Mota Figueira – investigador encarregue da Tarefa 3 do referido projeto. Também esteve integrada nos trabalhos a Investigadora responsável – Cecília Baptista.", "20220721_203209.jpg", "2022-07-25")


