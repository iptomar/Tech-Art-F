<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

// Receção dos parâmetros para a query
if (isset($_GET['query']) && isset($_GET['concluido']) && isset($_GET['context'])) {
    $query = $_GET['query'];
    $concluido = $_GET['concluido'];
    $context = $_GET['context'];

    // Preparar o statement
    $sql = "SELECT id, COALESCE(NULLIF(nome_en, ''), nome) AS nome, fotografia 
            FROM projetos 
            WHERE concluido = :concluido AND {$context} LIKE :query
            ORDER BY nome";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'concluido' => $concluido,
            'query' => "%$query%"
        ]);
        
        // Fetch aos resultados
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Devolver como JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    } catch (PDOException $e) {
        // Logs para os erros de base de dados
        error_log('Database Error: ' . $e->getMessage());
        echo json_encode(['error' => 'An error occurred while fetching search results.']);
    }
} else {
    echo json_encode([]);
}
?>
