<?php
require_once("../../config/conexao.php");

$banco    = ucwords($_POST["nome_banco"]);
$agencia  = str_replace(".", ",", $_POST["agencia_banco"]);
$conta    = $_POST["conta_banco"];
$saldo    = str_replace(",", ".", $_POST["saldo_banco"]);

$id       = $_POST["txtid2"]; 

try {
   /* if ($conta != $antigo) {
        $query = $pdo->query("SELECT * FROM CONTA WHERE conta = '$conta'");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            echo "Ja existe Agencia cadastrado com essa conta {$conta}";
            exit;
        } 
    }  */

    if ($id == "") {
        $query = $pdo->prepare("INSERT INTO CONTA (BANCO, AGENCIA, CONTA, SALDO) VALUES(:BANCO, :AGENCIA, :CONTA, :SALDO)");
    } else {
        $query = $pdo->prepare("UPDATE CONTA SET BANCO = :BANCO, AGENCIA = :AGENCIA, CONTA = :CONTA, SALDO = :SALDO WHERE ID = :ID");
        $query->bindValue(":ID", $id);
    }
    $query->bindValue(":BANCO", $banco);
    $query->bindValue(":AGENCIA", $agencia);
    $query->bindValue(":CONTA", $conta);
    $query->bindValue(":SALDO", $saldo);
    $query->execute();
    echo "Salvo com Sucesso!!";
} catch (\Throwable $th) {
    echo "Ops ocorreu algum erro " . $th->getMessage();
}
