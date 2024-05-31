<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();


                // Your database connection and other PHP code

                // Query to retrieve the minimum and maximum publication years
                $query = "SELECT MIN(YEAR(data)) AS min_year, MAX(YEAR(data)) AS max_year FROM publicacoes" ;
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve the minimum and maximum years from the query result
                $minYear = $result['min_year'];
                $maxYear = $result['max_year'];
                
?>

<script>
    // JavaScript function to update the displayed value when slider changes
    function updateSliderValue() {
        var slider = document.getElementById("yearSlider");
        var selectedYearDisplay = document.getElementById("selectedYearDisplay");
        
        // Update the displayed value
        selectedYearDisplay.innerText = slider.value;
    }

    document.querySelectorAll('#selectContext a').forEach(function(item) {
        item.addEventListener('click', function() {
            var selectedType = this.getAttribute('value');
            document.getElementById('selectedType').value = selectedType;
            document.getElementById('dropdownTitle').innerText = this.innerText;
        });
    });
</script>

<?= template_header('Publicações'); ?>
<section class='product_section layout_padding'>
    <div style='padding-top: 50px; padding-bottom: 30px;'>

             <!--Select para selecionar o campo pelo  qual se quer perquisar  o investigador-->
            <!-- <div class="dropdown-wrapper"> -->
<style>
    .scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
    text-align:left;
    }

    #reloadButton:hover {
    background-color: white;
    color: black;
    }
    
    .error-message {
    text-align: center; /* Centralizar o texto horizontalmente */
    margin-top: 20px; /* Espaçamento superior para afastar a mensagem das outras partes da página */
    padding: 10px; /* Espaçamento interno para melhorar a aparência */
    background-color: #ffcccc; /* Cor de fundo */
    color: #cc0000; /* Cor do texto */
    border: 1px solid #cc0000; /* Borda vermelha */
    border-radius: 5px; /* Borda arredondada */
}
    
    


</style>
    <div class="container">
        <div class="row">
        <div class="col-lg-6"> <!-- Adjust the column size as needed -->
        <form class="form-check form-check-inline"  method="get" >
            <div class="input-group" style = "width:550px;">
                <input type="text" class="form-control" id="searchBar" name="searchBar"     placeholder="Pesquisar...">
            </div>
        </div>
            <div class="col-lg-16">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" id="dropdownTitle" data-toggle="dropdown">Tipo <span class="caret"></span></button>
                    <ul class="dropdown-menu scrollable-menu" role="menu" name="selectContext" id="selectContext" onchange="atualizaPlaceHolder()" >
                            <li><a href="#" value="artistic-exhibition" onclick="atualizaPlaceHolder('artistic-exhibition', 'Pesquisar por exibição artística')">exibição artística</a></li>
                            <li><a href="#" value="audio-recording" onclick="atualizaPlaceHolder('audio-recording', 'Pesquisar por gravação de áudio')">gravação de áudio</a></li>
                            <li><a href="#" value="book" onclick="atualizaPlaceHolder('book', 'Pesquisar por livro')">livro</a></li>
                            <li><a href="#" value="book-chapter" onclick="atualizaPlaceHolder('book-chapter', 'Pesquisar por capítulo de livro')">capítulo de livro</a></li>
                            <li><a href="#" value="book-review" onclick="atualizaPlaceHolder('book-review', 'Pesquisar por avaliação de livro')">avaliação de livro</a></li>
                            <li><a href="#" value="choreography" onclick="atualizaPlaceHolder('choreography', 'Pesquisar por coreografia')">coreografia</a></li>
                            <li><a href="#" value="conference-abstract" onclick="atualizaPlaceHolder('conference-abstract', 'Pesquisar por resumo de conferência')">resumo de conferência</a></li>
                            <li><a href="#" value="conference-paper" onclick="atualizaPlaceHolder('conference-paper', 'Pesquisar por documento de conferência')">documento de conferência</a></li>
                            <li><a href="#" value="conference-poster" onclick="atualizaPlaceHolder('conference-poster', 'Pesquisar por cartaz de conferência')">cartaz de conferência</a></li>
                            <li><a href="#" value="curatorial-museum-exhibitionist" onclick="atualizaPlaceHolder('curatiorial-museum-exhibitionist', 'Pesquisar por curatorial museu exibicionista')">curatorial museu exibicionista</a></li>
                            <li><a href="#" value="dictionary-entry" onclick="atualizaPlaceHolder('dictionary-entry', 'Pesquisar por entrada do dicionário')">entrada do dicionário</a></li>
                            <li><a href="#" value="dissertation" onclick="atualizaPlaceHolder('dissertation', 'Pesquisar por dissertação')">dissertação</a></li>
                            <li><a href="#" value="edited-book" onclick="atualizaPlaceHolder('edited-book', 'Pesquisar por livro editado')">livro editado</a></li>
                            <li><a href="#" value="encyclopedia-entry" onclick="atualizaPlaceHolder('encyclopedia-entry', 'Pesquisar por entrada de enciclopédia')">entrada de enciclopédia</a></li>
                            <li><a href="#" value="exhibition-catalogue" onclick="atualizaPlaceHolder('exhibition-catalogue', 'Pesquisar por exibição de catálogo')">exibição de catálogo</a></li>
                            <li><a href="#" value="journal-article" onclick="atualizaPlaceHolder('journal-article', 'Pesquisar por artigo de jornal')">artigo de jornal</a></li>
                            <li><a href="#" value="journal-issue" onclick="atualizaPlaceHolder('journal-issue', 'Pesquisar por edição de jornal')">edição de jornal</a></li>
                            <li><a href="#" value="magazine-article" onclick="atualizaPlaceHolder('magazine-article', 'Pesquisar por artigo de revista')">artigo de revista</a></li>
                            <li><a href="#" value="manual" onclick="atualizaPlaceHolder('manual', 'Pesquisar por manual ')">manual</a></li>
                            <li><a href="#" value="musical-composition" onclick="atualizaPlaceHolder('musical-composition', 'Pesquisar por composição musical')">composição musical</a></li>
                            <li><a href="#" value="musical-performance" onclick="atualizaPlaceHolder('musical-performance', 'Pesquisar por apresentação musical')">apresentação musical</a></li>
                            <li><a href="#" value="newsletter-article" onclick="atualizaPlaceHolder('newsletter-article', 'Pesquisar por artigo newsletter')">artigo newsletter</a></li>
                            <li><a href="#" value="newspapper-article" onclick="atualizaPlaceHolder('newspapper-article', 'Pesquisar por artigo de jornal diário')">jornal diário</a></li>
                            <li><a href="#" value="online-resource" onclick="atualizaPlaceHolder('online-resource', 'Pesquisar por recurso online')">recurso online</a></li>
                            <li><a href="#" value="patent" onclick="atualizaPlaceHolder('patent', 'Pesquisar por patente')">patente</a></li>
                            <li><a href="#" value="performance-art" onclick="atualizaPlaceHolder('performance-art', 'Pesquisar por arte performática')">arte performática</a></li>
                            <li><a href="#" value="preface-postface" onclick="atualizaPlaceHolder('preface-postface', 'Pesquisar por prefácio-postfácio')">prefácio-postfácio</a></li>
                            <li><a href="#" value="prepint" onclick="atualizaPlaceHolder('prepint', 'Pesquisar por pré-impressão')">pré-impressão</a></li>
                            <li><a href="#" value="radio-tv-program" onclick="atualizaPlaceHolder('radio-tv-program', 'Pesquisar por programa de radio/tv')">programa de radio/tv</a></li>
                            <li><a href="#" value="report" onclick="atualizaPlaceHolder('report', 'Pesquisar por relatório')">relatório</a></li>
                            <li><a href="#" value="short-fiction" onclick="atualizaPlaceHolder('short-fiction', 'Pesquisar por ficção curta')">ficção curta</a></li>
                            <li><a href="#" value="software" onclick="atualizaPlaceHolder('software', 'Pesquisar por software')">software</a></li>
                            <li><a href="#" value="translation" onclick="atualizaPlaceHolder('translation', 'Pesquisar por tradução')">tradução</a></li>
                            <li><a href="#" value="video-recording" onclick="atualizaPlaceHolder('video-recording', 'Pesquisar por gravação de vídeo')">gravação de vídeo</a></li>
                            <li><a href="#" value="visual-artwork" onclick="atualizaPlaceHolder('visual-artwork', 'Pesquisar por artes visuais')">artes visuais</a></li>
                            <li><a href="#" value="website" onclick="atualizaPlaceHolder('website', 'Pesquisar por website')">website</a></li>
                            <li><a href="#" value="working-paper" onclick="atualizaPlaceHolder('working-paper', 'Pesquisar por documento de trabalho')">documento de trabalho</a></li>
                            </select>
                    </ul>
                </div>
            </div>
            <div class="input-group-append">
            <button type="submit" id="searchButton" style="height: 40px; margin-right:10px; margin-left:15px;">
                  <img name="search-icon"src='assets/icons/search.svg' style="width:30px">
            </button>
                </div>
            <div class="col-">
                <!--Formulario que permite limpar a pesquisa feita pelo utilizador-->
               <form  id="formmostraTodasPublicacoes" method="post">
                    <button id="reloadButton" type="submit" style="height: 40px; margin: 0px 0px" name="mostraTodos" value="vertodos" > <img name="reload_icon" src='assets\icons\reload.svg' style="width:30px"></button>
            </div>
            <div class="col-6" style="margin:0px 0px 0px 20px">
                <input type="hidden" id="selectedType" name="selectedType">
                <label for="yearSlider" class="form-label"> <span id="selectedYearDisplay"><?= $maxYear ?></span></label>
                <input id="yearSlider" name="yearSlider" type="range" min="<?= $minYear ?>" max="<?= $maxYear ?>" value="<?= $maxYear ?>" list="steplist" onchange="updateSliderValue()">
                <input type="checkbox" id="filtrarAno" name="filtrarAno" value="true" style="margin:0px 10px;">
                <label for="filtrarAno">Filtrar por ano</label><br>
            </div>
            </form>
         </div>
            

            <script>
                document.querySelectorAll('#selectContext a').forEach(function(item) {
                    item.addEventListener('click', function() {
                        var selectedType = this.getAttribute('data-value');
                        document.getElementById('selectedType').value = selectedType;
                        document.getElementById('dropdownTitle').innerText = this.innerText;
                    });
                });
            </script>

            <div class="row justify-content-center mt-3">
                <div class='heading_container3'>
                    <h3 class="heading_h3" style="text-transform: uppercase;">
                        <?= change_lang("publications-page-heading") ?>
                    </h3><br><br>
                    <?php
                    $pdo = pdo_connect_mysql();

                    if (!isset($_SESSION["lang"])) {
                        $lang = "pt";
                    } else {
                        $lang = $_SESSION["lang"];
                    }
                    $valorSiteName = "valor_site_$lang";
                    
                    $query = "SELECT distinct REPLACE(REGEXP_SUBSTR(p.dados, 'title = {(.*?)}'), ' ', '') as title, dados, YEAR(data) AS publication_year, p.tipo, pt.$valorSiteName
                              FROM publicacoes p
                              LEFT JOIN publicacoes_tipos pt ON p.tipo = pt.valor_API
                              WHERE visivel = true";
                    
                    if (isset($_POST["mostraTodos"])) {
                        // No additional filters
                    } else {
                        $filters = [];
                        
                        if (isset($_GET["searchBar"]) && !empty($_GET["searchBar"])) {
                            $searchBar = $_GET["searchBar"];
                            $filters[] = "dados LIKE '%$searchBar%'";
                        }
                    
                        if (isset($_GET["selectedType"]) && !empty($_GET["selectedType"])) {
                            $selectedType = $_GET["selectedType"];
                            $filters[] = "p.tipo = '$selectedType'";
                        }


                        if (isset($_GET["filtrarAno"]) && $_GET["filtrarAno"] == "true" && isset($_GET["yearSlider"])) {
                            $selectedYear = $_GET["yearSlider"];
                            $filters[] = "YEAR(data) = $selectedYear";
                        }

                        
                        if (!empty($filters)) {
                            $query .= " AND " . implode(" AND ", $filters);
                        }
                        

                    }
                    
                    $query .= " ORDER BY publication_year DESC, pt.$valorSiteName, data DESC";
                    
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $publicacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $hasPublications = false;

                    // Percorra todas as publicações
                    foreach ($publicacoes as $publicacao) {
                        // Verifique se há publicações para o ano selecionado
                        if ($publicacao['publication_year'] == isset($_GET["yearSlider"])) {
                            // Se houver publicações, defina a variável de sinalização como verdadeira
                            $hasPublications = true;
                            break; // Não é necessário continuar verificando se já encontramos publicações para o ano selecionado
                        }
                    }

                    // Verifique o valor da variável de sinalização
                    if (!$hasPublications) {
                        // Se não houver publicações para o ano selecionado, exiba a mensagem de erro
                        echo "<div class='error-message'>Não existem publicações para o ano selecionado.</div>";
                    } 
                    
                    $groupedPublicacoes = array();
                    
                    foreach ($publicacoes as $publicacao) {
                        $year = isset($publicacao['publication_year']) ? $publicacao['publication_year'] : change_lang("year-unknown");
                        $site = isset($publicacao[$valorSiteName]) ? $publicacao[$valorSiteName] : change_lang("site-unknown");
                    
                        if (!isset($groupedPublicacoes[$year])) {
                            $groupedPublicacoes[$year] = array();
                        }
                    
                        if (!isset($groupedPublicacoes[$year][$site])) {
                            $groupedPublicacoes[$year][$site] = array();
                        }
                    
                        if (isset($publicacao['dados'])) {
                            $groupedPublicacoes[$year][$site][] = $publicacao['dados'];
                        }

                        
                    }

                    
                ?>


                </script>
                <script src="../backoffice/assets/js/citation-js-0.6.8.js"></script>
                <script>
                    const Cite = require('citation-js');
                </script>

                <div id="publications">
                    <?php foreach ($groupedPublicacoes as $year => $yearPublica) : ?>
                        <div class="mb-5">
                            <b><?= $year ?></b><br>
                            <?php foreach ($yearPublica as $site => $publicacoes) : ?>
                                <div style="margin-left: 10px;" class="mt-3"><b><?= $site ?></b><br></div>
                                <div style="margin-left: 20px;" id="publications<?= $year ?><?= $site ?>">
                                    <?php foreach ($publicacoes as $publicacao) : ?>
                                        <script>
                                        var formattedCitation = new Cite(<?= json_encode($publicacao) ?>).format('bibliography', {
                                                format: 'html',
                                                template: 'apa',
                                                lang: 'en-US'
                                            });;
                                            var citationContainer = document.createElement('div');
                                            citationContainer.innerHTML = formattedCitation;
                                            citationContainer.classList.add('mb-3');
                                            document.getElementById('publications<?= $year ?><?= $site ?>').appendChild(citationContainer);
                                        </script>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div><br>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
   // metodo java scrip para altera o placeholder no input pesquisar 
   function atualizaPlaceHolder(selectedType, placeholderText) {
        var searchBar = document.getElementById("searchBar");
        var dropdownTitle = document.getElementById("dropdownTitle");
        searchBar.placeholder = placeholderText;
        dropdownTitle.innerText = selectedType;
    }

</script>

<?= template_footer(); ?>