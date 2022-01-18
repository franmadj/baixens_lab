<?php

class Pintura extends Eloquent {

    protected $table = 'pinturas';
    public $timestamps = false;

    public function pinturasDetalle() {
        return $this->hasMany('PinturasDetalle', 'idPintura')->orderBy('orden','ASC');
    }


    public static function tipoProductos() {

        return ['agua' => 'Agua', 'tio2' => 'TiO2', 'carga' => 'Carga', 'disolvente' => 'Disolvente', 'aditivo' => 'Aditivo', 'ligante' => 'Ligante'];
    }

    public static function tipos($default=[]) {
        if($default)
            $default = array('' => 'Tipos');
        return $default+['vinilica' => 'Vínilica', 'acrilica_e' => 'Acrílica esterilizada', 'acrilica' => 'Acrílica', 'otro' => 'Otro'];
    }

    public static function estados($default=[]) {
        if($default)
            $default = array('' => 'Estados');
        return $default+['desarrollo' => 'Desarrollo', 'validada' => 'Validada', 'confirmada' => 'Confirmada'];
    }

    public static function nombres($default=[]) {
        if($default)
            $default = array('0' => 'Nombres');
        $res = Pintura::orderBy('id')->lists('nombre', 'id');
        return $default+$res;
    }



    public static function codigos($default=[]) {
        if($default)
            $default = array('0' => 'Código');
        $res = Pintura::orderBy('id')->lists('numero', 'id');
        return $default+$res;
    }



    public function getFechaAttribute($value) {
        $date=date('d-m-Y',$value);
        return $date?:'';
    }

    // this is a recommended way to declare event handlers
        protected static function boot() {
            parent::boot();

            static::deleting(function($pintura) { // before delete() method call this
                 $pintura->pinturasDetalle()->delete();
                 // do the rest of the cleanup...
            });
        }

    

    

}
