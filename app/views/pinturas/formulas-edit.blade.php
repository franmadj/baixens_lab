@extends('layouts.base')

@section('content')
<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/tabbable.js') }}"></script>
<script>
jQuery(document).ready(function($){
$(document).keypress(function(event){
var key = event.key || event.which || event.keyCode;
//var key=event.which;l('numero: '+key);

if (key == 'PageDown'){
event.preventDefault();
event.stopPropagation();
$.tabNext();
return false;
}
});
});</script>

<style>

    .extra-campos th, .extra-campos td {
        border: solid thin #ccc;
        padding: 5px 10px;
        font-size: 14px;
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
                <a  href="{{URL::to('pinturas')}}" class="btn blue">
                    <span> Ver Pinturas </span>
                </a>
            </li>
            <li>
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Pinturas
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Editar Pintura
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
                    Editar Pintura
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                @if(Session::has('mensaje'))
                <div class="col-md-12 success-validation" >{{Session::get('mensaje')}}</div>
                @else
                
                @endif
                <div class="col-md-12 error-validation" ></div>
                <hr>
                <h4>Editar Pintura</h4>


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

                <div class="col-md-12" style="padding:0px; margin-bottom:5px;">
                    <div class="col-md-4" style="padding:0px;">
                        <input type="number" class="form-control text-center" id="cantPorduccion" placeholder="Cantidad de producción">
                    </div>
                    <div class="col-md-2" style="padding:0px;">
                        <a class="btn green fullButton" id="recalcular">Recalcular</a>
                    </div>
                    <div class="col-md-2" style="padding:0px;">
                        <a class="btn blue fullButton" id="restablecer" >Restablecer</a>
                    </div>
                    <div class="col-md-2" style="padding:0px;">
                        <a class="btn red fullButton enlaces_print" id="imprimir" target="_blank" href="{{URL::to('pdf-pintura')}}/{{ $formula->id  }}/0">Imprimir</a>
                    </div>
                    <div class="col-md-2" style="padding:0px;">
                        <a class="btn purple fullButton" id="duplicar" onclick="return confirm('Deseas duplicar esta pintura?')" href="{{URL::to('duplicar-pintura')}}/{{ $formula->id  }}">Duplicar</a>
                    </div>
                    <div class="col-md-6" style="padding:0px;">
                        <h3><small>Nombre Pintura: </small>{{ $formula->nombre  }}</h3>
                    </div>
                    <div class="col-md-6 text-right" style="padding:0px;">
                        <h3><small>Nº Pintura:</small> {{ $formula->numero_pintura  }}</h3>
                    </div>

                </div>




                <form class="form-horizontal" method="post" id="formula_form" role="form" action="{{ URL::to('add-pintura') }}">
                    <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                    {{ isset( $formula->id) ? '<input type="hidden" name="id"  value="'.$formula->id.'"/>': ''  }}
                    {{ Form::token() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Nombre Pintura</label>
                                <div class="col-md-10">
                                    <input tabindex="2" type="text" class="form-control nombre-fomula" name="nombre"  
                                           {{ isset($formula->nombre)? 'value="'.$formula->nombre.'"': ''  }} placeholder="Insertar nombre de formula">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">NºPintura</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ $formula->numero_pintura  }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">NºFormula</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ $formula->numero  }}
                                    </p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Fecha de creación</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ isset($formula->fecha)? $formula->fecha: ''  }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Fecha última modificación</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">
                                        {{ isset($formula->fechaUltEdicion)? $formula->fechaUltEdicion: ''  }}
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Ajustar a:</label>
                                <div class="col-md-10">
                                    <input tabindex="3" id="ajustar_a" type="numeric" class="form-control"  name="pintura_ajustar_a" 
                                           {{ isset($formula->pintura_ajustar_a)? 'value="'.$formula->pintura_ajustar_a.'"': ''  }} placeholder="Insertar ajustar a">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label col-md-2">Tipo</label>
                                <div class="col-md-4">

                                    {{ Form::select('pintura_tipo', $tipos, $formula->pintura_tipo,  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'3') ) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Estado Pintura</label>
                                <div class="col-md-4">


                                    {{ Form::select('pintura_estado', $estados, $formula->pintura_estado,  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'4') ) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Descripción</label>
                                <div class="col-md-4">

                                    <textarea name="descripcion" class="form-control" tabindex="5">{{ isset($formula->descripcion)? $formula->descripcion: ''  }} </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">I.T.:</label>
                                <div class="col-md-4">

                                    <textarea name="instrucciones" class="form-control" tabindex="6">{{ isset($formula->instrucciones)? $formula->instrucciones : ''  }} </textarea>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="control-label col-md-2">Sección</label>
                                <div class="col-md-4">

                                    {{ Form::select('secciones', $secciones, $formula->idSeccionFormula,  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'1') ) }}
                                </div>
                            </div>


                        </div>


                        <div class="col-md-12" >


                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Equivalencia formula</label>
                                <div class="col-md-4">
                                    <input tabindex="5" type="text" class="form-control" name="equivalencia-1" {{ (Input::old('equivalencia-1')) ? 'value="'.Input::old('equivalencia-1').'"' : '' }}{{ isset($equivalencias['equivalencia1'])? 'value="'.$equivalencias['equivalencia1'].'"': ''  }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" tabindex="6" class="form-control" name="codigo-1"  {{ (Input::old('codigo-1')) ? 'value="'.Input::old('codigo-1').'"' : '' }}{{ isset($equivalencias['codigo1'])? 'value="'.$equivalencias['codigo1'].'"': ''  }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="7" type="text" class="form-control" name="equivalencia-2"  {{ (Input::old('equivalencia-2')) ? 'value="'.Input::old('equivalencia-2').'"' : '' }}{{ isset($equivalencias['equivalencia2'])? 'value="'.$equivalencias['equivalencia2'].'"': ''  }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="8" type="text" class="form-control" name="codigo-2"  {{ (Input::old('codigo-2')) ? 'value="'.Input::old('codigo-2').'"' : '' }}{{ isset($equivalencias['codigo2'])? 'value="'.$equivalencias['codigo2'].'"': ''  }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="9" type="text" class="form-control" name="equivalencia-3"  {{ (Input::old('equivalencia-3')) ? 'value="'.Input::old('equivalencia-3').'"' : '' }}{{ isset($equivalencias['equivalencia3']) ? 'value="'.$equivalencias['equivalencia3'].'"': ''  }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="10" type="text" class="form-control" name="codigo-3"  {{ (Input::old('codigo-3')) ? 'value="'.Input::old('codigo-3').'"' : '' }}{{ isset($equivalencias['codigo3'])? 'value="'.$equivalencias['codigo3'].'"': ''  }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="11" type="text" class="form-control" name="equivalencia-4"  {{ (Input::old('equivalencia-4')) ? 'value="'.Input::old('equivalencia-4').'"' : '' }}{{ isset($equivalencias['equivalencia4'])? 'value="'.$equivalencias['equivalencia4'].'"': ''  }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="12" type="text" class="form-control" name="codigo-4"  {{ (Input::old('codigo-4')) ? 'value="'.Input::old('codigo-4').'"' : '' }}{{ isset($equivalencias['codigo4'])? 'value="'.$equivalencias['codigo4'].'"': ''  }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="13" type="text" class="form-control" name="equivalencia-5"  {{ (Input::old('equivalencia-5')) ? 'value="'.Input::old('equivalencia-5').'"' : '' }}{{ isset($equivalencias['equivalencia5'])? 'value="'.$equivalencias['equivalencia5'].'"': ''  }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="14" type="text" class="form-control" name="codigo-5"  {{ (Input::old('codigo-5')) ? 'value="'.Input::old('codigo-5').'"' : '' }}{{ isset($equivalencias['codigo5'])? 'value="'.$equivalencias['codigo5'].'"': ''  }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>




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
                                                VOC totales (g/l)
                                            </th>
                                            <th>
                                                VOC pesado totales (g/l)
                                            </th>
                                            <th>
                                                VOC teorico totales (g/l)
                                            </th>

                                            <th>
                                                Peso
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control vocTotales" type="text" disabled="" placeholder="Sale de calculo">
                                            </td>
                                            
                                            <td>
                                                <input class="form-control vocTotalesP" type="text" disabled="" placeholder="Sale de calculo">
                                            </td>
                                            
                                            <td>
                                                <input class="form-control vocTotalesT" type="text" disabled="" placeholder="Sale de calculo">
                                            </td>


                                            <td>
                                                <input class="form-control pesoTotal" type="text" disabled="" placeholder="Sale de calculo">
                                            </td>


                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <hr>


                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Código
                                        </th>
                                        <th>
                                            Cantidad pesada
                                        </th>
                                        <th>
                                            Producto
                                        </th>



                                        <th>
                                            Tipo
                                        </th>
                                        <th>
                                            % teorico
                                        </th>
                                        <th class="resaltar">
                                            Cantidad teorica
                                        </th>

                                        <th>
                                            % Pesado
                                        </th>
                                        <th>
                                            Aportación Precio Teórica
                                        </th>
                                        <th><button type="button" id="uno-mas" class="btn green" tabindex="-1">+</button>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="append" >

                                    {{$detalles}}




                                </tbody>

                                <tbody>

                                    <tr>
                                        <td >
                                            Total
                                        </td>
                                        <td>
                                            <input class="form-control cantidad_pesada_total" readonly value="{{$totCant}}">
                                        </td>
                                        <td >


                                        </td>

                                        <td>

                                        </td>


                                        <td>
                                            <input class="form-control porcentaje_teorico_total" readonly value="{{$totPorT}}">
                                        </td>
                                        <td>
                                            <input class="form-control cantidad_teorica_total" readonly value="{{$totCantTeorica}}">
                                        </td>


                                        <td>

                                        </td>
                                        <td class="product_values">


                                        </td>

                                        <td class="boton text-right" colspan="10"></td>

                                    </tr>




                                </tbody>

                            </table>


                        </div>
                    </div>


                    @include('layouts/extra-campos')                    


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
                            jQuery(document).ready(function() {
// initiate layout and plugins
                            App.init();
                            ComponentsFormTools.init();
                            ComponentsPickers.init();
                            FormSamples.init();
                            });</script>
<!-- BEGIN GOOGLE RECAPTCHA -->
<script type="text/javascript">
    var RecaptchaOptions = {
    theme : 'custom',
            custom_theme_widget: 'recaptcha_widget'
    };</script>
<!-- END JAVASCRIPTS -->


<script >
    var cant = Array();
    var getCosteProducto = "{{ URL::to('get-coste-producto') }}";
    var getCodigoProducto = "{{ URL::to('get-product-code-by-id') }}";
    var noAutoPopulateTipo = false;
    @if (Session::has('noAutoPopulateTipo'))
            noAutoPopulateTipo = true;
    @endif

            editando = true;
    $('#recalcular').click(function() {
    var cantProduccion = parseFloat($('#cantPorduccion').val());
    if (isNaN(cantProduccion)) {
    alert('Añade cantidad de producción valida');
    return false;
    }
    $('.enlaces_print').each(function() {
    var link = $(this).attr('href');
    var slices = link.split("/");
    $(this).attr('href', 'http://' + slices[2] + '/' + slices[3] + '/' + slices[4] + '/' + cantProduccion);
    });
    var totCant = sumatorioElemento($, '.cantidad_pesada');
    if (totCant == 0)
            return;
    $('#restablecer').data('original', totCant);
    //l(totCant);
    var valorPromedio = cantProduccion / totCant;
    //l(valorPromedio);
    $('.new-rows').find('.cantidad_pesada').each(function() {
    //SET CANTIDAD
    if ($(this).val().length) {
    var newCant = parseFloat($(this).val()) * valorPromedio;
    $(this).data('val', newCant).val(newCant.toFixed(4));
    }
    });
    $('.new-rows').find('.cantidad_pesada').blur();
    //calcularPinturas();
    return false;
    });
    $('#restablecer').click(function() {
    var pesoTotal = $(this).data('original');
    l(pesoTotal);
    if (typeof pesoTotal != 'undefined') {
    $('#cantPorduccion').val(pesoTotal);
    $('#recalcular').click();
    }
    });
    $('.eq-checked').click(function() {
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
            success: function(data) {
            //l(data);
            },
            dataType: 'json'
    });
    });
    @if (Session::has('filasDeMas'))
            jQuery('#filasDeMas').val({{Session::get('filasDeMas')}});
    @endif

</script>

<script src="{{ url('assets/js/add-pinturas.js') }}"></script>
<script>




</script>


@stop