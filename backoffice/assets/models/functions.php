<?php
//recebe a mudança de linguagem do botão
if (isset($_POST['lang'])) {
    $_SESSION['lang'] = $_POST['lang'];
}

require_once 'dicionario_pt.php';
require_once 'dicionario_en.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {
    //recebe linguagem atual a partir da sessão, ou define 'pt' como default
    var lang = '<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'pt'; ?>';
    //atualiza todas as traduções com a linguagem definida
    updateAllTranslations(lang);
});

function updateAllTranslations(lang) {
    //obtém o array de chaves e valores de dicionario para essa linguagem
    var translations = lang === "en" ? <?php echo json_encode(ret_dic_en()); ?> : <?php echo json_encode(ret_dic_pt()); ?>;
    //percorre todas as chaves das traduções
    for (var key in translations) {
        //atualiza a tradução para cada chave
        updateTranslation(key, translations[key]);
    }
}

//função para atualizar a tradução de um elemento específico
function updateTranslation(key, translation) {
    //seleciona todos os elementos com o atributo data-translation correspondente à chave
    var elements = document.querySelectorAll('[data-translation="' + key + '"]');
    //percorre todos os elementos selecionados
    for (var i = 0; i < elements.length; i++) {
        //se o elemento for um link, atualiza o conteúdo HTML
        if (elements[i].tagName.toLowerCase() === 'a') {
            elements[i].innerHTML = translation;
        } else {
            //caso contrário, atualiza o texto do elemento
            elements[i].textContent = translation;
        }
    }
}

//função para mudar a linguagem sem atualizar a página
function submitLanguageForm(lang) {
    //envia uma requisição AJAX para atualizar a linguagem na sessão
    $.ajax({
        type: "POST",
        url: "",
        data: {lang: lang},
        success: function() {
            //quando a requisição é bem-sucedida, atualiza as traduções
            updateAllTranslations(lang);
        }
    });
}

</script>