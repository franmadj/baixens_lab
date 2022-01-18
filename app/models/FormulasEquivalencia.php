<?php

class FormulasEquivalencia extends Eloquent {

	protected $table = 'formulas_equivalencias';
        public $timestamps = false;



	public function formula(){
		return $this->belongsTo('Formula', 'idFormula');
	}
        
        public static function dropDown(){
            $default      = array('0' => 'Formulas Equivalencias');
            $res  = FormulasEquivalencia::lists('equivalencia', 'id');
            return $res  = $default + $res;
        }

	

}