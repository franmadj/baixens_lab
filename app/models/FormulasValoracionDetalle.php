<?php

class FormulasValoracionDetalle extends Eloquent {

	protected $table = 'formulas_valoracion_detalle';
        public $timestamps = false;


	public function formulasValoracion(){
            return $this->belongsTo('FormulasValoracion', 'idFormulasValoracion');
	}
        
        public function producto(){
            return $this->belongsTo('Producto', 'idProducto');
        }


	

}