<?php
require_once("../../config/conexao.php");

/**
 * SEMPRE QUANDO FOR EXCLUIR UM LANÇAMENTO O SEMPRE SEMPRE VOLTA PARA SUA CONTA DESTINO 
 */
$id = $_POST["id"];

//PEGAR O VALOR E O ID_CONTA 
$query_lanc = $pdo->query("SELECT * FROM LANCAMENTO WHERE ID = '$id' ");
$resul_lan = $query_lanc->fetchAll(PDO::FETCH_ASSOC);
$id_conta = $resul_lan[0]['id_conta'];
$valor = $resul_lan[0]['valor'];

//PEGA O SALDO ATUAL DO CAIXA
$query_sum = $pdo->query("SELECT SUM(SALDO) as SALDO FROM CONTA WHERE ID = '$id_conta' ");
$resul_sum = $query_sum->fetchAll(PDO::FETCH_ASSOC);
$saldo_atual = $resul_sum[0]['SALDO'];

$saldo = $saldo_atual + $valor;

$query_volta = $pdo->query("UPDATE CONTA SET SALDO = '$saldo' " );

//DELETA O LANÇAMENTO
$query = $pdo->prepare("DELETE FROM LANCAMENTO WHERE ID = :ID");
$query->bindValue(":ID", $id);
$query->execute();
echo "Excluído com Sucesso!!";