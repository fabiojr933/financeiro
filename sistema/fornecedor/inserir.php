<?php
require_once("../../config/conexao.php");

$id = $_POST["txtid2"];
$nome = ucwords($_POST["nome_fornecedor"]);
$antigo = $_POST["antigo"];

if(empty($nome)){
    echo "Nome é obrigatorio";
    exit;
}

if($nome != $antigo){
    $query_busca = $pdo->query("SELECT * FROM FORNECEDOR WHERE NOME = '$nome'");
    $resul = $query_busca->fetchAll(PDO::FETCH_ASSOC);
    if($resul){
        echo "Ja existe fornecedor com esse nome";
        exit;
    }
}

if($id == ""){
    $query = $pdo->prepare("INSERT INTO FORNECEDOR (NOME) VALUES(:NOME)");
}else{
    $query = $pdo->prepare("UPDATE FORNECEDOR SET NOME = :NOME WHERE ID = :ID");
    $query->bindValue(":ID", $id);
}
$query->bindValue(":NOME", $nome);
$query->execute();
echo "Salvo com Sucesso!!";