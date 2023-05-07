<?php 
include_once "config/configurations.php";
function ret_dic_en(){



    /**
     * Dicionario para site em ingles
     * As chaves dos arrays servirao como substituto do id ou classe CSS do objeto
     * [INCOMPLETO!!! VERIFICAR E INTRODUZIR ENTRADAS NESTE DICIONARIO
     * E ACRESCENTAR TRADUCOES DE DADOS DA BD SE POSSIVEL!!]
     */
    $dic_en = array(

        //::::::IMAGEM DO SITE EM DESENVOLVIMENTO::::::

        "img-site-development" => "./assets/images/developmentWarningEN.png",

        //::::::CABEÇALHO PRINCIPAL::::::

        //Imagem com o logotipo da techn&art
        "header-site-logo" => "./assets/images/TechnArt11FundoTrans.png",
        //Drop-down 'Sobre o Techn&Art'
        "about-technart-drop-down" => "About Techn&art",
        "mission-and-goals-option" => "Mission and Goals",
        "research-axes-option" => "Research Axes",
        "org-struct-option" => "Organic Structure",
        "opportunities-option" => "Opportunities",
        //Separador 'Projetos'
        "projects-tab" => "Projects",
        //Drop-down 'Investigadores/as'
        "researchers-drop-down" => "Researchers",
        "integrated-option" => "Integrated",
        "collaborators-option" => "Collaborators",
        "students-option" => "Students",
        "admission-option" => "New admissions",
        //Separador 'Noticias'
        "news-tab" => "News",
        //Separador 'Publicacoes'
        "publ-tab" => "Publications",

        //::::::RODAPÉ PRINCIPAL::::::

        //Imagem com o logotipo da techn&art
        "footer-site-logo" => "./assets/images/TechnArt12FundoTrans.png",
        //Etiqueta / texto com parte da morada
        "address-txt-1" => "Contador Farm,",
        //Etiqueta / texto com parte da morada
        "address-txt-2" => "Serra Road",
        //Etiqueta / texto 'Siga-nos',
        "follow-us-txt" => "Follow Us",
        //Divisoria com 'projeto UD ...'
        "project-ud-txt" => "Project UD/05488/2020",
        //Etiqueta / texto com 'Instituto Pol...'
        "ipt-copyright-txt" => "©Polytechnic Institute of Tomar",
        //Etiqueta / texto com 'Todos os direitos reservados'
        "all-rights-reserved-txt" => "All rights reserved",

        //::::::index.php::::::

        //Titulo 'SOBRE O TECHN&ART' do slider
        "about-technart-slider" => "ABOUT TECHN&ART",
        //Breve descricao do item 'SOBRE O TECHN&ART'
        "about-technart-slider-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",
        //Titulo 'Ajudamos a Crescer o seu negocio' do slider
        "we-help-grow-slider" => "We help grow your business",
        //Breve descricao do item 'Somos a melhor agencia de consultoria'
        "we-help-grow-slider-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",
        //Titulo 'Somos a melhor agencia de consultoria' do slider
        "best-consulting-agency-slider" => "We are the best consulting agency",
        //Breve descricao do item 'Somos a melhor agencia de consultoria'
        "best-consulting-agency-slider-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",
        //botao 'Saiba mais' do slider
        "know-more-btn-txt-slider" => "KNOW MORE",
        //Etiqueta 'Video Institucional'
        "institutional-video-heading" => "INSTITUTIONAL VIDEO",
        //Descricao do video institucional
        "institutional-video-heading-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",
        //Etiqueta 'Projetos I&D'
        "rd-projects-heading" => "R&D PROJECTS",
        //botao 'Ver Todos'
        "see-all-btn-rd-projects" => "SEE ALL",
        //Etiqueta 'Ultimas noticias'
        "latest-news-heading" => "LATEST NEWS",
        //botao 'Ver todas'
        "see-all-btn-latest-news" => "SEE ALL",

        //::::::sobre.php::::::

        //Titulo 'Sobre o Techn&Art'
        "about-technart-page-heading" => "About TECHN&ART",
        //Subitulo página 'Sobre o Techn&Art'
        "about-technart-page-subtitle" => "Cras massa velit, vehicula nec tincidunt at, aliquet porttitor ligula. Nullam faucibus est nunc, at tincidunt odio efficitur eget. Pellentesque justo ex, tristique sed sapien ac, tempor venenatis odio liquet tincidun.  ",
        //Legenda 'Missao e Objetivos'
        "mission-and-goals-caption" => "MISSION AND GOALS",
        //Legenda 'Eixos de Investigacao'
        "research-axes-caption" => "RESEARCH AXES",
        //Legenda 'Estrutra organica'
        "organic-struct-caption" => "ORGANIC STRCUTURE",
        //Legenda 'Oportunidades'
        "opportunities-caption" => "OPPORTUNITIES",
        //botao 'SAIBA MAIS'
        "opportunities-know-more-btn" => "KNOW MORE",

        //::::::missao.php::::::

        //Titulo 'Missao e Objetivos'
        "mission-and-goals-page-heading" => "mission and goals",
        //Subtitulo
        "mission-and-goals-page-subtitle" => "caption",
        //ponto 1
        "mission-and-goals-page-point-one" => "Techn&Art develops research in the fields of Safeguarding Heritage and Valuing Heritage, both in experimental development and in applied research.",
        //ponto 2
        "mission-and-goals-page-point-two" => "Additionally, Techn&Art's mission is to:",
        //ponto 2, alinea a)
        "mission-and-goals-page-a-txt" => "Contribute to the consolidation of IPT's training programs within the listed scientific domains;",
        //ponto 2, alinea b)
        "mission-and-goals-page-b-txt" => "Contribute to the solid training of students by strengthening collaboration between the scientific research work carried out by TechnArt researchers;",
        //ponto 2, alinea c)
        "mission-and-goals-page-c-txt" => "Disseminate scientific, technological and artistic culture through the organization of conferences, colloquiums, seminars, exhibitions and cultural sessions;",
        //ponto 2, alinea d)
        "mission-and-goals-page-d-txt" => "Promote the advanced training of human resources, encouraging their constant scientific and cultural development;",
        //ponto 2, alinea e)
        "mission-and-goals-page-e-txt" => "Establish inter-institutional cooperation with national and international entities;",
        //ponto 2, alinea f)
        "mission-and-goals-page-f-txt" => "Effectively use the funding it receives and other available resources;",
        //ponto 2, alinea g)
        "mission-and-goals-page-g-txt" => "Provide services to the community within the scope of its activities.",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI
        
        //::::::eixos.php::::::

        //Título 'Eixos de Investigacao'
        "axes-page-heading" => "research axes",
        //Subtitulo
        "axes-page-subtitle" => "caption",
        //Descricao / texto da pagina 'Eixos de investigacao', logo abaixo do subtitulo
        "axes-page-description" => "The Center for Technology, Restoration and Enhancement of the Arts (Techn&Art) has as its mission the development of research strategies and methodologies within the scope of two thematic lines:",
        //alinea a)
        "axes-page-a-txt" => "Safeguard",
        //alinea a1)
        "axes-page-a-one-txt" => "Conservation and Restoration",
        // alinea a2)
        "axes-page-a-two-txt" => "Characterization and Contextualization of Heritage",
        //alinea b)
        "axes-page-b-txt" => "Enhancement of the Artistic and Cultural Heritage",
        //alinea b1)
        "axes-page-b-one-txt" => "Didactics, Technology and Communication",
        //alinea b2)
        "axes-page-b-two-txt" => "Design and Innovation",
        //Texto do fundo da página
        "bottom-text" => "These lines of action complement and intertwine so that the whole mission of Techn&Art is coherent and takes advantage of the aim of transferring the knowledge, skills and experiences of all the researchers and collaborators of our centre.",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI

        //::::::estrutura.php::::::

        //Título 'Estrutura Organica'
        "org-struct-page-heading" => "organic structure",
        //Subtitulo
        "org-struct-page-subtitle" => "caption",
        //Descricao / texto da pagina 'Estrutura Organica', logo abaixo do subtitulo
        "org-struct-page-description" => "Techn&Art's activity is supported by the following governing, management and administration bodies:",
        //Etiqueta 'Diretor'
        "org-struct-page-director-tag" => "Director",
        //Etiqueta 'Diretor adjunto'
        "org-struct-page-deputy-director-tag" => "Deputy Director",
        //Etiqueta 'secretarios administrativos'
        "org-struct-page-admin-directors-tag" => "Administrative Directors",
        //Etiqueta 'Conselho diretivo'
        "org-struct-page-board-of-directors-tag" => "Board of Directors",
        "director-deputy-director" => "Composed of the Director, Deputy Director",
        //Etiqueta 'Conselho cinetifico'
        "org-struct-page-scinetific-conucil-tag" => "Scientific Council",
        "all-integrated-members" => "Composed of all integrated members.",
        //Etiqueta 'Conselho consultivo'
        "org-struct-page-advisory-board-tag" => "Advisory Board",
        //Elementos integrantes do conselho consultivo
        "advisory-board-one" => "Ana María Calvo Manuel, Faculty of Fine Arts of the Completense University of Madrid, Spain.",
        "advisory-board-two" => "Chao Gejin, Institute of Oral Tradition, Chinese Academy of Social Sciences.",
        "advisory-board-three" => "José Julio García Arranz, University of Extremadura, Spain.",
        "advisory-board-four" => "Laurent Tissot, University of Neuchantel, Switzerland.",
        "advisory-board-five" => "Maria Filomena Guerra, Panthéon Sorbonne University, Nanterre, France.",
        "advisory-board-six" => "Zoltán Somhegyi, Universidade Károli Gáspár, Budapest, Hungary",

        //::::::oportunidades.php::::::

        //Titulo 'Oportunidades'
        "opport-page-heading" => "opportunities",
        //Subtitulo
        "opport-page-subtitle" => "caption",
        //legenda da imagem
        //LEGENDA DA IMAGEM AQUI
        //RESTO DO TEXTO DESTA PAGINA AINDA E SIMULADO

        //::::::projetos.php::::::

        //Titulo 'Projetos'
        "projects-page-heading" => "Projects",
        //Descricao pagina 'Projetos'
        "projects-page-description" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",

        //::::::projeto.php::::::

        //Classe css para todos os botoes 'Sobre o projeto'
        "about-project-btn-class" => "about the project",
        //Classe css para todos os titulos de separadores 'Sobre'
        "about-project-tab-title-class" => "About the project",
        //Subtitulo separador 'sobre o projeto'
        "about-project-tab-subtitle-class" => "Subtitle",
        //Etiqueta de referencia do projeto
        "about-project-tab-reference-tag" => "Reference: ",
        //Etiqueta de area preferida do projeto
        "about-project-tab-pref-area-tag" => "Techn&Art prefered area: ",
        //Etiqueta de financiamento do projeto
        "about-project-tab-financing-tag" => "Financing: ",
        //Etiqueta de escopo do projeto
        "about-project-tab-scope-tag" => "Scope: ",
        //Classe css para todos os botoes 'Equipa e Intervenientes'
        "team-steakholders-btn-class" => "team and steakholders",
        //Classe css para todos os botoes 'Equipa e Intervenientes'
        "team-steakholders-tab-title-class" => "Team and steakholders",
        //Subtitulo separador 'equipa e intervenientes'
        "team-steakholders-tab-subtitle-class" => "Subtitle",
        //

        //::::::integrados.php/colaboradores.php/alunos.php::::::

        //Titulo 'Investigadores/as Integrados/as'
        "integrated-researchers-page-heading" => "Integrated Researchers",
        //Descricao de 'Investigadores/as Integrados/as'
        "integrated-researchers-page-heading-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST ",
        //Titulo 'Investigadores/as Colaboradores/as'
        "colaborative-researchers-page-heading" => "Collaborative Researchers",
        //Descricao de 'Investigadores/as Integrados/as'
        "colaborative-researchers-page-heading-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",
        //Titulo 'Investigadores/as Alunos/as'
        "student-researchers-page-heading" => "Student Researchers",
        //Descricao de 'Investigadores/as Alunos/as'
        "student-researchers-page-heading-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",

        //::::::integrado.php/colaborador.php/aluno.php:::::

        //Classe css para todos os botoes 'Sobre'
        "about-btn-class" => "about",
        //Classe css para todos os titulos de separadores 'Sobre'
        "about-tab-title-class" => "About",
        //Classe css para todos os botoes 'areas de interesse'
        "areas-btn-class" => "areas of interest",
        //Classe css para todos os titulos de separadores 'areas de interesse'
        "areas-tab-title-class" => "Areas of interest",
        //Classe css para todos os botoes 'publicacoes'
        "publications-btn-class" => "publications",
        //Classe css para todos os titulos de separadores 'publicacoes'
        "publications-tab-title-class" => "Publications",
        //Classe css para todos os botoes 'projetos'
        "projects-btn-class" => "projects",
        //Classe css para todos os titulos de separadores 'projetos'
        "projects-tab-title-class" => "Projects",
        //Texto 'Ligacoes Externas'
        "ext-links" => "External links",

        //::::::noticias.php::::::

        //Titulo pagina 'Noticias'
        "news-page-heading" => "News",
        //Descricao pagina noticias
        "news-page-heading-desc" => "TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ",

        //::::::noticia.php::::::
        
        //Heading 'Conteúdo da noticia'
        "news-content-heading" => "News Content",

        //::::::publicacoes.php

        //Etiqueta 'Publicacoes'
        
        "publications-page-heading" => "Publications",

        //:::::novasadimssoes.php
        "new-admissions-title" => "New admissions",
        "new-admissions-p1" => "The admission of new members to the TECHN&ART research team, integrated or colaborators, is proessed by proposal to the scientific board. The candidate should fill the form with the necessary information and documentation.",
        "new-admissions-p2" => " Admission will require that the candidate be proposed by an integrated member of TECHN&ART, with the letter of recomendation required in the form serving this purpose.",
        "new-admissions-regulations" => "The candidate should also read the TECHN&ART",
        "new-admissions-regulations-link" => "general regulations document.",
        "new-admissions-regulations-fill" => "Fill out Form",

        //:::admiissao.php
        //Título
        "admission-title" => "Integration form | TECHN&ART",
        //Mensagem informação após o título
        "admission-msg-1" => "Dear researcher,",
        "admission-msg-2" => "Thank you very much for your interest in our R&D unit - TECHN&ART. So that your proposal may proceed to the consideration of the scientific board, it is necessary that you fill in this form.",
        "admission-msg-3" => "If any questions arise, do not hesitate to contact our secretariat, at",
        //Placeholder e Erro dos Inputs
        "admission-placeholder" => "Enter your answer",
        "admission-error" => "Please enter a valid value",
        //Etiquetas dos campos de input do formulário
        "admission-name" => "Full name",
        "admission-name-prof" => "Professional Name",
        "admission-cienciaid" => "Ciência ID",
        "admission-orcid" => "ORCID",
        "admission-email" => "Email address",
        "admission-cellphone" => "Cellphone number",
        "admission-academic-qualifications" => "Academic Qualifications",
        "admission-year-conclusion" => "Year of conclusion of the academic qualifications",
        "admission-field-expertise" => "Field of expertise of the academic qualifications",
        "admission-main-research-areas" => "Main research areas",
        "admission-institucional-affliation" => "Institucional affiliation (start date and end date, if applicable [dd/mm/yyyy)]",
        "admission-percentage-dedication-tech" => "Percentage of dedication to TECHN&ART",
        "admission-member-another" => "Are you a member of another research and development centre?",
        "admission-member-yes" => "Yes",
        "admission-member-no" => "No",
        "admission-another-centre-info" => "If YES, which centre, in which category and with what percentage of dedication?",
        "admission-biography" => "Short researcher biography (1-2 paragraphs) in English",
        //Etiquetas dos campos de ficheiros
        "admission-motivation" => "Motivation Letter",
        "admission-recommendation" => "Recommendation Letter of the proponent TECHN&ART researcher",
        "admission-cv" => "Curriculum Vitae",
        "admission-photo" => "Researcher Photo",
        //Botão Submeter
        "admission-submit" => "Submit",
        "admission-cancel" => "Cancel",
        //Mensagens de Submissão
        "admission-file-size-error" => "ERROR: File size exceeds the maximum limit of " . MAX_FILE_SIZE . "MB",
        "admission-required-error" => "ERROR: Failed to retrieve data from the fields",
        "admission-send-error" => "Database ERROR: Please try again later",
        "admission-successful" => "The form was successfully submitted"
    );

    return $dic_en;
}
