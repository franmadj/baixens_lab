<?php

class Pedido extends Eloquent {

	protected $table = 'pedidos';
        public $timestamps = false;

	

	
        
        public function pedidosDetalle(){
            return $this->hasMany('PedidosDetalle', 'idPedido');
            
        }
        
        public function proveedor(){
		return $this->belongsTo('Proveedor', 'idProveedor');
	}
        
        public function user(){
		return $this->belongsTo('User', 'idSolicitadoPor');
	}
        
        // this is a recommended way to declare event handlers
        protected static function boot() {
            parent::boot();

            static::deleting(function($pedido) { // before delete() method call this
                 $pedido->PedidosDetalle()->delete();
                 // do the rest of the cleanup...
            });
        }
        
        public static function dropDown(){
            $default      = array('0' => 'Pedidos');
            $res  = Pedido::lists('numero', 'id');
            return $res  = $default + $res;
        }
        
        


	

}