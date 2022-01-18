<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento de compra</title>
<style type="text/css">

				body{
					font-family:Verdana, Geneva, sans-serif;
					font-size:11px;
					font-weight:bold;
				}
				.table{
					border-top: 1px solid #000;
					border-bottom: 1px solid #000;
					border-spacing:0;
					border-collapse: collapse;
					position:relative;
				}
				
				.text_left{
					text-align:left;	
				}
				
				.min{
					width:30%;	
				}
				
				
				.minimo_titulo{
					width:15%;	
					font-size:12px;
					font-weight:lighter;
					text-align:right;
				}
				.minimo_text{
					width:15%;	
					font-size:13px;
					font-weight:bold;
					padding-left:10px;
					
				}
				
				.left{
					float:left;
					position:relative;	
				}
				
				.right{
					float:right;
					position:relative;
				}
				h1{
					font-size:16px;	
				}
				.margin_top{
					margin-top:10px;
				}
				.padding_top{
					height:40px;
				}
				
				.table_gran tr td{
					border: thin solid #000;
					border-collapse: collapse;
					padding:5px;
				}
				.table_gran tr td.peq{
					width:2%;
					font-size:7px;
					padding: 0px;
				}
				table{
					border-collapse:collapse;
				}
				.black{
					font-weight:bold;
				}
				.light{
					font-weight:lighter;	
				}
				strong{
					font-size:14px;
					font-weight:600;
				}
				small{
					font-size:13px;
					font-weight:400;
				}
				</style>
</head>

<body>
           <div class="contenedor">
				<table width="80%" class="text_left" style="margin-left:auto; margin-right:auto; position:relative;">
                	<thead>
                        <tr class="min">
                            <td width="40%" class="minimo_titulo"><img src="../img/logo_color.png" width="92" height="99"></td> 
                            <td width="60%" style="text-align:center;">
                            										<h1 style="text-decoration:">Establecimiento Baixens</h1>
                                                                    Pol.Ind. Moncarra, S/N - 46230 Alginet (Valencia) España<br>
                                                                    Tel/Fax: 961 75 93 92<br>
                                                                    WWW.BAIXENS.COM
                                                                    
                            </td> 
                        </tr>
                    </thead>
                </table>
				
				
				
				
                <div style="clear:both;"></div>
           </div>
           
           <div class="margin_top">
                <table width="80%" class="text_left table_gran"  style="margin-left:auto; margin-right:auto; position:relative;">
                    <thead>
                        <tr class="black">
                            <td style="width:100%; text-align:center;" colspan="2"><h1>DOCUMENTO DE COMPRA</h1></td> 
                        </tr>
					</thead>
                    <tbody>
                            <tr>
                                <td style="width:50%;"><small>Proeevedor:</small> <strong>{{$pedido->Proveedor->nombre}}</strong>	</td>
                                <td style="width:50%;"><small>NºPedido D.C.</small> <strong>{{$pedido->numero}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width:50%;"><small>Domicilio:</small> <strong>{{$pedido->proveedor->domicilio}}</strong>	</td>
                                <td style="width:50%;"><small>Población</small> <strong>{{$pedido->proveedor->poblacion}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width:50%;"><small>Fecha de pedido:</small> <strong>{{date('d/m/Y', $pedido->fecha)}}</strong>	</td>
                                <td style="width:50%;"><small>Tipo de envio:</small> <strong>{{($pedido->envio=='e')?'en':'rec';}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width:50%;"><small>Persona que pasa pedido:</small> <strong>{{$pedido->User->usuario}}</strong>	</td>
                                <td style="width:50%;"><small>Persona que lo recibe:</small> <strong>{{$pedido->recibidoPor}}</strong></td>
                            </tr>
                            <tr>
                                <td style="width:50%; text-align:center;"><small>Télefono del proveedor:</small> <strong>{{$pedido->proveedor->tel}}</strong></td>
                                <td style="width:50%; text-align:center;"><small>Fax del proveedor:</small> <strong>{{$pedido->$proveedor->fax}}</strong></td>
                            </tr>
                            
                    </tbody>
                    
                </table>
                
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:center;">
                    <thead>
                        <tr class="black">
                            <td style="width:20%;"><strong>CANTIDAD</strong>	</td>
                            <td style="width:40%;"><strong>FORMATO</strong>	</td>
                            <td style="width:40%;"><strong>PRODUCTO/S REFERENCIADO/S</strong>	</td>
                        </tr>
					</thead>
                    <tbody>
                        @foreach($pedido->PedidoDetlle as $pedDet)
                            <tr>
                                <td><small>{{$pedDet->cant}}</small></td>
                                <td><small>{{$pedDet->Formato->formato}}</small></td>
                                <td><small>{{$pedDet->Producto->nombre}}</small></td>
                            </tr>
                            @endforeach
                           
                    </tbody>
                    
                </table>
                
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:center;">
                    <tbody>
                            <tr>
                                <td width="30%"><small>Fecha de entrega:</small></td>
                                <td width="70%" style="font-size:16px;"><strong>{{date('d/m/Y', $pedido->plazoEntrega)}}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;"><small>Observaciones</small></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;"><strong>{{$pedido->observaciones}}</strong></td>
                            </tr>
                            
                    </tbody>
                    
                </table>
                
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:center; border:none;">
                    <tbody>
                            <tr>
                                <td style="text-align:left; vertical-align:text-top;  border:none;" width="70%">
                                	Nota: <small>Rogamos indiquen en sus albaranes y facturas el número de pedido indicado en la parte superior de esta hoja.</small><br><br>
                                    Horario de descarga: <small>{{$horarioDescarga->meta_value}}</small>
                                </td>
                                
                                <td style="text-align:left; vertical-align:text-top; height:100px;" width="30%"><small>Persona que autoriza el pedido<br>FIRMA:</small></td>
                            </tr>
                    </tbody>
                    
                </table>
                
                
                <div style="clear:both;"></div>
             </div>                         
                                       
                                     
</body>
</html>

