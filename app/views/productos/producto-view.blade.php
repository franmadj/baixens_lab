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
							<a href="inicio.html">
								Inicio
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							
								Productos
                                
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Ver productos
                            <i class="fa fa-angle-right"></i>
						</li>
                        <li>
								Nombre del producto
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
            <div class="row">
				<div class="col-md-12">
					<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover table-full-width">
							<tbody>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Proveedor</small></td>
                                            <td class="tdst-group-item"> <strong>{{ isset($producto->proveedor()->first()->nombre)?$producto->proveedor()->first()->nombre:'No DB'; }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Código</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->codigo }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Nombre producto</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->nombreProducto }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Nombre clave</small> </td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->nombreClave }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Descripción</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->descripcion }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Coste</small> </td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->coste }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>VOC (g/l)</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->VOC }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Densidad (g/l)</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->densidad }}</strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Solidos</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $producto->solidos }}</strong></td>
                                    </tr>
							</tbody>
							</table>
					</div>
				</div>
			</div>
            
            <div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								Histórico de costes
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-hover">
								<thead>
								<tr>
									<th>
										 Fecha
									</th>
									<th>
										 Coste
									</th>
									<th>
										 Notas
									</th>
								</tr>
								</thead>
								<tbody>
                                                                    @foreach($historicos as $historico)
								<tr>
									<td>
									<?php 
									if(!empty($historico->creado)) {
										echo date('d/m/Y', $historico->creado);
									}
									
										
									?>
										
										 
										 
										 
									</td>
									<td>
										 {{ $historico->coste }}
									</td>
									<td>
										 {{ $historico->notas }}
									</td>
								</tr>
                                                                @endforeach
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
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