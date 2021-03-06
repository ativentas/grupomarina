@extends('layout')

@section('content')

<div class="row">
    <div clss="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">Listado</li>
            <li><a href="{{ url('nuevoHorario') }}">Nuevo Horario</a></li>

        </ol>
    </div>
</div>

<!-- este script es para los graficos -->
<!--   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div"></div>
	
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'hora');
      data.addColumn('number', 'C');
      data.addColumn({type:'number', role: 'annotation' });

      data.addColumn({type: 'string', role: 'tooltip'});
      data.addRows(valores);
      // data.addRows([[valores[0]['hora'],0,0]]);
      // data.addRows(
      // 	[

      //   ['8:00', 7, 2],
      //   ['8:15', 4, 2],
      //   ['8:15', 4, 2],
      //   ['8:15', 4, 2],
      //   ['8:15', 4, 3],
      //   ['8:15', 4, 2],
      //   ['8:15', 4, 2],
        // [{v: [8, 0, 0], f: '8 am'}, 1, .25],
        // [{v: [9, 0, 0], f: '9 am'}, 2, .5],
        // [{v: [10, 0, 0], f:'10 am'}, 3, 1],
        // [{v: [11, 0, 0], f: '11 am'}, 4, 2.25],
        // [{v: [12, 0, 0], f: '12 pm'}, 5, 2.25],
        // [{v: [13, 0, 0], f: '1 pm'}, 6, 3],
        // [{v: [14, 0, 0], f: '2 pm'}, 7, 4],
        // [{v: [15, 0, 0], f: '3 pm'}, 8, 5.25],
        // [{v: [16, 0, 0], f: '4 pm'}, 9, 7.5],
        // [{v: [17, 0, 0], f: '5 pm'}, 10, 10],
      // ]
      // );

      var options = {
        title: 'Empleados trabajando',
        hAxis: {
          title: '',
          // format: 'h:mm a',
          // viewWindow: {
          //   min: [7, 30, 0],
          //   max: [17, 30, 0]
          // }
        },
        vAxis: {
          title: ''
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }
</script> -->




<div class="col-sm-12 row">
<h3>Ultimos Cuadrantes</h3>


<table class="table table-bordered">
	<thead>
		<tr>
		<th>Fecha</th>
		<th>Empresa/Restaurante</th>
		<th>Estado</th>
		<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($cuadrantes as $cuadrante)
		<tr>
		<td>{{$cuadrante->fecha->format('d-m-Y')}}</td>
		<td>{{$cuadrante->centro->nombre}}</td>
		<td>{{$cuadrante->estado}}</td>
		<td><a href="{{route('cuadrante.detalle',$cuadrante->id	)}}">Detalle</a></td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>





@stop