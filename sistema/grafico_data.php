<?php
$pag = "grafico_data";
require_once("../config/conexao.php");
@session_start();

?>

<div class="row mt-8 mb-8">
    <a type="button" class="btn-primary btn-sm ml-4 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Informar a Data</a>
    <a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo">+</a>

</div>

<div class="row">
    <div class="col-sm-6">
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
    </div>
    <div class="col-sm-6">

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input type="date" class="form-control" id="data_inicial" name="data_inicial" placeholder="data_inicial">
                        <label>Data Final</label>
                        <input type="date" class="form-control" id="data_final" name="data_final" placeholder="data_final">
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
                    <button type="submit" onclick="drawChart()" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
    echo "<script>$('#modalDados').modal('show');</script>";
}
?>



<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data1 = document.getElementById('data_inicial').value;   
        var data2= document.getElementById('data_final').value;    alert(data1); 
        var data = google.visualization.arrayToDataTable([
            ['Despesas', 'Valor'],
            <?php

            $query = $pdo->query("select a.valor, b.nome as despesas
            from lancamento a
            join despesa b on a.id_despesa = b.id
            where a.data BETWEEN '2020-01-01' and '2021-06-30'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($res); $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $desp = $res[$i]['despesas'];
                $valor = $res[$i]['valor'];
               

            ?>           
          [' <?php echo $desp ?>', <?php echo $valor ?>],
            <?php } ?>
        ]);

        var options = {
            title: 'Company Performance',
            hAxis: {
                title: 'Year',
                titleTextStyle: {
                    color: '#333'
                }
            },
            vAxis: {
                minValue: 0
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>