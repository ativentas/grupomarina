@extends('templates.default')

@section('content')





<div class="row">
    <div class="col-md-12">
        <h3>Informe: </h3>
    </div>
</div>

<div class="row">
<div id="no-more-tables">
    <table class="col-md-12 table-bordered table-striped table-condensed cf">
		<thead class="cf">
            <tr class="bg-success">
                <th colspan="2" class="text-center">Artículo</th>         
                <th colspan="1" class="text-center">F. Inicial</th>         
                <th colspan="2" class="text-center">Movimientos</th>         
                <th colspan="1" class="text-center">Teórico</th>         
                <th colspan="1" class="text-center">F. Final</th>         
                <th colspan="2" class="text-center">Desviación</th>         
                </tr>
            <tr>
				<th class="col-md-1">Cod.</th>
				<th class="col-md-4">Descrip.</th>
				<th class="col-md-1 numeric">Uds.</th>
				<th class="col-md-1 numeric">Entradas</th>
				<th class="col-md-1 numeric">Ventas</th>
				<th class="col-md-1 numeric">Uds.</th>
				<th class="col-md-1 numeric">Uds.</th>
				<th class="col-md-1 numeric">Uds.</th>
				<th class="col-md-1 numeric">Desv.%</th>
			</tr>
		</thead>
		<tbody>
			<tr>
                <td class="col-md-1"></td>
                <td class="col-md-4"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
                <td class="col-md-1"></td>
				<td class="col-md-1"></td>   				
			</tr>
		</tbody>
	</table>
</div>
</div>

<div class="row">
    <p class="bg-success" style="padding:10px;margin-top:20px"><small><a href="http://elvery.net/demo/responsive-tables/#no-more-tables" target="_blank">Link</a> to original article</small></p>
</div>
@stop