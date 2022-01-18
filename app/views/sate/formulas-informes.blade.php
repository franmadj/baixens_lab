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

                Informes

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
								Cambiar producto por producto, FORMULAS
							</div>
						</div>
                        <div class="portlet-body">
                            @if(Session::has('mensaje_lote'))
                                    <div class="col-md-12" >{{Session::get('mensaje_lote')}}</div>
                            @endif
                            <form action="{{URL::to('cambio-producto-lote')}}" method="post" style="padding:0px; margin-bottom:20px;" role="form" class="form-horizontal col-md-12">
                            	{{ Form::token() }}
                                    <div class="col-md-4" style="padding:0px;">
                                        <input type="text" class="form-control" name="producto_antiguo" placeholder="Código producto antiguo">
                                    </div>
                                    <div class="col-md-4" style="padding:0px;">
                                        <input type="text" class="form-control" name="producto_nuevo" placeholder="Código producto nuevo">
                                    </div>
                                    <div class="col-md-4">
                                       <button class="btn btn-info btn-block" type="submit">Editar</button>
                                    </div>
                                </form>
								<div style="clear:both;"></div>
                                 
                         </div>
                    </div>
        
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    INFORMES
                </div>
            </div>
            
            


            <div class="portlet-body">

                <form class="form-horizontal col-md-12" id="filter-form" method="post" action="{{URL::to('informes-formulas-valoracion')}}" role="form" style="padding:0px; margin-bottom:20px;">
{{ Form::token() }}
                    <div class="col-md-3" style="padding:0px;">
                        {{ Form::select('codigo', $productoCode, $codigo, array('class'=>'select2_category form-control codigo') ) }}
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="filtrar" id="filtrar" class="btn red btn-block send-filter">Filtrar</button>
                    </div>
                    <div class="col-md-3">
                        <a type="submit" target="_blank" id="print" href="#" class="btn green btn-block send-filter">Imprimir</a>
                    </div>
                    @if($puedeEditar && !$tienePendientes)
                    <div class="col-md-3">
                        <button type="submit" name="editar" value="1" id="editar-formulas" class="btn btn-info btn-block send-filter">Editar</button>
						<input name="editar" value="1" type="hidden" />
                    </div>
                    @elseif($tienePendientes && !$codigo)
                    <div class="col-md-3">
                        <button  type="submit" value="{{$tienePendientes}}" id="procesar-pendientes" name="procesar" class="btn btn-info btn-block">Procesar Pendientes</button>

                    </div>
                    @elseif($tienePendientes && $codigo)
                    <div class="col-md-3">
                        <button type="submit" id="anular" name="anular" value="1" id="editar-formulas" class="btn btn-info btn-block send-filter">Anular Pendientes</button>
                    </div>

                    @endif
                </form>


                
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
                            <th>
                                NF
                            </th>
                            <th>
                                Nombre formula
                            </th>
                            <th>
                                Código
                            </th>
                            <th>
                                Código producto
                            </th>
                            <th>
                                Sección
                            </th>
                            <th>
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulasDet as $formulaDet)

                        <tr>
                            <td>
                                {{ isset($formulaDet->Formula->numero)?$formulaDet->Formula->numero:''; }}
                            </td>

                            <td>
                                {{ isset($formulaDet->Formula->nombre)?$formulaDet->Formula->nombre:''; }}

                            </td>

                            <td>
                                {{ isset($formulaDet->Formula->codigo)?$formulaDet->Formula->codigo:''; }}


                            </td>


                            <td>
                                {{ isset($formulaDet->Producto->codigo)?$formulaDet->Producto->codigo:''; }}

                            </td>
                            <td>
                                {{ isset($formulaDet->Formula->SeccionesFormula->seccion)?$formulaDet->Formula->SeccionesFormula->seccion:''; }}
                            </td>
                            <td>

                                @if(isset($formulaDet->Formula->pendienteEdicion) && $formulaDet->Formula->pendienteEdicion != 0)
                                <a  href="{{URL::to('edit-formula')}}/{{ $formulaDet->Formula->id }}/pendiente" class="btn btn-info btn-block">Pendiente</a>
                                @else
                                <button disabled="" type="submit" class="btn btn-info btn-block"> - </button>
                                @endif
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


    $('#anular').click(function () {
        $('.codigo').val('0');
    });


    @if (Session::has('procesarPendientes'))
            $('#procesar-pendientes').click();
    @endif

    $('.send-filter').click(function (e) {
        e.preventDefault();
        if ($(this).attr('id') == 'filtrar') {
            $('#filter-form').removeAttr('target');
            $('#printing').remove();
        } else if ($(this).attr('id') == 'print') {
            $('#filter-form').attr('target', '_blank').append('<input type="hidden" value="1" id="printing" name="printing">');
        } else if ($(this).attr('id') == 'editar-formulas') {
            $('#printing').remove();
            //$('#filter-form').sumbit();
        }
        //editar-formulas
        $('#filter-form').submit();
        return false;

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