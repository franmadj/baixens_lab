<?php

class ProductosHistoricoCoste extends Eloquent {

	protected $table = 'productos_historico_coste';



	public function producto(){
		return $this->belongsTo('Producto', 'idProducto');
	}

	

}