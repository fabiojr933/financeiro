<?php
require_once("../../config/conexao.php");

$id =  $_POST["txtid2"];
$nome_dre = ucwords($_POST["nome_dre"]);       

$query = $pdo->query("SELECT * FROM dre WHERE NOME = '$nome_dre'");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
if($resultado){
    echo "Essa despesa com esse nome {$nome_despesa} ja existe";
    exit;
}
if(empty($id)){
    $query = $pdo->prepare("INSERT INTO DRE SET NOME = :NOME");  
}else{
    $query = $pdo->prepare("UPDATE DRE SET NOME = :NOME WHERE ID = '$id'");
}
$query->bindValue(":NOME", $nome_dre);
$query->execute();
echo "Salvo com Sucesso!!";
