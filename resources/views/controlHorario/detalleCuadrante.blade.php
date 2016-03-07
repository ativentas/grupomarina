@extends('templates.default')

@section('content')


<h3>Parte Horario. Fecha: {{$cuadrante->fecha->format('d/m/Y')}} - Empresa: {{$cuadrante->empresa}}</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
			<th>Empleado</th>
			<th>Tipo</th>
			<th style = "">Entrada</th>
			<th style = "">Salida</th>

			<th>Confirmacion</th>
			<th>email</th>

			</tr>
		</thead>
		<tfoot>
			<tr>
				<td style="visibility:hidden;"></td>
				<td colspan="3"><button class="center-block" type="submit" name="action" value="actualizarTodos" form="cuadrante">Validar Datos</button></td>
				<td style="visibility:hidden;"></td>
				<td colspan="2"><div class=""><button @if($cuadrante->estado!='poner aqui Validado')style="display:none;" @endif class="center-block" type="submit" name="action" value="requerirTodos" form="cuadrante">Requerir TODOS</button></div></td>
			</tr>
		</tfoot>
		<form id="cuadrante" action="{{route('cuadrante.requerir', $cuadrante->id)}}" method="POST">
		{{csrf_field()}}
		<tbody>
			@foreach ($lineas as $linea)
			<tr>

			<td>{{$linea->empleado->nombre_completo}}</td>
			<td>
			<select class="form-control" id="tipo{{$linea->id}}" name="tipo{{$linea->id}}">
				<option value = "Normal" {{$linea->tipo=='Normal'?' selected':''}}>Normal</option>
				<option value = "Partido" {{$linea->tipo=='Partido'?' selected':''}}>Partido</option>
				<option{{$linea->tipo=='Vacaciones'?' selected':''}}>Vacaciones</option>
				<option{{$linea->tipo=='Libre'?' selected':''}}>Libre</option>
				<option{{$linea->tipo=='Baja'?' selected':''}}>Baja</option>
				<option{{$linea->tipo=='Falta'?' selected':''}}>Falta</option>
			</select>
			</td>


			<td class="">
			@if ($linea->entrada == null)
			<input type="text" name="entrada{{$linea->id}}" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" id="entrada{{$linea->id}}" size="5" placeholder="00:00" value="">
			@else
			<input type="text" name="entrada{{$linea->id}}" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" id="entrada{{$linea->id}}" size="5" placeholder="00:00" value={{date('H:i',strtotime($linea->entrada))}}>
			@endif
			<br><input type="text" size="5" name="entrada2{{$linea->id}}" id="entrada2{{$linea->id}}" value="{{$linea->entrada2 ? date('H:i',strtotime($linea->entrada2)) : ''}}">

			</td>
			<td>
			@if ($linea->salida == null)
			<input type="text" size="5" name="salida{{$linea->id}}" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" id="salida{{$linea->id}}" placeholder="00:00" value="">
			@else
			<input type="text" size="5" name="salida{{$linea->id}}" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" id="salida{{$linea->id}}" placeholder="00:00" value={{date('H:i',strtotime($linea->salida))}}>
			@endif

			<br><input type="text" size="5" name="salida2{{$linea->id}}" id="salida2{{$linea->id}}" value="{{$linea->salida2 ? date('H:i',strtotime($linea->salida2)):''}}">
			
			</td>


			@if ($linea->estado == 'Requerido')			
			<td><p class="bg-warning small">Esperando...</p></td>
			@else
			<td><p class="bg-success small" id="asunto{{$linea->id}}">{{$linea->asunto}}</p></td>
			@endif			
			<td>{{$linea->empleado->email}}</td>
			<td><button type="submit" @if($cuadrante->estado!='Validado')style="display:none;" @endif name="action" id="requerir{{$linea->id}}" value={{$linea->id}} @if ($linea->estado == 'Requerido'|$linea->estado == 'Firmado') disabled class ="default"@else class="btn-info"@endif>Requerir</button></td>
			</tr>
			<script>
            
            $(document).ready(function(){
			var caso = $("#tipo{{$linea->id}}").val();
           	
           	var estado = "{{$linea->estado}}";
           	
            switch (caso){
            	case 'Normal':
            		$("#entrada{{$linea->id}}").show();
            		$("#salida{{$linea->id}}").show();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('{{$linea->asunto}}');
            		// $("#requerir{{$linea->id}}").show();

            		break;	
            	case 'Partido':
            		$("#entrada{{$linea->id}}").show();
            		$("#salida{{$linea->id}}").show();
            		$("#entrada2{{$linea->id}}").show();
            		$("#salida2{{$linea->id}}").show();
            		$("#asunto{{$linea->id}}").text('{{$linea->asunto}}');
            		// $("#requerir{{$linea->id}}").show();
            		break;
            	case 'Vacaciones':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** VACACIONES ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;
            	case 'Libre':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** LIBRE ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;
            	case 'Baja':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** BAJA MEDICA ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;
            	case 'Falta':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** FALTA ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;
            	default:
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		break;	
            }

            switch (estado){
            	case 'Pendiente':
            		$("#entrada{{$linea->id}}").prop('disabled', false);
            		$("#salida{{$linea->id}}").prop('disabled', false);
            		$("#entrada2{{$linea->id}}").prop('disabled', false);
            		$("#salida2{{$linea->id}}").prop('disabled', false);
            		$("#tipo{{$linea->id}}").prop('disabled', false);
            		break;
            	case 'Requerido':
            		$("#entrada{{$linea->id}}").prop('disabled', true);
            		$("#salida{{$linea->id}}").prop('disabled', true);
            		$("#entrada2{{$linea->id}}").prop('disabled', true);
            		$("#salida2{{$linea->id}}").prop('disabled', true);
            		$("#tipo{{$linea->id}}").prop('disabled', true);
            		break;
            	case 'Firmado':
        			$("#entrada{{$linea->id}}").prop('disabled', true);
        			$("#salida{{$linea->id}}").prop('disabled', true);
        			$("#entrada2{{$linea->id}}").prop('disabled', true);
        			$("#salida2{{$linea->id}}").prop('disabled', true);
        			$("#tipo{{$linea->id}}").prop('disabled', true);
            		break;
            }	
            });
			

            $("#tipo{{$linea->id}}").change(function() {
            var caso = $("#tipo{{$linea->id}}").val();
            switch (caso){
            	case 'Normal':
            		$("#entrada{{$linea->id}}").show();
            		$("#salida{{$linea->id}}").show();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('{{$linea->asunto}}');
            		$("#requerir{{$linea->id}}").show();
            		break;	
            	case 'Partido':
            		$("#entrada{{$linea->id}}").show();
            		$("#salida{{$linea->id}}").show();
            		$("#entrada2{{$linea->id}}").show();
            		$("#salida2{{$linea->id}}").show();
            		$("#asunto{{$linea->id}}").text('{{$linea->asunto}}');
             		$("#requerir{{$linea->id}}").show();           		
            		break;
            	case 'Vacaciones':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** VACACIONES ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;
            	case 'Libre':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** LIBRE ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;

            	case 'Baja':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** BAJA MEDICA ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;

            	case 'Falta':
            		$("#entrada{{$linea->id}}").hide();
            		$("#salida{{$linea->id}}").hide();
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		$("#asunto{{$linea->id}}").text('*** FALTA ***');
            		$("#requerir{{$linea->id}}").hide();
            		break;

            	default:
            		$("#entrada2{{$linea->id}}").hide();
            		$("#salida2{{$linea->id}}").hide();
            		break;	
            }	
            });
            </script>
			@endforeach
		</tbody>
		</form></form>

	</table>


  


@stop