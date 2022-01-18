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
                <a  href="{{URL::to('productos')}}" class="btn blue">
                    <span> Ver productos </span>
                </a>
            </li>
            <li>
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Productos
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Añadir productos
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
                    Añadir productos
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">	
                @if(Session::has('mensaje'))
                <div class="col-md-12">{{Session::get('mensaje')}}</div>
                @endif
                <hr>
                <h4>Nuevo producto</h4>

                <form class="form-horizontal" action="{{ URL::to('/add-productos') }}" role="form" method="post">
                    {{ isset( $producto->id) ? '<input type="hidden" name="id"  value="'.$producto->id.'"/>': ''  }}
                    {{ Form::token()}}
                    <div class="form-group">
                        <label class="control-label col-md-2">Proveedor</label>
                        <div class="col-md-4">

                            {{ Form::select('proveedores', $proveedores, $producto->idProveedor,  array('class'=>'select2_category form-control', 'data-placeholder'=>'Choose a Category', 'tabindex'=>'1' )) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="codigo" class="col-md-2 control-label">Código</label>
                        <div class="col-md-10">
                            <input type="text" name="codigo" class="form-control" {{ (Input::old('codigo'))? 'value="'.Input::old('codigo').'"': '' }} {{ isset($producto->codigo)? 'value="'.$producto->codigo.'"': ''  }}  placeholder="Insertar codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre producto</label>
                        <div class="col-md-10">
                            <input type="text" name="nombreProducto" class="form-control" {{ (Input::old('nombreProducto'))? 'value="'.Input::old('nombreProducto').'"': '' }} {{ isset($producto->nombreProducto)? 'value="'.$producto->nombreProducto.'"': ''  }} placeholder="Insertar nombre producto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre clave</label>
                        <div class="col-md-10">
                            <input type="text" name="nombreClave" class="form-control" {{ (Input::old('nombreClave'))? 'value="'.Input::old('nombreClave').'"': '' }} {{ isset($producto->nombreClave)? 'value="'.$producto->nombreClave.'"': ''  }} placeholder="Nombre clave">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Descripción</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="descripcion" rows="3">{{ isset($producto->descripcion)? $producto->descripcion : ''  }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Coste</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="coste" {{ (Input::old('coste'))? 'value="'.Input::old('coste').'"': '' }} {{ isset($producto->coste)? 'value="'.$producto->coste.'"': ''  }} placeholder="Insertar coste">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label" style="color:#F00;">Nota cambio de precio:</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="notaCambioPrecio" rows="3">{{ isset($producto->notaCambioPrecio)? $producto->notaCambioPrecio : ''  }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">VOC (g/l)</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="VOC" {{ (Input::old('VOC'))? 'value="'.Input::old('VOC').'"': '' }} {{ isset($producto->VOC)? 'value="'.$producto->VOC.'"': ''  }} placeholder="Insertar VOC (g/l)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Densidad (g/l)</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="densidad" {{ (Input::old('densidad'))? 'value="'.Input::old('densidad').'"': '' }} {{ isset($producto->densidad)? 'value="'.$producto->densidad.'"': ''  }} placeholder="Insertar densidad (g/l)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Sólidos</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="solidos" {{ (Input::old('solidos'))? 'value="'.Input::old('solidos').'"': '' }} {{ isset($producto->solidos)? 'value="'.$producto->solidos.'"': ''  }} placeholder="Insertar solidos">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Tipo</label>
                        <div class="col-md-10">
                            {{ Form::select('tipo', $tipoProductos, $producto->tipo, array('class'=>' form-control tipo')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="colorimetria" class="control-label col-md-2">Colorimetría</label>
                        <div class="col-md-4">

                            <input id="colorimetria" name="colorimetria" {{ (Input::old('colorimetria'))? 'checked="checked"': '' }} {{ ($producto->colorimetria)? 'checked="checked"' : ''  }} type="checkbox" value="1">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>


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
<script>
jQuery(document).ready(function () {
    // initiate layout and plugins
    App.init();
    FormSamples.init();
});
</script>
@stop