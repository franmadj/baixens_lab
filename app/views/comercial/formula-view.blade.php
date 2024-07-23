@extends('layouts.base')

@section('content')

@if($formula->idSeccionFormula!='1')
<style>
    .enlucido{
        display: none;
    }
</style>
@endif
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Baixens <small>aplicación formulación</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li class="btn-group">
                <a  href="{{URL::to('formulas')}}" class="btn blue">
                    <span> Ver formulas </span>
                </a>
            </li>
            <li>
                <a href="inicio.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>

                Formulas

                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Ver formulas
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                {{$formula->nombre}}
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body">
            <!--<div class="col-md-12" style="padding:0px; margin-bottom:5px;">
            <div class="col-md-4" style="padding:0px;">
                    <a  target="_blank" href="{{URL::to('print-formula-valorada')}}/{{ $formula->id  }}/0" class="btn dark fullButton enlaces_print">IMPRIMIR formula valorada</a>
            </div>
            <div class="col-md-4">
                    <a  target="_blank" href="{{URL::to('print-formula-sin-valorar')}}/{{ $formula->id  }}/0"  class="btn dark fullButton enlaces_print">IMPRIMIR formula sin valorar</a>
            </div>
            <div class="col-md-4" style="padding:0px;">
                    <a  target="_blank" href="{{URL::to('print-formula-ajustada')}}/{{ $formula->id  }}/0"  class="btn dark fullButton enlaces_print">IMPRIMIR formula ajustada a producción</a>
            </div>
        </div-->

            <div class="col-md-12" style="padding:0px; margin-bottom:5px;">
                <div class="col-md-4" style="padding:0px;">
                    <a target="_blank" href="{{URL::to('pdf-formula-valorada')}}/{{ $formula->id  }}/0" class="btn red fullButton enlaces_print">PDF formula valorada</a>
                </div>
                <div class="col-md-4" >
                    <a target="_blank" href="{{URL::to('pdf-formula-sin-valorar')}}/{{ $formula->id  }}/0" class="btn red fullButton enlaces_print">PDF formula sin valorar</a>
                </div>
                <div class="col-md-4" style="padding:0px;">
                    <a  target="_blank" href="{{URL::to('pdf-formula-ajustada')}}/{{ $formula->id  }}/0" class="btn red fullButton enlaces_print">PDF formula ajustada a producción</a>
                </div>

            </div>


            <div class="col-md-12 enlucido" style="padding:0px; margin-bottom:15px;" >

                <div class="col-md-3" style="padding:0px;">

                    <a id="print-base" target="_blank" href="{{URL::to('print-formula-ajustada-base')}}/{{ $formula->id  }}/0"  class="btn blue fullButton enlaces_print">IMPRIMIR Base</a>
                </div>
                <div class="col-md-3" >
                    <a id="print-ma"target="_blank" href="{{URL::to('print-formula-ajustada-ma')}}/{{ $formula->id  }}/0"  class="btn blue fullButton enlaces_print">IMPRIMIR MA</a>
                </div>
                <div class="col-md-3 text-center">
                    <label><input type="radio" name="size" id="grande" value="option1" checked> Maquina grande</label>
                </div>
                <div class="col-md-3 text-center">
                    <label><input type="radio" name="size" id="peque" value="option2"> Maquina pequeña </label>
                </div>
            </div>

            <div class="col-md-12" style="padding:0px; margin-bottom:5px;">
                <div class="col-md-6" style="padding:0px;">
                    <input type="text" class="form-control text-center" id="cantPorduccion" placeholder="Cantidad de producción">
                </div>
                <div class="col-md-6" style="padding:0px;">
                    <a class="btn green fullButton" id="recalcular">Recalcular</a>
                </div>
                <div class="col-md-6" style="padding:0px;">
                    <h3><small>Nombre formula: </small>{{ $formula->nombre  }}</h3>
                </div>
                <div class="col-md-6 text-right" style="padding:0px;">
                    <h3><small>Nº formula:</small> {{ $formula->numero  }}</h3>
                </div>

            </div>
            <div class="col-md-12" style="padding:0px; margin-bottom:15px;" >


                <table class="table table-striped table-bordered table-hover table-full-width">
                    <tbody>
                        <tr>
                            <td class="tdst-group-item"> <small>Código:</small></td>
                            <td class="tdst-group-item"> <strong>{{ $formula->codigo  }}</strong></td>
                        </tr>
                        <tr>
                            <td class="tdst-group-item"> <small>Sección:</small></td>
                            <td class="tdst-group-item"> <strong>{{ $formula->SeccionesFormula->seccion  }}</strong></td>
                        </tr>
                        <tr>
                            <td class="tdst-group-item"> <small>Fecha</small></td>
                            <td class="tdst-group-item"> <strong>@if($formula->fecha>1) {{$formula->fecha}} @else Sin Fecha  @endif</strong></td>
                        </tr>

                        <tr>
                            <td class="tdst-group-item"> <small>Fecha última modificación</small></td>
                            <td class="tdst-group-item"> <strong>@if($formula->fechaUltEdicion>1) {{date('d/m/Y', $formula->fechaUltEdicion)}} @else Sin Fecha  @endif</strong></td>
                        </tr>

                        <tr>

                            <td class="tdst-group-item"> <small>Densidad (g/l)</small></td>
                            <td class="tdst-group-item"> <strong id="densidad-val">{{ $formula->densidad  }}</strong></td>
                        </tr>
                        <tr>
                            <td class="tdst-group-item" colspan="2"> <small>Descripción</small></td>
                        </tr>
                        <tr>
                            <td class="tdst-group-item" colspan="2"> <strong>{{ $formula->descripcion  }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        Calculo
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        VOC totales (g/l)
                                    </th>
                                    <th>
                                        Total formula €
                                    </th>
                                    <th>
                                        Peso
                                    </th>
                                    <th>
                                        Precio x Kg
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control vocTotales" type="text" disabled="" placeholder="Sale de calculo">
                                    </td>
                                    <td>
                                        <input class="form-control importeTotal" type="text" disabled="" placeholder="Sale de calculo">
                                    </td>

                                    <td>
                                        <input class="form-control pesoTotal" type="text" disabled="" placeholder="Sale de calculo">
                                    </td>

                                    <td>
                                        <input class="form-control precioXkg" type="text" disabled="" placeholder="Sale de calculo">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        Código
                                    </th>
                                    <th>
                                        Producto
                                    </th>
                                    <th>
                                        %
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Coste
                                    </th>
                                    <th>
                                        Importe
                                    </th>
                                    <th>
                                        Proveedor
                                    </th>
                                    <th>
                                        VOC 
                                    </th>
                                    <th>
                                        DENSIDAD
                                    </th>
                                    <th>
                                        VOC indivi.
                                    </th>
                                    <th style="color:#F00;" class='enlucido'>
                                        Enlucido
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($formula->FormulasDetalle as $forDetalle)

                                <?php
                                if (!isset($forDetalle->Producto->codigo))
                                    continue;
                                ?>
                                <tr>
                                    <td>
                                        <input class="form-control" type="text" disabled="" placeholder="Sale de base" value="{{$forDetalle->Producto->codigo}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" disabled="" placeholder="Sale de base" value="{{ $forDetalle->Producto->nombreProducto }}">
                                    </td>
                                    <td>
                                        <input class="form-control porcentaje" type="text" disabled="" placeholder="Sale de base">
                                    </td>

                                    <td>
                                        <input class="form-control cantidad" type="text" disabled="" placeholder="Sale de base"  value="{{ $forDetalle->cantidad }}">
                                    </td>

                                    <td>
                                        <input class="form-control coste" type="text" disabled="" placeholder="Sale de base" value="{{ $forDetalle->Producto->coste }}">
                                    </td>
                                    <td>
                                        <input class="form-control importe" type="text" disabled="" placeholder="Sale de base" value=" <?php echo $forDetalle->cantidad * $forDetalle->Producto->coste; ?>">
                                    </td>
                                    <td>
                                        <?php
                                        if (!isset($forDetalle->Producto->Proveedor->nombre)) {
                                            $nombre = 'n';
                                        } else {
                                            $nombre = $forDetalle->Producto->Proveedor->nombre;
                                        }
                                        ?>
                                        <input class="form-control" type="text" disabled="" placeholder="Sale de base" value="{{ $nombre }}">
                                    </td>
                                    <td>
                                        <input class="form-control voc" type="text" disabled="" placeholder="Sale de base" value="{{ $forDetalle->Producto->VOC }}">
                                    </td>
                                    <td>
                                        <input class="form-control densidad" type="text" disabled="" placeholder="Sale de base" value="{{ $forDetalle->Producto->densidad }}">
                                    </td>
                                    <td>
                                        <input class="form-control vocIndividual" type="text" disabled="" placeholder="Sale de base" value="">
                                    </td>
                                    <td class='enlucido'>
                                        <input class="form-control" type="text" disabled="" placeholder="Sale de base" value="{{ $forDetalle->enlucido }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        Equivalencias, seleccionar.
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="hidden-xs" style="width:40px;">

                                    </th>
                                    <th>
                                        Nombre equivalencia
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formula->FormulasEquivalencia as $formEq)
                                <tr>
                                    <td style="padding:15px; text-align:right;">
                                        <input type="checkbox" class="eq-checked" <?php echo ($formEq->display) ? 'checked=""' : ''; ?> value="{{$formEq->id}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" disabled="" value="{{$formEq->equivalencia}}" placeholder="Sale de base">
                                    </td>
                                </tr>


                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET SEGUNDA-->
        </div>
    </div>

    <!-- END PAGE CONTENT-->
    @stop

    @section('scripts')
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>
    <script src="assets/plugins/excanvas.min.js"></script> 
    <![endif]-->
    <script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{ url('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ url('assets/scripts/core/app.js') }}"></script>
    <script src="{{ url('assets/scripts/custom/components-form-tools.js') }}"></script>
    <script src="{{ url('assets/scripts/custom/components-pickers.js') }}"></script>
    <script src="{{ url('assets/scripts/custom/form-samples.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{ url('assets/js/aplicationShare.js') }}"></script>
    <script>
    jQuery(document).ready(function () {
        // initiate layout and plugins
        App.init();
        FormSamples.init();
        $('#recalcular').click(function () {
        var cantProduccion = parseFloat($('#cantPorduccion').val());
        $('.enlaces_print').each(function () {
            var link = $(this).attr('href');
            console.log(link);
            var slices = link.split("/");
            console.log(slices);
            $(this).attr('href', 'http://' + slices[2] + '/' + slices[3] + '/' + slices[4] + '/' + cantProduccion);
        });
        var totCant = 0;
        $('.cantidad').each(function () {
            if($(this).val().length)
                totCant += parseFloat($(this).val());

        });
        //console.log(totCant);
        var valorPromedio = cantProduccion.toFixed(2) / totCant.toFixed(2);
        //console.log(valorPromedio);
        $('.cantidad').each(function () {
            //SET CANTIDAD
            if($(this).val().length)
                $(this).val(parseFloat($(this).val()) * valorPromedio);
            //console.log($(this).val());
        });
        calcular();
        return false;
    });
    function calcular() {
        var totCant = importeTot = totDensidad = totVocInd = 0;
        $('.cantidad').each(function () {
            if($(this).val().length)
                totCant += parseFloat($(this).val());


        });
		totCant=totCant.toFixed(4);
        console.log('totCant' +totCant);
        $('.cantidad').each(function () {
            console.log(' - ');
            if(!$(this).val().length)
                return;
            $parent = $(this).parent().parent();
            totDensidad += parseFloat($parent.find('.densidad').val());
            console.log('totDensidad');
            console.log(totDensidad);
            if(isNaN()){
                console.log($parent.find('.densidad'));
                console.log($parent.find('.densidad').val());
            }
            //SET IMPORTE
            var importe = parseFloat($(this).val()) * parseFloat($parent.find('.coste').val());
            importe=importe.toFixed(4);
            console.log('importe' +importe);
            $parent.find('.importe').val(importe);
            importeTot += parseFloat(importe);
            console.log('importeTot' +importeTot);
            //SET PORCENTAJE
            $parent.find('.porcentaje').val(calcularPorcentaje($(this), totCant));
            //SET VOC INDIVIDUAL
            totVocInd += calcularVocIndividual($parent.find('.voc'), $(this), $parent.find('.densidad'), $parent.find('.vocIndividual'));
            console.log('totVocInd' +totVocInd);

        });
        importeTot = importeTot.toFixed(4);
        console.log('importeTot' + importeTot);
        //SET VOC TOTALES FORMULA
        var volFormula = totCant / parseInt($('#densidad-val').text());
        console.log('volFormula' + volFormula);
        console.log('totDensidad' + totDensidad);
        console.log('totCant' + totCant);

        var vocTotales = totVocInd / volFormula;

        console.log('vocTotales' + vocTotales);
        console.log('totVocInd' + totVocInd);
		
        $('.vocTotales').val((vocTotales/1000).toFixed(2));
        $('.importeTotal').val(importeTot);
        $('.pesoTotal').val(totCant);
        $('.precioXkg').val((importeTot / totCant).toFixed(4));
        return false;
    }
        calcular();


        $('.eq-checked').click(function () {
            var $id = $(this).val();
            var $val = $(this).attr('checked') ? '1' : '0';
            $.ajax({
                type: "POST",
                url: "{{ URL::to('equivalencia-display') }}",
                data: {
                    "_token": '{{ Form::token() }}',
                    "id": $id,
                    "val": $val

                },
                success: function (data) {
                    //console.log(data);
                },
                dataType: 'json'
            });
        });

        $('#print-base, #print-ma').click(function (e) {
            e.preventDefault();
            var size = $('#grande').attr('checked') ? 'g' : 'p';
            var href = $(this).attr('href') + '/' + size;
            //window.location = href,'_blank';
            window.open(href, '_blank');

        });




    });
    </script>
    @stop                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        