<?php

class Formula extends Eloquent {

    protected $table = 'formulas';
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
        return $this->hasMany('FormulasDetalle', 'idFormula')->orderBy('orden', 'ASC');
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

    public static function dropDownBases($nf = false) {
        $name = $nf ? 'NF' : 'Formulas';
        $default = array('0' => $name);
        if (!$nf) {
            $res = Formula::orderBy('nombre')->where('esBase', 1)->where('activa', 1)->lists('nombre', 'id');
        } else {
            $res = Formula::orderBy('id')->lists('numero', 'id');
            //dame($res,1);
        }
        //$res  = Formula::lists('nombre', 'id');
        return $res = $default + $res;
    }

    public static function importe($id) {
        $formulas_det = FormulasDetalle::where('idFormula', $id)->get();
        $tot = $tot_cant = 0;
        foreach ($formulas_det as $f_det) {
            $prod_data = Producto::where('id', $f_det->idProducto)->first();
            if (isset($prod_data)) {
                $tot += $prod_data->coste * $f_det->cantidad;
                $tot_cant += $f_det->cantidad;
                //$tot+=$prod_data->coste;
                //return $f_det->idProducto.'id';
            }
            //$tot=$tot/$tot_cant;
            //dame($prod_data);dame($f_det);
            //$tot+=$prod_data->coste*$f_det->cantidad;
        }//dame($tot);dame($tot_cant);
        if ($tot == 1 or $tot_cant == 0)
            return 0.000;
        $tot = ($tot / $tot_cant); //dame($tot,1);

        return number_format((float) $tot, 3, '.', '');
    }

    public static function tienePendientes() {
        $formulas = Formula::where('pendienteEdicion', '>', '0')->first();
        if (count($formulas))
            return $formulas->pendienteEdicion;
        return false;
    }

    /* PINTURAS */

    public static function pinturaTipoProductos() {
        return ['' => 'Selecciona', 'agua' => 'Agua', 'tio2' => 'TiO2', 'carga' => 'Carga', 'disolvente' => 'Disolvente', 'aditivo' => 'Aditivo', 'ligante' => 'Ligante'];
    }

    public static function pinturaTipoProductosSelect($tipos, $default=NULL) {
        $html = '';
        foreach ($tipos as $key => $val) {
            $selected = '';
            if ($key == $default)
                $selected = 'selected="selected"';
            $html .= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
        }
        return $html;
    }

    public static function pinturaTipoBrillos($value = NULL) {
        $data = ['' => 'Selecciona', 'mate_profundo' => 'Mate Profundo', 'mate' => 'Mate', 'satinado' => 'Satinado', 'brillante' => 'Brillante'];
        if (NULL === $value)
            return $data;
        elseif ($value && isset($data[$value]))
            return $data[$value];
        return '';
    }

    public static function pinturaClasesMedidos($value = NULL) {
        $data = ['' => 'Selecciona', '1' => 'Clase 1', '2' => 'Clase 2', '3' => 'Clase 3', '4' => 'Clase 4', '5' => 'Clase 5'];
        if (NULL === $value)
            return $data;
        elseif ($value && isset($data[$value]))
            return $data[$value];
        return '';
    }

    public static function pinturaTipos($default = []) {
        if ($default)
            $default = array('' => 'Tipos');
        return $default + ['vinilica' => 'Vínilica', 'acrilica_e' => 'Acrílica estirenada', 'acrilica' => 'Acrílica', 'otro' => 'Otro'];
    }

    public static function pinturaEstados($default = [], $filtro = false, $pinturaEstado = false) {
        if ($default)
            $default = array('' => 'Estados');
        $estados = ['desarrollo' => 'Desarrollo', 'validada-activa' => 'Validada Activa', 'validada-reserva' => 'Validada Reserva'];
        if (Auth::user()->type == 1 || $filtro)
            $estados = $estados + ['confirmada' => 'Confirmada'];
        if ($pinturaEstado && $pinturaEstado == 'confirmada' && !isset($estados['confirmada'])) {
            $estados = $estados + ['confirmada' => 'Confirmada'];
        }
        return $default + $estados;
    }

    public static function pinturaNombres($default = []) {
        if ($default)
            $default = array('0' => 'Nombres');
        $res = Formula::orderBy('id')->where('idSeccionFormula', 3)->lists('nombre', 'id');
        return $default + $res;
    }

    public static function pinturaCodigos($default = []) {
        $res = Formula::orderBy('id')->where('idSeccionFormula', 3)->lists('numero', 'id');
        return $default + $res;
    }

    public static function formulasByCategory($default = [], $cagtegory, $field) {
        $res = Formula::orderBy('id')->whereIn('idSeccionFormula', (array) $cagtegory)->where($field, '!=', 0)->lists($field, 'id');
        return $default + $res;
    }

    public function getFechaAttribute($value) {
        $date = intval($value) ? date('d-m-Y', $value) : '';
        return $date ?: '';
    }
    
    public function getFechaUltEdicionAttribute($value) {
        $date = intval($value) ? date('d-m-Y', $value) : '';
        return $date ?: '';
    }

    public function getNumeroPinturaAttribute($value) {
        if (!$value)
            return false;
        return isset($value) ? 'PI-' . $value : '';
    }

    public function getNumeroSateAttribute($value) {
        if (!$value)
            return false;
        return isset($value) ? 'SATE-' . $value : '';
    }

    public function claseMedioAtt($value) {
        return self::pinturaClasesMedidos($value);
    }

    public function tipoBrilloMedioAtt($value) {
        return self::pinturaTipoBrillos($value);
    }

    public function getBrillo85MedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getBrillo60MedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getViscosidadMedioAttribute($value) {
        return AppHelper::formatNumericValue($value, 1);
    }

    public function getPrecioEuLtMedidoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPrecioEuLtPesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPrecioEuLtTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPrecioEuKgPesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPrecioEuKgTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getLiganteTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getLigantePesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getTio2TeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getTio2PesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getDensidadTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getDensidadPesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getDensidadMedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPvcTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPvcPesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPorcentajeSolidosTeoricoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPorcentajeSolidosPesadoAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getPorcentajeSolidosMedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getCubricionMedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getResFloteMedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getRendimientoMedioAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getDensidadAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    public function getTipoBrilloAttribute($value) {
        return AppHelper::formatNumericValue($value);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($pintura) { // before delete() method call this
            $pintura->formulasDetalle()->delete();
            // do the rest of the cleanup...
        });
    }

    public function scopePinturasValidadas($query) {
        return $query->where(function ($query) {
                    $query->where('pintura_estado', 'confirmada')->orWhere('pintura_estado', NULL);
                });
    }

    public function scopeSateSection($query) {
        return $query->where(function ($query) {
                    $query->where('idSeccionFormula', $_ENV['SATE']);
                });
    }

    public function scopePinturaSection($query) {
        return $query->where(function ($query) {
                    $query->whereIn('idSeccionFormula', [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']]);
                });
    }

    public function scopeOnlyFormulas($query) {
        return $query->where(function ($query) {
                    $query->where('idSeccionFormula', '!=', $_ENV['SATE'])->where('idSeccionFormula', '!=', $_ENV['PINTURAS_DECORATIVAS']);
                });
    }

    public function getCurrentNumber() {
        $confirmada = $this->pintura_estado == 'confirmada';
        if (!empty($this->numero_sate)) {
            return $this->numero_sate;
        } elseif (!empty($this->numero_pintura) && !$confirmada) {
            return $this->numero_pintura;
        } elseif (!empty($this->numero)) {
            return $this->numero;
        } else {
            return 'Sin numero';
        }
        return !empty($this->numero_sate) ? $this->numero_sate : $this->numero;
    }

}
