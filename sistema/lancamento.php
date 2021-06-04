<?php
$pag = "Lancamento";
require_once("../config/conexao.php");
@session_start();


?>

<div class="row mt-4 mb-4">
    <a type="button" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Lancamento</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>

</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="20%" align="left">Conta</th>
                        <th width="25%" align="left">Despesa</th>
                        <th width="25%" align="left">Fluxo</th>
                        <th width="10%" align="left">Valor</th>
                        <th width="10%" align="left">Data</th>

                        <th width="10%" align="left">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = $pdo->query("SELECT lan.id, cont.banco, de.nome as dre, flu.nome as fluxo, des.nome as despesa, lan.valor, lan.data
                                                    FROM lancamento lan
                                                    join despesa des on des.id = lan.id_despesa
                                                    join conta cont on  cont.id = lan.id_conta
                                                    join dre de on de.id = lan.id_dre
                                                    join fluxo flu on flu.id = lan.id_fluxo");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    for ($i = 0; $i < count($res); $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                        $banco    = $res[$i]['banco'];
                        $despesa  = $res[$i]['despesa'];
                        $fluxo    = $res[$i]['fluxo'];
                        $valor    = $res[$i]['valor'];
                        $data     = $res[$i]['data'];


                        $id = $res[$i]['id'];


                    ?>


                        <tr>
                            <td><?php echo $banco ?></td>
                            <td><?php echo $despesa ?></td>
                            <td><?php echo $fluxo ?></td>
                            <td><?php echo $valor ?></td>
                            <td><?php echo $data ?></td>


                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
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
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT lan.id, cont.banco, de.nome as dre, flu.nome as fluxo, des.nome as despesa, lan.valor, lan.data,
                                            cont.id as id_banco,de.id as id_dre, fluxo.id as id_fluxo, des.id as id_despesa
                                        FROM lancamento lan
                                        join despesa des on des.id = lan.id_despesa
                                        join conta cont on  cont.id = lan.id_conta
                                        join dre de on de.id = lan.id_dre
                                        join fluxo flu on flu.id = lan.id_fluxo where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $id_banco   = $res[0]['id_banco'];
                    $id_dre     = $res[0]['id_dre'];
                    $id_fluxo   = $res[0]['id_fluxo'];
                    $id_despesa = $res[0]['id_despesa'];


                    $dre2     = $res[0]['dre'];
                    $banco2   = $res[0]['banco'];
                    $fluxo2   = $res[0]['fluxo'];
                    $despesa2 = $res[0]['despesa'];
                    $valor2   = $res[0]['valor'];
                    $data2    = $res[0]['data'];
                } else {
                    $titulo = "Inserir Lançamento";
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
                                <label>Dre</label>
                                <select name="dre" class="form-control" id="dre">
                                    <?php

                                    $query = $pdo->query("SELECT * FROM dre ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_dre2 = $res[$i]['nome'];
                                        $id_dre2 = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$id_dre == $id_dre2) { ?> selected <?php } ?> value="<?php echo $id_dre2 ?>"><?php echo $nome_dre2 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banco</label>
                                <select name="banco" class="form-control" id="banco">
                                    <?php

                                    $query = $pdo->query("SELECT * FROM conta ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_banco2 = $res[$i]['banco'];
                                        $id_banco2 = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$id_banco2 == $id_banco) { ?> selected <?php } ?> value="<?php echo $id_banco2 ?>"><?php echo $nome_banco2 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fluxo</label>
                                <select name="fluxo" class="form-control" id="fluxo">
                                    <?php

                                    $query = $pdo->query("SELECT * FROM fluxo ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_fluxo2 = $res[$i]['nome'];
                                        $id_fluxo2 = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$id_fluxo == $id_fluxo2) { ?> selected <?php } ?> value="<?php echo $id_fluxo2 ?>"><?php echo $nome_fluxo2 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Despesa</label>
                                <select name="despesa" class="form-control" id="despesa">
                                    <?php

                                    $query = $pdo->query("SELECT * FROM despesa ");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                    for ($i = 0; $i < @count($res); $i++) {
                                        foreach ($res[$i] as $key => $value) {
                                        }
                                        $nome_despesa2 = $res[$i]['nome'];
                                        $id_despesa2 = $res[$i]['id'];
                                    ?>
                                        <option <?php if (@$id_despesa == $id_despesa2) { ?> selected <?php } ?> value="<?php echo $id_despesa2 ?>"><?php echo $nome_despesa2 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Valor</label>
                                <input value="<?php echo @$valor2 ?>" type="number" class="form-control" id="valor" name="valor" placeholder="Valor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data</label>
                                <input value="<?php echo @$data2 ?>" type="date" class="form-control" id="data" name="data" placeholder="Data">
                            </div>
                        </div>
                    </div>


                    <small>
                        <div id="mensagem">

                        </div>
                    </small>

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$nome2 ?>" type="hidden" name="antigo" id="antigo">

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