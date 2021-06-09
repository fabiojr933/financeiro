<?php 
$pag = "grafico";
require_once("../config/conexao.php"); 
@session_start();

$query = $pdo->query("select a.nome as depesas, 
                  EXTRACT(MONTH FROM c.data_baixa) as mes,
                  sum(b.total) as valor
                  from despesa A
                  join conta_pagar_fluxo b on a.id = b.id_despesa
                  join conta_pagar c on b.id_conta_pagar = c.id
                  GROUP by 1
                  ORDER by mes");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
   foreach ($res[$i] as $key => $value) {
   }
   $despesa = $res['mes'];


    echo $despesa;

}



?>



<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>         
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {           

        var data = google.visualization.arrayToDataTable([
          ['Despesas', 'Mes', 'Valor'],
          ['<?php  ?>',     <?php  ?>, <?php  ?>]
  
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
