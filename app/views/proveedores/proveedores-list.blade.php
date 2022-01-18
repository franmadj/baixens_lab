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
                            <a  href="{{URL::to('add-proveedor')}}" class="btn blue">
                            	<span> Añadir proveedores </span>
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
								Ver proveedores
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
								PROVEEDORES
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
							<thead>
							<tr>
								<th>
									 Nombre
								</th>
								<th>
									 Tel. Pedidos
								</th>
								<th>
									 Fax. Pedidos
								</th>
                                <th>
									 Email
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
                                                            @foreach($proveedores as $proveedor)
							<tr>
                                                    
                                                        
                                                    
								<td>
									 {{ $proveedor->nombre }}
								</td>
								<td>
									  {{ $proveedor->telPedidos }}
								</td>
								<td>
									  {{ $proveedor->faxPedidos }}
								</td>
                                <td>
									  {{ $proveedor->email }}
								</td>
								<td>
									 <a class="btn btn-success btn-xs fullButton" href="ver-proveedor/{{ $proveedor->id }}">Ver</a>
								</td>
								<td>
									 <a class="btn btn-info btn-xs fullButton"href="edit-proveedor/{{ $proveedor->id }}">Editar</a>
								</td>
                                <td>
									 <a onclick="return confirm('deseas borar este registro?')" class="btn btn-danger btn-xs fullButton"href="del-proveedor/{{ $proveedor->id }}">Borrar</a>
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