<?php
require "../verifica.php";
require "../config/basedados.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['noticias'])) {
    $noticias = json_encode($_POST['noticias']);
  }
  if (isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
  }
  if (isset($_POST['assunto'])) {
    $assunto = $_POST['assunto'];
  }
  if (isset($_POST['tituloEn'])) {
    $tituloEn = $_POST['tituloEn'];
  }
  if (isset($_POST['assuntoEn'])) {
    $assuntoEn = $_POST['assuntoEn'];
  }

  $json_noticias = json_decode($noticias);
  $all_ids = array();

  foreach ($obj->data as $el) {
    array_push($all_ids, $el[1]);
  }
  $data_envio = date("Y-m-d H:m:s");

  $sql = "INSERT INTO historico_newsletters (json_noticias, data_envio, titulo_pt, titulo_en, assunto_pt, assunto_en) " .
    "VALUES (?,?,?,?,?,?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'ssssss', $json_noticias, $data_envio, $titulo, $tituloEn, $assunto, $assuntoEn);

  if (mysqli_stmt_execute($stmt)) {
    echo "Dados inseridos com sucesso.";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

$conn->close();
