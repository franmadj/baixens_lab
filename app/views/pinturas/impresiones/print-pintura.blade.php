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
                position:absolute;
                z-index:1;
                margin-top:180px;
            }
            table tr td{
                border: thin solid rgba(182,182,182,1.00);
                border-collapse: collapse;
                padding:3px;
            }
            table tr{
                width:100%;
            }
            table{
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
			.resaltar{
				color: #a1a1a1;
    font-weight: bolder !important;
			}
        </style>
    </head>

    <body>

        <div style="position: absolute; left:0; right: 0; top: 0; bottom: 0; z-index:0;">
            <img class="body" src="img/print/laboratorio_fondo.jpg" style="width: 210mm; height: 297mm; margin: 0;" />
        </div>

        <div class="contenedor">
            <table>
                <thead>
                    <tr>
                        <td style="text-align:center;" colspan="2"><h1>Formula Pintura</h1></td> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><small>Nombre:</small> <span class="texto">{{$formula->nombre}}</span>	</td>
                        <td><small>Tipo:</small> <span class="texto">{{$formula->pintura_tipo}}</span></td>
                    </tr>
                    <tr>
                        <td><small>Estado:</small> <span class="texto">{{$formula->pintura_estado}}</span>	</td>
                        <td><small>Número:</small> <span class="texto">{{$formula->numero_pintura}}</span></td>
                    </tr>
                    <tr>
                        <td><small>Ajustar a:</small> <span class="texto">{{$formula->pintura_ajustar_a}}</span>	</td>
                        <td><small>Fecha:</small> <span class="texto">{{$formula->fecha}}</span></td>
                    </tr>

                </tbody>

            </table>

            <table id="append" style="margin-top:20px; text-align:center;">
                <thead>
                    <tr>
                        <td>CÓDIGO	</td>
                        <td>C. PESADA	</td>
                        <td>PRODUCTO	</td>
                        <td>TIPO	</td>
                        <td>% TEORICO	</td>
                        
                        <td class="resaltar">C. TEORICA	</td>
                        
                        <td>% PESADO	</td>
                        
                        <td>APORT. PRECIO TEORICO	</td>
                        <td style="width:25%;">NOTAS	</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $porTeorico = 0; 
                    $cantTeorico = 0; 
                    $cantPesada = 0;
                    $porcentajePesado=0;
                    
                    
                    ?>
                    @foreach($formula->FormulasDetalle as $formDet)

                    @endforeach

                    @foreach($formula->FormulasDetalle as $formDet)
                    
                    
                    <?php 
                    $cantPesada += $formDet->cantidad;
                    $cantTeorico +=$formDet->cantidad_teorica; 
                    $porTeorico +=$formDet->porcentaje_teorico; 
                    $porcentajePesado+=$formDet->porcentaje_pesado; 
                    
                    
                    
                    
                    ?>
                    <tr class="new-rows">
                        <td class="right"><span class="texto">{{$formDet->Producto->codigo}}</span></td>
                        <td class="right"><span class="texto"><input type="hidden" class="cantidad_pesada" value="{{$formDet->cantidad}}">{{ ($formDet->cantidad) }}</span></td>
                        <td class="left"><span class="texto">{{$formDet->Producto->nombreProducto}}</span></td>
                        <td class="right">{{$formDet->tipo}}</td>
                        <td class="right"><span class="texto"><input type="hidden" class="porcentaje_teorico" value="{{$formDet->porcentaje_teorico}}">{{ $formDet->porcentaje_teorico }}</span></td>
                        <td class="right"  style="background-color:gainsboro;"><span class="texto"><input type="hidden" class="cantidad_teorica" value="{{$formDet->cantidad_teorica}}">{{ $formDet->cantidad_teorica }}</span></td>
                        
                        <td class="right"><span class="texto">{{ ($formDet->porcentaje_pesado) }}</span></td>
                        
                        <td class="right">{{$formDet->aportacion_precio_teorico}}</td>
                        <td class="right" style="background-color:gainsboro;"></td>

                    </tr>
                    @endforeach
                </tbody>


                <tbody>

                    <tr>
                        <td >
                            Total
                        </td>
                        <td>
                            <?php echo $cantPesada; ?>
                            
                        </td>
                        <td >
                            

                        </td>

                        <td>
                            
                            
                            

                        </td>
                        <td>
                            <?php echo round($porTeorico); ?>
                            

                        </td>


                        <td>
                            <?php echo $cantTeorico; ?>
                            
                        </td>
                        <td>
                            <?php echo round($porcentajePesado); ?>
                            
                        </td>


                        
                        <td class="product_values">


                        </td>

                        <td class="boton text-right" colspan="10"></td>

                    </tr>




                </tbody>





            </table>


            <table style="margin-top:20px; text-align:left; border:none;">
                <tbody>
                    <tr>
                        <td></td>
                        <td>Objetivo</td>
                        <td>Teorico</td>
                        <td >Pesado</td>
                        <td >Medido</td>
                    </tr>
                    <tr>
                        <td><small>% Solidos</small></td>
                        <td >{{$formula->porcentaje_solidos_objetivo}}</td>
                        <td >{{$formula->porcentaje_solidos_teorico}}</td>
                        <td >{{$formula->porcentaje_solidos_pesado}}</td>
                        <td >{{$formula->porcentaje_solidos_medio}}</td>
                    </tr>
                    <tr>
                        <td><small>PVC</small></td>
                        <td >{{$formula->pvc_objetivo}}</td>
                        <td >{{$formula->pvc_teorico}}</td>
                        <td >{{$formula->pvc_pesado}}</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td><small>Densidad</small></td>
                        <td >{{$formula->densidad_objetivo}}</td>
                        <td >{{$formula->densidad_teorico}}</td>
                        <td >{{$formula->densidad_pesado}}</td>
                        <td >{{$formula->densidad_medio}}</td>
                    </tr>
                    <tr>
                        <td><small>% TiO2</small></td>
                        <td >{{$formula->tio2_objetivo}}</td>
                        <td >{{$formula->tio2_teorico}}</td>
                        <td >{{$formula->tio2_pesado}}</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td><small>% Ligante</small></td>
                        <td >{{$formula->ligante_objetivo}}</td>
                        <td >{{$formula->ligante_teorico}}</td>
                        <td >{{$formula->ligante_pesado}}</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td><small>Precio (€/kg)</small></td>
                        <td >{{$formula->precio_eu_kg_objetivo}}</td>
                        <td >{{$formula->precio_eu_kg_teorico}}</td>
                        <td >{{$formula->precio_eu_kg_pesado}}</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td><small>Precio (€/L)</small></td>
                        <td >{{$formula->precio_eu_lt_objetivo}}</td>
                        <td >{{$formula->precio_eu_lt_teorico}}</td>
                        <td >{{$formula->precio_eu_lt_pesado}}</td>
                        <td >{{$formula->precio_eu_lt_medido}}</td>
                    </tr>
                    <tr>
                        <td><small>Viscosidad (cP)</small></td>
                        <td >{{$formula->viscosidad_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->viscosidad_medio}}</td>
                    </tr>
                    <tr>
                        <td><small>Brillo 60ª</small></td>
                        <td >{{$formula->brillo_60_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->brillo_60_medio}}</td>
                    </tr>
                   
                    <tr>
                        <td><small>Brillo 85ª</small></td>
                        <td >{{$formula->brillo_85_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->brillo_85_medio}}</td>
                    </tr>
                    <tr>
                        <td><small>Cubrición</small></td>
                        <td >{{$formula->cubricion_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->cubricion_medio}}</td>
                    </tr>
                    
                    <tr>
                        <td><small>Resistencia Frote</small></td>
                        <td >{{$formula->res_flote_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->res_flote_medio}}</td>
                    </tr>
					
					
					
					<tr>
                        <td><small>L</small></td>
                        <td >{{$formula->l_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->l_medio}}</td>
                    </tr>
                   
                    <tr>
                        <td><small>a</small></td>
                        <td >{{$formula->a_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->a_medio}}</td>
                    </tr>
                    <tr>
                        <td><small>b</small></td>
                        <td >{{$formula->b_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->b_medio}}</td>
                    </tr>
                    
                    <tr>
                        <td><small>Y</small></td>
                        <td >{{$formula->y_objetivo}}</td>
                        <td ></td>
                        <td ></td>
                        <td >{{$formula->y_medio}}</td>
                    </tr>
                </tbody>

            </table>


        </div>


        <div style="clear:both;"></div>
    </div>


 


</body>

</html>
