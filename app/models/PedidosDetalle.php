<?php

class PedidosDetalle extends Eloquent {

	protected $table = 'pedidos_detalle';
        public $timestamps = false;


	public function pedido(){
            return $this->belongsTo('Pedido', 'idPedido');
	}
        
        public function formatosPedido(){
            return $this->belongsTo('FormatosPedido', 'idFormatoPedido');
        }
        
        public function producto(){
            return $this->belongsTo('Producto', 'idProducto');
        }

	

}