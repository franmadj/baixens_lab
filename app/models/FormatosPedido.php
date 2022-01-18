<?php

class FormatosPedido extends Eloquent {

    protected $table = 'formatos_pedido';
    public $timestamps = false;

    public function pedidosDetalle() {
        return $this->hasMany('PedidosDetalle', 'idFormatoPedido');
    }

    public static function dropDown() {
        $default = array('0' => 'Formatos Pedido');
        $res = FormatosPedido::where('desactivado', '!=', '1')->lists('formato', 'id');
        return $res = $default + $res;
    }

    public static function get_data($get_field, $where_field, $where_data) {
        try {
            $data = new FormatosPedido();
            $data = $data->select($get_field)->where($where_field, $where_data)->first();
            return $data->$get_field;
        } catch (Exception $e) {
            echo 'Exceptión: ', $e->getMessage(), "\n";
        }
    }

}
