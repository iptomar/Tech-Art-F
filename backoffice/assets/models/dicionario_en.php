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

        //::::::administradores/create.php::::::
        /*
        //Titulo da página create.php
        "admin-create-title" => "Add administrator",
        //Etiquetas dos campos na página create.php
        "admin-create-name" => "Name",
        "admin-create-password" => "Password",
        "admin-create-repeat-password" => "Repeat the Password",
        //Botões 'guardar' e 'cancelar' na página create.php 
        "admin-create-save" => "Save",
        "admin-create-cancel" => "Cancel" ,

        //::::::investigadores/create.php::::::
        // Titulo da página
        "researcher-add-title" => "Add Researcher",
        //Conteudo da página 
        "researcher-add-name" => "Name",
        "researcher-add-email" => "Email",
        "researcher-add-password" => "Password",
        "researcher-add-repeat-password" => "Repeat the Password",
        "researcher-add-about" => "About",
        "researcher-add-interest-areas" => "Areas of interest",
        "researcher-add-about-en" => "About",
        "researcher-add-interest-areas-en" => "Areas of interest",
        "researcher-add-type" => "type",
        "researcher-add-photo" => "Photography",
        //Botões 'guardar' e 'cancelar' na página create.php dos investigadores
        "researcher-add-save" => "Save",
        "researcher-add-cancel" => "Cancel",
        */

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

        /*
        //::::::Projetos/create.php::::::
        //Conteúdo da página
        "project-create-title" => "Create Project",
        "project-create-completed" => "Completed",
        "project-create-name-en" => "Name",
        "project-create-description-en" => "Description",
        "project-create-about-en" => "About Project",
        "project-create-reference" => "Reference",
        "project-create-preferencial-area" => "TECH&ART preferencial area",
        "project-create-funding" => "Funding",
        "project-create-scope" => "Scope",
        "project-create-site" => "Site",
        "project-create-facebook" => "Facebook",
        "project-create-researchers" => "Researchers",
        //checkboxes dos investigadores
        "project-create-student" => "Student",
        "project-create-collaborator" => "Collaborator",
        "project-create-integrated" => "Integrated",
        "project-create-external" => "External",
        "project-create-photography" => "Photography",
        //Botões criar e cancelar encontrados no fundo da página
        "project-create-create" => "Create",
        "project-create-Cancel" => "Cancel",
        */

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

        /*
        //::::::News/create.php::::::
        //Conteúdo da página 
        "news-add-date-en" => "News Date",
        "news-add-title-en" => "News Title",
        "news-add-content-en" => "News content",
        "news-add-image" => "Image",
        //Botões escolher ficheiro,criar e cancelar
        "news-add-choose-file" => "Choose File",
        "news-add-create" => "Create",
        "news-add-cancel" => "Cancel",
        */

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
        /*
        //::::::oportunidades/create.php::::::
        //Conteúdo da pagina
        "opportunities-add-visible" => "Visible",
        "opportunities-add-title-en" => "Title",
        "opportunities-add-content-en" => "Content",
        "opportunities-add-files-en" => "Files",
        "opportunities-add-choose-files" => "Choose Files",
        "opportunities-add-image" => "Image",
        "opportunities-add-choose-image" => "Choose image",
        "opportunities-add-create" => "Create",
        "opportunities-add-Cancel" => "Cancel",
        */

        //::::::admissões::::::
        "admissions-title" => "Admissions",
        "admissions-requests-title" => "Admission requests",
        "admissions-table-submission-date" => "Submission date",
        "admissions-table-photo" => "Photography",
        "admissions-table-full-name" => "Full Name",
        "admissions-table-actions" => "Actions",
        "admissions-button-details" => "Details",
        "admissions-button-delete" => "Delete",

        //::::::Editar areas::::::
        "areas-title" => "Edit Areas",
        "areas-edit-text" => "Edit text",
        "areas-choose-to-edit" => "Choose the area to edit",
        "areas-dropdown-select" => "Select",
        "areas-dropdown-mission-and-objectives" => "Mission and objectives",
        "areas-dropdown-research-axes" => "Research Axes",
        "areas-dropdown-organic-structures" => "Organic Structure",
        "areas-dropdown-new-admissions" => "New Admissions",
        "areas-photo" => "Photography",
        "areas-button-save" => "Save",
        "areas-button-cancel" => "Cancel",

        //::::::Duplicados::::::
        "duplicated-title" => "Duplicates",
        "duplicated-button-update-post-analytics" => "Update Publication Analysis",
        "duplicated-show" => "Show",
        "duplicated-entry" => "entry's",
        "duplicated-button-search" => "Update search",
        "duplicated-in-the-field" => "in the field",
        "duplicated-checkbox-filter-by-state" => "filter by state",
        "duplicated-checkbox-to-check" => "To check",
        "duplicated-checkbox-waiting-for-change" => "Waiting for change",
        "duplicated-checkbox-verified" => "To be Verified",
        "duplicated-checkbox-numbered-titles" => "Numbered Titles",
        "duplicated-button-update-search" => "Update Search",
        "duplicated-button-update-state" => "Update State",
        "duplicated-table-state" => "State",
        "duplicated-table-title" => "Title",

        //::::::Publicações::::::
        "publications-title" => "Publications",
        "publications-button-update-post-analytics" => "Update Publication Analysis",
        "publications-show" => "Show",
        "publications-entry" => "entry's",
        "publications-search" => "Search",
        "publications-in-the-field" => "in the field",
        "publications-button-update-search" => "Update Search",
        "publications-table-title" => "Title",
        "publications-table-journal" => "Journal",
        "publications-table-number" => "Nmber",
        "publications-table-pages" => "Pages",
        "publications-table-year" => "Year",
        "publications-table-author" => "Author",
        "publications-table-keywords" => "keywords",  

        //::::::Slider::::::
        "slider-button-add-new-item" => "Add New Item to the Slider",
        "slider-table-title" => "Title",
        "slider-table-image" => "Image",
        "slider-table-content" => "Content",
        "slider-button-change" => "Change" ,
        "slider-button-delete" => "Delete",

        //Newsletter
        "newsletter-button-send" => "Start sending",
        "newsletter-stats-subscribers-pt" => "Portuguese Subscribers",
        "newsletter-stats-subscribers-en" => "English Subscribers",
        "newsletter-stats-total-subs" => "Total Subscribers",
        "newsletter-stats-sended" => "Newsletter sent",



        //botão sair do backoffice
        "exit" => "Exit"
    );
}