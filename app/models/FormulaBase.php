<?php

class FormulaBase extends Eloquent {

    protected $table = 'formulas_base';
    public $timestamps = false;

//	public static function onProveedores($id)
//	{
//		$proveedores = Producto::find($id)->proveedores()->lists('id');
//		return $proveedores;
//	}



    public function seccionesFormula() {
        return $this->belongsTo('SeccionesFormula', 'idSeccionFormula');
    }

    public function formulasDetalle() {
        return $this->hasMany('FormulasDetalle', 'idFormula')->orderBy('orden','ASC');
    }

    public function formulasEquivalencia() {
        return $this->hasMany('FormulasEquivalencia', 'idFormula');
    }

    public static function dropDown($nf = false) {
        $name = $nf ? 'NF' : 'Formulas';
        $default = array('0' => $name);
        if (!$nf) {
            $res = Formula::orderBy('nombre')->lists('nombre', 'id');
        } else {
            $res = Formula::orderBy('id')->lists('numero', 'id');
            //dame($res,1);
        }
        //$res  = Formula::lists('nombre', 'id');
        return $res = $default + $res;
    }

    public static function importe($id) {
        $formulas_det = FormulasDetalle::where('idFormula', $id)->get();
        $tot = $tot_cant=0;
        foreach ($formulas_det as $f_det) {
            $prod_data = Producto::where('id', $f_det->idProducto)->first();
            if (isset($prod_data)) {
                $tot+=$prod_data->coste * $f_det->cantidad;
				$tot_cant+=$f_det->cantidad;
                //$tot+=$prod_data->coste;
                //return $f_det->idProducto.'id';
            }
			//$tot=$tot/$tot_cant;
            //dame($prod_data);dame($f_det);
            //$tot+=$prod_data->coste*$f_det->cantidad;
			
			
        }//dame($tot);dame($tot_cant);
		if($tot==1 or $tot_cant==0)return 0.000;
		$tot=($tot/$tot_cant);//dame($tot,1);
		
        return number_format((float) $tot, 3, '.', '');
    }

    public static function tienePendientes() {
        $formulas = Formula::where('pendienteEdicion', '>', '0')->first();
        if (count($formulas))
            return $formulas->pendienteEdicion;
        return false;
    }

}
