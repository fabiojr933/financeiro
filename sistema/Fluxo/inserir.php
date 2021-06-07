<?php
require_once("../../config/conexao.php");

$nome_fluxo = ucwords($_POST["nome_fluxo"]);
$id         = $_POST["txtid2"];
$antigo     = $_POST["antigo"];

try {
    if ($nome_fluxo != $antigo) {
        $query = $pdo->query("SELECT * FROM FLUXO WHERE NOME = '$nome_fluxo' ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            echo "Já existe Fluxo cadatrado com esse nome {$nome_fluxo}";
            exit;
        }
    }
    if (empty($id)) {
        $query = $pdo->prepare("INSERT INTO FLUXO SET NOME = :NOME");
    } else {
        $query = $pdo->prepare("UPDATE FLUXO SET NOME = :NOME WHERE ID = :ID");
        $query->bindValue(":ID", $id);
    }
    $query->bindValue(":NOME", $nome_fluxo);
    $query->execute();
    echo "Salvo com Sucesso!!";
} catch (\Throwable $th) {
    echo "Ops ocorreu algum erro " . $th->getMessage();
}
