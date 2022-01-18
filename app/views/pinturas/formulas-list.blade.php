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
                <a  href="{{URL::to('add-pintura')}}" class="btn blue">
                    <span> Añadir Pintura </span>
                </a>
            </li>
            <li>
                <a href="inicio.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>

                Pinturas

                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Ver Pinturas
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    @if(Session::has('mensaje'))
    <div class="col-md-12" >{{Session::get('mensaje')}}</div>
    @endif
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Pinturas
                </div>
            </div>


            <div class="portlet-body">

                <form action="{{ URL::to('pinturas') }}" method="post" id="filter-form" class="form-horizontal col-md-12" role="form" style="padding:0px; margin-bottom:20px;">

                    {{ Form::token() }}
                    <div class="col-md-1"  >

                        {{ Form::select('codigo', $codigos, $viejos['codigo'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Formula', 'tabindex'=>'1' )) }}

                    </div>
                    <div class="col-md-1"  >

                        {{ Form::select('numero_pintura', $numero_pinturas, $viejos['numero_pintura'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'N Pintura', 'tabindex'=>'1' )) }}

                    </div>

                    <div class="col-md-2"  >

                        {{ Form::select('nombre', $nombres, $viejos['nombre'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Formula', 'tabindex'=>'1' )) }}

                    </div>

                    <div class="col-md-1">

                        {{ Form::select('codigoProducto', $codigosProducto, $viejos['codigoProducto'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona', 'tabindex'=>'1' )) }}
                    </div>


                    <div class="col-md-1">

                        {{ Form::select('tipo', $tipos, $viejos['tipo'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona', 'tabindex'=>'1' )) }}
                    </div>
                    <div class="col-md-2">

                        {{ Form::select('estado', $estados, $viejos['estado'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona', 'tabindex'=>'1' )) }}
                    </div>



                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="solMin" value="<?php echo $viejos['solMin']; ?>" class="form-control" placeholder="Solidos Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="solMax" value="<?php echo $viejos['solMax']; ?>" class="form-control" placeholder="Solidos Max.">
                    </div>


                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="pvcMin" value="<?php echo $viejos['pvcMin']; ?>" class="form-control" placeholder="PVC Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="pvcMax" value="<?php echo $viejos['pvcMax']; ?>" class="form-control" placeholder="PVC Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="denMin" value="<?php echo $viejos['denMin']; ?>" class="form-control" placeholder="Densidad Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="denMax" value="<?php echo $viejos['denMax']; ?>" class="form-control" placeholder="Densidad Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="tioMin" value="<?php echo $viejos['tioMin']; ?>" class="form-control" placeholder="TiO2 Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="tioMax" value="<?php echo $viejos['tioMax']; ?>" class="form-control" placeholder="TiO2 Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="ligMin" value="<?php echo $viejos['ligMin']; ?>" class="form-control" placeholder="Ligante Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="ligMax" value="<?php echo $viejos['ligMax']; ?>" class="form-control" placeholder="Ligante Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="ekMin" value="<?php echo $viejos['ekMin']; ?>" class="form-control" placeholder="Precio(€/Kg) Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="ekMax" value="<?php echo $viejos['ekMax']; ?>" class="form-control" placeholder="Precio(€/Kg) Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="elMin" value="<?php echo $viejos['elMin']; ?>" class="form-control" placeholder="Precio(€/L) Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="elMax" value="<?php echo $viejos['elMax']; ?>" class="form-control" placeholder="Precio(€/L) Max.">
                    </div>


                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="cubMin" value="<?php echo $viejos['cubMin']; ?>" class="form-control" placeholder="Cubrición Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="cubMax" value="<?php echo $viejos['cubMax']; ?>" class="form-control" placeholder="Cubrición Max.">
                    </div>

                    <div class="col-md-2 min-rang"  style="margin-bottom:20px;">
                        <input type="input" name="reFMin" value="<?php echo $viejos['reFMin']; ?>" class="form-control" placeholder="Res. Frote Min.">
                    </div>
                    <div class="col-md-2 max-rang"  style="margin-bottom:20px;">
                        <input type="input" name="reFMax" value="<?php echo $viejos['reFMax']; ?>" class="form-control" placeholder="Res. Frote Max.">
                    </div>

                    <div class="col-md-4">

                        {{ Form::select('eq', $eqs, $viejos['eq'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona', 'tabindex'=>'1' )) }}
                    </div>
                    <div class="col-md-6">

                        {{ Form::select('seccion', $secciones, $viejos['seccion'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Formula', 'tabindex'=>'1' )) }}
                    </div>


                    <div class="col-md-3">
                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
                            <input name="fechaDe" type="text" class="form-control" readonly {{ ($viejos['fechaDe']!='')? 'value="'.$viejos['fechaDe'].'"': '' }} >
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
                    
                    <div class="col-md-12" style="margin-bottom:20px;">
                        <label class="checkbox-inline">
                            Excel:
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="excel-fields-all" id="excel-fields-all" value="all"> Todos
                        </label>
                        @foreach($excelFields as $key=>$value)
                        <label class="checkbox-inline">
                            <input class="excel-fields" type="checkbox" name="excel-fields[{{$key}}]" value="{{$value}}"> {{$value}}
                        </label>
                        
                        @endforeach
                        
                        
                    </div>

                    <div class="col-md-6"  style="margin-bottom:20px;">
                        <input type="input" name="search" value="<?php echo $viejos['search']; ?>" class="form-control" placeholder="Buscar">
                        <p class="help-block">Añade diferentes terminos a buscar separados por coma.</p>
                    </div>

                    <div class="col-md-3"  style="margin-bottom:20px;">
                        <button type="submit" name="filtrar" value="1" class="btn red btn-block">Filtrar</button>
                    </div>
                    <div class="col-md-3"  style="padding-right:0px; margin-bottom:20px;">
                        <button  type="submit" target="_blank" name="excel" value="1" class="btn green btn-block">Exportar Excel</button>

                    </div>
                    <input type="hidden" name="selected-ids" id="selected-ids">





                </form>

                <?php if ($formulas) echo $formulas->appends(['filter' => '1'])->links(); ?>


                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="check-all">
                            </th>
                            <th>
                                NP
                            </th>
                            <th>
                                Nombre Pintura
                            </th>
                            
                            <th>
                                Sección
                            </th>
                            
                            <th>
                                % Sólidos
                            </th>
                            <th>
                                PVC
                            </th>
                            <th>
                                Densidad(g/mL)
                            </th>
                            <th>
                                % TiO2
                            </th>
                            <th>
                                % Ligante
                            </th>
                            <th>
                                Precio(€/Kg)
                            </th>
                            <th>
                                Precio(€/L)
                            </th>



<!--                                <th class="hidden-xs">
                                         Ver
                                </th>-->


                            <th class="hidden-xs">
                                Editar/Ver
                            </th>
                            <th class="hidden-xs">
                                Borrar
                            </th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach($formulas as $formula)	

                        <tr>
                            <td>
                                <input type="checkbox" class="pintura-check" data-id="{{ $formula->id  }}">
                            </td>

                            <td>
                                {{ $formula->numero_pintura  }}
                            </td>

                            <td>
                                {{ $formula->nombre }}
                            </td>
                            
                            <td>
                                {{ $formula->seccionesFormula->seccion }}
                            </td>

                            <th>
                                {{ $formula->porcentaje_solidos_pesado }}
                            </th>
                            <th>
                                {{ $formula->pvc_pesado }}
                            </th>
                            <th>
                                {{ $formula->densidad_pesado }}
                            </th>
                            <th>
                                {{ $formula->tio2_pesado }}
                            </th>
                            <th>
                                {{ $formula->ligante_pesado }}
                            </th>
                            <th>
                                {{ $formula->precio_eu_kg_pesado }}
                            </th>
                            <th>
                                {{ $formula->precio_eu_lt_pesado }}
                            </th>



                            <td>
                                <a class="btn btn-info btn-xs fullButton" href="{{ URL::to('edit-pintura') }}/{{ $formula->id }}">Editar</a>
                            </td>
                            <td>

                                <a  class="btn btn-danger btn-xs fullButton normal-del" data-id="{{$formula->id}}" href="{{ URL::to('borrar-pintura') }}/{{ $formula->id }}">Borrar</a>

                            </td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
                <?php if ($formulas) echo $formulas->appends(['filter' => '1'])->links(); ?>
                <span id="token-ajax">{{ Form::token() }}</span>
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
<script type="text/javascript" src="{{ url('assets/plugins/bootbox/bootbox.min.js') }}"></script>



<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function ($) {
    // initiate layout and plugins
    App.init();
    ComponentsFormTools.init();
    ComponentsPickers.init();
    FormSamples.init();
    $('.normal-del').click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        bootbox.confirm('Deseas borrar este registro?', function (result) {
            if (result) {
                window.location = href;

            }


        });
    });
    
    $('#excel-fields-all').click(function(){
        if($(this).is(':checked')){
            $('.excel-fields').attr('checked',true).parent().addClass('checked');
        }else{
            $('.excel-fields').attr('checked',false).parent().removeClass('checked');
        }
        
    });
    
    $('#check-all').click(function(){ 
        if($(this).is(':checked')){
            $('.pintura-check').attr('checked',true).parent().addClass('checked');
        }else{
            $('.pintura-check').attr('checked',false).parent().removeClass('checked');
        }
        
    });
    
    $('#filter-form').submit(function(){
        var selectedIds=[];
        $('.pintura-check').each(function(){
            if($(this).is(':checked')){
                selectedIds.push($(this).data('id'));  
            }
            
        });
        $('#selected-ids').val(selectedIds.join(','));
        return true;
        
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

<style>
    .min-rang{padding-right: 5px;}
    .max-rang{padding-left: 5px;}

</style>
@stop