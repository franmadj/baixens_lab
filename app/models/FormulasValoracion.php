<?php

class FormulasValoracion extends Eloquent {

	protected $table = 'formulas_valoracion';
        public $timestamps = false;


	
        
        public function formulasValoracionDetalle(){
            return $this->hasMany('FormulasValoracionDetalle', 'idFormulasValoracion');
            
        }
        
        public static function dropDown(){
            $default      = array('0' => 'Formulas Valoracion');
            $res  = FormulasValoracion::lists('nombre', 'id');
            return $res  = $default + $res;
        }
        
        
        
        
        

        


	

}