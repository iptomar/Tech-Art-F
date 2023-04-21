<?php 
function ret_dic_pt(){


    /**
     * Dicionario para site em portugues
     * As chaves dos arrays servirao como substituto do id ou classe CSS do objeto
     * [INCOMPLETO!!! VERIFICAR E INTRODUZIR ENTRADAS NESTE DICIONARIO!!]
     */

    $dic_pt = array(

        //::::::IMAGEM DO SITE EM DESENVOLVIMENTO::::::

        "img-site-development" => "./assets/images/developmentWarningPT.png",

        //::::::CABEÇALHO PRINCIPAL::::::

        //Imagem com o logotipo da techn&art
        "header-site-logo" => "./assets/images/TechnArt5FundoTrans.png",
        //Drop-down 'Sobre o Techn&Art'
        "about-technart-drop-down" => "Sobre o Techn&art",
        "mission-and-goals-option" => "Missão e Objetivos",
        "research-axes-option" => "Eixos de Investigação",
        "org-struct-option" => "Estrutura Orgânica",
        "opportunities-option" => "Oportunidades",
        //Separador 'Projetos'
        "projects-tab" => "Projetos",
        //Drop-down 'Investigadores/as'
        "researchers-drop-down" => "Investigadores",
        "integrated-option" => "Integrados",
        "collaborators-option" => "Colaboradores",
        "students-option" => "Aluno",
        "admission-option" => "Novas admissões",
        //Separador 'Noticias'
        "news-tab" => "Notícias",
        //Separador 'Publicacoes'
        "publ-tab" => "Publicações",

        //::::::RODAPÉ PRINCIPAL::::::

        //Imagem com o logotipo da techn&art
        "footer-site-logo" => "./assets/images/TechnArt6FundoTrans.png",
        //Etiqueta / texto com parte da morada
        "address-txt-1" => "Quinta do Contador,",
        //Etiqueta / texto com parte da morada
        "address-txt-2" => "Estrada da Serra",
        //Etiqueta / texto 'Siga-nos',
        "follow-us-txt" => "Siga-nos",
        //Divisoria com 'projeto UD ...'
        "project-ud-txt" => "Projeto UD/05488/2020",
        //Etiqueta / texto com 'Instituto Pol...'
        "ipt-copyright-txt" => "©Instituto Politécnico de Tomar",
        //Etiqueta / texto com 'Todos os direitos reservados'
        "all-rights-reserved-txt" => "Todos os direitos reservados",

        //::::::index.php::::::

        //Titulo 'SOBRE O TECHN&ART' do slider
        "about-technart-slider" => "SOBRE O TECHN&ART",
        //Breve descricao do item 'SOBRE O TECHN&ART'
        "about-technart-slider-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //Titulo 'Ajudamos a Crescer o seu negocio' do slider
        "we-help-grow-slider" => "Ajudamos a Crescer o seu Negócio",
        //Breve descricao do item 'Somos a melhor agencia de consultoria'
        "we-help-grow-slider-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //Titulo 'Somos a melhor agencia de consultoria' do slider
        "best-consulting-agency-slider" => "Somos s Melhor Agência de Consultoria",
        //Breve descricao do item 'Somos a melhor agencia de consultoria'
        "best-consulting-agency-slider-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //botao 'Saiba mais' do slider
        "know-more-btn-txt-slider" => "SAIBA MAIS",
        //Etiqueta 'Video Institucional'
        "institutional-video-heading" => "VÍDEO INSTITUCIONAL",
        //Descricao do video institucional
        "institutional-video-heading-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //Etiqueta 'Projetos I&D'
        "rd-projects-heading" => "PROJETOS I&D",
        //botao 'Ver Todos'
        "see-all-btn-rd-projects" => "VER TODOS",
        //Etiqueta 'Ultimas noticias'
        "latest-news-heading" => "ÚLTIMAS NOTÍCIAS",
        //botao 'Ver todas'
        "see-all-btn-latest-news" => "VER TODAS",

        //::::::sobre.php::::::

        //Titulo 'Sobre o Techn&Art'
        "about-technart-page-heading" => "Sobre o TECHN&ART",
        //Subitulo página 'Sobre o Techn&Art'
        "about-technart-page-subtitle" => "Cras massa velit, vehicula nec tincidunt at, aliquet porttitor ligula. Nullam faucibus est nunc, at tincidunt odio efficitur eget. Pellentesque justo ex, tristique sed sapien ac, tempor venenatis odio liquet tincidun.  ",
        //Legenda 'Missao e Objetivos'
        "mission-and-goals-caption" => "MISSÃO E OBJETIVOS",
        //Legenda 'Eixos de Investigacao'
        "research-axes-caption" => "EIXOS DE INVESTIGAÇÃO",
        //Legenda 'Estrutra organica'
        "organic-struct-caption" => "ESTRUTURA ORGÂNICA",
        //Legenda 'Oportunidades'
        "opportunities-caption" => "OPORTUNIDADES",
        //botao 'SAIBA MAIS'
        "opportunities-know-more-btn" => "SAIBA MAIS",

        //::::::missao.php::::::

        //Titulo 'Missao e Objetivos'
        "mission-and-goals-page-heading" => "Missão e Objetivos",
        //Subtitulo
        "mission-and-goals-page-subtitle" => "Subtítulo",
        //ponto 1
        "mission-and-goals-page-point-one" => "O Techn&Art desenvolve investigação nos domínios da Salvaguarda do Património e da Valorização do Património, quer em desenvolvimento experimental, quer em investigação aplicada.",
        //ponto 2
        "mission-and-goals-page-point-two" => "Adicionalmente, o Techn&Art tem por missão:",
        //ponto 2, alinea a)
        "mission-and-goals-page-a-txt" => "Contribuir para a consolidação dos programas de formação do IPT enquadrados nos domínios científicos listados;",
        //ponto 2, alinea b)
        "mission-and-goals-page-b-txt" => "Contribuir para a sólida formação dos alunos estreitando a colaboração entre os trabalhos de investigação científica desenvolvidos pelos investigadores TechnArt;",
        //ponto 2, alinea c)
        "mission-and-goals-page-c-txt" => "Difundir a cultura científica, tecnológica e artística através da organização de conferências, colóquios, seminários, exposições e sessões culturais;",
        //ponto 2, alinea d)
        "mission-and-goals-page-d-txt" => "Promover a formação avançada dos recursos humanos, fomentando a sua constante valorização científica e cultural;",
        //ponto 2, alinea e)
        "mission-and-goals-page-e-txt" => "Estabelecer a cooperação interinstitucional com entidades nacionais e internacionais;",
        //ponto 2, alinea f)
        "mission-and-goals-page-f-txt" => "Utilizar com eficácia os financiamentos de que é beneficiária e outros recursos disponíveis;",
        //ponto 2, alinea g)
        "mission-and-goals-page-g-txt" => "Prestar serviços à comunidade no âmbito das suas atividades.",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI
        
        //::::::eixos.php::::::

        //Título 'Eixos de Investigacao'
        "axes-page-heading" => "Eixos de Investigação",
        //Subtitulo
        "axes-page-subtitle" => "Subtítulo",
        //Descricao / texto da pagina 'Eixos de investigacao', logo abaixo do subtitulo
        "axes-page-description" => "O Centro de Tecnologia, Restauro e Valorização das Artes (Techn&Art) tem como missão o desenvolvimento de estratégias e metodologias de investigação no âmbito de duas linhas temáticas:",
        //alinea a)
        "axes-page-a-txt" => "Salvaguarda",
        //alinea a1)
        "axes-page-a-one-txt" => "Conservação e Restauro",
        // alinea a2)
        "axes-page-a-two-txt" => "Caraterização e Contextualização do Património",
        //alinea b)
        "axes-page-b-txt" => "Valorização do Património Artístico e Cultural",
        //alinea b1)
        "axes-page-b-one-txt" => "Didática, Tecnologia e Comunicação",
        //alinea b2)
        "axes-page-b-two-txt" => "Design e Inovação",
        //Texto do fundo da página
        "bottom-text" => "Estas linhas de ação complementam-se e imbricam-se para que o todo que a missão do Techn&Art seja coerente e tire partido do visando a transferência de conhecimento, de competências e de experiências de todos os investigadores e colaboradores do nosso centro.",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI

        //::::::estrutura.php::::::

        //Título 'Estrutura Organica'
        "org-struct-page-heading" => "Estrutura Orgânica",
        //Subtitulo
        "org-struct-page-subtitle" => "Subtítulo",
        //Descricao / texto da pagina 'Estrutura Organica', logo abaixo do subtitulo
        "org-struct-page-description" => "A atividade do Techn&Art é suportada pelos seguintes órgãos de direção, gestão e administração:",
        //Etiqueta 'Diretor'
        "org-struct-page-director-tag" => "Diretor",
        //Etiqueta 'Diretor adjunto'
        "org-struct-page-deputy-director-tag" => "Diretor Adjunto",
        //Etiqueta 'secretarios administrativos'
        "org-struct-page-admin-directors-tag" => "Secretário Administrativo",
        //Etiqueta 'Conselho diretivo'
        "org-struct-page-board-of-directors-tag" => "Conselho Diretivo",
        "director-deputy-director" => "Composto pelo Diretor, Diretor Adjunto",
        //Etiqueta 'Conselho cinetifico'
        "org-struct-page-scinetific-conucil-tag" => "Conselho Científico",
        "all-integrated-members" => "Composto por todos os membros integrados.",
        //Etiqueta 'Conselho consultivo'
        "org-struct-page-advisory-board-tag" => "Conselho Consultivo",
        //Elementos integrantes do conselho consultivo
        "advisory-board-one" => "Ana María Calvo Manuel, Faculdade de Belas Artes da Universidade Completense de Madrid, Espanha.",
        "advisory-board-two" => "Chao Gejin, Instituto de Tradição Oral da Academia Chinesa de Ciências Sociais.",
        "advisory-board-three" => "José Julio García Arranz, Universidade da Estremadura, Espanha.",
        "advisory-board-four" => "Laurent Tissot, Universidade de Neuchântel, Suíça.",
        "advisory-board-five" => "Maria Filomena Guerra, Universidade Panthéon Sorbonne, Nanterre, França.",
        "advisory-board-six" => "Zoltán Somhegyi, Universidade Károli Gáspár, Budapeste, Hungria",

        //::::::oportunidades.php::::::

        //Titulo 'Oportunidades'
        "opport-page-heading" => "oportunidades",
        //Subtitulo
        "opport-page-subtitle" => "subtítulo",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI
        //RESTO DO TEXTO DESTA PAGINA AINDA E SIMULADO

        //::::::projetos.php::::::

        //Titulo 'Projetos'
        "projects-page-heading" => "Projetos",
        //Descricao pagina 'Projetos'
        "projects-page-description" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",

        //::::::projeto.php::::::

        //Classe css para todos os botoes 'Sobre o projeto'
        "about-project-btn-class" => "sobre o projeto",
        //Classe css para todos os titulos de separadores 'Sobre'
        "about-project-tab-title-class" => "Sobre o projeto",
        //Subtitulo separador 'sobre o projeto'
        "about-project-tab-subtitle-class" => "Subtitulo ",
        //Etiqueta de referencia do projeto
        "about-project-tab-reference-tag" => "Referência: ",
        //Etiqueta de area preferida do projeto
        "about-project-tab-pref-area-tag" => "Área preferencial Techn&Art: ",
        //Etiqueta de financiamento do projeto
        "about-project-tab-financing-tag" => "Financiamento: ",
        //Etiqueta de escopo do projeto
        "about-project-tab-scope-tag" => "Escopo: ",
        //Classe css para todos os botoes 'Equipa e Intervenientes'
        "team-steakholders-btn-class" => "equipa e intervenientes",
        //Classe css para todos os botoes 'Equipa e Intervenientes'
        "team-steakholders-tab-title-class" => "Equipa e intervenientes",
        //Subtitulo separador 'equipa e intervenientes'
        "team-steakholders-tab-subtitle-class" => "Subtitulo ",
        //

        //::::::integrados.php/colaboradores.php/alunos.php::::::

        //Titulo 'Investigadores/as Integrados/as'
        "integrated-researchers-page-heading" => "Investigadores/as Integrados/as",
        //Descricao de 'Investigadores/as Integrados/as'
        "integrated-researchers-page-heading-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //Titulo 'Investigadores/as Colaboradores/as'
        "colaborative-researchers-page-heading" => "Investigadores/as Colaboradores/as",
        //Descricao de 'Investigadores/as Integrados/as'
        "colaborative-researchers-page-heading-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",
        //Titulo 'Investigadores/as Alunos/as'
        "student-researchers-page-heading" => "Investigadores/as Alunos/as",
        //Descricao de 'Investigadores/as Alunos/as'
        "student-researchers-page-heading-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",

        //::::::integrado.php/colaborador.php/aluno.php:::::

        //Classe css para todos os botoes 'Sobre'
        "about-btn-class" => "sobre",
        //Classe css para todos os titulos de separadores 'Sobre'
        "about-tab-title-class" => "Sobre",
        //Classe css para todos os botoes 'areas de interesse'
        "areas-btn-class" => "áreas de interesse",
        //Classe css para todos os titulos de separadores 'areas de interesse'
        "areas-tab-title-class" => "Áreas de interesse",
        //Classe css para todos os botoes 'publicacoes'
        "publications-btn-class" => "publicações",
        //Classe css para todos os titulos de separadores 'publicacoes'
        "publications-tab-title-class" => "Publicações",
        //Classe css para todos os botoes 'projetos'
        "projects-btn-class" => "projetos",
        //Classe css para todos os titulos de separadores 'projetos'
        "projects-tab-title-class" => "Projetos",
        //Texto 'Ligacoes Externas'
        "ext-links" => "Ligações externas",

        //::::::noticias.php::::::

        //Titulo pagina 'Noticias'
        "news-page-heading" => "Notícias",
        //Descricao pagina noticias
        "news-page-heading-desc" => "TESTE TESTE TESTE TESTE TESTE TESTE TESTE ",

        //::::::noticia.php::::::
        
        //Heading 'Conteúdo da noticia'
        "news-content-heading" => "Conteúdo da Notícia",

        //::::::publicacoes.php

        //Etiqueta 'Publicacoes'

        "publications-page-heading" => "Publicações",
        
        
        //:::::novasadimssoes.php
        "new-admissions-title" => "Novas admissões",
        "new-admissions-p1" => "A admissão de novos/as membros/as à equipa de investigação do TECHN&ART, integrados/as ou colaboradores/as, processa-se através de proposta ao conselho científico. O/A candidado/a deve preencher o formulário com as informações e a documentação necessária.",
        "new-admissions-p2" => "A admissão requerirá que o/a candidado/a seja proposto/a por um membro integrado do TEHN&ART, servindo para o efeito a carta de recomendação pedida no formulário.",
        "new-admissions-regulations" => "O/A candidato deverá também consultar o",
        "new-admissions-regulations-link" => "regulamento geral do TECHN&ART.",
        "new-admissions-regulations-fill" => "Preencher Formulário"
    );

    return $dic_pt;
}

?>