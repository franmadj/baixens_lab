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
							<a href="inicio.html">
								Inicio
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							
								Proveedores
                                
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Ver proveedor
                            <i class="fa fa-angle-right"></i>
						</li>
                        <li>
								Nombre del proveedor
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
            <div class="row">
				<div class="col-md-6">
					<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-full-width">
							<tbody>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Nombre</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->nombre }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Domicilio</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->domicilio }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>CP</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->cp }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Población</small> </td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->poblacion }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Ciudad</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->ciudad }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Pais</small> </td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->nombre }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Teléfono</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->tel }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Fax</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->fax }}</strong></td>
                                    </tr>
							</tbody>
							</table>
						</div>
				</div>
                
                <div class="col-md-6">
					<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-full-width">
							<tbody>
                                    
                                    <tr>
                                            <td class="tdst-group-item"> <small>Persona de contacto</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $proveedor->contacto }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item text-center" colspan="2"> <small>Datos de interes</small> </td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item" colspan="2"> <strong>{{ $proveedor->datosInteres }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Email</small>  </td>
                                            <td class="tdst-group-item"> <strong style="color:#900;">{{ $proveedor->email }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Tel. pedidos</small> </td>
                                            <td class="tdst-group-item"> <strong style="color:#900;">{{ $proveedor->telPedidos }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Fax. pedidos</small> </td>
                                            <td class="tdst-group-item"> <strong style="color:#900;">{{ $proveedor->faxPedidos }}</strong></td>
                                    </tr>
							</tbody>
							</table>
						</div>
				</div>
                
                
                 <div  class="col-md-12">
                            <hr>
                                <h2>Productos</h2>
                            <hr>
							<table class="table table-striped table-bordered table-hover table-full-width">
							<thead>
							<tr>
								<th>
									 Código
								</th>
								<th>
									 Nombre producto
								</th>
								<th>
									 Nombre en clave
								</th>
                                <th>
									VOC (g/l)
								</th>
                                <th>
									Densidad (g/l)
								</th>
                                <th>
									 Precio
								</th>
                                <th class="hidden-xs">
									 Ver
								</th>
							</tr>
							</thead>
							<tbody>
                                                            @foreach($productos as $producto)
							<tr>
								<td>
									 {{$producto->codigo}}
								</td>
								<td>
									 {{$producto->nombreProducto}}
								</td>
								<td>
									 {{$producto->nombreClave}}
								</td>
                                <td>
									 {{$producto->VOC}}
								</td>
								<td>
									 {{$producto->densidad}}
								</td>
								<td>
									{{$producto->coste}}
								</td>
                                <td>
									 
                                                                         
                                                                         <a class="btn btn-success btn-xs fullButton" href="{{ URL::to('ver-producto', $producto->id) }}">Ver</a>
								</td>
							</tr>
                                                        @endforeach
							
							</tbody>
							</table>
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