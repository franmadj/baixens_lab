<?php

class BaseController extends Controller {

    var $generalData;
    var $tipos;
    var $tipo_usuarios = [1 => 'Admin', 2 => 'Gestión pedidos', 3 => 'Colorimetría', 4 => 'SATE'];

    public function __construct() {
        Input::merge(array_map([$this, 'trimInput'], Input::all()));
        date_default_timezone_set('Europe/Madrid');
        $generalData = array();
        $generalData['lenguaje'] = 'lenguage';
        $generalData['FACEBOOK_ID'] = '187454854';
        $generalData['ANALITYCS'] = 'ga-18965';
        $generalData['GMAPS_KEY'] = 'bdjsgfjsgdfsgdfgsjdfgdsfsdufvhxchfuisdyhfusduxfvkxcj';
        $generalData['EMAIL'] = 's.comes@baixens.com';
        $generalData['WEB'] = 'formulacion.com';
        $generalData['DIRECCION'] = 'C/ Mossen Eusebio Gimeno nª20';
        $generalData['POBLACION'] = 'Albal';
        $generalData['CIUDAD'] = 'Valencia';
        $generalData['CP'] = '46470';
        $generalData['PAIS'] = 'ESPAÑA';
        $generalData['TELEFONO'] = 'XXXXXXXXX';
        $generalData['LOPD'] = 'XXXXXXXXXXXX';
        $generalData['CIF'] = 'XXXXXXXXXXXX';
        $generalData['nombreCOMERCIAL'] = 'baixens';
        $generalData['current_user'] = Auth::user();
        $generalData['admin_notifications'] = $this->checkAdminNotifications(); //dd($generalData['admin_notifications']);
        $this->generalData = $generalData;
        View::share('generalData', $this->generalData);
    }

    function trimInput($val) {
        if (is_array($val)) {
            return array_map([$this, 'trimInput'], $val);
        } else {
            return trim($val);
        }
    }

    function checkUserAccess($allow = []) {
        return true; //por ahora
        if (!Auth::user() || !in_array(Auth::user()->type, $allow)) {
            exit('Acceso denegado!');
        }
    }

    function getUserRoles($type = 0) {
        $tipos = '';
        foreach ($this->tipo_usuarios as $key => $val) {
            $selected = '';
            if ($key == $type)
                $selected = 'selected="selected"';
            $tipos .= '<option ' . $selected . ' value="' . $key . '">' . $val . '</option>';
        }
        return $tipos;
    }

    protected function checkAdminNotifications() {
        if (Auth::check() && Auth::User()->type == 1) {
            return Formula::whereIn('pintura_estado', ['validada-activa', 'validada-reserva'])->where('allow_notifications', '!=', 0)->get();
        }
        return Formula::where('pintura_estado', '0')->get();
    }

    protected function dame($data, $ex = 0) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($ex)
            exit;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Creates a view
     *
     * @param String $path path to the view file
     * @param Array $data all the data
     * @return void
     */
    protected function view($path, array $data = []) {
        $this->layout->content = View::make($path, $data);
    }

    /**
     * Redirect back with input and with provided data
     *
     * @param Array $data all the data
     * @return void
     */
    protected function redirectBack($data = []) {
        return Redirect::back()->withInput()->with($data);
    }

    /**
     * Redirect to the previous url
     *
     * @return void
     */
    public function redirectReferer() {
        $referer = Request::server('HTTP_REFERER');
        return Redirect::to($referer);
    }

    /**
     * Redirect to a given route, with optional data
     *
     * @param String $route route name
     * @param Array $data optional data
     * @return void
     */
    protected function redirectRoute($route, $data = []) {
        return Redirect::route($route, $data);
    }

    protected function get_variables_generales() {
        $nuevoHorario = Option::where('meta_key', '=', 'nuevoHorario')->first();
        //dame($nuevoHorario, 1);
        $seccionesFormula = SeccionesFormula::all();
        //$formatosPedido=  FormatosPedido::all();//dame($formatosPedido,1);
        $formatosPedido = FormatosPedido::where('desactivado', '=', 0)->get();
        $users = User::all();

        //$usuarios=User
        return array(
            'nuevoHorario' => $nuevoHorario->meta_value,
            'secciones' => $seccionesFormula,
            'formatos' => $formatosPedido,
            'users' => $users,
            'mensajeHorario' => ''
        );
    }

    protected function calculo_voc_individual($vocPord, $cantidad, $densidad) {
        return $vocPord * (1000 * $cantidad / $densidad);
    }

    protected function calcularPorcentaje($cantidad, $totCant) {
        $porcentaje = $cantidad / $totCant * 100;
        return number_format($porcentaje, 2);
    }

    function get_message($state, $message) {
        if ($state = 'ok') {
            $msm = '<div class="alert alert-success">
                                        	<strong>' . $message . ' </strong>
                                    	</div>';
        } else {
            $msm = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> ' . $message . '
                                    	</div>';
        }
        return $msm;
    }

    function set_cantidad($formula, $cantProduccion) {
        $formulasDet = array();
        $cantidad = 0;
        foreach ($formula->FormulasDetalle as $laFormula) {
            $cantidad += $laFormula->cantidad;
        }
        if ($cantidad > 0)
            $valorPromedio = $cantProduccion / $cantidad;
        else
            $valorPromedio = 0;
        $i = 0;
        foreach ($formula->FormulasDetalle as $laFormula) {
            $laFormula->cantidad = $laFormula->cantidad * $valorPromedio;
        }
        return $formula;
    }

    function lastFormulaId() {
        $last = DB::table('formulas')->select('numero')->where('numero', '<>', 0)->orderBy('numero', 'desc')->first();
        if (!isset($last->numero)) {
            $last = 1;
        } else {
            $last = $last->numero + 1;
        }
        return $last;
    }

    function isFormulasDetalleUpdate($formulasDetalle, $numbered_rows) {
        $n = 2;
        $changed = false;
        $count = 0;
        foreach ($formulasDetalle as $detalle) {
            $count++;

            if (trim(Input::get('det-cantidad-' . $n)) != $detalle->cantidad)
                $changed = true;

            if (trim(Input::get('det-producto-' . $n)) != $detalle->idProducto)
                $changed = true;
            if (trim(Input::get('det-porcentaje_teorico-' . $n)) != $detalle->porcentaje_teorico)
                $changed = true;
            if (trim(Input::get('det-porcentaje_pesado-' . $n)) != $detalle->porcentaje_pesado)
                $changed = true;
            if (trim(Input::get('det-aportacion_precio_teorico-' . $n)) != $detalle->aportacion_precio_teorico)
                $changed = true;
            if (trim(Input::get('det-cantidad_teorica-' . $n)) != $detalle->cantidad_teorica)
                $changed = true;
            if (trim(Input::get('det-tipo-' . $n)) != $detalle->tipo)
                $changed = true;
            if ($changed)
                return true;
            $n++;
        }
        if ($n == 2 || $count != count($numbered_rows))
            return true;
        return false;
    }

    function isFormulasDetalleUpdates($formulasDetalle, $numbered_rows) {
        $n = 2;
        $changed = false;
        $count = 0;
        foreach ($formulasDetalle as $detalle) {

            if (trim(Input::get('det-cantidad-' . $n)) != $detalle->cantidad)
                var_dump(Input::get('det-cantidad-' . $n) . 'cantidad_pesada' . $detalle->cantidad);

            if (trim(Input::get('det-producto-' . $n)) != $detalle->idProducto)
                var_dump(Input::get('det-producto-' . $n) . 'producto' . $detalle->idProducto);
            if (trim(Input::get('det-porcentaje_teorico-' . $n)) != $detalle->porcentaje_teorico)
                var_dump('porcentaje_teorico');
            if (trim(Input::get('det-porcentaje_pesado-' . $n)) != $detalle->porcentaje_pesado)
                var_dump('porcentaje_pesado');
            if (trim(Input::get('det-aportacion_precio_teorico-' . $n)) != $detalle->aportacion_precio_teorico)
                var_dump(Input::get('det-aportacion_precio_teorico-' . $n) . 'aportacion_precio_teorico' . $detalle->aportacion_precio_teorico);
            if (trim(Input::get('det-cantidad_teorica-' . $n)) != $detalle->cantidad_teorica)
                var_dump('cantidad_teorica');
            if (trim(Input::get('det-tipo-' . $n)) != $detalle->tipo)
                var_dump('tipo');
            if ($changed)
                return true;
            $n++;
        }
        if ($n == 2 || $count != count($numbered_rows))
            return true;
        return false;
    }

}
