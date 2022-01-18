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
                            <a  href="{{URL::to('proveedores')}}" class="btn blue">
                            	<span> Ver proveedores </span>
                            </a>
                        </li>
						<li>
							<a href="index.html">
								Inicio
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Proveedores
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Añadir proveedores
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
                            	Añadir proveedores
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
							<h4>Nuevo proveedor</h4>
                            
                            <form action="{{URL::to('/add-proveedores')}}" class="form-horizontal" role="form" method="post">
                                {{ isset( $proveedor->id) ? '<input type="hidden" name="id"  value="'.$proveedor->id.'"/>': ''  }}
                                {{ Form::token()}}
								<div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Nombre</label>
									<div class="col-md-10">
										<input type="text" name="nombre" class="form-control" {{ (Input::old('nombre'))? 'value="'.Input::old('nombre').'"': '' }}{{ isset($proveedor->nombre)? 'value="'.$proveedor->nombre.'"': ''  }} placeholder="Insertar nombre">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Domicilio</label>
									<div class="col-md-10">
										<input type="text" name="domicilio" class="form-control" {{ (Input::old('domicilio'))? 'value="'.Input::old('domicilio').'"': '' }}{{ isset($proveedor->domicilio)? 'value="'.$proveedor->domicilio.'"': ''  }} placeholder="Insertar domicilio">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">CP</label>
									<div class="col-md-10">
										<input type="text" name="cp" class="form-control" {{ (Input::old('cp'))? 'value="'.Input::old('cp').'"': '' }}{{ isset($proveedor->cp)? 'value="'.$proveedor->cp.'"': ''  }} placeholder="Insertar CP">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Población</label>
									<div class="col-md-10">
										<input type="text" name="poblacion" class="form-control" {{ (Input::old('poblacion'))? 'value="'.Input::old('poblacion').'"': '' }}  {{ isset($proveedor->poblacion)? 'value="'.$proveedor->poblacion.'"': ''  }} placeholder="Insertar población">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Ciudad</label>
									<div class="col-md-10">
										<input type="text" name="ciudad" class="form-control" {{ (Input::old('ciudad'))? 'value="'.Input::old('ciudad').'"': '' }}  {{ isset($proveedor->ciudad)? 'value="'.$proveedor->ciudad.'"': ''  }} placeholder="Insertar ciudad">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Pais</label>
									<div class="col-md-10">
										<input type="text" name="pais" class="form-control" {{ (Input::old('pais'))? 'value="'.Input::old('pais').'"': '' }}  {{ isset($proveedor->pais)? 'value="'.$proveedor->pais.'"': ''  }} placeholder="Insertar pais">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Teléfono</label>
									<div class="col-md-10">
										<input type="text" name="tel" class="form-control" {{ (Input::old('tel'))? 'value="'.Input::old('tel').'"': '' }}  {{ isset($proveedor->tel)? 'value="'.$proveedor->tel.'"': ''  }} placeholder="Insertar teléfono">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Fax</label>
									<div class="col-md-10">
										<input type="text" name="fax" class="form-control" {{ (Input::old('fax'))? 'value="'.Input::old('fax').'"': '' }}  {{ isset($proveedor->fax)? 'value="'.$proveedor->fax.'"': ''  }} placeholder="Insertar fax">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Email</label>
									<div class="col-md-10">
										<input type="email" name="email" class="form-control" {{ (Input::old('email'))? 'value="'.Input::old('email').'"': '' }}  {{ isset($proveedor->email)? 'value="'.$proveedor->email.'"': ''  }} placeholder="Insertar email">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Persona de contacto</label>
									<div class="col-md-10">
										<input type="text" name="contacto" class="form-control" {{ (Input::old('contacto'))? 'value="'.Input::old('contacto').'"': '' }}  {{ isset($proveedor->contacto)? 'value="'.$proveedor->contacto.'"': ''  }} placeholder="Insertar persona de contacto">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Datos de interes</label>
									<div class="col-md-10">
										<textarea name="datosInteres" class="form-control" rows="3">{{ (Input::old('datosInteres'))? Input::old('datosInteres'): '' }}{{ isset($proveedor->datosInteres)? $proveedor->datosInteres : ''  }}</textarea>
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Teléfono de pedidos</label>
									<div class="col-md-10">
										<input type="text" name="telPedidos" class="form-control" {{ (Input::old('telPedidos'))? 'value="'.Input::old('telPedidos').'"': '' }} {{ isset($proveedor->telPedidos)? 'value="'.$proveedor->telPedidos.'"': ''  }} placeholder="Insertar teléfono de pedidos">
									</div>
								</div>
                                <div class="form-group">
									<label for="inputEmail1" class="col-md-2 control-label">Fax de pedidos</label>
									<div class="col-md-10">
										<input type="text" name="faxPedidos" class="form-control" {{ (Input::old('faxPedidos'))? 'value="'.Input::old('faxPedidos').'"': '' }} {{ isset($proveedor->faxPedidos)? 'value="'.$proveedor->faxPedidos.'"': ''  }} placeholder="Insertar fax de pedidos">
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
jQuery(document).ready(function() {    
   // initiate layout and plugins
   App.init();
   FormSamples.init();
});
</script>
@stop