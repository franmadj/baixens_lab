<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formula ajustada</title>
<style type="text/css">
body{
					font-family:Verdana, Geneva, sans-serif;
					font-size:11px;
				}
				h1{
					font-size:20px;	
				}
				.contenedor{
					width:70%;
					position:absolute;
					z-index:1;
					margin-top:150px;
					margin-left:15%;
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
					font-size:18px;
				}
				span.texto{
					font-size:18px;
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
				small{
					font-size:15px;
					font-weight:600;
					color:#1865ab;
				}
				small.kg{
					font-size:13px;
					font-weight:600;
					color:rgba(146,146,146,1.00);
				}
				</style>
</head>

<body>

			<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0; z-index:0;">
                <img class="body" src="img/print/fondoAjustada.jpg" style="width: 210mm; height: 297mm; margin: 0;" />
            </div>
            
           <div class="contenedor">
                    <table style="background-color:rgba(223,223,223,0.5);">
                        <thead>
                            <tr style="width:100%;">
                                <?php if(!isset($enlucido)){ ?>
                                <td style="text-align:center;" colspan="3"><h1>FÓRMULA AJUSTADA A PRODUCCIÓN</h1></td>
                                <?php }else{ ?>
                                <td style="text-align:center;" colspan="3"><h1>FÓRMULA <?php echo $enlucido. ' Maquina: '.$size; ?></h1></td>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td colspan="3"><small>Nombre:</small> <span class="texto">{{$formula->nombre}}</span>	</td>
                                </tr>
                                <tr>
                                    <td><small>Sección:</small> <span class="texto">{{$formula->SeccionesFormula->seccion}}</span></td>
                                    <td><small>Código fórmula:</small> <span class="texto">{{$formula->codigo}}</span>	</td>
                                    <td><small>Número fórmula:</small> <span class="texto">{{$formula->numero}}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><small>Equivalencia:</small><span class="texto">
                                            <?php $coma='';?>
                                        @foreach($formula->FormulasEquivalencia as $eq)
                                            @if($eq->display==1)
                                                <p> {{ $eq->equivalencia }} <?php if($eq->codigo!='')echo '('.$eq->codigo.')'; ?></p>
                                            @endif
                                        <?php $coma=', ';?>
                                        @endforeach
                                        </span>	</td>
                                    <td><small>Fecha:</small> <span class="texto">  {{ $formula->fecha }} </span></td>
                                </tr>
                                
                        </tbody>
                        
                    </table>
                    <div style="clear:both;"></div>
                    
                    
                    <table style="margin-top:20px;">
                        <thead class="center">
                            <tr>
                                <td style="width:30%;"><strong class="center">CANTIDAD</strong>	</td>
                                <td style="width:70%;"><strong class="center">PRODUCTO</strong>	</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $numComp=$pesoTotal=0; ?>
                            @foreach($formula->FormulasDetalle as $formDet)
                            <?php 
                            $numComp++; 
                            $pesoTotal+=$formDet->cantidad;
                            ?>
                                <tr class="ajustada_a_produccion">
                                     <td class="right"> <span class="texto">{{number_format((float)$formDet->cantidad, 3, '.', '')}} Kg.	</span> <input type="hidden" class="cantidad" value="{{number_format((float)$formDet->cantidad, 3, '.', '')}}"></td>
                                     <td class="left"><span class="texto" >{{$formDet->Producto->nombreClave}}</span></td>
                                </tr>
                                @endforeach
                                
                             <tr>
                                    <td  class="right"><span class="texto" style="font-weight:bold;"><?php echo $pesoTotal; ?> Kg.</span></td>
                                    <td style=" border:none;"></td>
                             </tr>
                        </tbody>
                        
                    </table>
                    
                    
                    <table style="margin-top:10px; border:none;">
                        <tbody>
                                <tr>
                                    <td style="width:40%; border:none; "><small>Nº de componentes</small> <strong class="pesoTotal"><?php echo $numComp; ?></strong></td>
                                    <td style="text-align:left; vertical-align:text-top; border:none; width:60%;"></td>
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
