<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();
$language = ($_SESSION["lang"] == "en") ? "_en" : "";

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $context = isset($_GET['context']) ? $_GET['context'] : 'nome';
    $concluido = null; 
    $origin = isset($_GET['origin']) ? $_GET['origin'] : '';

    if ($origin === 'projetos_concluidos') {
        $concluido = true;
    } elseif ($origin === 'projetos_em_curso') {
        $concluido = false;
    } elseif ($origin === 'projetos') {
        $concluido = isset($_GET['concluido']) ? $_GET['concluido'] === 'true' : null;
    }

    if ($origin === 'projetos' || $origin === 'projetos_concluidos' || $origin === 'projetos_em_curso') {
        // Consulta para a tabela projetos
        if ($context == 'i.nome' || $context == 'g.nome') {
            $sql = "SELECT DISTINCT p.id, COALESCE(NULLIF(p.nome{$language}, ''), p.nome) AS nome, p.fotografia
                    FROM projetos p
                    LEFT JOIN investigadores_projetos ip ON ip.projetos_id = p.id
                    LEFT JOIN investigadores i ON ip.investigadores_id = i.id
                    LEFT JOIN gestores_projetos gp ON gp.projetos_id = p.id
                    LEFT JOIN investigadores g ON gp.gestores_id = g.id
                    WHERE p.concluido = :concluido AND {$context} LIKE CONCAT('%', :query, '%')
                    ORDER BY COALESCE(NULLIF(p.nome{$language}, ''), p.nome)";
        } elseif ($context == 'financiamento') {
            $sql = "SELECT id, COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia
                    FROM projetos
                    WHERE concluido = :concluido AND REPLACE({$context}, ' ', '') LIKE REPLACE(CONCAT('%', :query, '%'), ' ', '')
                    ORDER BY COALESCE(NULLIF(nome{$language}, ''), nome)";
        } else {
            $sql = "SELECT id, COALESCE(NULLIF(nome{$language}, ''), nome) AS nome, fotografia
                    FROM projetos
                    WHERE concluido = :concluido AND {$context} LIKE CONCAT('%', :query, '%')
                    ORDER BY COALESCE(NULLIF(nome{$language}, ''), nome)";
        }
    } elseif ($origin === 'integrados') {
        // Consulta para a tabela investigadores com o filtro tipo = "Integrado"
        $sql = "SELECT id, email, nome,
                COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
                COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
                ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
                FROM investigadores
                WHERE tipo = 'Integrado' AND {$context} LIKE CONCAT('%', :query, '%')
                ORDER BY nome";
    } elseif ($origin === 'noticias') {
        // Consulta para a tabela noticias
        $sql = "SELECT id, COALESCE(NULLIF(titulo{$language}, ''), titulo) AS titulo, imagem, data
                FROM noticias
                WHERE {$context} LIKE CONCAT('%', :query, '%')
                ORDER BY data DESC";
    } elseif ($origin === 'colaboradores') {
        // Consulta para a tabela investigadores com o filtro tipo = "Colaborador"
        $sql = "SELECT id, email, nome,
                COALESCE(NULLIF(sobre{$language}, ''), sobre) AS sobre,
                COALESCE(NULLIF(areasdeinteresse{$language}, ''), areasdeinteresse) AS areasdeinteresse,
                ciencia_id, tipo, fotografia, orcid, scholar, research_gate, scopus_id
                FROM investigadores
                WHERE tipo = 'Colaborador' AND {$context} LIKE CONCAT('%', :query, '%')
                ORDER BY nome";
    } else {
        echo json_encode(['error' => 'Invalid origin.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare($sql);

        if ($origin === 'projetos' || $origin === 'projetos_concluidos') {
            $stmt->execute([
                'concluido' => $concluido,
                'query' => "%$query%"
            ]);
        } else {
            $stmt->execute([
                'query' => "%$query%"
            ]);
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($results);
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        echo json_encode(['error' => 'An error occurred while fetching search results.']);
    }
} else {
    echo json_encode([]);
}
?>