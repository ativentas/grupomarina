@extends('templates.default')

@section('content')


<div class="row">
    <div class="col-md-6">
        <h3 style="display:inline" ><strong>Informe:</strong> {{$control->descripcion}}</h3>
    </div>
    <div class="col-md-offset-7">
        <button class="btn-primary" name="guardar"form="tabla">Calcular Informe</button>
        <button class="btn-primary" name="salir" form="tabla">Salir</button>
    </div>
</div>
<hr>    

<div class="row">

    <form id="tabla" action="{{route('control.update', $control->id)}}" method="POST">
    {{ csrf_field() }}
    <!-- <button class="btn-primary" name="guardar">Guardar</button> -->
    <input name="_method" type="hidden" value="PUT">
    <div id="no-more-tables">
    <table id="" class="col-md-12 table-bordered  table-condensed cf">
        <thead class="cf">
            
            <tr class="bg-success">
                <th colspan="2" class="text-center">Artículo</th>         
                
                <th colspan="1" class="text-center">{{date("d/m/y", strtotime($control->inicial_fecha))}}</th>         
                <th colspan="2" class="text-center">Movimientos</th>         
                <th colspan="1" class="text-center">Teórico</th>         
                <th colspan="1" class="text-center">{{date("d/m/y", strtotime($control->final_fecha))}}</th>         
                <th colspan="2" class="text-center">Desviación</th>         
                </tr>
            <tr class="bg-success">
                <th style="text-align: center;" class="col-md-1">Cod.</th>
                <th style="text-align: center;" class="col-md-4">Descrip.</th>
                <th style="text-align: center;" class="col-md-1 numeric">Uds.</th>
                <th style="text-align: center;" class="col-md-1 numeric">Compras</th>
                <th style="text-align: center;" class="col-md-1 numeric">Ventas</th>
                <th style="text-align: center;" class="col-md-1 numeric">Uds.</th>
                <th style="text-align: center;" class="col-md-1 numeric">Uds.</th>
                <th style="text-align: center;" class="col-md-1 numeric">Uds.</th>
                <th style="text-align: center;" class="col-md-1 numeric">Desv.%</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lineas as $linea)
            <tr>
                <td style="background-color: lightgrey" class="col-md-1">{{$linea->codigoArticulo_id}}</td>
                <td style="background-color: lightgrey" class="col-md-4">{{$linea->articulo['nombre']}}</td>
                <td style="text-align: right;padding:0 1em 0 0em;background-color: lightgrey" class="col-md-1">{{$linea->inicial_uds}}</td>            
                <td style="text-align: right;padding:0 0.5em 0 0.5em" id="" class="col-md-1"><input style="padding:0 0 0 1em;width:4em" type="number" name="cantidadCompra_{{$linea->id}}" min="0" max="999"class="" id="" value="{{$linea->entradas}}"></td>
                <td style="text-align: right;padding:0 0.5em 0 0.5em" id="" class="col-md-1"><input style="padding:0 0 0 1em;width:4em" type="number" name="cantidadVenta_{{$linea->id}}" min="0" max="999"class="" id="" value="{{$linea->ventas}}"></td>
                <td style="text-align: right;padding:0 1em 0 0em;background-color: lightgrey" class="col-md-1">{{$linea->teorico_uds}}</td>
                <td style="text-align: right;padding:0 1em 0 0em;background-color: lightgrey" class="col-md-1">{{$linea->final_uds}}</td>
                <td style="text-align: right;padding:0 1em 0 0em;background-color: lightgrey" class="col-md-1">{{$linea->desviacion_uds}}</td>
                <td style="text-align: right;padding:0 0.5em 0 0em;background-color: lightgrey" class="col-md-1" style="text-align:right">{{sprintf("%.2f%%", $linea->desviacion_percent * 100)}}</td>                
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color:lightblue;font-size:large; ">
              <td></td>
              <td>Totales</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalInicial']}}</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalEntradas']}}</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalVentas']}}</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalTeorico']}}</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalFinal']}}</td>
              <td style="text-align:right;padding:0 1em 0 0" >{{$totals['totalDesviaciones']}}</td>
              <td style="text-align:right;font-weight: bold;color:red">{{sprintf("%.2f%%", $control->promedio*100)}}</td>
            </tr>
        </tfoot>
    </table>
    </div>
    
    </form>
</div>


<div class="row">
    <p class="bg-success" style="padding:10px;margin-top:20px">
    De acuerdo con estos datos, si se hubiese tikado todo correctamente, los ingresos habrían sido un {{$control->promedio*100*(-1)}} % mayores con los mismos costes, por lo que se puede estimar que para una facturación de 100.000 €/mes del restaurante, el perjuicio sufrido se podría estimar en  {{number_format($control->promedio*100000*(-1), 0, ',', '.')}}€/mes</p>
</div>
<!--
<script>

/*global $, window*/
$.fn.editableTableWidget = function (options) {
    'use strict';
    return $(this).each(function () {
        var buildDefaultOptions = function () {
                var opts = $.extend({}, $.fn.editableTableWidget.defaultOptions);
                opts.editor = opts.editor.clone();
                return opts;
            },
            activeOptions = $.extend(buildDefaultOptions(), options),
            ARROW_LEFT = 37, ARROW_UP = 38, ARROW_RIGHT = 39, ARROW_DOWN = 40, ENTER = 13, ESC = 27, TAB = 9,
            element = $(this),
            editor = activeOptions.editor.css('position', 'absolute').hide().appendTo(element.parent()),
            active,
            showEditor = function (select) {
                active = element.find('#editable:focus');
                if (active.length) {
                    editor.val(active.text())
                        .removeClass('error')
                        .show()
                        .offset(active.offset())
                        .css(active.css(activeOptions.cloneProperties))
                        .width(active.width())
                        .height(active.height())
                        .focus();
                    if (select) {
                        editor.select();
                    }
                }
            },
            setActiveText = function () {
                var text = editor.val(),
                    evt = $.Event('change'),
                    originalContent;
                if (active.text() === text || editor.hasClass('error')) {
                    return true;
                }
                originalContent = active.html();
                active.text(text).trigger(evt, text);
                if (evt.result === false) {
                    active.html(originalContent);
                }
            },
            movement = function (element, keycode) {
                if (keycode === ARROW_RIGHT) {
                    return element.next('#editable');
                } else if (keycode === ARROW_LEFT) {
                    return element.prev('#editable');
                } else if (keycode === ARROW_UP) {
                    return element.parent().prev().children().eq(element.index());
                } else if (keycode === ARROW_DOWN) {
                    return element.parent().next().children().eq(element.index());
                }
                return [];
            };
        editor.blur(function () {
            setActiveText();
            editor.hide();
        }).keydown(function (e) {
            if (e.which === ENTER) {
                setActiveText();
                editor.hide();
                active.focus();
                e.preventDefault();
                e.stopPropagation();
            } else if (e.which === ESC) {
                editor.val(active.text());
                e.preventDefault();
                e.stopPropagation();
                editor.hide();
                active.focus();
            } else if (e.which === TAB) {
                active.focus();
            } else if (this.selectionEnd - this.selectionStart === this.value.length) {
                var possibleMove = movement(active, e.which);
                if (possibleMove.length > 0) {
                    possibleMove.focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
        })
        .on('input paste', function () {
            var evt = $.Event('validate');
            active.trigger(evt, editor.val());
            if (evt.result === false) {
                editor.addClass('error');
            } else {
                editor.removeClass('error');
            }
        });
        element.on('click keypress dblclick', showEditor)
        .css('cursor', 'pointer')
        .keydown(function (e) {
            var prevent = true,
                possibleMove = movement($(e.target), e.which);
            if (possibleMove.length > 0) {
                possibleMove.focus();
            } else if (e.which === ENTER) {
                showEditor(false);
            } else if (e.which === 17 || e.which === 91 || e.which === 93) {
                showEditor(true);
                prevent = false;
            } else {
                prevent = false;
            }
            if (prevent) {
                e.stopPropagation();
                e.preventDefault();
            }
        });

        element.find('td').prop('tabindex', 1);

        $(window).on('resize', function () {
            if (editor.is(':visible')) {
                editor.offset(active.offset())
                .width(active.width())
                .height(active.height());
            }
        });
    });

};
$.fn.editableTableWidget.defaultOptions = {
    cloneProperties: ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
                      'text-align', 'font', 'font-size', 'font-family', 'font-weight',
                      'border', 'border-top', 'border-bottom', 'border-left', 'border-right'],
    editor: $('<input>')
};




/* global $ */
/* this is an example for validation and change events */
$.fn.numericInputExample = function () {
    'use strict';
    var element = $(this),
        footer = element.find('tfoot tr'),
        dataRows = element.find('tbody tr'),
        initialTotal = function () {
            var column, total;
            for (column = 1; column < footer.children().size(); column++) {
                total = 0;
                dataRows.each(function () {
                    var row = $(this);
                    total += parseFloat(row.children().eq(column).text());
                });
                footer.children().eq(column).text(total);
            };
        };
    element.find('td').on('change', function (evt) {
        var cell = $(this),
            column = cell.index(),
            total = 0;
        if (column === 0) {
            return;
        }
        element.find('tbody tr').each(function () {
            var row = $(this);
            total += parseFloat(row.children().eq(column).text());
        });
        if (column === 1 && total > 5000) {
            $('.alert').show();
            return false; // changes can be rejected
        } else {
            $('.alert').hide();
            footer.children().eq(column).text(total);
        }
    }).on('validate', function (evt, value) {
        var cell = $(this),
            column = cell.index();
        if (column === 0) {
            return !!value && value.trim().length > 0;
        } else {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }
    });
    initialTotal();
    return this;
};
</script>

<script>
$('#mainTable').editableTableWidget().numericInputExample().find('#editable:first').focus();
</script>-->


@stop
