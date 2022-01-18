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
					font-size:16px;	
				}
				.contenedor{
					width:100%;
					position:absolute;
					z-index:1;
					margin-top:250px;
					
				}
				table tr td{
					border: 0.1 solid rgba(182,182,182,1.00);
					border-collapse: collapse;
					padding:5px;
				}
				table tr{
					width:100%;
				}
				table{
					width:600px;
					border-collapse:collapse;
					margin-left:5%; 
					margin-right:5%; 
					position:relative;
				}
				img{
					vertical-align: middle;
					padding-left: 14px;
				}
				img.body{
					vertical-align:top;
					padding-left: 0px;
				}
				strong{
					font-size:14px;
				}
				span.texto{
					font-size:14px;
				}
				small{
					font-size:12px;
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
				table.cuerpo tr td{
					height:30.300px;
				}';

$esPinturas = formulaEsPinturas($formula->idSeccionFormula);


if (in_array($formula->idSeccionFormula, [3, 11, 5, 10, 8, 14, 15]))
    $html .= 'table.t-margin-left{margin-left:180px;}';




$html .= '</style>
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



<table>
                            <tr style="width:100%;">';
if (!isset($data['enlucido'])) {
    $html .= '<td style="text-align:center; background-color:#F78181;padding:2px;" colspan="3"><h1>FÓRMULA AJUSTADA A PRODUCCIÓN</h1></td></table>';
} else {
    //$html.='<td style="text-align:center;" colspan="3"><h1>FÓRMULA ' . $data['enlucido'] . ' Maquina: ' . $data['size'] . '</h1></td>';
    $color = $data['size'] == 'Grande' ? '#A9D0F5' : '#F5ECCE';
    $html .= '<td style="text-align:center;background-color:' . $color . '; border-color:' . $color . ';padding:2px;" colspan="3"><h1>LINEA MASILLAS Y ENLUCIDOS</h1></td></tr></table>';
}
$codigo_maquina = false;



$equiv = false;
$coma = $equivs = $equivsOut = '';
foreach ($formula->FormulasEquivalencia as $eq) {
    if ($eq->display == 1) {
        $equiv = $eq->equivalencia;
        $equivs .= $coma . $eq->equivalencia;
        $coma = ', ';
        $formula->codigo = $eq->codigo;
    }
}

if (!$esPinturas) {
    $equiv = $equiv ?: $formula->nombre;
    $nombre = '<td colspan="3"><span class="texto">' . $equiv . '</span>	</td>';
} else {
    $equivsOut = '<div>' . $equivs . '</div>';
    $nombre = '<td colspan="3"><span class="texto">' . $formula->nombre . '</span>' . $equivsOut . '</td>';
}

$html .= '<table style="background-color:rgba(223,223,223,0.5);margin-top:5px;" class="t-margin-left">
                        <tbody>
                                <tr>
                                    ' . $nombre . '
                                </tr>';
if ($esPinturas)
    $html .= '<tr><td colspan="3"><small>Número fórmula:</small> <span class="texto">' . $formula->numero . '</span></td></tr>';


$html .= '<tr>
                                    <td><small>Sección:</small> <span class="texto">' . $formula->SeccionesFormula->seccion . '</span></td>
                                    <td><small>Código fórmula:</small> <span class="texto">' . $formula->codigo . '</span>	</td>';
if ($esPinturas)
    $html .= '<td><small>Número pintura:</small> <span class="texto">' . $formula->numero_pintura . '</span></td>';
else
    $html .= '<td><small>Número fórmula:</small> <span class="texto">' . $formula->numero . '</span></td>';

'</tr>
                                <tr>
                                    
                                    <td colspan="3"><small>Fecha:</small> <span class="texto">';
$html .= $formula->fecha;
$html .= '</span></td>
                                </tr>
                                
<tr>';
if ($formula->instrucciones != '') {

    $html .= '<td colspan="4"><small>Instruccion de Trabajo:</small> <span class="texto">';
    $html .= $formula->instrucciones;
    $html .= '</span></td>';
}
$html .= '</tr>
                                
                        </tbody>
                        
                    </table>';



$html .= '<table style="margin-top:5px;" class="cuerpo t-margin-left">
                        <thead class="center">
                            <tr>
                                <td style="width:30%;"><strong class="center">CANTIDAD</strong>	</td>
                                <td style="width:70%;"><strong class="center">PRODUCTO</strong>	</td>
                            </tr>
                        </thead>
                        
                        <tbody>';
$numComp = $pesoTotal = 0;
foreach ($formula->FormulasDetalle as $formDet) {

    $numComp++;
    $pesoTotal += $formDet->cantidad;
    $product = isset($formDet->Producto->nombreClave) ? $formDet->Producto->nombreClave : '-';

    $html .= '<tr>
                                     <td class="right"> <span class="texto">' . number_format((float) $formDet->cantidad, 3, '.', '') . ' Kg.	</span> <input type="hidden" class="cantidad" value="' . number_format((float) $formDet->cantidad, 3, '.', '') . '"></td>
                                     <td class="left"><span class="texto" >' . $product . '</span></td>
                                </tr>';
}

$html .= '<tr>
                                    <td  class="right"><span class="texto" style="font-weight:bold;">' . round($pesoTotal) . ' Kg.</span></td>
                                    <td style=" border:none;"></td>
                             </tr>
                        </tbody>
                        
                    </table>
                    
                    
                    <table style="margin-top:10px; border:none;" class="t-margin-left">
                        <tbody>
                                <tr>
                                    <td style="width:40%; border:none; "><small>Nº de componentes</small> <strong class="pesoTotal">' . $numComp . '</strong></td>
                                    <td style="text-align:left; vertical-align:text-top; border:none; width:60%;"></td>
                                </tr>
                        </tbody>
                        
                    </table></body></html>';
//echo $html;exit;


include(public_path() . "/packages/MPDF57/mpdf.php");



$mpdf = new mPDF('', // mode - default
        [170, 297], // format - A4, for example, default
        0, // font size - default 0
        '', // default font family
        0, // margin_left
        0, // margin right
        20, // margin top
        20, // margin bottom
        'L');  // L - landscape, P - portrait

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
//$mpdf->SetWatermarkImage('http://laboratorio/img/laboratorio_fondo.jpg', 0.7);
//$mpdf->showWatermarkImage = true;


$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>

