<?php
require_once("../../config/conexao.php");

$id = $_POST["id"];
try {
    $query = $pdo->prepare("DELETE FROM DRE WHERE ID = :ID");
    $query->bindValue(":ID", $id);
    $query->execute();
    echo "Excluído com Sucesso!!";
} catch (\Throwable $th) {
    echo "Ops ocorreu algum erro " . $th->getMessage();
}
