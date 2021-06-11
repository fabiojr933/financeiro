<?php
require_once("../../config/conexao.php");

$id = $_POST["id"];
$data_baixa = date('Y/m/d');
$valor_pendente = 0;
$pago = "S";
$forma_pag = $_POST["conta_banco"];

try {

    /**
     * VEREFICA SE O VALOR DO DOCUMENTO É MAIOR DO QUE O SALDO DO CAIXA
     */
    $saldo_cxa = $pdo->query("SELECT * FROM CONTA WHERE ID = '$forma_pag'");
    $resul_cxa = $saldo_cxa->fetchAll(PDO::FETCH_ASSOC);
    $saldo_cxa = $resul_cxa[0]['saldo'];

    $saldo_doc = $pdo->query("SELECT * FROM conta_receber WHERE ID = '$id'");
    $resul_doc = $saldo_doc->fetchAll(PDO::FETCH_ASSOC);
    $valor_doc = $resul_doc[0]['valor'];
    $multa_doc = $resul_doc[0]['juros_multa'];

    $total_doc = $valor_doc + $multa_doc;

   if($total_doc > $saldo_cxa){
       echo "Não é possivel fazer a baixa, o valor do documento é maior que o saldo do caixa";
       exit;
   }

   //FAZ A BAIXA
    $query = $pdo->prepare("UPDATE conta_receber SET VALOR_PENDENTE = :VALOR_PENDETE, DATA_BAIXA = :DATA_BAIXA, PAGO = :PAGO
                            WHERE ID = :ID");
    $query->bindValue(":VALOR_PENDETE", $valor_pendente);
    $query->bindValue(":DATA_BAIXA", $data_baixa);
    $query->bindValue(":PAGO", $pago);
    $query->bindValue(":ID", $id);
    $query->execute();

    /**
     * SALVANDO O FORMA PAG NA TABELA conta_receber_FLUXO
     */
    $pag = $pdo->prepare("UPDATE conta_receber_FLUXO SET ID_CONTA = :ID_CONTA WHERE ID_conta_receber = :ID_conta_receber");
    $pag->bindValue(":ID_CONTA", $forma_pag);
    $pag->bindValue(":ID_conta_receber", $id);
    $pag->execute();

    /**
     * PEGANDO O VALOR DESSE DOCUMENTO 
     */
    $documento = $pdo->prepare("SELECT * FROM conta_receber_FLUXO WHERE ID_conta_receber = :ID_conta_receber");
    $documento->bindValue(":ID_conta_receber", $id);
    $documento->execute();
    $resultado = $documento->fetchAll(PDO::FETCH_ASSOC);

    // TOTAL DA VENDA DESSE DOCUMENTO
    $total_documento = $resultado[0]['total'];
    $id_conta = $resultado[0]['id_conta'];



    // PEGANDO O SALDO DO CAIXA BUSCANDO O CAIXA ESPECIFICO QUE FOI FEITO DO DOCUMENTO
    $banco = $pdo->query("SELECT * FROM CONTA WHERE ID = '$id_conta'");
    $result = $banco->fetchAll(PDO::FETCH_ASSOC);
    //SALDO DO DOCUMENTO
    $saldo_caixa = $result[0]['saldo'];

    //FAZENDO O CALCULO APARA ATUALIZAR O CAIXA
    $saldo_real = $saldo_caixa - $total_documento;


    //ATUALIZADO O SALDO DO BANCO 
    $atualizar = $pdo->prepare("UPDATE CONTA SET SALDO = :SALDO WHERE ID = :ID");
    $atualizar->bindValue(":SALDO", $saldo_real);
    $atualizar->bindValue(":ID", $id_conta);
    $atualizar->execute();


    echo 'Pago com Sucesso!!';
} catch (\Throwable $th) {
    echo "Ops ocorreu algum erro " . $th->getMessage();
}
