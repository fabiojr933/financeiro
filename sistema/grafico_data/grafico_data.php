<?php
require_once("../../config/conexao.php");

$data_inicial = $_POST['data_inicial'];
$data_final   = $_POST['data_final'];
?>

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Despesas', 'Valor'],

          <?php
            $sql = "select a.nome as despesas,                  
                        sum(b.total) as valor,
                        c.data_baixa 
                        from despesa A
                        join conta_pagar_fluxo b on a.id = b.id_despesa
                        join conta_pagar c on b.id_conta_pagar = c.id
                        where c.data_baixa BETWEEN '$data_inicial' and  '$data_final'
                        GROUP by 1
                        ORDER by c.data_baixa";
            $query = $pdo->query($sql);
            $resul = $query->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i < count($resul); $i++) { 
                foreach($resul[$i] as $key => $value){

                }
                $despesas = $resul[$i]['despesas'];    echo $despesas; exit;
                $valor = $resul[$i]['valor'];
                $data = $resul[$i]['data_baixa'];
           
          ?>

          ['<?php echo $data ?>', <?php echo $valor ?>],
         
          <?php  } ?>
        ]);

        var options = {
          title: 'Despesas por data',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <?php echo "Salvo com Sucesso!!"; ?>