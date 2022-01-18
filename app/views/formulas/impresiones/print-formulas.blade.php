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
					font-size:10px;	
				}
				.contenedor{
					width:100%;
					position:absolute;
					z-index:1;
					margin-top:250px;
					height:3000px;
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
				strong{
					font-size:10px;
				}
				span.texto{
					font-size:10px;
				}
				small{
					font-size:10px;
					font-weight:600;
					color:#1865ab;
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
				</style>
</head>

<body>
<!--mpdf

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0; z-index:0;">
                <img class="body" src="img/print/laboratorio_fondo.jpg" style="width: 210mm; height: 297mm; margin: 0;" />
            </div>
           <div class="contenedor">
              
	
          
                <table >
                    @foreach($formulas as $formula)
                    <?php if($formula->idSeccionFormula!=$idSeccion){ 
                        $idSeccion=$formula->idSeccionFormula; 
                    ?>
                    <thead>
                        <tr class="min">
                            <td colspan="5" width="100%" class="minimo_titulo" style="text-align:center; background-color:#FAFAFA"><h1>
							<?php if($formula->SeccionesFormula){ ?>
                                                                    
									 {{$formula->SeccionesFormula->seccion}}
                               <?php }else{ echo 'no Seccion DB';} ?>
							
							
							
							
							</h1></td> 
                        </tr>
                    </thead>
                    <thead>
                        <tr class="black">
                            <td><strong>NF</strong>	</td>
                            <td><strong>Código</strong>	</td>
                            <td ><strong>Nombre formula</strong>	</td>
                            <td ><strong>Equivalencias</strong>	</td>
                            <td><strong>Importe €</strong>	</td>
                        </tr>
					</thead>
                    <?php } $coma=''; ?>
                    <tbody>
                        
                            <tr>
                                <td><small>{{$formula->numero}}</small></td>
                                <td><small>{{$formula->codigo}}</small></td>
                                <td><small>{{$formula->nombre}}</small></td>
                                <td><small>
                                        @foreach($formula->FormulasEquivalencia as $eq)
                                			{{$coma.$eq->equivalencia}}<br>
                                                        <?php $coma=', '; ?>
                                  
                                        @endforeach
                                </small></td>
                                <td><small>{{Formula::importe($formula->id)}}</small></td>
                            </tr>
                            
                    </tbody>
                    @endforeach
                    
                    
                    
                    
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