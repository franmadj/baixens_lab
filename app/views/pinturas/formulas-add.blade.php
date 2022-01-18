@extends('layouts.base')

@section('content')
<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/tabbable.js') }}"></script>
<script>
jQuery(document).ready(function($){
$(document).keypress(function(event){
var key = event.key || event.which || event.keyCode;
//var key=event.which;console.log('numero: '+key);
console.log('numero: ' + key);
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
                    Añadir formulas
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                @if(Session::has('mensaje'))
                <div class="col-md-12" >{{Session::get('mensaje')}}</div>
                @else
                <div class="col-md-12 error-validation" ></div>
                @endif
                <hr>
                <h4>Nueva Pintura</h4>

                <form class="form-horizontal" method="post" id="formula_form" role="form" action="{{ URL::to('add-pintura') }}">
                    <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                    {{ Form::token() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Nombre formula</label>
                                <div class="col-md-10">
                                    <input tabindex="2" type="text" class="form-control nombre-fomula" name="nombre"  {{ (Input::old('nombre')) ? 'value="'.Input::old('nombre').'"' : '' }} placeholder="Insertar nombre de formula">
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
                                <label for="inputEmail1" class="col-md-2 control-label">Ajustar a:</label>
                                <div class="col-md-10">
                                    <input tabindex="3" id="ajustar_a" type="numeric" class="form-control"  name="pintura_ajustar_a" {{ (Input::old('pintura_ajustar_a')) ? 'value="'.Input::old('pintura_ajustar_a').'"' : '' }} placeholder="Insertar ajustar a">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="control-label col-md-2">Tipo</label>
                                <div class="col-md-4">

                                    {{ Form::select('pintura_tipo', $tipos, Input::old('pintura_tipos'),  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'3') ) }}
                                </div>
                            </div>

                            
                            
                            <div class="form-group">
                                <label class="control-label col-md-2">Estado Fórmula</label>
                                <div class="col-md-4">
                                    Desarrollo
                                    <input type="hidden" name="pintura_estado" value="desarrollo">

                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Descripción</label>
                                <div class="col-md-4">

                                    <textarea name="descripcion" class="form-control" tabindex="5">{{ (Input::old('pintura_descripcion')) ? Input::old('pintura_descripcion') : '' }} </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">I.T.:</label>
                                <div class="col-md-4">

                                    <textarea name="instrucciones" class="form-control" tabindex="6">{{ (Input::old('instrucciones')) ? Input::old('instrucciones') : '' }} </textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2">Sección</label>
                                <div class="col-md-4">

                                    {{ Form::select('secciones', $secciones, Input::old('secciones'),  array('class'=>'select2_category form-control', 'id'=>'secciones', 'tabindex'=>'1') ) }}
                                </div>
                            </div>

                        </div>


                        <div class="col-md-12" >






                            <div class="form-group">
                                <label for="inputEmail1" class="col-md-2 control-label">Equivalencia formula</label>
                                <div class="col-md-4">
                                    <input tabindex="5" type="text" class="form-control" name="equivalencia-1" {{ (Input::old('equivalencia-1')) ? 'value="'.Input::old('equivalencia-1').'"' : '' }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="6" type="text" class="form-control" name="codigo-1"  {{ (Input::old('codigo-1')) ? 'value="'.Input::old('codigo-1').'"' : '' }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="7" type="text" class="form-control" name="equivalencia-2"  {{ (Input::old('equivalencia-2')) ? 'value="'.Input::old('equivalencia-2').'"' : '' }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="8" type="text" class="form-control" name="codigo-2"  {{ (Input::old('codigo-2')) ? 'value="'.Input::old('codigo-2').'"' : '' }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="9" type="text" class="form-control" name="equivalencia-3"  {{ (Input::old('equivalencia-3')) ? 'value="'.Input::old('equivalencia-3').'"' : '' }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="10" type="text" class="form-control" name="codigo-3"  {{ (Input::old('codigo-3')) ? 'value="'.Input::old('codigo-3').'"' : '' }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="11" type="text" class="form-control" name="equivalencia-4"  {{ (Input::old('equivalencia-4')) ? 'value="'.Input::old('equivalencia-4').'"' : '' }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="12" type="text" class="form-control" name="codigo-4"  {{ (Input::old('codigo-4')) ? 'value="'.Input::old('codigo-4').'"' : '' }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="13" type="text" class="form-control" name="equivalencia-5"  {{ (Input::old('equivalencia-5')) ? 'value="'.Input::old('equivalencia-5').'"' : '' }}  placeholder="Equivalencia">
                                </div>
                                <div class="col-md-4">
                                    <input tabindex="14" type="text" class="form-control" name="codigo-5"  {{ (Input::old('codigo-5')) ? 'value="'.Input::old('codigo-5').'"' : '' }}  placeholder="Código">
                                </div>
                                <div class="col-md-2">
                                </div>
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

                                    <tr id="aClonar" style="display:none;">
                                        <td class="td_codigo">
                                            <input name="det-codigo-1" id="codigo-1" {{ (Input::old('det-codigo-1')) ? 'value="'.Input::old('det-codigo-1').'"' : '' }} class="form-control codigo" type="text"  placeholder="Sale de calculo" tabindex="15">
                                        </td>
                                        <td class="td_cantidad">
                                            <input tabindex="16" name="det-cantidad-1" {{ (Input::old('det-cantidad-1')) ? 'value="'.Input::old('det-cantidad-1').'"' : '' }}  type="text" class="form-control cantidad_pesada"  placeholder="Cantidad pesada">
                                        </td>
                                        <td class="td_prod">
                                            {{ Form::select('det-producto-1', $productoName, Input::old('det-producto-1'), array('class'=>'select2_category form-control producto', 'sar'=>'det-prod-1', 'tabindex'=>'17', 'id'=>'det-producto-1', 'readonly'=>true) ) }}

                                        </td>


                                        <td class="tipos">
                                            {{ Form::select('det-tipo-1', $tipoProductos, Input::old('det-tipo-1'), array('class'=>' form-control tipo', 'tabindex'=>'18')) }}
                                        </td>
                                        <td>
                                            <input name="det-porcentaje_teorico-1" id="porcentaje_teorico-1" {{ (Input::old('det-porcentaje_teorico-1')) ? 'value="'.Input::old('det-porcentaje_teorico-1').'"' : '' }} class="form-control porcentaje_teorico" type="text" tabindex="-1">
                                        </td>
                                        <td>
                                            <input name="det-cantidad_teorica-1" id="cantidad_teorica-1" {{ (Input::old('det-cantidad_teorica-1')) ? 'value="'.Input::old('det-cantidad_teorica-1').'"' : '' }} class="form-control cantidad_teorica" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1">
                                        </td>

                                        <td>
                                            <input name="det-porcentaje_pesado-1" id="porcentaje_pesado-1" {{ (Input::old('det-porcentaje_pesado-1')) ? 'value="'.Input::old('det-porcentaje_pesado-1').'"' : '' }} class="form-control porcentaje_pesado" type="text" readonly="" placeholder="Sale de base" tabindex="-1">
                                        </td>
                                        <td class="product_values">
                                            <input name="det-aportacion_precio_teorico-1" id="aportacion_precio_teorico-1" {{ (Input::old('det-aportacion_precio_teorico-1')) ? 'value="'.Input::old('det-aportacion_precio_teorico-1').'"' : '' }} class="form-control aportacion_precio_teorico" type="text" readonly="" placeholder="Sale de base" tabindex="-1">

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


            @if (Session::has('cantidad_pesada'))
    {{Session::get('cantidad_pesada')}}
    @endif

            @if (Session::has('codigo'))
    {{Session::get('codigo')}}
    @endif


            @if (Session::has('densidad'))
    {{Session::get('densidad')}}
    @endif
            @if (Session::has('tipo'))
    {{Session::get('tipo')}}
    @endif
            @if (Session::has('porcentaje_teorico'))
    {{Session::get('porcentaje_teorico')}}
    @endif
            @if (Session::has('filasDeMas'))
            jQuery('#filasDeMas').val({{Session::get('filasDeMas')}});
    @endif

</script>
<script src="{{ url('assets/js/aplicationShare.js') }}"></script>
<script src="{{ url('assets/js/add-pinturas.js') }}"></script>
<script>




</script>


@stop