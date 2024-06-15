<?php
function ret_dic_en()

{

    return array(

        //dates
        "day-name" => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
        "date-of" => " of ",
        "month-name" => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),

        //::::::administradores/index.php::::::

        //Titulo da página Administradores
        "admin-title" => "Administrators",
        //Botao 'Adicionar Novo Administradores'
        "admin-add-new" => "Add new administrator",
        //Títulos das colunas na tabela da página administradores
        "admin-name" => "Name",
        "admin-actions" => "Actions",
        //Botões da tabela dos administradores da coluna ações
        "admin-change" => "Change",
        "admin-delete" => "Delete",
        "admin-change-password" => "Change Password",

        //::::::investigadores/::::::
        //Titulos das colunas da página 
        "researcher-title" => "Researchers",
        "researcher-add-profile" => "Add New Profile",
        "reasercher-search" => "Search",
        "researcher-type" => "Type",
        "researcher-name" => "Name",
        "researcher-photo" => "Photography",
        "researcher-actions" => "Actions",
        //botões na coluna Ações da página 
        "researcher-change" => "Change",
        "researcher-delete" => "Delete",
        "researcher-change-password" => "Change Password",
        "researcher-report-generate" => "Generate Report" ,
        "researcher-select-publications" => "Select Publications",
        //Botão selecionar no topo da página 
        "researcher-select-year" => "Select Year",
        "researcher-current-year" => "Current Year",

        //::::::Projetos::::::
        //Titulos das colunas da página
        "project-title" => "Projects",
        "project-name" => "Name",
        "project-state" => "State",
        "project-reference" => "Reference",
        "project-preferencial-area" => "TECHN&ART Preferencial Area",
        "project-photo" => "Photography",
        "project-actions" => "Actions",
        "project-funding" => "Fuding",
        //Botões da coluna Ações
        "project-button-change" => "Change",
        "project-button-delete" => "Delete",
        "project-add-new" => "Add New Project",

        
        //::::::Notícias::::::
        //Titulo da pagina
        "news-title" => "News",
        //titulos das colunas 
        "news-table-title" => "Title",
        "news-table-content" => "Content",
        "news-table-date" => "Date",
        "news-table-image" => "Image",
        "news-button-add" => "Add new",
        //Botões alterar e apagar
        "news-button-change" => "Change",
        "news-button-delete" => "Delete",


        //::::::oportunidades::::::
        //Titulo da página
        "opportunities-title" => "Opportunities",
        //Titulos das colunas 
        "opportunities-table-visible" => "Visible",
        "opportunities-table-image" => "Image",
        "opportunities-table-title-en" => "Title EN",
        "opportunities-button-add" => "Add new opportunitie",
        //Botões alterar e apagar
        "opportunities-button-change" => "Change",
        "opportunities-button-delete" => "Delete",
        

        //::::::admissões::::::
        //Titulo da tab
        "admissions-title" => "Admissions",
        //Título da página
        "admissions-requests-title" => "Admission requests",
        //Titulos das colunas   
        "admissions-table-submission-date" => "Submission date",
        "admissions-table-photo" => "Photography",
        "admissions-table-full-name" => "Full Name",
        "admissions-table-actions" => "Actions",
        //Botões detalhes e apagar
        "admissions-button-details" => "Details",
        "admissions-button-delete" => "Delete",

        //::::::Editar areas::::::
        //Título da tab
        "areas-title" => "Edit Areas",
        //Texto da seccção de "Editar texto"
        "areas-edit-text" => "Edit text",
        "areas-choose-to-edit" => "Choose the area to edit",
        //dropdown
        "areas-dropdown-select" => "Select",
        "areas-dropdown-mission-and-objectives" => "Mission and objectives",
        "areas-dropdown-research-axes" => "Research Axes",
        "areas-dropdown-organic-structures" => "Organic Structure",
        "areas-dropdown-new-admissions" => "New Admissions",
        //Botões guardar e cancelar
        "areas-button-save" => "Save",
        "areas-button-cancel" => "Cancel",

        //::::::Duplicados::::::
        //Título da página e da tab
        "duplicated-title" => "Duplicates",
        //Botão "Atualizar Análise de Publicações"
        "duplicated-button-update-post-analytics" => "Update Publication Analysis",
        //Texto do menu de pesquisa
        "duplicated-show" => "Show",
        "duplicated-button-search" => "Update search",
        "duplicated-checkbox-to-check" => "To check",
        "duplicated-checkbox-waiting-for-change" => "Waiting for change",
        //Dropdown "Atualizar Estado"
        "duplicated-checkbox-verified" => "To be Verified",
        "duplicated-checkbox-numbered-titles" => "Numbered Titles",
        "duplicated-button-update-search" => "Update Search",
        "duplicated-button-update-state" => "Update State",
        //Titulos das colunas da tabela
        "duplicated-table-state" => "State",
        "duplicated-table-title" => "Title",

        //::::::Publicações::::::
        //Título da página e tab
        "publications-title" => "Publications",
        //Botão "Atualizar Pesquisa"
        "publications-button-update-search" => "Update Search",
        //Títulos das colunas da tabela
        "publications-table-title" => "Title",
        "publications-table-journal" => "Journal",
        "publications-table-number" => "Nmber",
        "publications-table-pages" => "Pages",
        "publications-table-year" => "Year",
        "publications-table-author" => "Author",
        "publications-table-keywords" => "keywords",  

        //::::::Slider::::::
        //Botão "Adicionar novo item ao slider"
        "slider-button-add-new-item" => "Add New Item to the Slider",
        //Titulos das colunas da tabela
        "slider-table-title" => "Title",
        "slider-table-image" => "Image",
        "slider-table-content" => "Content",
        //Botões alterar e eliminar
        "slider-button-change" => "Change" ,
        "slider-button-delete" => "Delete",

        //Newsletter
        //Botão "Iniciar Envio"
        "newsletter-button-send" => "Start sending",
        //Texto dos cartões dos subscritores
        "newsletter-stats-subscribers-pt" => "Portuguese Subscribers",
        "newsletter-stats-subscribers-en" => "English Subscribers",
        "newsletter-stats-total-subs" => "Total Subscribers",
        //Texto "Newsletters Enviadas"
        "newsletter-stats-sended" => "Newsletter sent",



        //botão sair do backoffice
        "exit" => "Exit"
    );
}