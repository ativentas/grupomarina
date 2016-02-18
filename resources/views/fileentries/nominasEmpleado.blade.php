@extends('templates.default')
@section('content')
<div class="row">
    <div class="col-md-8">
        <h2> Nominas</h2>
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
                <form action="/fileentry/detalle/{{ $entry->filename }}" method="GET">
                {{ csrf_field() }}

                <input type="submit" class="btn btn-primary" name ="descargar" value="Descargar">
                </form>
            </td>
            <td><button type="button" class="btn btn-default"><a href="/fileentry/detalle/{{ $entry->filename }}" target="_blank">VER</a></button></td>
          </tr>
        @endforeach
        </tbody>
        </table>
 
    </div>
</div>



@endsection