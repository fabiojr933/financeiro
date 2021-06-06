<?php
require_once("../../config/conexao.php");

$id = $_POST["txtid2"];
$nome_despesa = ucwords($_POST["nome_despesa"]);   
$tipo = ucwords($_POST["tipo"]);    

$query = $pdo->query("SELECT * FROM DESPESA WHERE NOME = '$nome_despesa'");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
if($resultado){
    echo "Essa despesa com esse nome {$nome_despesa} ja existe";
    exit;
}
if(empty($id)){
    $query = $pdo->prepare("INSERT INTO DESPESA (NOME, TIPO) VALUES(:NOME, :TIPO) ");  
}else{
    $query = $pdo->prepare("UPDATE DESPESA SET NOME = :NOME, TIPO = :TIPO WHERE ID = '$id'");
}
$query->bindValue(":NOME", $nome_despesa);
$query->bindValue(":TIPO", $tipo);
$query->execute();
echo "Salvo com Sucesso!!";
