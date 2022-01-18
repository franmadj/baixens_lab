<?php





$html = '
<html>
<head>
<style>
	body {font-family: sans-serif;
		font-size: 10pt;
	}
	p {	margin: 0pt; }
	table.items {
		border: 0.1mm solid #000000;
	}
	td { vertical-align: top; }
	.items td {
		border-left: 0.1mm solid #000000;
		border-right: 0.1mm solid #000000;
	}
	table thead td { background-color: #EEEEEE;
		text-align: center;
		border: 0.1mm solid #000000;
		font-variant: small-caps;
	}
	.items td.blanktotal {
		background-color: #EEEEEE;
		border: 0.1mm solid #000000;
		background-color: #FFFFFF;
		border: 0mm none #000000;
		border-top: 0.1mm solid #000000;
		border-right: 0.1mm solid #000000;
	}
	.items td.totals {
		text-align: right;
		border: 0.1mm solid #000000;
	}
	.items td.cost {
		text-align: "." center;
	}
	
	
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
<htmlpageheader name="myheader">
<div style="position: relative;">
                <img class="body" src="http://laboratorio/img/laboratorio_fondo.jpg" style="width: 100%; margin: 0;" />
            </div>


</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Página {PAGENO} de {nb}

</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->



<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">';



                
					
                    $idSeccion='';
					
foreach ($formulas as $formula) {
    if ($formula->idSeccionFormula != $idSeccion) {
        $idSeccion = $formula->idSeccionFormula;

        $html.='
                        <tr class="min">
                            <td colspan="5" width="100%" class="minimo_titulo" style="text-align:center; background-color:#FAFAFA"><h1>';

        if ($formula->SeccionesFormula) {

            $html.= $formula->SeccionesFormula->seccion;
        } else {
            $html.= 'no Seccion DB';
        }




        $html.='</h1></td> 
                        </tr>
                    
                        <tr class="black">
                            <td><strong>NF</strong>	</td>
                            <td><strong>Codigo</strong>	</td>
                            <td ><strong>Nombre formula</strong>	</td>
                            <td ><strong>Equivalencias</strong>	</td>
                            <td><strong>Importe €</strong>	</td>
                        </tr>';
    } 
    $coma = '';

    $html.='<tr>
                                <td><small>'.$formula->numero.'</small></td>
                                <td><small>'.$formula->codigo.'</small></td>
                                <td><small>'.$formula->nombre.'</small></td>
                                <td><small>';
    
    foreach ($formula->FormulasEquivalencia as $eq) {
        $html.= $coma . $eq->equivalencia . '<br>';
        $coma = ', ';
    }
    $html.='</small></td><td><small>' . Formula::importe($formula->id) . '</small></td></tr>';
}


								
$html.='</table></body></html>';
//echo $html;exit;


include(public_path() . "/packages/MPDF57/mpdf.php");



$mpdf = new mPDF('',    // mode - default
		 '',    // format - A4, for example, default
		 0,     // font size - default 0
		 '',    // default font family
		 0,    // margin_left
		 0,    // margin right
		 45,     // margin top
		 20,    // margin bottom
		 'L');  // L - landscape, P - portrait
	 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
		
		//$mpdf->SetWatermarkImage('http://laboratorio/img/laboratorio_fondo.jpg', 0.7);

//$mpdf->showWatermarkImage = true;
		
	
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
?>

