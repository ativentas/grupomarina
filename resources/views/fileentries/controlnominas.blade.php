@extends('templates.default')
@section('content')
<style type="text/css">
    .btn-file {
      position: relative;
      overflow: hidden;
    }
    .btn-file input[type=file] {
      position: absolute;
      top: 0;
      right: 0;
      min-width: 100%;
      min-height: 100%;
      font-size: 100px;
      text-align: right;
      filter: alpha(opacity=0);
      opacity: 0;
      background: red;
      cursor: inherit;
      display: block;
    }
    input[readonly] {
      background-color: white !important;
      cursor: text !important;
    }
</style>

<script>

    function updateFileName() {
        var filefield = document.getElementById('filefield');
        var file_name = document.getElementById('file_name');
        var fileNameIndex = filefield.value.lastIndexOf("\\");

        file_name.value = filefield.value.substring(fileNameIndex + 1);

    }

    $(function(){
        $("#filefield").on('change', function(event) {
            var file = event.target.files[0];
            if(file.size>=1024*512) {
                alert("Máximo 512K");
                //$("#form-id").get(0).reset(); //the tricky part is to "empty" the input file here I reset the form.
                
                return;
            }

            if(!file.type.match('pdf')) {
                alert("Solamente archivos PDF");
                // $("#form-id").get(0).reset(); //the tricky part is to "empty" the input file here I reset the form.
               
                return;
            }

            // var fileReader = new FileReader();
            // fileReader.onload = function(e) {
            //     var int32View = new Uint8Array(e.target.result);
            //     //verify the magic number
            //     // for JPG is 0xFF 0xD8 0xFF 0xE0 (see https://en.wikipedia.org/wiki/List_of_file_signatures)
            //     if(int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xE0) {
            //         alert("ok!");
            //     } else {
            //         alert("only valid JPG images");
            //         $("#form-id").get(0).reset(); //the tricky part is to "empty" the input file here I reset the form.
            //         return;
            //     }
            // };
            // fileReader.readAsArrayBuffer(file);
        });
    });
</script> 



<!-- Ejemplo adaptado de: http://www.abeautifulsite.net/whipping-file-inputs-into-shape-with-bootstrap-3/ -->

<div class="row">
<div class="col-md-6">
<form action="{{route('addentry', [])}}" method="post" enctype="multipart/form-data">


<h2>Subir Nominas</h2>    
<hr>
<h4>Selecciona Mes</h4>
<div class="form-group">
<select class="form-control" name="year">
    <option value="2016"@if (old('year') == '2016') selected="selected" @endif>2016</option>
    <option value="2015"@if (old('year') == '2015') selected="selected" @endif>2015</option>
</select>
</div>
<div class="form-group">
<select class="form-control" name="month">
  <option value="ENE"@if (old('month') == 'ENE') selected="selected" @endif>Enero</option>
  <option value="FEB"@if (old('month') == 'FEB') selected="selected" @endif>Febrero</option>
  <option value="MAR"@if (old('month') == 'MAR') selected="selected" @endif>Marzo</option>
  <option value="ABR"@if (old('month') == 'ABR') selected="selected" @endif>Abril</option>
  <option value="MAY"@if (old('month') == 'MAY') selected="selected" @endif>Mayo</option>
  <option value="JUN"@if (old('month') == 'JUN') selected="selected" @endif>Junio</option>
  <option value="JUL"@if (old('month') == 'JUL') selected="selected" @endif>Julio</option>
  <option value="AGO"@if (old('month') == 'AGO') selected="selected" @endif>Agosto</option>
  <option value="SEP"@if (old('month') == 'SEP') selected="selected" @endif>Septiembre</option>
  <option value="OCT"@if (old('month') == 'OCT') selected="selected" @endif>Octubrer</option>
  <option value="NOV"@if (old('month') == 'NOV') selected="selected" @endif>Noviembre</option>
  <option value="DIC"@if (old('month') == 'DIV') selected="selected" @endif>Diciembre</option>
</select>
</div>

<div class="form-group{{$errors->has('filefield') ? ' has-error' : ''}}">
<div class="input-group">
    <span class="input-group-btn">
        <span class="btn btn-primary btn-file">
            Browse&hellip;<input type="file" name="filefield" id="filefield" value=""onchange="updateFileName()">
        </span>
    </span>
    <input type="text" class="form-control" name="file_name" id="file_name" value=""placeholder="nombreArchivo.pdf" readonly>
    <input type="hidden" name="_token" value="{{Session::token()}}">
</div>
@if ($errors->has('filefield'))
    <span class="help-block">{{$errors->first('filefield')}}</span>
@endif
</div>  
<div class="form-group{{$errors->has('empleado') ? ' has-error' : ''}}">
<select class="form-control" name="empleado">
    <option value="">-- Selecciona Empleado --</option>
    @foreach($empleados as $empleado)
    <option value="{{$empleado->id}}">{{$empleado->id}} - {{$empleado->username}}</option>
    @endforeach
</select>
@if ($errors->has('empleado'))
    <span class="help-block">{{$errors->first('empleado')}}</span>
@endif
</div>
<div class="form-group">
    
        <input class="btn btn-primary center" type="submit" value="Subir Archivo"style="opacity: 1;">
</form>
</div>
</div>


<!-- <input type="file" name="img1" id="img1" onchange="updateFileName()">
<input type="text" name="file_name" id="file_name"> -->

<div class="row">
    <div class="col-md-6">
        <h2> Ultimas subidas</h2>
        <hr>
        <table class="table table-condensed">
        <thead>
          <tr>
            <th>Descripcion</th>
            <th>Fichero</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @foreach($entries as $entry)
          <tr>
            <td>{{$entry->descripcion}}</td>
            <td>{{$entry->original_filename}}</td>
            <td>
                <form action="/fileentry/delete/{{ $entry->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <input type="submit" class="btn btn-danger" value="borrar">
                </form>
            </td>
<!--             <td>
                <form action="/fileentry/detalle/{{ $entry->filename }}" method="GET">
                {{ csrf_field() }}

                <input type="submit" class="btn btn-primary" name ="descargar" value="Descargar">
                </form>
            </td> -->
            <td><button type="button" class="btn btn-info"><a href="/fileentry/detalle/{{ $entry->filename }}" target="_blank">VER</a></button></td>
          </tr>
        @endforeach
        </tbody>
        </table>
 
    </div>
</div>



@endsection