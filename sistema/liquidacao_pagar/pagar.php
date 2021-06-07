<?php
require_once("../../config/conexao.php");

$id = $_POST["id"];
$data_baixa = date('Y/m/d');
$valor_pendente = 0;
$pago = "S";
$forma_pag = $_POST["conta_banco"];   
   
try {
    $query = $pdo->prepare("UPDATE CONTA_PAGAR SET VALOR_PENDENTE = :VALOR_PENDETE, DATA_BAIXA = :DATA_BAIXA, PAGO = :PAGO
                            WHERE ID = :ID");
    $query->bindValue(":VALOR_PENDETE", $valor_pendente);
    $query->bindValue(":DATA_BAIXA", $data_baixa);
    $query->bindValue(":PAGO", $pago);
    $query->bindValue(":ID", $id);
    $query->execute();

/**
 * SALVANDO O FORMA PAG NA TABELA CONTA_PAGAR_FLUXO
 */
   $pag = $pdo->prepare("UPDATE CONTA_PAGAR_FLUXO SET ID_CONTA = :ID_CONTA WHERE ID_CONTA_PAGAR = :ID_CONTA_PAGAR");
   $pag->bindValue(":ID_CONTA", $forma_pag); 
   $pag->bindValue(":ID_CONTA_PAGAR", $id); 
   $pag->execute();
   
     /**
     * PEGANDO O VALOR DESSE DOCUMENTO 
     */
    $documento = $pdo->prepare("SELECT * FROM CONTA_PAGAR_FLUXO WHERE ID_CONTA_PAGAR = :ID_CONTA_PAGAR");
    $documento->bindValue(":ID_CONTA_PAGAR", $id);
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