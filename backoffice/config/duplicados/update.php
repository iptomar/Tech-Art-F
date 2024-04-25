<?php

if (isset($_POST['ids']) && isset($_POST['selected_state'])) {
    require "../verifica.php";
    require "../config/basedados.php";

    $ids = $_POST['ids'];
    $option = $_POST['selected_state'];

    if (!empty($ids) && !empty($option)) {
        $idsStr = implode(',', array_map('intval', $ids));
        $sql = "UPDATE publicacoes_duplicados SET status = '$option' WHERE id IN ($idsStr)";

        if ($conn->query($sql) === TRUE) {
            echo "Records updated successfully.";
        } else {
            echo "Error updating records: " . $conn->error;
        }
    } else {
        echo "Invalid request.";
    }
}
