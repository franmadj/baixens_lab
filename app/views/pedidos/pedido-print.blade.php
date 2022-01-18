<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento de compra</title>
<style type="text/css">

				body{
					font-family:Verdana, Geneva, sans-serif;
					font-size:11px;
				}
				h1{
					font-size:20px;	
				}
				.contenedor{
					width:100%;
					position:absolute;
					z-index:1;
					margin-top:200px;
				}
				table tr td{
					border: thin solid rgba(182,182,182,1.00);
					border-collapse: collapse;
					padding:5px;
				}
				table tr{
					width:100%;
				}
				table{
					width:100%;
					border-collapse:collapse;
					margin-left:5%; 
					margin-right:5%; 
					position:relative;
				}
				img{
					vertical-align: middle;
					padding-left: 10px;
				}
				img.body{
					vertical-align:top;
					padding-left: 0px;
				}
				strong{
					font-size:15px;
				}
				span.texto{
					font-size:15px;
				}
				small{
					font-size:15px;
					font-weight:600;
					color:#1865ab;
				}
				</style>
</head>

<body>
			
			<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0; z-index:0;">
                <img class="body" src="img/print/fondoEnvios.jpg" style="width: 210mm; height: 297mm; margin: 0;" />
            </div>
			         
			<div class="contenedor">
		   
                <table>
						<thead>
							<tr>
								<td  colspan="2" style="width:90%; text-align:center;"><h1>DOCUMENTO DE COMPRA</h1></td>
								<td style="width:10%; text-align:center;"><small>NºPedido</small> <strong style="font-size:24px; padding-left:5px;"> {{$pedido->numero}}</strong></td>		
							</tr>
						</thead>
						<tbody>
								<tr>
									<td colspan="3"><small>Proveedor:</small> <span class="texto">{{$pedido->Proveedor->nombre}}</span></td>
								</tr>
								
								<tr>
									<td><small>Teléfono de contacto:</small> <span class="texto">{{$pedido->proveedor->tel}}</span></td>
									<td colspan="2"><small>Fax del proveedor:</small> <span class="texto">{{$pedido->proveedor->fax}}</span></td>
								</tr>
								
								<tr>
									<td colspan="3"><small>e-mail:</small> <span class="texto">{{$pedido->Proveedor->email}}</span>	</td>
								</tr>
								
								<tr>
									<td colspan="3"><small>Fecha de pedido:</small> <span class="texto">{{date('d/m/Y', $pedido->fecha)}}</span>	</td>
								</tr>
								
								<tr>
									<td colspan="3"><small>Receptor del pedido:</small> <span class="texto">{{$pedido->recibidoPor}}</span>	</td>
								</tr>
								
								<tr style="background-color:rgba(223,223,223,0.5)">
								  	<td style="width:40%"><small>MODO DE RECEPCIÓN</small></td>
								  	<td style="width:30%"><small style="text-align:right;">Envío proveedor:</small> {{($pedido->envio=='e')?HTML::image('img/print/imgCheck.jpg', 'Imagen usuario', array('width'=>'20', 'height'=>20)):HTML::image('img/print/imgNoCheck.jpg', 'Imagen usuario', array('width'=>'20', 'height'=>20));}}</td>
									<td style="width:30%"><small style="text-align:right;">Nuestros medios:</small> {{($pedido->envio=='e')?HTML::image('img/print/imgNoCheck.jpg', 'Imagen usuario', array('width'=>'20', 'height'=>20)):HTML::image('img/print/imgCheck.jpg', 'Imagen usuario', array('width'=>'20', 'height'=>20));}}</td>
								</tr>
                                
								<tr>
									<td  colspan="3"><small>Plazo de entrega:</small> <span class="texto">{{date('d/m/Y', $pedido->plazoEntrega)}}</span>	</td>
								</tr>
                                
                                <tr>
									<td colspan="3" >
                                    	<small>Observaciones:</small> 
                                        <br>
                                        <br>
                                    	<span class="texto" style="font-size:12px;">
                                        	{{$pedido->observaciones}}<br>
											{{$horarioDescarga->meta_value}}<br><br>
                                        </span>	
                                    </td>
								</tr>
						</tbody>
					</table>
                    
                    <table style="margin-top:30px;">
						<thead>
							<tr>
								<td style="width:10%; text-align:center;"><strong>CANTIDAD</strong></td>
                                <td style="width:20%; text-align:center;"><strong>FORMATO</strong>	</td>
                                <td style="width:70%; text-align:center;"><strong>PRODUCTO/S REFERENCIADO/S</strong></td>		
							</tr>
						</thead>
						<tbody>
								@foreach($pedido->PedidosDetalle as $pedDet)
                                <tr>
                                    <td style="text-align:center; padding-right:10px;"><span class="texto">{{$pedDet->cantidad}}</span></td>
                                    <td style="text-align:left; padding-left:10px;"><span class="texto">{{$pedDet->FormatosPedido->formato}}</span></td>
                                    <td style="text-align:left; padding-left:10px;"><span class="texto">{{$pedDet->Producto->nombreProducto}}</span></td>
                                </tr>
                                @endforeach
						</tbody>
					</table>
                
                    <table  style="margin-top:20px;">
                        <tbody>
								<tr>
                                    <td width="60%" style="border:none !important; text-align:right; vertical-align:top; padding-top:16px; position:relative;">
                                    	<small style="">Pedido solicitado por:</small>
                                    </td>
									<td width="40%" style="border:none !important;">
										<img class="body" src="img/{{$user_img}}" style="width: 300px; height: auto; margin: 0;" />
                                    </td>
                                </tr>
                        </tbody>
                        
                    </table>
				
				<div style="clear:both;"></div> 
           </div>
	  
	<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			window.print();
		});
	</script> 
                               
</body>
</html>


