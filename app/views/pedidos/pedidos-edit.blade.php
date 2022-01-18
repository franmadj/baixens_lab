@extends('layouts.base')

@section('content')



<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Baixens <small>aplicación formulación</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li class="btn-group">
                <a  href="{{URL::to('pedidos')}}" class="btn blue">
                    <span> Ver pedidos </span>
                </a>
            </li>
            <li>
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Pedidos
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Añadir pedidos
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
                    Añadir pedidos
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                @if(Session::has('mensaje'))
                <div class="col-md-12" >{{Session::get('mensaje')}}</div>
                @endif
                <hr>
                <h4>Nuevo pedidos</h4>

                <form class="form-horizontal" role="form" method="post" action="{{ URL::to('/add-pedido') }}">
                    <input type="hidden" value="{{ $filasDeMas }}" id="filasDeMas" name="filasDeMas">
                    {{ isset( $pedido->id) ? '<input type="hidden" name="id"  value="'.$pedido->id.'"/>': ''  }}
                    {{ Form::token() }}
                    <div class="form-group">
                        <label class="control-label col-md-2">Proveedor</label>
                        <div class="col-md-4">

                            {{ Form::select('proveedores', $proveedores, $pedido->idProveedor,  array('id'=>'proveedores_select', 'class'=>'select2_category form-control', 'data-placeholder'=>'Choose a Category', 'tabindex'=>'1' )) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Fecha</label>
                        <div class="col-md-10">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                <input type="text" class="form-control" readonly name="fecha"  {{ (Input::old('fecha'))? 'value="'.Input::old('fecha').'"': '' }}{{ isset($pedido->fecha)? 'value="'.date('d-m-Y', $pedido->fecha).'"': ''  }} />
                                       <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Selecciona la fecha
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nº pedido</label>
                        <div class="col-md-10">
                            <p class="form-control-static">Número de pedido autómatico correlativo</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Envio</label>
                        <div class="radio-list col-md-10">
                            <label>
                                {{ Form::radio('envio', 'e', ($pedido->envio == 'e')) }} Envian</label>
                            <label>
                                {{ Form::radio('envio', 'r', ($pedido->envio == 'r')) }} Recogemos </label>


                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Solicitado por</label>
                        <div class="col-md-4">
                            <p class="form-control-static">Usuario logueado</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Recibido por</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="recibidoPor" {{ (Input::old('recibidoPor'))? 'value="'.Input::old('recibidoPor').'"': '' }}{{ isset($pedido->recibidoPor)? 'value="'.$pedido->recibidoPor.'"': ''  }} placeholder="Insertar persona que lo recibe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Plazo de entrega</label>
                        <div class="col-md-10">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                <input type="text" class="form-control" name="plazoEntrega" readonly {{ (Input::old('nombreProducto'))? 'value="'.Input::old('nombreProducto').'"': '' }}{{ isset($pedido->plazoEntrega)? 'value="'.date('d-m-Y', $pedido->plazoEntrega).'"': ''  }}>
                                       <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Selecciona la fecha
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Observaciones</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="observaciones">{{ isset($pedido->observaciones)? $pedido->observaciones : ''  }}</textarea>
                        </div>
                    </div>

                    <hr>


                    <div class="portlet-body">
                        <div class="table-responsive">
                            <p> Nota Fran: cuando seleciones codigo o producto el otro aparece automaticamente.</p>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Cantidad
                                        </th>
                                        <th>
                                            Formato
                                        </th>
                                        <th>
                                            Producto
                                        </th>
                                        <th>
                                            Código
                                        </th>
                                        <th>
                                            Precio
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="append">
                                    <tr id="aClonar">
                                        <td>

                                            <input type="text"  {{ (Input::old('det-cantidad-1'))? 'value="'.Input::old('det-cantidad-1').'"': '' }}{{ isset($firstRow['cantidad']) ? 'value="'.$firstRow['cantidad'].'"': ''  }} class="form-control cantidad" id="det-cantidad-1" name="det-cantidad-1" placeholder="Cantidad">
                                        </td>
                                        <td>


                                            {{ Form::select('det-formatos-1', $formatos, $firstRow['formatos'],  array('id'=>'det-formatos-1', 'class'=>'select2_catefgory form-control formatos', 'data-placeholder'=>'Choose a Category', 'tabindex'=>'1' )) }}
                                        </td>
                                        <td>

                                            {{ Form::select('det-productoName-1', $productoName, $firstRow['productoName'],  array('id'=>'det-productoName-1','class'=>'productoName select2_cdategory form-control reqAjax', 'data-placeholder'=>'Choose a Category', 'tabindex'=>'1' )) }}
                                        </td>
                                        <td>

                                            {{ Form::select('det-productoCode-1', $productoCode, $firstRow['productoName'],  array('id'=>'det-productoCode-1','class'=>'productoCode select2_cdategory form-control reqAjax', 'data-placeholder'=>'Choose a Category', 'tabindex'=>'1' )) }}
                                        </td>
                                        <td>
                                            <input {{ (Input::old('det-precio-1'))? 'value="'.Input::old('det-precio-1').'"': '' }}{{ isset($firstRow['precio']) ? 'value="'.$firstRow['precio'].'"': ''  }} class="form-control precio" type="text" readonly placeholder="Precio" name='det-precio-1' id="det-precio-1">
                                        </td>
                                        <td class="boton text-right" colspan="5"><button type="button" id="uno-mas" class="btn green">+</button></td>

                                    </tr>
<!--								<tr class='boton'>
                                            <td class="boton text-right" colspan="5"><button type="button" id="uno-mas" class="btn green">+</button></td>
                                    </tr>-->
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Aceptar</button>
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



<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
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


<script >
    jQuery(document).ready(function ($) {
        
        $('#proveedores_select').change(function () {
            var val = $(this).val();
            var $this = $(this);
            $.ajax({
                type: "POST",
                url: "{{ URL::to('get-product-by-proveedor') }}",
                data: {
                    "_token": $('#token-ajax').find('input').val(),
                    "idProv": val

                },
                success: function (data) {
                    console.log(data);

                    //{"427":"ADDISLIP 2000 WL(orientativo)","560":"GELTIX PU 500 (NO PEDIR)"}
                    $('.productoName').html($("<option>").attr('value', '').text('Productos'));
                    for (var p in data) {
                        console.log(data[p]);
                        $('.productoName').append($("<option>").attr('value', p).text(data[p]));
                    }

                },
                dataType: 'json'
            });


            $.ajax({
                type: "POST",
                url: "{{ URL::to('get-product-code-by-proveedor') }}",
                data: {
                    "_token": $('#token-ajax').find('input').val(),
                    "idProv": val

                },
                success: function (data) {
                    console.log(data);

                    //{"427":"ADDISLIP 2000 WL(orientativo)","560":"GELTIX PU 500 (NO PEDIR)"}
                    $('.productoCode').html($("<option>").attr('value', '').text('Productos'));
                    for (var p in data) {
                        console.log(data[p]);
                        $('.productoCode').append($("<option>").attr('value', p).text(data[p]));
                    }

                },
                dataType: 'json'
            });


        });
        $('#proveedores_select').change();
        
        
        

        $('body').on('change', '.reqAjax', function () {
            var val = $(this).val();
            var $this = $(this);
            // ajax post method to pass form data to the 

            $.ajax({
                type: "POST",
                url: "{{ URL::to('get-coste-producto') }}",
                data: {
                    "_token": $('#token-ajax').find('input').val(),
                    "idProd": val

                },
                success: function (data) {

                    $this.parent().parent().find('.precio').val(data.coste);
                    $this.parent().parent().find('.reqAjax').val(val);
                },
                dataType: 'json'
            });

            return false;
        });

        var aClonar;
        var desc = Array();
        var prevButton = Array();
        function addClon(pos) {
            jQuery('#filasDeMas').val(pos - 1);
            aClonar.removeAttr('id');

            aClonar.find('.cantidad').attr('name', 'det-cantidad-' + pos).attr('id', 'det-cantidad-' + pos).val('');
            aClonar.find('.formatos').attr('name', 'det-formatos-' + pos).attr('id', 'det-formatos-' + pos);
            aClonar.find('.productoName').attr('name', 'det-productoName-' + pos).attr('id', 'det-productoName-' + pos);
            aClonar.find('.productoCode').attr('name', 'det-productoCode-' + pos).attr('id', 'det-productoCode-' + pos);
            aClonar.find('.precio').attr('name', 'det-precio-' + pos).attr('id', 'det-precio-' + pos).val('');

            if (prevButton[pos - 1])
                prevButton[pos - 1].css('display', 'none');
            var boton = $('<button/>',
                    {
                        text: '-',
                        class: 'btn red',
                        type: "button",
                        click: function () {
                            if (prevButton[pos - 1])
                                prevButton[pos - 1].css('display', 'inherit');
                            jQuery(this).parent().parent().remove();
                            numFilas = parseInt(jQuery('#filasDeMas').val());
                            jQuery('#filasDeMas').val(numFilas - 1);
                            return false;
                        }
                    });
            prevButton[pos] = boton;
            aClonar.find('.boton').html(boton);
            // jQuery('#aClonar').after(aClonar);
            jQuery("#append").append(aClonar);
        }


        var cant = Array();

        {{isset($cant) ? $cant : ''}}
        {{ isset($productoNameR) ? $productoNameR : ''}}
        {{ isset($productoNameRFr) ? $productoNameRFr : ''}}
        {{isset($formato) ? $formato : '' }}
        {{ isset($precio) ? $precio : '' }}




        var filasDeMas = parseInt(jQuery('#filasDeMas').val());





        var numFilas = 1 + filasDeMas;
        //var numCodig = {$numCodig};
        $('#uno-mas').click(function () {
            aClonar = $('#aClonar').clone();
            numFilas++;
            addClon(numFilas);
        });

        console.log(filasDeMas);
        if (filasDeMas > 0) {
            for (var i = 0; i < filasDeMas; i++) {
                console.log(1);
                aClonar = jQuery('#aClonar').clone();
                addClon(2 + i);
            }
        }
        var n = 2;
        
        setTimeout(function(){
            jQuery('#det-productoName-1').val(productoNameRFr);
            jQuery('#det-productoCode-1').val(productoNameRFr);
            for (var i in cant) {
                $('#det-cantidad-' + n).val(cant[i]);
                jQuery('#det-formatos-' + n).val(formato[i]);
                jQuery('#det-productoName-' + n).val(productoName[i]);

                jQuery('#det-productoCode-' + n).val(productoName[i]);
                jQuery('#det-precio-' + n).val(precio[i]);

                n++;
            }
            
            
        }, 1500);

        
        
        


        


    });

</script>
@stop                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     