<?php
$pag = "liquidacao_pagar";
require_once("../config/conexao.php");
@session_start();


?>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fornecedor</th>
                        <th>Documento</th>
                        <th>Valor</th>
                        <th>Juros/Multa</th>
                        <th>Vencimento</th>
                        <th>Pago</th>

                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = $pdo->query("SELECT fornecedor.id as id_fornecedor, fornecedor.nome as nome_fornecedor,
                                            conta_pagar.id, conta_pagar.documento, conta_pagar.valor,
                                            conta_pagar.valor_pendente, conta_pagar.juros_multa, conta_pagar.data_lancamento,
                                            conta_pagar.data_baixa, conta_pagar.data_vencimento, conta_pagar.pago,
                                            conta_pagar.id_lancamento, conta_pagar.observacao
                                        from conta_pagar 
                                        join fornecedor on conta_pagar.id_fornecedor = fornecedor.id 
                                        WHERE conta_pagar.pago = 'N' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $fornecedor   = $res[$i]['nome_fornecedor'];
                        $documento    = $res[$i]['documento'];
                        $valor        = $res[$i]['valor'];
                        $juros        = $res[$i]['juros_multa'];
                        $vencimento   = $res[$i]['data_vencimento'];
                        $pago         = $res[$i]['pago'];



                        $vencimento = implode('/', array_reverse(explode('-', $vencimento)));

                        $id = $res[$i]['id'];

                        if ($pago == 'N') {
                            $cor = "text-danger";
                        } else {
                            $cor = "text-success";
                        }
                        if ($vencimento == date('d/m/Y')) {
                            $cor2 = "text-danger";
                        } else {
                            $cor2 = "";
                        }



                    ?>


                        <tr>
                            <td><?php echo $fornecedor ?></td>

                            <td>
                                <a class="text-secondary" title="Ver Dados" href="index.php?pag=<?php echo $pag ?>&funcao=conta_pagar&id=<?php echo $id ?>">
                                    <?php echo $documento ?>
                                </a>
                            </td>
                            <td><?php echo 'R$ ' . $valor ?></td>
                            <td><?php echo 'R$ ' . $juros ?></td>
                            <td class="<?php echo $cor2 ?>"><?php echo $vencimento ?></td>
                            <td class="<?php echo $cor ?>"><?php echo $pago ?></td>


                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=pagar&id=<?php echo $id ?>" class='text-warning mr-1' title='Pagar este documeno'><i class='far fa-money-bill-alt'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=conta_pagar&id=<?php echo $id ?>" class='text-success mr-1' title='Ver Dados'><i class='fas fa-info-circle'></i></a>
                            </td>
                        </tr>
                    <?php } ?>





                </tbody>
            </table>
        </div>
    </div>
</div>






<div class="modal" id="modal-pagar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deseja realmente Pagar este Documento?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">

                    <p></p>

                    <div class="form-group">
                        <label>Selecione a forma de pagamento</label>
                        <select name="conta_banco" class="form-control" id="conta_banco">
                            <?php

                            $query = $pdo->query("SELECT * FROM conta ");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i = 0; $i < @count($res); $i++) {
                                foreach ($res[$i] as $key => $value) {
                                }
                                $nome_banco2 = $res[$i]['banco'];
                                $id_banco2 = $res[$i]['id'];
                            ?>
                                <option value="<?php echo @$id_banco2 ?>"><?php echo @$nome_banco2 ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div align="center" id="mensagem_excluir" class="">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>


                    <input type="hidden" id="id" name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-pagar" name="btn-btn-pagar" class="btn btn-danger">Pagar</button>
            </form>
        </div>
    </div>
</div>
</div>



<div class="modal" id="modal-conta_pagar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php
                if (@$_GET['funcao'] == 'conta_pagar') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT pag.id, forn.nome, pag.documento, pag.valor, pag.valor_pendente, pag.juros_multa, pag.data_baixa,
                                            pag.data_vencimento, pag.pago, pag.observacao  
                                            FROM conta_pagar pag 
                                            join fornecedor forn on pag.id_fornecedor = forn.id
                                            where pag.id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $id3              = $res[0]['id'];
                    $fornecedor3      = $res[0]['nome'];
                    $documento3       = $res[0]['documento'];
                    $valor3           = $res[0]['valor'];
                    $valor_pendente3  = $res[0]['valor_pendente'];
                    $juros_multa3     = $res[0]['juros_multa'];
                    $valor_pendente3  = $res[0]['valor_pendente'];
                    $data_baixa3      = $res[0]['data_baixa'];
                    $data_vencimento3 = $res[0]['data_vencimento'];
                    $pago3            = $res[0]['pago'];
                    $observacao3      = $res[0]['observacao'];
                }


                ?>

                <span><b>Fornecedor: </b> <i><?php echo $fornecedor3 ?></i><br>
                    <span><b>Documento: </b> <i><?php echo $documento3 ?></i><br>
                        <span><b>Valor: </b> <i><?php echo $valor3 ?> <span class="ml-4"><b>Valor Pendente: </b> <i><?php echo $valor_pendente3 ?></i> <span class="ml-4"><b>Juros/Multa: </b> <i><?php echo $juros_multa3 ?></i><br>
                                        <span><b>Data Vencimento: </b> <i><?php echo $vencimento ?></i> <span class="ml-4"><b>Data Baixa: </b> <i><?php echo $data_baixa3 ?></i><br>
                                                <span><b>Observação: </b> <i><?php echo $observacao3 ?></i><br>
            </div>

        </div>
    </div>
</div>





<?php



if (@$_GET["funcao"] != null && @$_GET["funcao"] == "pagar") {
    echo "<script>$('#modal-pagar').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "conta_pagar") {
    echo "<script>$('#modal-conta_pagar').modal('show');</script>";
}


?>




<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag=" + pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>





<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function() {
        var pag = "<?= $pag ?>";
        $('#btn-pagar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/pagar.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    if (mensagem.trim() === 'Pago com Sucesso!!') {


                        $('#btn-cancelar-excluir').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_excluir').text(mensagem)



                },

            })
        })
    })
</script>



<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }
</script>





<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>