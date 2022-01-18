@extends('layouts.base')

@section('content')


        
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
                            @if(Session::has('pedido_view_message'))
                                    <div class="col-md-12"  style="color:red;">{{Session::get('pedido_view_message')}}</div>
                            @endif
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
                            <i class="fa fa-angle-right"></i>
						</li>
                        <li>
								Numero del pedidos
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
                    		<div class="col-md-12" style="padding:0px; margin-bottom:20px;">
                            	<!-- <div class="col-md-4" style="padding:0px;">
                                	<a class="btn dark fullButton" target="_blank" href="{{URL::to('print-pedido')}}/{{ $pedido->id}}">IMPRIMIR</a>
                                </div> -->
                                <div class="col-md-8">
                                	<a target="_blank" href="{{URL::to('pdf-pedido')}}/{{ $pedido->id}}" class="btn red fullButton">Exportar PDF</a>
                                </div>
                                <div class="col-md-4" style="padding:0px;">
                                	<a target="_blank" href="{{URL::to('email-pedido')}}/{{ $pedido->id}}" class="btn purple fullButton">Enviar EMAIL</a>
                                </div>
                            </div>
                    		<h1><small>Nº pedido:</small> {{ $pedido->numero}}</h1> 
							<table class="table table-striped table-bordered table-hover table-full-width">
							<tbody>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Proveedor</small></td>
                                            <td class="tdst-group-item"> <strong>{{ $pedido->proveedor->nombre}} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Fecha</small></td>
                                            <td class="tdst-group-item"> <strong> {{ date('d/m/Y', $pedido->fecha) }} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Tipo de envio</small> </td>
                                            <td class="tdst-group-item"> <strong> {{ $pedido->envio}} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Encargado por</small></td>
                                            <td class="tdst-group-item"> <strong> {{ $pedido->User->username}} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Destinatario</small> </td>
                                            <td class="tdst-group-item"> <strong> {{ $pedido->recibidoPor}} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item"> <small>Fecha de entrega</small></td>
                                            <td class="tdst-group-item"> <strong> {{ date('d/m/Y', $pedido->plazoEntrega) }} </strong></td>
                                    </tr>
                                    <tr>
                                            <td class="tdst-group-item" colspan="2"> <small>Observaciones</small></td>
                                    </tr>
                                     <tr>
                                            <td class="tdst-group-item" colspan="2"> <strong> {{ $pedido->observaciones}} </strong></td>
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
								Pedido de productos y cantidades
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
								<tbody>
                                                                  @foreach($pedidoDetalle as $pedidoDet) 
								<tr>
									<td>
										 {{ $pedidoDet->cantidad }} 
									</td>
									<td>
 										 {{ $pedidoDet->FormatosPedido->formato }} 
									</td>
                                                                        <td>
										 {{ $pedidoDet->Producto->nombreProducto }}
									</td> 
                                                                         <td>
										 {{ $pedidoDet->Producto->codigo }}
									</td>
                                    <td>
										 {{ $pedidoDet->Producto->coste }}
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