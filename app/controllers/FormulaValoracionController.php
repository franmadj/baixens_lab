<?php

class FormulaValoracionController extends BaseController {

    var $viejos = array('formula' => '0', 'fechaDe' => '', 'fechaA' => '');
    
    
    public function __construct() {
        parent::__construct();
        $this->checkUserAccess([1]);
    }

    public function get_index() {
        $formulas = FormulasValoracion::all();
        //$viejos=array('formula'=>'0', 'fechaDe'=>'', 'fechaA'=>'');
        return View::make('formulasValoracion/formulasValoracion-list', array(
                    'formulas' => $formulas,
                    'formulasSel' => FormulasValoracion::dropDown(),
                    'viejos' => $this->viejos, 'formulaActive' => 'active')
        );
    }

    public function post_index() {
        
        //dame(Input::all());
        if (Input::has('formula')) {
            $formulas = new FormulasValoracion();
            $filtra = false;

            //$viejos=array('proveedor'=>'0', 'fechaDe'=>'', 'fechaA'=>'');
            if (Input::get('formula') != 0) {
                $formulas = $formulas->where('id', Input::get('formula'));
                $filtra = true;
                $this->viejos['formula'] = Input::get('formula');
            }
            if (date_validate(Input::get('fechaDe')) && date_validate(Input::get('fechaA'))) {//exit;
                $formulas = $formulas->whereBetween('fecha', array(
                    strtotime(swip_date_us_eu(Input::get('fechaDe'))),
                    strtotime(swip_date_us_eu(Input::get('fechaA')))));
                $filtra = true;
                $this->viejos['fechaDe'] = Input::get('fechaDe');
                $this->viejos['fechaA'] = Input::get('fechaA');
            }
            if ($filtra) {
                $formulas = $formulas->get();
            } else {
                $formulas::all();
            }
        } else {
            $formulas = FormulasValoracion::all();
        }
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );exit;
        return View::make('formulasValoracion/formulasValoracion-list', array('formulas' => $formulas, 'formulasSel' => FormulasValoracion::dropDown(), 'viejos' => $this->viejos, 'formulaActive' => 'active'));
    }

    public function get_view($id) {
        $formula = FormulasValoracion::where('id', '=', $id)->first();
        //dame($formula->SeccionesFormula->seccion, 1);
        //$formula->envio = ($pedido->envio == 'e') ? 'envio' : 'recojen';
        $formsDetalle = $formula->FormulasDetalle; //$this->dame($pedido->envio, 1);
        $formsEq = $formula->FormulasEquivalencia;

        return View::make('formulasValoracion/formulasValoracion-view', array(
                    'formula' => $formula,
                    'formsDetalle' => $formsDetalle,
                    'formsEq' => $formsEq, 'formulaActive' => 'active'
        ));
    }

    public function get_edit($id, $action) {
        $formula = FormulasValoracion::where('id', '=', $id)->first();
        
        $filasDeMas = $formula->FormulasValoracionDetalle->count() ;
        
        


        //$this->dame($validator->messages(), 1);
        $coma = $cant = $codigo = $coste = $producto = $importe = $porcentaje = '';
        $n = 0;
        //DVULEVE VALORES

        foreach ($formula->FormulasValoracionDetalle as $forDetalle) {//dame($forDetalle->Producto->idProveedor, 1);
            $n++;

            $codigo .= $coma . "'" . $forDetalle->Producto->codigo . "'";
            $cant .= $coma . "'" . $forDetalle->cantidad . "'";
            


            $coma = ', ';
        }





        $cant = 'cant=Array(' . $cant . ');';
        $codigo = 'var codigo=Array(' . $codigo . ');';
       


        if ($action == 'edit') {
            $view = 'formulasValoracion-edit';
        } else {
            $view = 'formulasValoracion-view';
        }


        return View::make('formulasValoracion/' . $view)->with(array(
                    'cant' => $cant,
                    'codigo' => $codigo,
                    
                    'getPorcentaje' => "$('#calcular').click();",
                    'productoCode' => Producto::dropdown('codigo'),
                    'filasDeMas' => $filasDeMas,
                    //'firstRow' => $firstRow,
                    'formula' => $formula, 'formulaActive' => 'active'
        ));
    }

    public function get_new() {

        return View::make('formulasValoracion/formulasValoracion-add', array(
                    'productoCode' => Producto::dropdown('codigo'),
                    'filasDeMas' => 0, 'formulaActive' => 'active'
        ));
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function post_create() {


        $input = Input::all();
        
        $filasDeMas = Input::get('filasDeMas');
        //dd(strtotime(Input::get('fecha')), swip_date_us_eu(Input::get('plazoEntrega')));


        $rules = array(
            //'observaciones' => 'required',
            'nombre' => 'required',
            'importeTotal' => 'required',
            'pesoTotal' => 'required',
            'precioXkg' => 'required',
        );
        $numbered_rows = [];

        for ($i = 0; $i <= 100; $i++) {
            $n = $i + 1;
            if (trim(Input::get('det-codigo-' . $n)) == '' || !Input::has('det-codigo-' . $n) || trim(Input::get('det-cantidad-' . $n)) == '' || !Input::has('det-cantidad-' . $n))
                continue;
            $rules += array(
                'det-codigo-' . $n => 'required',
                
                'det-cantidad-' . $n => 'required'
            );
            $numbered_rows[] = $n;
        }
        




        if (Input::has('id')) {
            $updating = true;
        } else {
            $updating = false;
        }


        $validator = Validator::make($input, $rules);
//        var_dump(Input::get('fecha'));
//        var_dump($validatorExtra);exit;

        if ($validator->fails()) {
           
            if ($updating)
                return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            //$this->dame($validator->messages(), 1);
            $coma = $cant = $codigo = $coste = $producto = $importe = $porcentaje = '';
            //DVULEVE VALORES
            for ($i = 1; $i <= $numbered_rows; $i++) {
                $n = $i + 1;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                

                $coma = ', ';
            }

            $cant = 'cant=Array(' . $cant . ');';
            $codigo = 'var codigo=Array(' . $codigo . ');';
            




            //dd($cant);

            return Redirect::to('add-formula-valoracion')->withInput()->with(array(
                        'mensaje' => '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ',
                        'cant' => $cant,
                        'codigo' => $codigo,
                        'productoCode' => Producto::dropdown('codigo'),
                        'filasDeMas' => $filasDeMas
            ));
        } else {
            //ame($input,1);

            if (Input::has('id')) {
                $formula = FormulasValoracion::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $formula = new FormulasValoracion();
                $formula->fecha = time();
            }//var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->nombre = Input::get('nombre');
            $formula->observaciones = Input::get('observaciones');
            if ($formula->save()) {
                

                if (Input::has('id')) {
                    $formula->formulasValoracionDetalle()->delete();
                }

                foreach ($numbered_rows as $i) {

                    $formulasDetalle = new FormulasValoracionDetalle();
                    $formulasDetalle->cantidad = Input::get('det-cantidad-' . $i);
                    $prod_id=Producto::get_data('id', 'codigo', Input::get('det-codigo-' . $i));
                    $formulasDetalle->idProducto = $prod_id;
                    $formulasDetalle->idFormulasValoracion = $formula->id;

                    $formulasDetalle->save();
					$formulasDetalle->orden = $formulasDetalle->id;
					$formulasDetalle->save();
                }
            }
            if (Input::has('printing')) {
                return Redirect::to('ver-pdf-formula-valoracion/' . $formula->id);
            }
            return Redirect::to('formulas-valoracion');
        }
    }

    public function get_delete($id) {
        FormulasValoracion::destroy($id);
        return Redirect::to('formulas-valoracion');
    }

    public function informes_valoracion() {
        $formulas = new stdClass();

        return View::make('formulas/formulas-informes', array(
                    'formulasDet' => $formulas,
                    'codigo' => '',
                    'puedeEditar' => false,
                    'tienePendientes' => Formula::tienePendientes(),
                    'productoCode' => Producto::dropDown('codigo'), 'formulaActive' => 'active'));
    }

    public function informes_valoracion_post() {
        //dame(Input::all(),1);
        $puedeEditar = false;
        if (Input::has('editar')) {
			
			//dame(Input::get('codigo'),1);
            if (Input::has('codigo')) {
                if (Input::get('codigo') != 0) {
                    $formulasDet = new FormulasDetalle();
                    $formulasDet = $formulasDet->select('idFormula')->where('idProducto', Input::get('codigo'))->groupBy('idFormula')->get();
					//dame(DB::getQueryLog(),1 );
                    //dame(Input::get('codigo'));
                    //dame($formulasDet,1);
                    foreach ($formulasDet as $formulaDet) {
                        $formula = Formula::find($formulaDet->idFormula); //dame($formula,1);
                        if ($formula) {
                            $formula->pendienteEdicion = Input::get('codigo');
                            $formula->save();
                        }
                    }
                }
            }
        } elseif (Input::has('anular')) {
            DB::table('formulas')
                    ->where('id', '>', 0)
                    ->update(array('pendienteEdicion' => 0));
        }

        $codigo = $input = '';
        if (Input::has('procesar')) {
            $input = Input::get('procesar');
        } elseif (Input::has('codigo')) {
            $input = Input::get('codigo');
        }


        if ($input) {
            $formulasDet = new FormulasDetalle();
            //$formulasDet=$formulasDet->where('idProducto', $input )->groupBy('idFormula');
            //dame($formulasDet,1);
            $formulasDet = $formulasDet->where('idProducto', $input)->get();
            $codigo = $input;
            $formulasDet = $formulasDet;
            if ($formulasDet) {
                $puedeEditar = 1;
            }//dame($formulasDet,1);
        } else {
            $formulasDet = new stdClass();
        }

        $formsId = array();
        foreach ($formulasDet as $formDet) {
            $formsId[] = $formDet;
        }
        Session::forget('formulas');
        if ($formsId) {
            Session::put('formulas', $formsId);
        }
        //if($puedeEditar)exit;
        //dame($formulasDet, 1);
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );exit;
        //dame($formulaDet[0]->Producto->nombreProducto,1);
        $formDetArr = (array) $formulasDet; //dame($formulasDet,1);
        if (Input::has('printing') && count($formDetArr) > 0 && $input) {
            $producto = Producto::find($input);
            $producto = $producto->nombreProducto;
            return View::make('formulas/impresiones/print-formula-informes', array('formulasDet' => $formulasDet, 'nombreProducto' => $producto));
        } else {
            //dame($formulasDet,1);

            return View::make('formulas/formulas-informes', array(
                        'formulasDet' => $formulasDet,
                        'codigo' => $codigo,
                        'puedeEditar' => $puedeEditar,
                        'tienePendientes' => Formula::tienePendientes(),
                        'productoCode' => Producto::dropDown('codigo'), 'formulaActive' => 'active'));
        }
    }

    public function print_formula_valoracion($id) {
        $formula = FormulasValoracion::find($id);
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active'
        );
        return View::make('formulasValoracion/print-formulasValoracion', $data);
    }

    public function ver_pdf_formula_valoracion($id) {
        $this->print_pdf();
    }
    public function ver_print_formula_valoracion($id) {
        $formula = FormulasValoracion::find($id);
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active'
        );
        //FormulasValoracion::destroy($id);
        return View::make('formulasValoracion/print-formulasValoracion', $data);
    }
    
    private function print_pdf() {
        include(public_path() . "/packages/MPDF57/mpdf.php");
		$mpdf = new mPDF('utf-8', array(210, 297));
		$mpdf = new mPDF('',    // mode - default
		 '',    // format - A4, for example, default
		 0,     // font size - default 0
		 '',    // default font family
		 0,    // margin_left
		 0,    // margin right
		 0,     // margin top
		 16,    // margin bottom
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

}
