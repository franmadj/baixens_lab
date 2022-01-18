<?php

class SeccionesFormula extends Eloquent {

    protected $table = 'secciones_formulas';
    public $timestamps = false;
    public $colores = [
        '#FFA07A',
        '#FF4500',
        '#EEE8AA',
        '#DA70D6',
        '#B22222',
        '#808000',
        '#6495ED',
        '#DEB887',
        '#B0E0E6',
        '#FFF',
        '#000',
    ];

    public function formula() {
        return $this->hasMany('Formula', 'idSeccionFormula');
    }

    public static function dropDown() {
        $default = array('0' => 'Secciones Formula');
        $res = SeccionesFormula::lists('seccion', 'id');
        return $res = $default + $res;
    }

}
