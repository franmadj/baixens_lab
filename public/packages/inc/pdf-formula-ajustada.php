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
					border: solid thin rgba(182,182,182,1.00);
					border-collapse: collapse;
					padding:5px;
                                        border-top:none;
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
				}
                                #encabezado-detalles td,#encabezado-detalles tr{
                                padding:0px;
                                }
                                #encabezado-detalles span.texto{
					font-size:5px !important;
				}
                                
';

$esPinturas = formulaEsPinturas($formula->idSeccionFormula);


if (in_array($formula->idSeccionFormula, [3, 11, 5, 10, 8, 14, 15]))
    $html .= 'table.t-margin-left{margin-left:180px;}';




$html .= '</style>
</head>
<body>

<div style="width:580px;margin:auto;color:black;padding-bottom:8px;text-align:_center;font-size:8.6px;">ESTABLECIMIENTOS BAIXENS, S.L. Polígono Industrial Moncarra, s/n. 46230 Alginet(Valencia) - España - Tel.:+34 96 1750834 - Fax:+34 96 1752471</div>
<table>

                            <tr style="width:100%;">';




///////////////////FRANJA ROSA ENCABEZADO////////////////////////////////////////
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
        $formula->codigo = trim($eq->codigo);
    }
}

if (!$esPinturas) {
    $equiv = $equiv ?: $formula->nombre;
    $nombre = '<td colspan="4" style="width:100%;"><span class="texto" style="font-size:12px;">' . $equiv . '</span>	</td>';
} else {
    $equivsOut = '<div>' . $equivs . '</div>';
    $nombre = '<td colspan="4" style="width:100%;font-size:12px;"><span style="font-size:12px;" class="texto">' . $formula->nombre . '</span>' . $equivsOut . '</td>';
}

//$debug = true;
///////////////ENCABEZADO FORMULA////////////////////////////////
$html .= '<table id="encabezado-detalles" style="background-color:rgba(223,223,223,0.5);margin-top:0px;widh:100%;">
                        <tbody>';





/////////////////////TR 1////////////////////
$html .= '<tr>
                                <td rowspan="2" style="background:white; width:10%"><img class="body" src="/img/logo_color.jpg" style="width: 40px; margin-right:2px;margin-left:2px;" /></td>
                                    ' . $nombre . '
                                </tr>';




///////////////////////////////////////
//if ($esPinturas)
//    $html .= '<tr><td colspan="2"><small>Núm. fórmula:</small> <span class="texto">' . $formula->numero . '</span></td></tr>';



if ($formula->idSeccionFormula == $_ENV['SATE'])
    $seccion = 'Sate';
elseif ($formula->idSeccionFormula)
    $seccion = $formula->seccionesFormula->seccion;
else
    $seccion = '';

/////////////////////TR 3////////////////////
$html .= '<tr>';


//70max chars row
$codFormula = trim($formula->codigo);
$numPintura = trim($formula->numero_pintura);
$numFormula = trim($formula->numero);
$fechaUltEdicion = trim($formula->fechaUltEdicion);
$instrucciones = trim($formula->instrucciones);
$fields = [
    ['value' => $seccion, 'html' => '<small>Sección:</small> <span class="texto">' . $seccion . '</span>', 'code' => 'seccion', 'strlen' => strlen('Sección: ' . $seccion)],
    ['value' => $codFormula, 'html' => '<small>Cód. fórmula:</small> <span class="texto">' . $codFormula . '</span>', 'code' => 'codeFormula', 'strlen' => strlen('Cód. fórmula: ' . $codFormula)],
    ['value' => $numPintura, 'html' => '<small>Núm. pintura:</small> <span class="texto">' . $numPintura . '</span>', 'code' => 'numPintura', 'strlen' => strlen('Núm. pintura:' . $numPintura)],
    ['value' => $numFormula, 'html' => '<span class="texto" style="color:red;">NF' . $numFormula . '</span>', 'code' => 'numFormula', 'strlen' => strlen('NF' . $numFormula)],
    ['value' => $fechaUltEdicion, 'html' => '<span class="texto">' . $fechaUltEdicion . '</span>', 'code' => 'fechaUltEdicion', 'strlen' => strlen($fechaUltEdicion)],
    ['value' => $instrucciones, 'html' => '<small>IT.:</small> <span class="texto">' . $instrucciones . '</span>', 'code' => 'instrucciones', 'strlen' => strlen('IT.: ' . $instrucciones)]
];

$totalCols = 5;
$maxCharsRow = 50;
$charsCell = $maxCharsRow / $totalCols;
$colsCount = 0;
$html .= '<tr>';
foreach ($fields as $field) {
    if ($field['value']) {
        //if($colsCount>)
        $colspan = round($field['strlen'] / $charsCell);
        if ($colspan > 5)
            $colspan = 5;
        if ($colspan < 1)
            $colspan = 1;

        $leftCols = (5 - $colsCount);

        if ($colspan > $leftCols) {
            $html .= '</tr><tr>';
            $colsCount = 0;
        }
        $colsCount += $colspan;

        $html .= '<td colspan="' . $colspan . '">' . $field['html'] . '</td>';
    }
}
if ($colsCount < 5)
    $html .= '<td colspan="' . (5 - $colsCount) . '"></td>';

$html .= '</tr></tbody></table>';
$debug = false;


/*
  $colspan = '';
  if (!$codFormula) {
  $colspan = ' colspan="2"';
  } elseif (!$esPinturas && !$formula->numero) {
  $colspan = ' colspan="2"';
  }

  if (!$esPinturas && !$formula->numero && !$codFormula) {
  $colspan = ' colspan="3"';
  }

  $html .= '<td ' . $colspan . '>';
  $html .= '<small>Sección:</small> <span class="texto">' . $seccion . '</span>';
  $html .= '</td>';



  if ($codFormula) {
  $html .= '<td>';
  $html .= ' <small>Cód. fórmula:</small><span class="texto">' . $codFormula . '</span>';
  $html .= '</td>';
  }

  if ($esPinturas && $numPintura) {
  $html .= '<td>';
  $html .= ' <small>Núm. pintura:</small> <span class="texto">' . $formula->numero_pintura . '</span>';
  $html .= '</td>';
  }

  if ($formula->numero && $numFormula) {
  $html .= '<td>';
  $html .= ' <span class="texto" style="color:red;">NF' . $formula->numero . '</span>';
  $html .= '</td>';
  }



  $html .= '<td>';
  $html .= '<span class="texto">' . $formula->fechaUltEdicion . '</span>';
  $html .= '</td>';

  $html .= '</tr>';










  /////////////////////TR 4////////////////////
  $html .= '<tr>';
  if ($formula->instrucciones != '') {
  $html .= '<td colspan="5"><small>IT.:</small> <span class="texto">';
  $html .= $formula->instrucciones;
  $html .= '</span></td>';
  }
  $html .= '</tr></tbody></table>';



 */










///////////////////CUERPO///////////////////////////////
$html .= '<table style="margin-top:0px;" class="cuerpo t-margin-left">
                        <thead class="center">
                            <tr>
                                <td style="width:30%;border-top:0;"><strong class="center">CANTIDAD</strong>	</td>
                                <td style="width:70%;border-top:0;"><strong class="center">PRODUCTO</strong>	</td>
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
                                    <td style=" border:none;"><small>Nº de componentes</small> <strong class="pesoTotal">' . $numComp . '</strong></td>
                             </tr>
                        </tbody>
                        
                    </table>
                    
                    
                    </body></html>';

if ($debug) {
    echo $html;
    exit;
}


include(public_path() . "/packages/MPDF57/mpdf.php");



$mpdf = new mPDF('', // mode - default
        [170, 297], // format - A4, for example, default
        0, // font size - default 0
        '', // default font family
        0, // margin_left
        0, // margin right
        4, // margin top
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

