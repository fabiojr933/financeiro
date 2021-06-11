<?php
$pag = "grafico_geral";
require_once("../config/conexao.php");
@session_start();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>
    <div class="row">
        <div class="col-sm-6">
            <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
        </div>
        <div class="col-sm-6">
            <div id="chart_div" style="width: 900px; height: 500px;"></div>
        </div>
    </div>
</body>

</html>




<script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Despesas', 'Valor'],
            <?php

            $query = $pdo->query("select a.valor, b.nome as despesas
            from lancamento a
            join despesa b on a.id_despesa = b.id");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($res); $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $desp = $res[$i]['despesas'];
                $valor = $res[$i]['valor'];
              

            ?>[' <?php echo $desp ?>', <?php echo $valor ?>],
            <?php } ?>
        ]);

        var options = {
            title: 'Grafico de despesas',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>


<script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Despesas', 'Valor'],
            <?php

            $query = $pdo->query("select a.valor, b.nome as despesas
            from lancamento a
            join despesa b on a.id_despesa = b.id");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($res); $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $desp = $res[$i]['despesas'];
                $valor = $res[$i]['valor'];
               

            ?>[' <?php echo $desp ?>', <?php echo $valor ?>],
            <?php } ?>
        ]);

        var options = {
            title: 'Grafico de despesas2',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
        chart.draw(data, options);
    }
</script>








<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Despesas', 'Valor'],
            <?php

            $query = $pdo->query("select a.valor, b.nome as despesas
            from lancamento a
            join despesa b on a.id_despesa = b.id");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 0; $i < count($res); $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $desp = $res[$i]['despesas'];
                $valor = $res[$i]['valor'];
               

            ?>[' <?php echo $desp ?>', <?php echo $valor ?>],
            <?php } ?>
        ]);


        var options = {
            title: 'Grafico de despesas',
            vAxis: {
                title: 'Cups'
            },
            hAxis: {
                title: 'Month'
            },
            seriesType: 'bars',
            series: {
                5: {
                    type: 'line'
                }
            }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>