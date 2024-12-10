<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formula de laboratorio valorada</title>
<style type="text/css">
body{
					font-family:Verdana, Geneva, sans-serif;
					font-size:10px;
				}
				h1{
					font-size:14px;	
				}
				.contenedor{
					width:100%;
					
					z-index:1;
					
				}
				table.table-popup tr td{
					border: thin solid rgba(182,182,182,1.00);
					border-collapse: collapse;
					padding:3px;
				}
				table.table-popup tr{
					width:100%;
				}
				table.table-popup{
					width:700px;
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
				.right{
					text-align:right !important;
					padding-right:10px;
					position:relative;
				}
				.left{
					text-align:left !important;
					padding-left:20px;
					position:relative;
				}
				.center{
					text-align:center !important;
				}
				strong{
					font-size:12px;
				}
				span.texto{
					font-size:10px;
				}
				small{
					font-size:10px;
					font-weight:600;
					color:#1865ab;
				}
				</style>
</head>

<body>

			
            
           <div class="contenedor">
                <table class="table-popup">
                    <thead>
                        <tr>
                            <td style="text-align:center;" colspan="2"><h1>FÓRMULA DE LABORATORIO VALORADA</h1></td> 
                        </tr>
					</thead>
                    <tbody>
                            <tr>
                                <td><small>Nombre:</small> <span class="texto">{{$formula->nombre}}</span>	</td>
                                <td><small>Sección:</small> <span class="texto">{{$formula->seccion_name}}</span></td>
                            </tr>
                            <tr>
                                <td><small>Código fórmula:</small> <span class="texto">{{$formula->codigo}}</span>	</td>
                                <td><small>Número fórmula:</small> <span class="texto">{{$formula->numero}}</span></td>
                            </tr>
                            <tr>
                                <td><small>Equivalencia:</small>
                                	<span class="texto">
                                        <?php $coma='';?>
                                    @foreach($formula->FormulasEquivalencia as $eq)
                                        @if($eq->display==1)
                                            <p> {{ $eq->equivalencia }} <?php if($eq->codigo!='')echo '('.$eq->codigo.')'; ?></p>
                                        @endif
                                    <?php $coma=', ';?>
                                    @endforeach
                                    </span>	
                                </td>
                                <td><small>Fecha:</small> <span class="texto">@if($formula->fecha > 1) {{$formula->fecha}} @endif</span></td>
                            </tr>
                            
                    </tbody>
                    
                </table>
                
                <table class="table-popup" style="margin-top:20px; text-align:center;">
                    <thead>
                        <tr>
                            <td><strong>CÓDIGO</strong>	</td>
                            <td><strong>PRODUCTO</strong>	</td>
                            <td><strong>CANTIDAD</strong>	</td>
                            <td><strong>COSTE</strong>	</td>
                            <td><strong>IMPORTE</strong>	</td>
                            <td><strong>PORCENTAJE</strong>	</td>
                        </tr>
					</thead>
                    <tbody>
                        <?php $numComp=$pesoTotal=$precioXkg=$totCoste=0; ?>
                        @foreach($componentes as $formDet)
                        <?php 
                        $numComp++; 
                        $pesoTotal+=$formDet['cantidad'];
                        $totCoste+=isset($formDet['Producto']->coste)? $formDet['Producto']->coste* $formDet['cantidad']:0;
                        ?>
                        @endforeach
                        <?php 
                        $precioXkg=$totCoste/$pesoTotal;
                        ?>
                        @foreach($componentes as $formDet)
                            <tr> 
                                <td class="right"><span class="texto">{{isset($formDet['Producto']->codigo)?$formDet['Producto']->codigo:''}}</span></td>
                                <td class="left"><span class="texto">{{isset($formDet['Producto']->nombreProducto)?$formDet['Producto']->nombreProducto:''}}</span></td>
                                <td class="right"><span class="texto">{{ number_format($formDet['cantidad'],3) }}</span></td>
                                <td class="right"><span class="texto">{{ isset($formDet['Producto']->coste)?$formDet['Producto']->coste:'sin precio' }}</span></td>
                                <td class="right"><input type="hidden" class="densidad" value="{{isset($formDet['Producto']->densidad)?$formDet['Producto']->densidad:0}}"><span class="texto">
								{{ number_format((isset($formDet['Producto']->coste)? $formDet['Producto']->coste:0) * $formDet['cantidad'], 3) }}</span></td>
                                <td class="right"><span class="texto">
                                    {{ AppHelper::calcularPorcentaje($formDet['cantidad'], $pesoTotal) }}</span>%</td>
                            </tr>
                            @endforeach
                    </tbody>
                    
                </table>
                
                
                <table style="margin-top:20px; text-align:left; border:none;">
                    <tbody>
                            <tr>
                                <td style="text-align:left; vertical-align:text-top;  border:none;" width="60%">
                                    <small>Nº de componentes</small> <strong><?php echo $numComp; ?></strong>
                                </td>
                                
                                <td><small>Importe fórmula (€)</small></td>
                                <td class="right"><strong class="importeTotal"><?php echo number_format((float)$totCoste, 3, '.', '');; ?></strong></td>
                            </tr>
                            <tr>
                            	<td style="text-align:left; vertical-align:text-top;  border:none;"></td>
                                <td><small>Peso fórmula (Kg)</small></td>
                                <td class="right"><strong class="pesoTotal"><?php echo $pesoTotal; ?></strong></td>
                            </tr>
                            <tr>
                            	<td style="text-align:left; vertical-align:text-top;  border:none;"></td>
                            	<td><small>Coste (€/kg)</small></td>
                                <td class="right"><strong class="precioXkg"><?php echo number_format($precioXkg, 2); ?></strong></td>
                            </tr>
                            
                    </tbody>
                    
                </table>
                
                
             </div>
             
             
                <div style="clear:both;"></div>
           </div>
    


                                       
                                     
</body>

</html>
