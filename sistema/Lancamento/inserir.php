<?php
require_once("../../config/conexao.php");

$id         = $_POST["txtid2"];
$dre        = $_POST["dre"];
$banco      = $_POST["banco"];
$fluxo      = $_POST["fluxo"];
$despesa    = $_POST["despesa"];
$valor      = $_POST["valor"];
$data_d     = $_POST["data"];
$observacao = $_POST["observacao"];

$valor = str_replace(",", ".", $valor);

if ($valor == "") {
    echo "O valor é obrigatorio";
    exit;
}
/**
 * 
 */
/**
 * 1 PEGAR O SALDO CO CAIXA
 * 2 VEREFICA SE É TIPO SAIDA
 * 3 VEREFICA sE O VALOR DIGITADO É MAIOR DO QUE O VALOR EM CAIXA
 * 4 PEGAR O TIPO DE SAIDA 
 *   SE FOR SAIDA DIMINUI O SALDO DO CAIXA
 *   SE FOR ENTRADA SOMA COM O SALDO DO CAIXA
 * 4 FAZ O LANÇAMENTO
 */
try {
    $query_tipo = $pdo->query("SELECT * FROM DESPESA WHERE ID = $despesa");
    $resul_tipo = $query_tipo->fetchAll(PDO::FETCH_ASSOC);
    $tipo_atual = $resul_tipo[0]['tipo'];


    $query_saldo_caixa = $pdo->query("SELECT * FROM CONTA WHERE ID = '$banco' ");
    $resul_saldo = $query_saldo_caixa->fetchAll(PDO::FETCH_ASSOC);
    $saldo_atual = $resul_saldo[0]['saldo'];

    if ($tipo_atual == "Saida") {
        if ($valor > $saldo_atual) {
            echo "Impossivel fazer o lançamento, O valor digitado é maior do que o valor do CAIXA";
            exit;
        }
        $saida = $saldo_atual - $valor;
        $query_atualizar_caixa = $pdo->query("UPDATE CONTA SET SALDO = $saida WHERE ID = '$banco' ");
    } else {
        $saida = $saldo_atual + $valor;
        $query_atualizar_caixa = $pdo->query("UPDATE CONTA SET SALDO = $saida WHERE ID = '$banco' ");
    }

    if ($id == "") {
        $query = $pdo->prepare("INSERT INTO LANCAMENTO (ID_CONTA, ID_DESPESA, ID_DRE, ID_FLUXO, VALOR, DATA, OBSERVACAO)
                        VALUES(:ID_CONTA, :ID_DESPESA, :ID_DRE, :ID_FLUXO, :VALOR, :data_d, :OBSERVACAO)");
    } else {
        $query = $pdo->prepare("UPDATE LANCAMENTO SET ID_CONTA = :ID_CONTA, ID_DESPESA = :ID_DESPESA, ID_DRE = :ID_DRE, 
                            ID_FLUXO = :ID_FLUXO, VALOR = :VALOR, DATA = :data_d, OBSERVACAO = :OBSERVACAO WHERE ID = :ID");
        $query->bindValue(":ID", $id);
    }
    $query->bindValue(":ID_CONTA", $banco);
    $query->bindValue(":ID_DESPESA", $despesa);
    $query->bindValue(":ID_DRE", $dre);
    $query->bindValue(":ID_FLUXO", $fluxo);
    $query->bindValue(":VALOR", $valor);
    $query->bindValue(":data_d", $data_d);
    $query->bindValue(":OBSERVACAO", $observacao);
    $query->execute();
    echo "Salvo com Sucesso!!";
} catch (\Throwable $th) {
    echo "Ops ocorreu algum erro " . $th->getMessage();
}
