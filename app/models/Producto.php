<?php

class Producto extends Eloquent {

    protected $table = 'productos';

    public function proveedor() {
        return $this->belongsTo('Proveedor', 'idProveedor');
    }

    public function pedidosDetalle() {
        return $this->hasMany('PedidosDetalle', 'idProducto');
    }

    public function formulasDetalle() {
        return $this->hasMany('FormulasDetalle', 'idProducto');
    }

    public function productosHistoricoCoste() {
        return $this->hasMany('ProductosHistoricoCoste', 'idProducto');
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($producto) { // before delete() method call this
            $producto->ProductosHistoricoCoste()->delete();
            // do the rest of the cleanup...
        });
    }

    public static function dropDown($key = 'nombreProducto', $colores = false) {
        $name = ($key == 'nombreProducto') ? 'Productos' : 'Código Producto';
        $default = array('0' => $name);
        //$res  = Producto::lists($key, 'id');
        if ($colores) {
            $res = Producto::where('colorimetria', '1')->orderBy($key)->lists($key, 'id');
        } else {
            $res = Producto::orderBy($key)->lists($key, 'id');
        }
        return $res = $default + $res;
    }

    public static function dropDownToSelect($key = 'nombreProducto', $colores = false, $products = NULL, $default = NULL) {
        if(!$products)
            $products = self::dropDown($key, $colores);
        $html = '';
        if ($products) {
            foreach ($products as $key => $val) {
                $selected='';
                if($key==$default)
                    $selected='selected="selected"';
                $html .= '<option value="' . $key . '" '.$selected.'>' . $val . '</option>';
            }
        }

        return $html;
    }

    public static function get_data($get_field, $where_field, $where_data) {


        try {
            $data = new Producto();
            $data = $data->select($get_field)->where($where_field, $where_data)->first();
            return $data->$get_field;
        } catch (Exception $e) {
            echo 'Exceptión: ', $e->getMessage(), "\n";
        }
    }

}
