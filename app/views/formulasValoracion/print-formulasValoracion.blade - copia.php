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
                                        padding-left:10px;
                                        text-align: justify;
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
                            <td style="width:100%; text-align:center;" colspan="2"><h1>VALORACIÓN DE FORMULAS</h1></td> 
                        </tr>
					</thead>
                    <tbody>
                            <tr>
                                <td style="width:50%;"><small>Nombre:</small> <strong>{{$formula->nombre}}</strong>	</td>
                                <td style="width:50%;"><small>Fecha:</small> <strong>{{ $formula->fecha }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;"><small>Observaciones</small></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;"><strong>{{$formula->observaciones}}</strong></td>
                            </tr>
                    </tbody>
                    
                </table>
                
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:center;">
                    <thead>
                        <tr class="black">
                            <td style="width:10%;"><strong>CÓDIGO</strong>	</td>
                            <td style="width:50%;"><strong>PRODUCTO</strong>	</td>
                            <td style="width:10%;"><strong>CANTIDAD</strong>	</td>
                            <td style="width:10%;"><strong>COSTE</strong>	</td>
                            <td style="width:10%;"><strong>IMPORTE</strong>	</td>
                            <td style="width:10%;"><strong>PORCENTAJE</strong>	</td>
                        </tr>
					</thead>
                    <tbody>
                        <?php $numComp=$pesoTotal=$precioXkg=$totCoste=0; ?>
                        @foreach($formula->FormulasValoracionDetalle as $formDet)
                        <?php 
						
						
                        $numComp++; 
                        $pesoTotal+=$formDet->cantidad;
						
                        $totCoste+=$formDet->Producto->coste * $formDet->cantidad;
						
						
                        ?>
                        @endforeach
                        <?php 
						
						if($pesoTotal<1)$pesoTotal=1;
						if($totCoste<1)$totCoste=1;
						
						
                        $precioXkg=$totCoste/$pesoTotal;
                        ?>
                        @foreach($formula->FormulasValoracionDetalle as $formDet)
                            <tr>
                                <td><small>{{$formDet->Producto->codigo}}</small></td>
                                <td><small>{{$formDet->Producto->nombreProducto}}</small></td>
                                <td><small>{{$formDet->cantidad}}</small></td>
                                <td><small>{{$formDet->Producto->coste}}</small></td>
                                <td><small>{{$formDet->Producto->coste * $formDet->cantidad}}</small></td>
                                <td><small>{{ AppHelper::calcularPorcentaje($formDet->cantidad, $pesoTotal) }}</small></td>
                            </tr>
                            @endforeach
                    </tbody>
                    
                </table>
                
                
                <table width="80%" class="table_gran"  style="margin-left:auto; margin-right:auto; position:relative; margin-top:20px; text-align:left; border:none;">
                    <tbody>
                            <tr>
                                <td style="text-align:left; vertical-align:text-top;  border:none;" width="70%">
                                	<small>Nº de componentes</small> <strong><?php echo $numComp; ?></strong>
                                </td>
                                
                                <td><small>Importe formula</small></td>
                                <td><strong><?php echo $totCoste; ?></strong></td>
                            </tr>
                            <tr>
                            	<td style="text-align:left; vertical-align:text-top;  border:none;"></td>
                                <td><small>Peso formula</small></td>
                                <td><strong><?php echo $pesoTotal; ?></strong></td>
                            </tr>
                            <tr>
                            	<td style="text-align:left; vertical-align:text-top;  border:none;"></td>
                            	<td><small>Precio por kg €</small></td>
                                <td><strong><?php echo $precioXkg; ?></strong></td>
                            </tr>
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