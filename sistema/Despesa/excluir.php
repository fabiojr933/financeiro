<?php
require_once("../../config/conexao.php");

$id = $_POST["id"];
$query = $pdo->prepare("DELETE FROM DESPESA WHERE ID = :ID");
$query->bindValue(":ID", $id);
$query->execute();
echo "Excluído com Sucesso!!";