<?php

class PinturasDetalle extends Eloquent {

	protected $table = 'pinturas_detalle';
        public $timestamps = false;


	public function pintura(){
            return $this->belongsTo('Pintura', 'idPintura');
	}
        
        public function producto(){
            return $this->belongsTo('Producto', 'idProducto');
        }

	

}