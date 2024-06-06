<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";
$query = "SELECT id, COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia FROM projetos WHERE concluido=false";
$stmt = $pdo->prepare($query);
$stmt->execute();
$projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<?= template_header(change_lang("projects-ongoing-page-heading")); ?>

<body>

<style>
    #searchResults {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 20px;
    }
</style>

<section class="product_section layout_padding">
    <div style="background-color: #dbdee1; padding-top: 50px; padding-bottom: 50px;">
        <div class="container">
            <div class="heading_container3">
                <h3 style="margin-bottom: 5px;">
                    <?= change_lang("projects-ongoing-page-heading") ?>
                </h3>
                <h5 class="heading2_h5">
                    <?= change_lang("projects-ongoing-page-description") ?>
                </h5>
            </div>
        </div>
    </div>
</section>

<section class="product_section layout_padding">
    <div style="padding-top: 20px;">
        <div class="container">
            <!-- Search Bar -->
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <form>
                        <div class="input-group">
                            <input id="searchInput" type="text" class="form-control" placeholder="Pesquisar...">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Listing -->
            <div id="productListing" class="row justify-content-center mt-3">
                <?php foreach ($projetos as $projeto) : ?>
                    <div class="ml-5 imgList">
                        <a href="projeto.php?projeto=<?= $projeto['id'] ?>">
                            <div class="image_default">
                                <img class="centrare" style="object-fit: cover; width:225px; height:280px;" src="../backoffice/assets/projetos/<?= $projeto['fotografia'] ?>" alt="">
                                <div class="imgText justify-content-center m-auto"><?= $projeto['nome'] ?></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Search Results Container -->
            <div class="row justify-content-center mt-3">
                <div class="col-md-9">
                    <div id="searchResults"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<?= template_footer(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('#searchInput');
        const searchResults = document.querySelector('#searchResults');
        const productListing = document.querySelector('#productListing');
        const selectContext = document.querySelector('#selectContext');

        function createProjectItem(project) {
            const projectItem = document.createElement('div');
            projectItem.classList.add('ml-5', 'imgList');

            const link = document.createElement('a');
            link.href = `projeto.php?projeto=${project.id}`;

            const imageDiv = document.createElement('div');
            imageDiv.classList.add('image_default');

            const image = document.createElement('img');
            image.classList.add('centrare');
            image.style.objectFit = 'cover';
            image.style.width = '225px';
            image.style.height = '280px';
            image.src = `../backoffice/assets/projetos/${project.fotografia}`;
            image.alt = '';

            const textDiv = document.createElement('div');
            textDiv.classList.add('imgText', 'justify-content-center', 'm-auto');
            textDiv.textContent = project.nome;

            imageDiv.appendChild(image);
            imageDiv.appendChild(textDiv);
            link.appendChild(imageDiv);
            projectItem.appendChild(link);

            return projectItem;
        }

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            const context = selectContext ? selectContext.value : 'nome';

            fetch(`search.php?query=${encodeURIComponent(query)}&concluido=0&context=${encodeURIComponent(context)}&origin=projetos`)
                .then(response => response.json())
                .then(data => {
                    productListing.style.display = 'none';
                    searchResults.innerHTML = '';
                    if (Array.isArray(data)) {
                        data.forEach((result) => {
                            const resultItem = createProjectItem(result);
                            searchResults.appendChild(resultItem);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    });
</script>

</body>
</html>
