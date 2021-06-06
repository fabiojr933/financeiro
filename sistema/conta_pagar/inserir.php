<?php
require_once("../../config/conexao.php");

$id = $_POST["txtid2"];
$documento = $_POST["documento"];
$fornecedor = $_POST["fornecedor"];
$valor_doc = $_POST["valor_doc"];
$valor_Pen = $_POST["valor_doc"];
$juros_multa = $_POST["juros_multa"];
$data_lanc = date('Y/m/d');
$vencimento = $_POST["vencimento"];
$pago = $_POST["pago"];
$observacao = $_POST["observacao"];   
$data_baixa = null;
$id_lancamento = null;

$valor_doc = str_replace(',','.', $valor_doc);
$valor_Pen = str_replace(',','.', $valor_Pen);
$juros_multa = str_replace(',','.', $juros_multa);

if(empty($documento)){
    echo "O campo documento não pode ficar em BRANCO";
    exit;
}
if(empty($fornecedor)){
    echo "O campo fornecedor não pode ficar em BRANCO";
    exit;
}
if(empty($valor_doc)){
    echo "O campo valor não pode ficar em BRANCO";
    exit;
}
if(empty($vencimento)){
    echo "O campo venciemnto não pode ficar em BRANCO";
    exit;
}
if(empty($pago)){
    echo "O campo tipo pago não pode ficar em BRANCO";
    exit;
}
if($pago == "S"){
    $data_baixa = date('Y/m/d');
    $valor_Pen = 0;
}
if(empty($id)){
    $query = $pdo->prepare("INSERT INTO CONTA_PAGAR(ID_FORNECEDOR, DOCUMENTO, VALOR, VALOR_PENDENTE, JUROS_MULTA,
             DATA_LANCAMENTO, DATA_VENCIMENTO, DATA_BAIXA, PAGO, ID_LANCAMENTO, OBSERVACAO)
                    VALUES(:ID_FORNECEDOR, :DOCUMENTO, :VALOR, :VALOR_PENDENTE, :JUROS_MULTA,
                     :DATA_LANCAMENTO, :DATA_VENCIMENTO, :DATA_BAIXA, :PAGO, :ID_LANCAMENTO, :OBSERVACAO)");
}else{
    
$query = $pdo->prepare("UPDATE CONTA_PAGAR SET ID_FORNECEDOR = :ID_FORNECEDOR, DOCUMENTO = :DOCUMENTO, VALOR = :VALOR, VALOR_PENDENTE = :VALOR_PENDENTE,
                     JUROS_MULTA = :JUROS_MULTA, DATA_LANCAMENTO = :DATA_LANCAMENTO, DATA_VENCIMENTO = :DATA_VENCIMENTO, DATA_BAIXA = :DATA_BAIXA,
                      PAGO = :PAGO, ID_LANCAMENTO= :ID_LANCAMENTO, OBSERVACAO = :OBSERVACAO
                        WHERE ID = :ID");
$query->bindValue(":ID", $id);
}
$query->bindValue(":ID_FORNECEDOR", $fornecedor);
$query->bindValue(":DOCUMENTO", $documento);
$query->bindValue(":VALOR", $valor_doc);
$query->bindValue(":VALOR_PENDENTE", $valor_Pen);
$query->bindValue(":JUROS_MULTA", $juros_multa);
$query->bindValue(":DATA_LANCAMENTO", $data_lanc);
$query->bindValue(":DATA_VENCIMENTO", $vencimento);
$query->bindValue(":DATA_BAIXA", $data_baixa);
$query->bindValue(":PAGO", $pago);
$query->bindValue(":ID_LANCAMENTO", $id_lancamento);
$query->bindValue(":OBSERVACAO", $observacao);
$query->execute();
echo "Salvo com Sucesso!!";
