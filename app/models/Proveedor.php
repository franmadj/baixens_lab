<?php

class Proveedor extends Eloquent {

	protected $table = 'proveedores';
        public $timestamps = false;

	

	public function producto(){
		return $this->hasMany('Producto', 'id');
	}
        
        public function pedido(){
		return $this->hasMany('Pedido', 'idProveedor');
	}
        
        // this is a recommended way to declare event handlers
        protected static function boot() {
            parent::boot();

            static::deleting(function($proveedor) { // before delete() method call this
                foreach($proveedor->Producto as $producto){
                    $producto->ProductosHistoricoCoste()->delete();
                }
                $proveedor->Producto()->delete();

            });
        }
        
        public static function dropDown(){
            $default      = array('0' => 'Proveedores');
            //$proveedores  = Proveedor::lists('nombre', 'id');
            $proveedores  = Proveedor::orderBy('nombre')->lists('nombre', 'id');
            return $proveedores  = $default + $proveedores;
        }
        
        


	

}