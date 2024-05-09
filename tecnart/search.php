<?php
include 'config/dbconnection.php';
include 'models/functions.php';

$pdo = pdo_connect_mysql();

if (isset($_GET['query']) && isset($_GET['concluido'])) {
    $query = $_GET['query'];
    $concluido = $_GET['concluido'];
    
    // Prepare the SQL statement
    $sql = "SELECT id, nome AS nome, fotografia 
            FROM projetos 
            WHERE concluido=" . $concluido . " AND nome like " . "'%" . $query . "%'";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // Fetch the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return results as JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    } catch (PDOException $e) {
        // Log any database errors
        error_log('Database Error: ' . $e->getMessage());
        echo json_encode(['error' => 'An error occurred while fetching search results.']);
    }
} else {
    // Missing query parameter or concluido parameter
    echo json_encode([]);
}
?>
