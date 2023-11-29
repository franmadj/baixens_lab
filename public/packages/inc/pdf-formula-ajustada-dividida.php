<?php ob_start(); ?>
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
            <?php
            $esPinturas = formulaEsPinturas($formula->idSeccionFormula);
            $debug = false;
            if (in_array($formula->idSeccionFormula, [3, 11, 5, 10, 8, 14, 15]))
                echo 'table.t-margin-left{margin-left:180px;}';
            ?>
        </style>

    </head>
    <body>


        <!--    MATERIA ACTIVA 
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ------>

        <div style="width:580px;margin:auto;color:black;padding-bottom:8px;text-align:_center;font-size:8.6px;">ESTABLECIMIENTOS BAIXENS, S.L. Polígono Industrial Moncarra, s/n. 46230 Alginet(Valencia) - España - Tel.:+34 96 1750834 - Fax:+34 96 1752471</div>
        <table>

            <tr style="width:100%;">
                <!--                ///////////////////FRANJA ROSA ENCABEZADO////////////////////////////////////////-->
                <td style="text-align:center; background-color:#F78181;padding:2px;" colspan="3"><h1>FÓRMULA AJUSTADA A PRODUCCIÓN</h1></td></table>
        <?php
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
            $nombre = '<td colspan="4" style="width:100%;border-left:none;border-right:none;"><span class="texto" style="font-size:16px;">' . $equiv . '</span>	</td>';
        } else {
            $equivsOut = '<div>' . $equivs . '</div>';
            $nombre = '<td colspan="4" style="width:100%;font-size:16px;border-left:none;border-right:none;"><span style="font-size:16px;" class="texto">' . $formula->nombre . '</span>' . $equivsOut . '</td>';
        }

//$debug = true;
///////////////ENCABEZADO FORMULA////////////////////////////////
        ?>
        <table id="encabezado-detalles" style="background-color:rgba(223,223,223,0.5);margin-top:0px;widh:100%;border-right:solid thin #aeaeae;">
            <tbody>';

                <!--                /////////////////////TR 1////////////////////-->
                <tr>
                    <td colspan="1" rowspan="2" style="background:white; width:10%"><img class="body" src="/img/logo_color.jpg" style="width: 40px; margin-right:2px;margin-left:2px;" /></td>
                    <?= $nombre ?>
                </tr>



                <?php
                if ($formula->idSeccionFormula == $_ENV['SATE'])
                    $seccion = 'Sate';
                elseif ($formula->idSeccionFormula)
                    $seccion = $formula->seccionesFormula->seccion;
                else
                    $seccion = '';

/////////////////////TR 3////////////////////
                echo '<tr>';
                $codFormula = trim($formula->codigo);
                $numPintura = trim($formula->numero_pintura);
                $numFormula = trim($formula->numero);
                $fechaUltEdicion = trim($formula->fechaUltEdicion);
                $instrucciones = trim($formula->instrucciones);

                echo '<td colspan="5" style="padding:0 3px;border-right:none;">';
                echo '<small>Sección:</small> <span class="texto">' . $seccion . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';

                if ($codFormula) {
                    echo '<small>Cód. fórmula:</small><span class="texto">' . $codFormula . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                if ($esPinturas && $numPintura) {
                    echo '<small>Núm. pintura:</small> <span class="texto">' . $numPintura . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                if ($numFormula) {
                    echo '<span class="texto" style="color:red;font-size:22px;">NF' . $numFormula . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                echo '<span class="texto">' . $fechaUltEdicion . '</span><span style="font-size:20px;color:#aeaeae;">&nbsp;</span> ';
                ?>
                </td>

                </tr>

                <?php
                if ($instrucciones) {
                    echo '<tr><td colspan="5"><small>IT.:</small><span class="texto">' . $instrucciones . '</span></td></tr>';
                }
                ?>




                <tr>
                    <td colspan="5" style="font-size:20px;border-right: none;text-transform: uppercase;text-align: center;">
                        Código materia activa: <?= $formula->codigoMa ?> 

                    </td>

                </tr>



            </tbody>
        </table>

        <!--    ///////////////////CUERPO///////////////////////////////-->
        <table style="margin-top:0px;" class="cuerpo t-margin-left">
            <thead class="center">
                <tr>
                    <td style="width:30%;border-top:0;"><strong class="center">CANTIDAD</strong>	</td>
                    <td style="width:70%;border-top:0;"><strong class="center">PRODUCTO</strong>	</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $pesoTotal = 0;
                foreach ($formula->FormulasDetalle as $formDet) {
                    if ($formDet->enlucido != 'MA')
                        continue;

                    $pesoTotal += $formDet->cantidad;
                    $product = isset($formDet->Producto->nombreClave) ? $formDet->Producto->nombreClave : '-';
                    ?>

                    <tr>
                        <td class="right"> <span class="texto"><?= number_format((float) $formDet->cantidad, 3, '.', ''); ?> Kg.	</span> <input type="hidden" class="cantidad" value="<?= number_format((float) $formDet->cantidad, 3, '.', '') ?>"></td>
                        <td class="left"><span class="texto" ><?= $product ?></span></td>
                    </tr>
                    <?php
                }
                $totMateriaActiva = $pesoTotal;
                ?>

                <tr>
                    <td  class="right"><span class="texto" style="font-weight:bold;"><?= ($totMateriaActiva); ?> Kg.</span></td>
                    <td style="border:none;"></td>
                </tr>
            </tbody>

        </table>







        <!--    BASE **********************************
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ***********************************************
        ------>


        <div style="width:580px;margin:auto;color:black;padding-bottom:8px;text-align:_center;font-size:8.6px;page-break-before:always;">ESTABLECIMIENTOS BAIXENS, S.L. Polígono Industrial Moncarra, s/n. 46230 Alginet(Valencia) - España - Tel.:+34 96 1750834 - Fax:+34 96 1752471</div>
        <table>

            <tr style="width:100%;">
                <!--                ///////////////////FRANJA ROSA ENCABEZADO////////////////////////////////////////-->
                <td style="text-align:center; background-color:#F78181;padding:2px;" colspan="3"><h1>FÓRMULA AJUSTADA A PRODUCCIÓN</h1></td></table>
        <?php
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
            $nombre = '<td colspan="4" style="width:100%;border-left:none;border-right:none;"><span class="texto" style="font-size:16px;">' . $equiv . '</span>	</td>';
        } else {
            $equivsOut = '<div>' . $equivs . '</div>';
            $nombre = '<td colspan="4" style="width:100%;font-size:16px;border-left:none;border-right:none;"><span style="font-size:16px;" class="texto">' . $formula->nombre . '</span>' . $equivsOut . '</td>';
        }

//$debug = true;
///////////////ENCABEZADO FORMULA////////////////////////////////
        ?>
        <table id="encabezado-detalles" style="background-color:rgba(223,223,223,0.5);margin-top:0px;widh:100%;border-right:solid thin #aeaeae;">
            <tbody>';

                <!--                /////////////////////TR 1////////////////////-->
                <tr>
                    <td colspan="1" rowspan="2" style="background:white; width:10%"><img class="body" src="/img/logo_color.jpg" style="width: 40px; margin-right:2px;margin-left:2px;" /></td>
                    <?= $nombre ?>
                </tr>



                <?php
                if ($formula->idSeccionFormula == $_ENV['SATE'])
                    $seccion = 'Sate';
                elseif ($formula->idSeccionFormula)
                    $seccion = $formula->seccionesFormula->seccion;
                else
                    $seccion = '';

/////////////////////TR 3////////////////////
                echo '<tr>';
                $codFormula = trim($formula->codigo);
                $numPintura = trim($formula->numero_pintura);
                $numFormula = trim($formula->numero);
                $fechaUltEdicion = trim($formula->fechaUltEdicion);
                $instrucciones = trim($formula->instrucciones);

                echo '<td colspan="5" style="padding:0 3px;border-right:none;">';
                echo '<small>Sección:</small> <span class="texto">' . $seccion . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';

                if ($codFormula) {
                    echo '<small>Cód. fórmula:</small><span class="texto">' . $codFormula . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                if ($esPinturas && $numPintura) {
                    echo '<small>Núm. pintura:</small> <span class="texto">' . $numPintura . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                if ($numFormula) {
                    echo '<span class="texto" style="color:red;font-size:22px;">NF' . $numFormula . '</span><span style="font-size:20px;color:#aeaeae;border-right:solid thin #aeaeae;">&nbsp;</span> ';
                }

                echo '<span class="texto">' . $fechaUltEdicion . '</span><span style="font-size:20px;color:#aeaeae;">&nbsp;</span> ';
                ?>
                </td>

                </tr>
                <?php
                if ($instrucciones) {
                    echo '<tr><td colspan="5"><small>IT.:</small><span class="texto">' . $instrucciones . '</span></td></tr>';
                }
                ?>

                <?php
                $tipo_maquina_base = trim($formula->tipo_maquina_base);
                switch ($tipo_maquina_base) {
                    case "mg":
                        $maquina = 'grande: ' . $formula->codigoBaseMg;
                        break;
                    case "mgb":
                        $maquina = 'grande bricolage: ' . $formula->codigoBaseMgb;
                        break;
                    default:
                        $maquina = 'pequeña: ' . $formula->codigoBaseMp;
                        break;
                }
                ?>

                <tr>
                    <td colspan="5" style="font-size:20px;border-right: none;text-transform: uppercase;text-align: center;">
                        Código base máquina <?= $maquina ?> 

                    </td>

                </tr>



            </tbody>
        </table>

        <!--    ///////////////////CUERPO///////////////////////////////-->
        <table style="margin-top:0px;" class="cuerpo t-margin-left">
            <thead class="center">
                <tr>
                    <td style="width:30%;border-top:0;"><strong class="center">CANTIDAD</strong>	</td>
                    <td style="width:70%;border-top:0;"><strong class="center">PRODUCTO</strong>	</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $pesoTotal = 0;
                foreach ($formula->FormulasDetalle as $formDet) {
                    if ($formDet->enlucido != 'base')
                        continue;

                    $pesoTotal += $formDet->cantidad;
                    $product = isset($formDet->Producto->nombreClave) ? $formDet->Producto->nombreClave : '-';
                    ?>

                    <tr>
                        <td class="right"> <span class="texto"><?= number_format((float) $formDet->cantidad, 3, '.', ''); ?> Kg.	</span> <input type="hidden" class="cantidad" value="<?= number_format((float) $formDet->cantidad, 3, '.', '') ?>"></td>
                        <td class="left"><span class="texto" ><?= $product ?></span></td>
                    </tr>
                <?php
                }

                $pesoTotal += $totMateriaActiva;
                ?>
                <tr>
                    <td class="right"> <span class="texto"><?= number_format((float) $totMateriaActiva, 3, '.', ''); ?> Kg.	</span> </td>
                    <td class="left"><span class="texto" >Materia Activa Nº <?= $formula->codigoMa ?></span></td>
                </tr>

                <tr>
                    <td  class="right"><span class="texto" style="font-weight:bold;"><?= round($pesoTotal); ?> Kg.</span></td>
                    <td style="border:none;"></td>
                </tr>
            </tbody>

        </table>



    </body>
</html>


<?php
$html = ob_get_clean();
if (false) {
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


