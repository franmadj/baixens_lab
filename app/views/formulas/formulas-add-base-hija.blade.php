@extends('layouts.base')

@section('content')

<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/tabbable.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    $(document).keypress(function (event) {
        var key = event.key || event.which || event.keyCode;
        //var key=event.which;console.log('numero: '+key);

        if (key == 'PageDown') {
            event.preventDefault();
            event.stopPropagation();
            $.tabNext();
            return false;
        }
    });
});
</script>

<style>

    .enlucido-fields{
        display:none;
    }


</style>


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
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Formulas
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Añadir formula
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->

<div class="row ">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Añadir formulas Base
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                {{ isset($mensaje) ? '<div class="col-md-12" >'.$mensaje.'</div>': ''  }}

                <hr>





                <div class="col-md-12" style="padding:0px; margin-bottom:5px;">

                    <div class="col-md-6" style="padding:0px;">
                        <h3><small>Nombre formula base: </small>{{ $formula->nombre  }}</h3>
                    </div>
                    <div class="col-md-6 text-right" style="padding:0px;">
                        <h3><small>Nº formula base:</small> {{ $formula->numero  }}</h3>
                    </div>

                </div>






                <form class="form-horizontal" method="post" id="formula_form" role="form" action="{{ URL::to('add-formula-base-hija') }}">
                    <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">

                    {{ isset( $formula->id) ? '<input type="hidden" name="parent_id"  value="'.$formula->id.'"/>': ''  }}
                    {{ Form::token() }}

                    <div class="form-group">
                        <label class="control-label col-md-2">Sección</label>
                        <div class="col-md-4">
                            <p class="form-control-static">
                                Base Coloreada
                            </p>


                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">NºFormula</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                Correlativo automático
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Fecha de creación</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                Automático
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre formula</label>
                        <div class="col-md-10">
                            <input tabindex="2" type="text" class="form-control" name="nombre"   {{ isset($old['nombre']) ? 'value="'.$old['nombre'].'"': ''  }} placeholder="Insertar nombre de formula">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Código formula</label>
                        <div class="col-md-10">
                            <input tabindex="3" id="codigo" type="text" class="form-control"  name="codigo" {{ isset($old['codigo']) ? 'value="'.$old['codigo'].'"': ''  }} placeholder="Insertar codigo de formula">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Descripción</label>
                        <div class="col-md-10">
                            <textarea tabindex="4" class="form-control" name="descripcion" rows="3">{{ isset($old['descripcion']) ? $old['descripcion']: ''  }} </textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                                <label class="control-label col-md-2">I.T.;</label>
                                <div class="col-md-10">

                                    <textarea name="instrucciones" class="form-control" tabindex="4">{{ isset($old['instrucciones']) ? $old['instrucciones']: ''  }} </textarea>
                                </div>
                            </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Equivalencia formula</label>
                        <div class="col-md-4">
                            <input tabindex="5" type="text" class="form-control" name="equivalencia-1" {{ isset($old['equivalencia-1']) ? 'value="'.$old['equivalencia-1'].'"': ''  }}  placeholder="Equivalencia">
                        </div>
                        <div class="col-md-4">
                            <input type="text" tabindex="6" class="form-control" name="codigo-1"  {{ isset($old['codigo-1']) ? 'value="'.$old['codigo-1'].'"': ''  }}  placeholder="Código">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="7" type="text" class="form-control" name="equivalencia-2"  {{ isset($old['equivalencia-2']) ? 'value="'.$old['equivalencia-2'].'"': ''  }}  placeholder="Equivalencia">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="8" type="text" class="form-control" name="codigo-2"  {{ isset($old['codigo-2']) ? 'value="'.$old['codigo-2'].'"': ''  }}  placeholder="Código">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="9" type="text" class="form-control" name="equivalencia-3"  {{ isset($old['equivalencia-3']) ? 'value="'.$old['equivalencia-3'].'"': ''  }}  placeholder="Equivalencia">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="10" type="text" class="form-control" name="codigo-3"  {{ isset($old['codigo-3']) ? 'value="'.$old['codigo-3'].'"': ''  }}  placeholder="Código">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="11" type="text" class="form-control" name="equivalencia-4"  {{ isset($old['equivalencia-4']) ? 'value="'.$old['equivalencia-4'].'"': ''  }}  placeholder="Equivalencia">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="12" type="text" class="form-control" name="codigo-4"  {{ isset($old['codigo-4']) ? 'value="'.$old['codigo-4'].'"': ''  }}  placeholder="Código">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="13" type="text" class="form-control" name="equivalencia-5"  {{ isset($old['equivalencia-5']) ? 'value="'.$old['equivalencia-5'].'"': ''  }}  placeholder="Equivalencia">
                        </div>
                        <div class="col-md-4">
                            <input tabindex="14" type="text" class="form-control" name="codigo-5" {{ isset($old['codigo-5']) ? 'value="'.$old['codigo-5'].'"': ''  }}  placeholder="Código">
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Densidad (g/l)</label>
                        <div class="col-md-10">
                            <input tabindex="15" type="text" name="densidad" id="densidad-val"  {{ isset($old['densidad']) ? 'value="'.$old['densidad'].'"': ''  }} class="form-control"  placeholder="Insertar densidad (g/l)">
                        </div>
                    </div>


                    <hr>

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

                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>
                                            es color
                                        </th>
                                        <th>
                                            Código
                                        </th>
                                        <th>
                                            Cantidad
                                        </th>
                                        <th>
                                            Producto
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
                                        <th>
                                        </th>


                                    </tr>
                                </thead>
                                <tbody id="append">


                                    {{$detalles}}






                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>






                    <div class="form-group">
                        <div class="col-md-12">
                            <button tabindex="19" id="enviar_formula" type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>
                <span id="token-ajax">{{ Form::token() }}</span>


            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->

@stop


@section('scripts')




<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ url('assets/plugins/respond.min.js') }}"></script>
<script src="{{ url('assets/plugins/excanvas.min.js') }}"></script> 
<![endif]-->




<script src="{{ url('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->


<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="{{ url('assets/plugins/fuelux/js/spinner.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery.input-ip-address-control-1.0.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/typeahead/handlebars.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/typeahead/typeahead.min.js') }}"></script>


<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/clockface/js/clockface.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ url('assets/scripts/core/app.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-form-tools.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-pickers.js') }}"></script>
<script src="{{ url('assets/scripts/custom/form-samples.js') }}"></script>
<script src="{{ url('assets/js/aplicationShare.js') }}"></script>


<!-- END PAGE LEVEL SCRIPTS -->
<script>
var getCosteProducto = "{{ URL::to('get-coste-producto') }}";
var getCodigoProducto = "{{ URL::to('get-product-code-by-id') }}";
var cant = {};
esBaseHija = true;
$cantidad = false;
esNewBaseHija = true;

jQuery(document).ready(function () {
    // initiate layout and plugins
    App.init();
    ComponentsFormTools.init();
    ComponentsPickers.init();
    FormSamples.init();
    var options = $('#producto-2 option');

    availableProductCodes = $.map(options, function (option) {
        return option.value;
    });

console.log('values**********************************************************************************************************************');
    console.log(availableProductCodes);
});
</script>
<!-- BEGIN GOOGLE RECAPTCHA -->
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'custom',
        custom_theme_widget: 'recaptcha_widget'
    };
</script>
<!-- END JAVASCRIPTS -->



<script src="{{ url('assets/js/aplicationShare.js') }}"></script>
<script src="{{ url('assets/js/add-formulas.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {



    });

    function calcularNewBaseHija() {

        var cantProduccion = 100;

        var totCant = 0;
        $('.cantidad-no-coloreada').each(function () {
            if ($(this).val().length)
                totCant += parseFloat($(this).data('val'));

        });
        //console.log(totCant);
        var valorPromedio = cantProduccion / totCant;
        //console.log(valorPromedio);
        $('.cantidad-no-coloreada').each(function () {
            //SET CANTIDAD
            if ($(this).val().length) {
                var newCant = parseFloat($(this).val()) * valorPromedio;
                $(this)
                        .data('val', newCant)
                        .val(newCant.toFixed(4));
            }
            //console.log($(this).val());
        });
        calcularColoreada();
        return false;
    }


    function calcularColoreada() {
        var totCant = importeTot = totDensidad = totVocInd = 0;
        $('.cantidad-no-coloreada').each(function () {
            if ($(this).val().length)
                totCant += parseFloat($(this).data('val'));


        });
        totCant = totCant;
        //console.log('totCant' + totCant);
        $('.cantidad-no-coloreada').each(function () {
            //console.log(' - ');
            if (!$(this).val().length)
                return;
            $parent = $(this).parent().parent();
            totDensidad += parseFloat($parent.find('.densidad').val());
            
            
            //SET IMPORTE
            var importe = parseFloat($(this).data('val')) * parseFloat($parent.find('.coste').val());
            importe = importe;
            
            $parent.find('.importe').val(importe.toFixed(4));
            importeTot += parseFloat(importe);
          


        });
        importeTot = importeTot;
        
        //SET VOC TOTALES FORMULA
        var volFormula = totCant / parseInt($('#densidad-val').val());
        

        var vocTotales = totVocInd / volFormula;

        


        $('.importeTotal').val(importeTot.toFixed(4));
        $('.pesoTotal').val(totCant.toFixed(4));



        //$('.precioXkg').val('importeTot: '+importeTot+' totCant: '+totCant);
        $('.precioXkg').val((importeTot / totCant).toFixed(4));


        return false;
    }

</script>

@stop