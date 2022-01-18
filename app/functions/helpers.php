<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function numberFormatPrecision($number, $precision = 2, $separator = '.') {
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if (count($numberParts) > 1) {
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
}
function getSeccionesPinturas(){
    return explode(',', $_ENV['SECCIONES_PINTURAS']);
    
}

function formulaEsPinturas($idSeccionFormula=0){
    return in_array($idSeccionFormula, getSeccionesPinturas());
}

function date_validate($date) {
    if (preg_match('/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/', $date)) {
        return true;
    }
    return false;
}

function swip_date_us_eu($date) {
    $parts = explode('-', $date); //'5/25/12';
    return $parts[2] . '/' . $parts[1] . '/' . $parts[0];
}

function dame($data, $e = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($e)
        exit;
}

function serverIs($env) {
    return $env == $_ENV['APP_ENV'];
}

function fn_($number){
    return number_format($number,4,'.','');
    
}

function calcularVocIndividual($voc, $cantidad, $densidad) { //console.log(voc.val()+' - '+cantidad.val()+' - '+densidad.val());
    if(!$densidad)
        return 0;
    $res = $voc * ( 1000 * $cantidad / $densidad );//console.log(res.toFixed(2));
    if (!$res) {
        return 0;
    }
    return fn_($res);

}
