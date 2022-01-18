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
                    <span> Añadir Sate </span>
                </a>
            </li>
            <li>
                <a href="inicio.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>

                Sate

                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Ver Sate
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
                    Sate
                </div>
            </div>


            <div class="portlet-body">

                <form action="{{ URL::to('sate') }}" method="post" class="form-horizontal col-md-12" role="form" style="padding:0px; margin-bottom:20px;">
                    
                    {{ Form::token() }}
                    <div class="col-md-3"  >

                        {{ Form::select('codigo', $codigos, $viejos['codigo'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Formula', 'tabindex'=>'1' )) }}

                    </div>

                    <div class="col-md-3"  >

                        {{ Form::select('nombre', $nombres, $viejos['nombre'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Formula', 'tabindex'=>'1' )) }}

                    </div>
                    
                    <div class="col-md-2">

                        {{ Form::select('codigoProducto', $codigosProducto, $viejos['codigoProducto'],  array('class'=>'select2_category form-control', 'data-placeholder'=>'Selecciona', 'tabindex'=>'1' )) }}
                    </div>

                    
                    
                    

                    
                    
                    
                    
                    
                    <div class="col-md-2">
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
                    <div class="col-md-2">
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
                    
                    <div class="col-md-10"  >
                        <input type="input" name="search" value="<?php echo $viejos['search']; ?>" class="form-control" placeholder="Buscar">
                    </div>
                    
                    <div class="col-md-2"  >
                        <button type="submit" name="filtrar" value="1" class="btn red btn-block">Filtrar</button>
                    </div>

                    


                    
                </form>
                
                <?php if($formulas)echo $formulas->appends(['filter' => '1'])->links(); ?>


                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                    <thead>
                        <tr>
                            <th>
                                NP
                            </th>
                            <th>
                                Nombre Sate
                            </th>
                            

                            @if($user_type==3)
                            <th class="hidden-xs">
                                Editar/Ver
                            </th>
                            <th class="hidden-xs">
                                Borrar
                            </th>
                            
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        
                        
                        


                        @foreach($formulas as $formula)	
                        
                        <tr>

                            <td>
                                {{ $formula->numero_sate  }}
                            </td>

                            <td>
                                {{ $formula->nombre }}
                            </td>
                            
                            
                            
                            
                            
                            <td>
                                <a class="btn btn-info btn-xs fullButton" href="{{ URL::to('edit-sate') }}/{{ $formula->id }}">Editar</a>
                            </td>
                            <td>
                                @if($user_type==3)
                                <a  class="btn btn-danger btn-xs fullButton normal-del" data-id="{{$formula->id}}" href="{{ URL::to('borrar-sate') }}/{{ $formula->id }}">Borrar</a>
                                @endif
                            </td>
                            
                        </tr>
                        @endforeach


                    </tbody>
                </table>
                <?php if($formulas)echo $formulas->appends(['filter' => '1'])->links(); ?>
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
<script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>-->
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
jQuery(document).ready(function () {
    // initiate layout and plugins
    App.init();
//    ComponentsFormTools.init();
    ComponentsPickers.init();
//    FormSamples.init();
    $('.normal-del').click(function (e) {
        e.preventDefault();
        var href=$(this).attr('href');
        bootbox.confirm('Deseas borrar este registro?', function (result) {
            if (result) {
                window.location=href;
               
            } 


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

<style>
    .min-rang{padding-right: 5px;}
    .max-rang{padding-left: 5px;}
    
</style>
@stop