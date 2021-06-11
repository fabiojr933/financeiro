<?php
require_once("../../config/conexao.php");

$id = $_POST["id"];
try {
    //DELETA NA TABELA CONTA_RECEBER_FLUXO
    $query_fluxo = $pdo->prepare("DELETE FROM conta_receber_fluxo WHERE ID_CONTA_RECEBER = :ID_CONTA");
    $query_fluxo->bindValue(":ID_CONTA", $id);
    $query_fluxo->execute();
    //DELETE NA TABELA CONTA_PAGAR
    $query = $pdo->prepare("DELETE FROM CONTA_RECEBER WHERE ID = :ID");
    $query->bindValue(":ID", $id);
    $query->execute();
    echo "Excluído com Sucesso!!";
} catch (\Throwable $th) {
    echo "Ops correu algum erro " . $th->getMessage();
}
