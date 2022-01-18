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
                <a  href="{{URL::to('add-pedido')}}" class="btn blue">
                    <span> Añadir pedidos </span>
                </a>
            </li>
            <li>
                <a href="inicio.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>

                Pedidos

                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Ver pedidos
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    PEDIDOS
                </div>
            </div>


            <div class="portlet-body">

                <form action="{{ URL::to('pedidos') }}" class="form-horizontal col-md-12" role="form" method="post" style="padding:0px; margin-bottom:20px;">
                    {{ Form::token() }}
                    <div class="row">
                        <div class="col-md-3" >
                            {{ Form::select('proveedores', $proveedores, $viejos['proveedor'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona Proveedor' )) }}

                        </div>
                        <div class="col-md-3">

                            {{ Form::select('estadoPedidos', array(0=>'Selecciona Estado','pend'=>'Pendientes', 'rec'=>'Recibidos'), $viejos['estadoPedidos'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona Estado' )) }}
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
                                <input name="fechaDe" type="text" class="form-control" readonly {{ ($viejos['fechaDe']!='')? 'value="'.$viejos['fechaDe'].'"': '' }}>
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Inicio la fecha
                            </span>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
                                <input name="fechaA" type="text" class="form-control" readonly {{ ($viejos['fechaA']!='')? 'value="'.$viejos['fechaA'].'"': '' }}>
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Fin de la fecha
                            </span>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
                                <input name="fechaDeE" type="text" class="form-control" readonly {{ ($viejos['fechaDeE']!='')? 'value="'.$viejos['fechaDeE'].'"': '' }}>
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Inicio la fecha de entrega
                            </span>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
                                <input name="fechaAE" type="text" class="form-control" readonly {{ ($viejos['fechaAE']!='')? 'value="'.$viejos['fechaAE'].'"': '' }}>
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <!-- /input-group -->
                            <span class="help-block">
                                Fin de la fecha de entrega
                            </span>
                        </div>

                        <div class="col-md-6" >
                            <button type="submit" class="btn red btn-block">Filtrar</button>
                        </div>

                    </div>


                    <div class="row">
                        <div style="padding-right:0px; margin-bottom:20px;" class="col-md-6">
                            <button class="btn green btn-block" value="1" name="excel_valorado" target="_blank" type="submit">Exportar Excel valorado</button>

                        </div>
                        <div style="padding-right:0px; margin-bottom:20px;" class="col-md-6">
                            <button class="btn green btn-block" value="1" name="excel" target="_blank" type="submit">Exportar Excel no valorado</button>

                        </div>
                    </div>
                </form>



                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Proveedor
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>Recibido

                            </th>
                            <th>
                                Fecha de entrega

                            </th>
                            <th class="hidden-xs">
                                Imprimir Pdf
                            </th>
                            <th class="hidden-xs">
                                Ver
                            </th>
                            <th class="hidden-xs">
                                Editar
                            </th>
                            <th class="hidden-xs">
                                Borrar
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($pedidos as $pedido)  
                        <tr>
                            <td>
                                {{ $pedido->numero }}
                            </td>
                            <td>
                                {{ isset($pedido->Proveedor->nombre)?$pedido->Proveedor->nombre:''; }}
                            </td>
                            <td>
                                {{ date('d/m/Y', $pedido->fecha) }}
                            </td>
                            <td>
                                <input class="estadoPedidoCk" type="checkbox" data-idPedido="{{ $pedido->id }}" <?php echo trim($pedido->estadoPedido) == 'rec' ? 'checked="checked"' : ''; ?> />
                                <span id="token-ajax">{{ Form::token() }}</span>
                            </td>
                            <td>
                                {{ date('d/m/Y', $pedido->plazoEntrega) }}
                            </td>
                            <td>
                                <a class="btn red btn-xs fullButton" target="_blank" href="{{ URL::to('pdf-pedido') }}/{{ $pedido->id }}">Imprimir Pdf</a>
                            </td>
                            <td>
                                <a class="btn btn-success btn-xs fullButton" href="{{ URL::to('ver-pedido') }}/{{ $pedido->id }}">Ver</a>
                            </td>
                            <td>
                                <a class="btn btn-info btn-xs fullButton" href="{{ URL::to('edit-pedido') }}/{{ $pedido->id }}">Editar</a>
                            </td>
                            <td>
                                <a onclick="return confirm('deseas borrar este registro?')" href="{{ URL::to('del-pedido') }}/{{ $pedido->id }}" class="btn btn-danger btn-xs fullButton">Borrar</a>
                            </td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
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
                                        $('.estadoPedidoCk').click(function () {
                                            var idPedido = $(this).attr('data-idPedido');
                                            var recibido = $(this).attr('checked') ? 'r' : 'p';
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ URL::to('set-estado-pedido') }}",
                                                data: {
                                                    "_token": $('#token-ajax').find('input').val(),
                                                    "idPedido": idPedido,
                                                    "recibido": recibido

                                                },
                                                success: function (data) {


                                                    //$parent.find('.porcentaje').val(val);

                                                },
                                                dataType: 'json'
                                            });
                                        });

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
@stop