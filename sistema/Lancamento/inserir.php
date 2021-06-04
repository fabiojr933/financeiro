<?php
require_once("../../config/conexao.php");

$id = $_POST["txtid2"];
$nome_despesa = ucwords($_POST["nome_despesa"]);       

$query = $pdo->query("SELECT * FROM DESPESA WHERE NOME = '$nome_despesa'");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
if($resultado){
    echo "Essa despesa com esse nome {$nome_despesa} ja existe";
    exit;
}
if(empty($id)){
    $query = $pdo->prepare("INSERT INTO DESPESA SET NOME = :NOME");  
}else{
    $query = $pdo->prepare("UPDATE DESPESA SET NOME = :NOME WHERE ID = '$id'");
}
$query->bindValue(":NOME", $nome_despesa);
$query->execute();
echo "Salvo com Sucesso!!";
