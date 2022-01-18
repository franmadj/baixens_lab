@extends('layouts.base')

@section('content')
<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/tabbable.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    $(document).keypress(function (event) {
        var key = event.key || event.which || event.keyCode;
        //var key=event.which;console.log('numero: '+key);
        console.log('numero: ' + key);
        if (key == 'PageDown') {
            event.preventDefault();
            event.stopPropagation();
            $.tabNext();
            return false;
        }
    });
});</script>




<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Baixens <small>aplicación formulación</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li class="btn-group">
                <a  href="{{URL::to('sate')}}" class="btn blue">
                    <span> Ver sate </span>
                </a>
            </li>
            <li>
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Sate
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Añadir Sate
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
                    Añadir Sates
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
                <h4>Nuevo Sate</h4>


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
                        <a class="btn red fullButton enlaces_print" id="imprimir" target="_blank" href="{{URL::to('pdf-sate')}}/{{ $formula->id  }}/0">Imprimir</a>
                    </div>

                    <div class="col-md-6" style="padding:0px;">
                        <h3><small>Nombre Pintura: </small>{{ $formula->nombre  }}</h3>
                    </div>

                </div>

                <form class="form-horizontal" method="post" id="formula_form" role="form" action="{{ URL::to('add-sate') }}">
                    <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                    {{ isset( $formula->id) ? '<input type="hidden" name="id"  value="'.$formula->id.'"/>': ''  }}
                    {{ Form::token() }}





                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">NºSate</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                {{$formula->numero_sate}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Fecha de creación</label>
                        <div class="col-md-10">
                            <p class="form-control-static">
                                {{$formula->fecha}}
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre sate</label>
                        <div class="col-md-10">
                            <input tabindex="2" type="text" class="form-control" name="nombre"  {{ (Input::old('nombre')) ? 'value="'.Input::old('nombre').'"' : '' }}
                                   {{ isset($formula->nombre)? 'value="'.$formula->nombre.'"': ''  }}placeholder="Insertar nombre de sate">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Código Sate</label>
                        <div class="col-md-10">
                            <input tabindex="3" id="codigo" type="text" class="form-control"  name="codigo" {{ (Input::old('codigo')) ? 'value="'.Input::old('codigo').'"' : '' }} 
                                   {{ isset($formula->codigo)? 'value="'.$formula->codigo.'"': ''  }} placeholder="Insertar codigo de sate">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Descripción</label>
                        <div class="col-md-10">
                            <textarea tabindex="4" class="form-control" name="descripcion" rows="3">{{ (Input::old('descripcion')) ? Input::old('descripcion') : '' }}{{ isset($formula->descripcion)? $formula->descripcion : ''  }} </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">I.T.;</label>
                        <div class="col-md-10">

                            <textarea name="instrucciones" class="form-control" tabindex="4">{{ (Input::old('instrucciones')) ? Input::old('instrucciones') : '' }}{{ isset($formula->instrucciones)? $formula->instrucciones : ''  }} </textarea>
                        </div>
                    </div>


                    <div class="form-group">

                        <?php
                        if (Input::old('densidad')) {
                            $densidad_val = 'value="' . Input::old('densidad') . '"';
                        } else {
                            $densidad_val = 'value="0.0"';
                        }
                        ?>


                        <label for="inputEmail1" class="col-md-2 control-label">Densidad (g/l)</label>
                        <div class="col-md-10">
                            <input type="text" tabindex="5" name="densidad"  {{ $densidad_val }} class="form-control"  placeholder="Insertar densidad (g/l)">
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
                                        <th><button type="button" id="uno-mas" class="btn green" tabindex="-1">+</button>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="append" >

                                   {{$detalles}}




                                </tbody>
                            </table>
                            <img class="loader" style="display: block; margin: auto; margin-top: 80px;" src="{{ url('assets/img/ajax-loading.gif') }}">
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success" id="enviar_formula" tabindex="19">Aceptar</button>
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


<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function () {
// initiate layout and plugins
    App.init();
    ComponentsFormTools.init();
    ComponentsPickers.init();
    FormSamples.init();
});</script>
<!-- BEGIN GOOGLE RECAPTCHA -->
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'custom',
        custom_theme_widget: 'recaptcha_widget'
    };</script>
<!-- END JAVASCRIPTS -->


<script type="text/javascript">
    var getCosteProducto = "{{ URL::to('get-coste-producto') }}";
    var cant = Array();
    editando = true;
    



    $('#recalcular').click(function () {
        var cantProduccion = parseFloat($('#cantPorduccion').val());
        if (isNaN(cantProduccion)) {
            alert('Añade cantidad de producción valida');
            return false;

        }
        $('.enlaces_print').each(function () {
            var link = $(this).attr('href');
            var slices = link.split("/");
            $(this).attr('href', 'http://' + slices[2] + '/' + slices[3] + '/' + slices[4] + '/' + cantProduccion);
        });
        var totCant = sumatorioElemento($, '.cantidad');
        if (totCant == 0)
            return;
        $('#restablecer').data('original', totCant);


        //console.log(totCant);
        var valorPromedio = cantProduccion / totCant;
        //console.log(valorPromedio);
        $('.new-rows').find('.cantidad').each(function () {
            //SET CANTIDAD
            if ($(this).val().length) {
                var newCant = parseFloat($(this).val()) * valorPromedio;
                $(this).data('val', newCant).val(newCant.toFixed(4));
            }
        });
        $('.new-rows').find('.cantidad').blur();
        //calcularPinturas();
        return false;
    });

    $('#restablecer').click(function () {
        var pesoTotal = $(this).data('original');
        if (typeof pesoTotal != 'undefined') {
            $('#cantPorduccion').val(pesoTotal);
            $('#recalcular').click();
        }
    });


</script>
<script src="{{ url('assets/js/aplicationShare.js') }}"></script>
<script src="{{ url('assets/js/add-formulas_n.js') }}"></script>


@stop