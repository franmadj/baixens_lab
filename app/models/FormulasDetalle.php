<?php

class FormulasDetalle extends Eloquent {

    protected $table = 'formulas_detalle';
    public $timestamps = false;

    public function formula() {
        return $this->belongsTo('Formula', 'idFormula');
    }

    public function producto() {
        return $this->belongsTo('Producto', 'idProducto');
    }

    public function getPorcentajePesadoAttribute($value) {
        return AppHelper::formatNumericValue($value,3);
    }
    public function getPorcentajeTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value,3);
    }
    
    public function getAportacionPrecioTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value,3);
    }
    
    public function getCantidadAttribute($value) {
        return AppHelper::formatNumericValue($value,3);
    }
    
    public function getCantidadTeoricaAttribute($value) {
        return AppHelper::formatNumericValue($value,3);
    }
    
    

}
