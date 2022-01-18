<?php

class SateController extends BaseController {

    private $viejos = array('nombre' => '0', 'codigoProducto' => '0', 'codigo' => '-1', 'search' => '', 'fechaDe' => '', 'fechaA' => '');

    public function index() {
        $formulas = Formula::sateSection()->paginate(20);
        if (Input::has('page') && Input::has('filter') && Session::get('filter')) {
            return $this->post_index(Session::get('filter'));
        }

        return View::make('sate/formulas-list', array(
                    'formulas' => $formulas,
                    'nombres' => Formula::formulasByCategory(['0' => 'Nombre Sate'], $_ENV['SATE'], 'nombre'),
                    'codigos' => Formula::formulasByCategory(['0' => 'Codigo Sate'], $_ENV['SATE'], 'numero'),
                    'codigosProducto' => Producto::dropDown('codigo'),
                    'viejos' => $this->viejos,
                    'sateActive' => 'active',
                    'user_type' => Auth::user()->type,
        ));
    }

    public function filter($filterPaginated = false) {
        //dame(Input::all(), 1);
        $input = $filterPaginated ? $filterPaginated : Input::all();
        $imprimir = false;
        if (Input::has('imprimir')) {
            $imprimir = true;
            $max = 10;
        }
        $formulas = new Formula();
        if (isset($input['filtrar'])) {
            if (!$filterPaginated)
                Session::put('filter', Input::all());

            $filtra = $porId = $formVacia = false;
            if ($input['codigoProducto'] != 0) {
                $filtra = true;
                $this->viejos['codigoProducto'] = $input['codigoProducto'];

                $formulas = $formulas
                        ->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
                        ->where('formulas_detalle.idProducto', $input['codigoProducto']);
            }
            if ($input['nombre'] != 0) {
                $formulas = $formulas->where('formulas.id', $input['nombre']);
                $filtra = $porId = true;
                $this->viejos['nombre'] = $input['nombre'];
            }
            if ($input['codigo'] != 0) {
                $formulas = $formulas->where('formulas.id', $input['codigo']);
                $filtra = $porId = true;
                $this->viejos['codigo'] = $input['codigo'];
            }

            if (date_validate($input['fechaDe']) && date_validate($input['fechaA'])) {//exit;
                $formulas = $formulas->whereBetween('fecha', array(
                    strtotime(swip_date_us_eu($input['fechaDe'])),
                    strtotime(swip_date_us_eu($input['fechaA']))));
                $filtra = true;
                $this->viejos['fechaDe'] = $input['fechaDe'];
                $this->viejos['fechaA'] = $input['fechaA'];
            }

            if ($input['search']) {
                $formulas = $formulas->where(function ($query)use($input) {
                    $query->where('formulas.nombre', 'like', '%' . $input['search'] . '%')->orWhere('formulas.descripcion', 'like', '%' . $input['search'] . '%');
                });
                $filtra = true;
                $this->viejos['search'] = $input['search'];
            }
            //var_dump($this->viejos);exit;
            if ($filtra) {

                //$formulas = $formulas->groupBy('formulas_detalle.id', 'formulas.id','formulas.numero','formulas.nombre','formulas.idSeccionFormula', 'productos.nombreProducto', 'formulas_equivalencias.equivalencia', 'productos.coste')->get();
                $formulas = $formulas->select('formulas.*');
                //var_dump($formulas);exit;
            } else {

                $formulas = $formulas->where('id', '>', '0')->orderBy('id', 'desc');
            }
        }

        $formulas = $formulas->sateSection()->paginate(50);

        //dame(URL::to('/'),1);
        //dame(DB::getQueryLog(), 1); //dame(Input::get('fechaA') );exit;
        //dame(Input::get(),1);
        //dame($formulas->count(), 1);

        $view = 'sate/formulas-list';
        return View::make($view, array(
                    'formulas' => $formulas,
                    'nombres' => Formula::formulasByCategory(['0' => 'Nombre Sate'], $_ENV['SATE'], 'nombre'),
                    'codigos' => Formula::formulasByCategory(['0' => 'Codigo Sate'], $_ENV['SATE'], 'numero'),
                    'codigosProducto' => Producto::dropDown('codigo'),
                    'user_type' => Auth::user()->type,
                    'viejos' => $this->viejos,
                    'sateActive' => 'active',
        ));
    }

    public function show($id) {
        $formula = Formula::where('id', '=', $id)->stateSection()->first();
        //dame($formula,1);
        return View::make('sate/formula-view', array(
                    'formula' => $formula,
                    'sateActive' => 'active',
        ));
    }

    public function edit($id) {
        $formula = Formula::where('id', '=', $id)->sateSection()->first();
        $detalles = $this->get_formula_hija_detalle($formula);
        return View::make('sate/formulas-edit', array(
                    'formula' => $formula,
                    'sateActive' => 'active',
                    'detalles' => $detalles['detalles'],
                    'filasDeMas' => $detalles['count'],
        ));
    }

    private function set_default_values() {
        $cantidad_pesada = 'var cant=Array("0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0");';
        $codigo = 'var producto=Array("1000","117","290","725","513","460","762","563","360","485","852","514","150","30","515","12","57","11","358");';

        Session::flash('cant', $cantidad_pesada);
        Session::flash('producto', $codigo);
    }

    function get_formula_hija_detalle($formula) {
        $i = 1;
        $products = Producto::dropDown('nombreProducto');
        $porduct_select = Producto::dropDownToSelect('', false, $products);
        $detalles = '<tr id="aClonar" style="display:none;">
                                        
                                        <td class="td_codigo">
                                            <input   onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 9"  class="form-control codigo " type="text"  placeholder="Sale de calculo" >
                                        </td>
                                        <td class="td_cantidad">
                                            <input  class="form-control cantidad cantidad-no-coloreada"  placeholder="Cantidad" >
                                        </td>
                                        <td class="td_prod">
                                        <select  class="select2_category form-control producto select2-offscreen"  tabindex="-1"  >' . $porduct_select . '</select>
                                        </td>
                                        <td>
                                            <input   class="form-control coste" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input   class="form-control importe" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input   class="form-control proveedorNom" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input  class="form-control voc" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input   class="form-control densidad" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input   class="form-control vocIndividual" type="text" readonly="" placeholder="Sale de formula" tabindex="-1" >
                                        </td>
                                        <td class="boton text-right" colspan="10"></td>
                                    </tr>';



        foreach ($formula->FormulasDetalle as $forDetalle) {
            $i++;
            if (isset($forDetalle->Producto->codigo)) {
                $codigo = $forDetalle->Producto->codigo;

                $cant = $forDetalle->cantidad ?: 0;
                $porduct_select = Producto::dropDownToSelect('', false, $products, $forDetalle->idProducto);
                $coste = $forDetalle->Producto->coste ?: 0;
                $importe = fn_($forDetalle->Producto->coste * $cant);
                $proveedor = $forDetalle->Producto->proveedor->nombre;
                $voc = $forDetalle->Producto->VOC ?: 0;
                $densidad = $forDetalle->Producto->densidad ?: 0;
                $vocInd = calcularVocIndividual($voc, $cant, $densidad);

                $tab_index = '-1';

                $detalles .= '<tr class="new-rows">
                                        
                                        <td class="td_codigo">
                                            <input  name="det-codigo-' . $i . '" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 9"  class="form-control codigo " type="text"  placeholder="Sale de calculo" ' . $tab_index . '  value="' . $codigo . '">
                                        </td>
                                        <td class="td_cantidad">
                                            <input ' . $tab_index . ' name="det-cantidad-' . $i . '"  type="text" class="form-control cantidad cantidad-no-coloreada "  placeholder="Cantidad"  value="' . $cant . '" data-val="' . $cant . '">
                                        </td>
                                        <td class="td_prod">
                                        <select  name="det-producto-' . $i . '" class="select2_category form-control producto select2-offscreen"  tabindex="-1" id="producto-' . $i . '" >' . $porduct_select . '</select>
                                        </td>
                                        <td>
                                            <input id="coste-' . $i . '"  class="form-control coste" type="text" readonly="" placeholder="Sale de base" tabindex="-1" value="' . $coste . '">
                                        </td>
                                        <td>
                                            <input id="importe-' . $i . '"  class="form-control importe" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" value="' . $importe . '">
                                        </td>
                                        <td>
                                            <input id="proveedorNom-' . $i . '"  class="form-control proveedorNom" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" value="' . $proveedor . '">
                                        </td>
                                        <td>
                                            <input id="voc-' . $i . '" class="form-control voc" type="text" readonly="" placeholder="Sale de base" tabindex="-1" value="' . $voc . '">
                                        </td>
                                        <td>
                                            <input id="densidad-' . $i . '"  class="form-control densidad" type="text" readonly="" placeholder="Sale de base" tabindex="-1" value="' . $densidad . '">
                                        </td>
                                        <td>
                                            <input id="vocIndividual-' . $i . '"  class="form-control vocIndividual" type="text" readonly="" placeholder="Sale de formula" tabindex="-1" value="' . $vocInd . '">
                                        </td>
                                        
                                        <td class="boton text-right" colspan="10">
                                        <button class="btn red del-row" style="padding:1px 16px;" type="button">-</button>
                                        <button class="btn green add-row" style="padding:1px 14.5px;" type="button">+</button>
                                        </td>
                                    </tr>';
            }
        }

        //dame($detalles,1);

        return ['detalles' => $detalles, 'count' => $i];
    }

    /* Se crea a partir de la base */

    function get_new_base_hija($id) {
        $formula = Formula::where('id', '=', $id)->first();
        if ($formula->esBase != 1) {
            return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> La formula base selccionada no existe .
                                    	</div>');
        }
        //DVULEVE VALORES
        $detalles = $this->get_formula_hija_detalle($formula);

        return View::make('sate/formulas-add-base-hija', array(
                    'formula' => $formula,
                    'sateActive' => 'active',
                    'detalles' => $detalles['detalles'],
                    'filasDeMas' => $detalles['count'],
        ));
    }

    public function create() {
        return View::make('sate/formulas-add-hija', array(
                    'bases' => Formula::dropDownBases(),
                    'sateActive' => 'active',
        ));
    }

    protected function store() {


        $mBase = '';
        if (Input::has('id')) {
            $updating = true;
        } else {
            $updating = false;
        }
        $input = Input::all();
        //dame($input,2);
        $filasDeMas = Input::get('filasDeMas');


        $pendiente = 0;
        if (Input::has('pendiente')) {
            $pendiente = 1;
        }
        $rules = array(
            'nombre' => 'required',
        );

        $numbered_rows = [];
        for ($i = 0; $i <= 100; $i++) {
            $n = $i + 1;
            $cantidad = trim(Input::get('det-cantidad-' . $n));
            //dame('det-cantidad-' . $n);
            //dame(Input::has('det-cantidad-' . $n));
            if ($cantidad == '' || Input::get('det-codigo-' . $n) == '0')
                continue;
            //IN CASE THAT ROW HAS BEEN DELETED FOR THE NEW REQUIREMENT
            if (!Input::has('det-cantidad-' . $n))
                continue;
            $rules += array(
                'det-cantidad-' . $n => 'required',
                'det-codigo-' . $n => 'required',
                // 'det-coste-' . $n => 'required',
                'det-producto-' . $n => 'required',
//                'det-importe-' . $n => 'required',
//                'det-proveedor-' . $n => 'required',
//                'det-voc-' . $n => 'required',
//                'det-densidad-' . $n => 'required',
//                'det-vocIndividual-' . $n => 'required'
            );

            $numbered_rows[] = $n;
        }
        //dame($rules);
        //dame($numbered_rows,1);
        $validator = Validator::make($input, $rules);
        //        var_dump(Input::get('fecha'));
        //        var_dump($validatorExtra);exit;
        if ($validator->fails()) {
            //$this->dame($validator->messages(), 1);
            if ($updating)
                return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            $coma = $cant = $codigo = $coste = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = '';
            //DVULEVE VALORES
            foreach ($numbered_rows as $i) {
                $n = $i;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";

                $producto .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $coma = ', ';
            }
            $cant = 'cant=Array(' . $cant . ');';
            $codigo = 'var codigo=Array(' . $codigo . ');';

            $producto = 'var producto=Array(' . $producto . ');';
            //dd($cant);
            if (Input::has('convierteFormula')) {
                $mensaje = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Estas Completando una Formula Valorada.
                                    	</div> ';
                $convierteFormula = true;
            } else {
                $mensaje = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ';
                $convierteFormula = false;
            }
            return Redirect::to('add-sate')->withInput()->with(array(
                        'mensaje' => $mensaje,
                        'cant' => $cant,
                        'codigo' => $codigo,
                        'producto' => $producto,
                        'pendiente' => $pendiente,
                        'convierteFormula' => $convierteFormula,
                        'filasDeMas' => $filasDeMas
            ));
        } else {
            $isFormulasDetalleUpdate=false;
            if (Input::has('id')) {
                $formula = Formula::where('id', Input::get('id'))->sateSection()->first();
                $isFormulasDetalleUpdate = $this->isFormulasDetalleUpdates($formula->formulasDetalle,$numbered_rows);
                //var_dump($isFormulasDetalleUpdate);exit;
            } else {
                $formula = new Formula();
                $formula->fecha = time();
                $lastSate = DB::table('formulas')->select('numero_sate')->where('numero_sate', '<>', 0)->orderBy('id', 'desc')->first();
                if (!isset($lastSate->numero_sate)) {
                    $lastSate = 1;
                } else {
                    $lastSate = $lastSate->numero_sate + 1;
                }
                $formula->numero_sate = $lastSate;
                $formula->numero = 0;
            }
            $formula->fechaUltEdicion = time();
            $formula->idSeccionFormula = $_ENV['SATE'];
            $formula->origSeccion = Input::get('secciones');
            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');
            $formula->densidad = Input::get('densidad');
            $formula->codigo = Input::get('codigo');
            $formula->pendienteEdicion = '0';

            if ($formula->save()) {
                if (Input::has('id')) {
                    if ($isFormulasDetalleUpdate)
                        $formula->formulasDetalle()->delete();
                }

                if ($isFormulasDetalleUpdate)
                    foreach ($numbered_rows as $n) {
                        //$n = $i + 1;
                        $cant_trim = trim(Input::get('det-cantidad-' . $n));
                        $cant_producto = trim(Input::get('det-producto-' . $n));
                        if ($cant_trim == '' || $cant_producto == '0')
                            continue;
                        $formulasDetalle = new FormulasDetalle();
                        $formulasDetalle->cantidad = Input::get('det-cantidad-' . $n);
                        $formulasDetalle->idProducto = Input::get('det-producto-' . $n);
                        $formulasDetalle->idFormula = $formula->id;
                        $formulasDetalle->orden = $n;

                        //dame($formulasDetalle,1);
                        $formulasDetalle->save();
                        $formulasDetalle->orden = $formulasDetalle->id;
                        $formulasDetalle->save();
                    }
            } else {
                return Redirect::to('sate')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }
            if ($pendiente) {
                return Redirect::to('informes-formulas-valoracion')->with('procesarPendientes', true);
            } else {
                if ($updating) {
                    return Redirect::back()->withInput()->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
                } else {
                    return Redirect::to('edit-sate/' . $formula->id)->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
                }
                //return Redirect::to('formulas')->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
            }
        }
    }

    public function pdf_sate($id, $cantProduccion) {
        include(public_path() . "/packages/MPDF57/mpdf.php");
        //$mpdf = new mPDF('utf-8', array(210, 297));
        $mpdf = new mPDF('', // mode - default
                '', // format - A4, for example, default
                5, // font size - default 0
                '', // default font family
                0, // margin_left
                0, // margin right
                0, // margin top
                16, // margin bottom
                'L');  // L - landscape, P - portrait
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
        $url = str_replace('pdf', 'print', Request::url() . '/?user_img=0');
        //dame($url,1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        //dame($this->generalData,1);
        curl_close($ch); //dame($content);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
        exit;
    }

    function get_user_img() {
        if (isset($_GET['user_img'])) {
            $user_img = $_GET['user_img'];
        } else {
            $user_img = $this->generalData['current_user']->img;
        }
        return $user_img;
    }

    public function print_sate($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('sate/impresiones/print', $data);
    }

    public function delete($id) {
        Formula::destroy($id);
        return Redirect::to('sate');
    }

}
