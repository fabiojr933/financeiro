<?php
$pag = "conta_pagar";
require_once("../config/conexao.php");
@session_start();


?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Cadastro documento a pagar</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>

</div>



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
                                        join fornecedor on conta_pagar.id_fornecedor = fornecedor.id ");
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
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=conta_pagar&id=<?php echo $id ?>" class='text-warning mr-1' title='Ver Dados'><i class='fas fa-info-circle'></i></a>
                            </td>
                        </tr>
                    <?php } ?>





                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Cadastrar um Documento";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT fornecedor.id as id_fornecedor, fornecedor.nome as nome_fornecedor,
                                            conta_pagar.id, conta_pagar.documento, conta_pagar.valor,
                                            conta_pagar.valor_pendente, conta_pagar.juros_multa, conta_pagar.data_lancamento,
                                            conta_pagar.data_baixa, conta_pagar.data_vencimento, conta_pagar.pago,
                                            conta_pagar.id_lancamento, conta_pagar.observacao
                                        from conta_pagar 
                                        join fornecedor on conta_pagar.id_fornecedor = fornecedor.id 
                                        where conta_pagar.id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $id_fornecedor2    = $res[0]['id_fornecedor'];
                    $documento2        = $res[0]['documento'];
                    $valor2            = $res[0]['valor'];
                    $juros_multa2      = $res[0]['juros_multa'];
                    $data_lancamento2  = $res[0]['data_lancamento'];
                    $data_vencimento2  = $res[0]['data_vencimento'];
                    $observacao2       = $res[0]['observacao'];
                } else {
                    $titulo = "Inserir Registro";
                }


                ?>

                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Documento</label>
                                <input value="<?php echo @$documento2 ?>" type="text" class="form-control" id="documento" name="documento" placeholder="Documento">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fornecedor</label>
                                <select name="fornecedor" class="form-control" id="fornecedor">
                                    <?php

                                    $query = $pdo->query("SELECT * FROM fornecedor ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_for2 = $res[$i]['nome'];
                                        $id_for2 = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$id_for2 == $id_fornecedor2) { ?> selected <?php } ?> value="<?php echo @$id_for2 ?>"><?php echo @$nome_for2 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Valor Documento</label>
                                <input value="<?php echo @$valor2 ?>" type="text" class="form-control" id="valor_doc" name="valor_doc" placeholder="Valor Documento">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Juros / Multa</label>
                                <input value="<?php echo @$juros_multa2 ?>" type="text" class="form-control" id="juros_multa" name="juros_multa" placeholder="Juros ou Multa">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vencimento</label>
                                <input value="<?php echo @$data_vencimento2 ?>" type="date" class="form-control" id="vencimento" name="vencimento" placeholder="Vencimento">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foi Pago?</label>
                                <select name="pago" class="form-control" id="pago">
                                    <option selected>Selecione um tipo</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Observação</label>
                        <input value="<?php echo @$observacao2 ?>" type="text" class="form-control" id="observacao" name="observacao" placeholder="Observacao">
                    </div>




                    <small>
                        <div id="mensagem">

                        </div>
                    </small>

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$conta2 ?>" type="hidden" name="antigo" id="antigo">

                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id" name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
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

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
    echo "<script>$('#modalDados').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
    echo "<script>$('#modal-deletar').modal('show');</script>";
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
        $('#btn-deletar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/excluir.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function(mensagem) {

                    if (mensagem.trim() === 'Excluído com Sucesso!!') {


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