<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AppHelper {

    public static function calculo_voc_individual($vocPord, $cantidad, $densidad) {
        return $vocPord * (1000 * $cantidad / $densidad);
    }

    public static function calcularPorcentaje($cantidad, $totCant) {
        if($totCant==0)
            return 0;
        $porcentaje = $cantidad / $totCant * 100;
        return number_format($porcentaje, 2);
    }

    public static function formatNumericValue($value, $decimales = 2) {
        return isset($value) ? number_format(floatVal($value), $decimales, '.', '') : '';
    }

}


