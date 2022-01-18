<?php

class FormulaController extends BaseController {

    private $viejos = array('codigo' => '0', 'seccion' => '0', 'nombre' => '0', 'nombre_formula' => '0', 'eq' => '0', 'activa' => '-1', 'search' => '');

    function test() {
        //$formulas=Formula::with(array('formulasDetalle' => function($query){  
        //$query->where('numero', '=',321 );  
        //}))->whereNotIn('numero',[2244,2245,82,2386,1955])->get();
        //var_dump($formulas);
        //290 - 42
        //321 - 68
        //899 - 925
        //900 - 926

        $formulas = Formula::whereNotIn('numero', [2244, 2245, 82, 2386, 1955, 58, 970])->get();
        foreach ($formulas as $formula) {
            $detalle321 = FormulasDetalle::where('idFormula', $formula->id)->whereIn('idProducto', [68])->first();
            $detalle290 = FormulasDetalle::where('idFormula', $formula->id)->whereIn('idProducto', [42])->first();
            //var_dump($detalle321,$detalle290);continue;
            if ($detalle321 || $detalle290) {

                //$idDetalleEliminar=$detalle321?68:42;

                if ($detalle321) {
                    $idDetalleEliminar = $detalle321->id;
                } else {

                    $idDetalleEliminar = $detalle290->id;
                }

                var_dump('eliminara detalle:' . $idDetalleEliminar);


                $changeOrder = FormulasDetalle::where('idFormula', $formula->id)->where('id', '>', $idDetalleEliminar)->get();

                foreach ($changeOrder as $cho) {
                    $cho->orden = $cho->orden + 1;
                    $cho->save();

                    var_dump('cambia orden detalle id :' . $cho->id);
                }


                var_dump('si');



                $detalles = FormulasDetalle::where('idFormula', $formula->id)->get();
                $totFormula = 0;
                foreach ($detalles as $eldetalle) {
                    $totFormula += $eldetalle->cantidad;
                }
                var_dump($formula->id);
                var_dump($totFormula);

                $icb = $totFormula * 0.3 / 100;
                $mv = $totFormula * 0.09 / 100;


                if (FormulasDetalle::find($idDetalleEliminar)->delete()) {

                    var_dump('eliminando detalle:' . $idDetalleEliminar);


                    $formDetalle = new FormulasDetalle();
                    $formDetalle->idFormula = $formula->id;
                    $formDetalle->idProducto = 925;
                    $formDetalle->cantidad = $icb;
                    $formDetalle->orden = $idDetalleEliminar;
                    $formDetalle->save();

                    var_dump('añade orden a formula:' . $formula->id . ' con orden: ' . $idDetalleEliminar);


                    $formDetalle = new FormulasDetalle();
                    $formDetalle->idFormula = $formula->id;
                    $formDetalle->idProducto = 926;
                    $formDetalle->cantidad = $mv;
                    $formDetalle->orden = $idDetalleEliminar + 1;
                    $formDetalle->save();

                    var_dump('añade orden a formula:' . $formula->id . ' con orden: ' . $idDetalleEliminar + 1);



                    $formula->componentes = $formula->componentes + 1;
                    $formula->save();
                } else {
                    var_dump('No eliminando detalle!!!:' . $idDetalleEliminar);
                }


                var_dump('))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))');
            } else {
                //var_dump('no');
                //var_dump($formula->id);
                //var_dump($detalle);
            }
        }
    }

    public function cambioProductoLote() {
        $message = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Error .
                                    	</div>';
        if (Input::has('producto_antiguo') && Input::has('producto_nuevo')) {
            $old = DB::table('productos')->select('id')->where('codigo', Input::get('producto_antiguo'))->first();
            $new = DB::table('productos')->select('id')->where('codigo', Input::get('producto_nuevo'))->first();
            if ($old && $new) {
                $res = DB::table('formulas_detalle')
                        ->where('idProducto', $old->id)
                        ->update(array('idProducto' => $new->id));
                if ($res)
                    $message = '<div class="alert alert-success">
                                        	<strong>Cambio realizado con éxito!! </strong>
                                    	</div>';
            }
        }
        return Redirect::to('informes-formulas-valoracion')->with('mensaje_lote', $message);
    }

    public function get_catalogar($est, $id, $ref, $pinturas) {
        if ($est == 0 or $est == 1) {
            $formula = Formula::find($id); //var_dump($formula->origSeccion);exit;
            if (0 == $est) {
                $formula->idSeccionFormula = 6;
            } elseif (!(empty($formula->origSeccion))) {
                $formula->idSeccionFormula = $formula->origSeccion;
            }
            $formula->activa = $est;
            $formula->save();
        }
        if ($ref == '1') {// base
            return Redirect::to('formulas-base');
        }
        if ($pinturas === '1') {
            return Redirect::to('formulas-pinturas');
        } else {
            return Redirect::to('formulas');
        }

        //$formulas = Formula::all();
        $data = array(
            //'codigos'=> $formulas,

            'secciones' => SeccionesFormula::dropDown(),
            'nombres' => Formula::dropDown(),
            'nombres_formula' => Formula::dropDown(true),
            'eqs' => FormulasEquivalencia::dropDown(),
            'codigos' => Producto::dropDown('codigo'),
            'viejos' => $this->viejos,
            'formulaActive' => 'active',
            'user_type' => Auth::user()->type,
            'base' => '0',
            'url_base' => '',
            'formulas' => []
        );



        return View::make('formulas/formulas-list', $data);
    }

    public function get_index_pinturas() {
        //$formulas = Formula::all();

        $formulas = [];
        return View::make('formulas/formulas-list-pinturas', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    //'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'codigos' => Producto::dropDown('codigo'),
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'viejos' => $this->viejos,
                    'user_type' => Auth::user()->type,
                    'formulaActive' => 'active',
                    'base' => '0',
                    'url_base' => ''
        ));
    }

    public function get_index() {
        $this->checkUserAccess([1, 2]);
        //$formulas = Formula::all();
        if (Input::has('page') && Input::has('filter') && Session::get('filter')) {
            return $this->post_index(Session::get('filter'));
        }
        $formulas = []; //Formula::orderBy('id', 'DESC')->pinturasValidadas()->where('idSeccionFormula', '!=', $_ENV['SATE'])->paginate(15);

        return View::make('formulas/formulas-list', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'codigos' => Producto::dropDown('codigo'),
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'viejos' => $this->viejos,
                    'formulaActive' => 'active',
                    'user_type' => Auth::user()->type,
                    'base' => '0',
                    'url_base' => '',
                    'filter' => false
        ));
    }

    public function post_index($filterPaginated = false) {
        //dame(Input::all(),1);
        $input = $filterPaginated ? $filterPaginated : Input::all();
        $filtrar_get = $excel_get = $excel_new_get = $imprimir = false;
        if (isset($input['filtrar'])) {
            $filtrar_get = true;
            if (!$filterPaginated)
                Session::put('filter', Input::all());
        } elseif (Input::has('excel')) {
            $excel_get = true;
            $max = 10000;
        } elseif (Input::has('excel_new')) {
            $excel_new_get = true;
            $max = 10000;
        } elseif (Input::has('imprimir')) {
            $imprimir = true;
            $max = 10;
        }
        $formulas = Formula::pinturasValidadas();
        if (isset($input['nombre'])) {

            if ($filtrar_get or $excel_get or $imprimir) {
                
            } elseif ($excel_new_get) {

                $formulas = $formulas
                        ->select([
                            DB::raw('Max(formulas.esColor) as esColor'),
                            DB::raw('Max(formulas.id) as id'),
                            DB::raw('Max(formulas.numero) as numero'),
                            DB::raw('Max(formulas.activa) as activa'),
                            DB::raw('Max(formulas.nombre) as nombre'),
                            DB::raw('Max(formulas.idSeccionFormula) as idSeccionFormula'),
                            DB::raw('Max(productos.nombreProducto) as nombreProducto'),
                            DB::raw('Max(formulas_equivalencias.equivalencia) as equivalencia'),
                            DB::raw('Max(productos.coste) as coste'),
                            DB::raw('formulas_detalle.id as formulas_detalle_id')
                        ])
                        ->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
                        ->join('formulas_equivalencias', 'formulas.id', '= ', 'formulas_equivalencias.idFormula', 'full outer')
                        ->join('productos', 'formulas_detalle.idProducto', '= ', 'productos.id');
            }
            //$formulas = $formulas->where('esBase', Input::get('esBase'));
            $filtra = $porId = $formVacia = false;
            if ($input['codigo'] != 0) {
                $filtra = true;
                $this->viejos['codigo'] = $input['codigo'];
                if ($filtrar_get or $imprimir or $excel_get) {
                    $formulas = $formulas->select([
                                DB::raw('Max(formulas.parent) as parent'),
                                DB::raw('Max(formulas.id) as id'),
                                DB::raw('Max(formulas.numero) as numero'),
                                DB::raw('count(formulas.esBase) as esBase'),
                                DB::raw('Max(formulas.nombre) as nombre'),
                                DB::raw('Max(formulas.numeroHija) as numeroHija'),
                                DB::raw('Max(formulas.numero_sate) as numero_sate'),
                        DB::raw('Max(formulas.idSeccionFormula) as idSeccionFormula'),
                            ])
                            ->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
                            ->where('formulas_detalle.idProducto', $input['codigo'])->groupBy('formulas.id');
                } elseif ($excel_new_get or $imprimir) {
                    $formulas = $formulas
                            ->where('formulas_detalle.idProducto', $input['codigo']);
                }
            }
            if ($input['nombre'] != 0) {
                $formulas = $formulas->where('formulas.id', $input['nombre']);
                $filtra = $porId = true;
                $this->viejos['nombre'] = $input['nombre'];
            }
            if ($input['nombre_formula'] != 0) {
                $formulas = $formulas->where('formulas.id', $input['nombre_formula']);
                $filtra = $porId = true;
                $this->viejos['nombre_formula'] = $input['nombre_formula'];
            }
            if ($input['seccion'] != 0) {
                $formulas = $formulas->where('idSeccionFormula', $input['seccion']);
                $filtra = true;
                $this->viejos['seccion'] = $input['seccion'];
            }
            if ($input['eq'] != 0) {
                $formulasEquivalencias = FormulasEquivalencia::find($input['eq']);
                if (!$porId) {
                    $formulas = $formulas->where('formulas.id', $formulasEquivalencias->idFormula);
                } else {
                    if ($input['nombre'] != $formulasEquivalencias->idFormula)
                        $formVacia = true;
                }
                $filtra = true;
                $this->viejos['eq'] = $input['eq'];
            }
            if ($input['search'] != '') {
                $formulas = $formulas
                        ->where(function ($query)use($input) {
                    $query->where('formulas.nombre', 'like', '%' . $input['search'] . '%')
                    ->orWhere('formulas.descripcion', 'like', '%' . $input['search'] . '%')
                    ->orWhere('formulas.codigo', 'like', '%' . $input['search'] . '%')
                    ->orWhere('formulas.codigo', 'like', '%' . str_replace('-', '', $input['search']) . '%');
                });
                $filtra = true;
                $this->viejos['search'] = $input['search'];
            }
            if ($filtra) {
                if ($filtrar_get) {
                    
                } elseif ($excel_get or $imprimir) {
                    $formulas = $formulas->orderBy('idSeccionFormula', 'desc')->orderBy('formulas.id');
                } elseif ($excel_new_get) {
                    $formulas = $formulas->groupBy('formulas_detalle.id');
                }
            } else {
                if ($filtrar_get or $excel_get or $imprimir) {
                    $formulas = $formulas->orderBy('idSeccionFormula', 'desc');
                } elseif ($excel_new_get) {
                    $formulas = $formulas->groupBy('formulas_detalle.id');
                }
            }
        }


        if ($filtrar_get)
            $formulas = $formulas->paginate(50);
        else
            $formulas = $formulas->get();
//        if ($formVacia)
//            $formulas = new stdClass();
        //dame(URL::to('/'),1);
        //dame($formulas,1);
        //dame(DB::getQueryLog(), 1); //dame($input['fechaA'] );exit;
        //dame(Input::get(),1);
        if ($excel_new_get) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN EXCEL
            $n = 2;
            include(public_path() . "/packages/phpExcel/Classes/PHPExcel.php");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('a')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setAutoSize(true);
            $new_formulas = [];
            $r = 0;
            foreach ($formulas as $formula) {
                $r++;
                if ($formula->idSeccionFormula == 1) {//ENLUCIDOS
                    $new_formulas[1][] = $formula;
                } elseif ($formula->idSeccionFormula == 2) {//MORTEROS
                    $new_formulas[2][] = $formula;
                } else {
                    $new_formulas[3][] = $formula;
                }
            }
            //dame($r,1);
            if (isset($new_formulas[1])) {
                $objPHPExcel->getActiveSheet()->SetCellValue('a1', 'Seccion enlucidos');
                $objPHPExcel->getActiveSheet()->getStyle("a1")->getFont()->setSize(20);
                $objPHPExcel->getActiveSheet()->SetCellValue('a2', 'NF');
                $objPHPExcel->getActiveSheet()->SetCellValue('b2', 'Producto');
                //$objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('c2', 'Equivalencia');
                //$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('d2', 'Coste');
                //$objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('e2', 'Vigor');
                //$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
                foreach ($new_formulas[1] as $formula) {
                    $n++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $formula->numero);
                    $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, $formula->nombreProducto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, $formula->equivalencia);
                    $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, $formula->coste);
                    $estado = $formula->activa == '1' ? 'En Vigor' : 'Descatalogada';
                    $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, $estado);
                    if ($n > $max)
                        break;
                }
            }
            if (isset($new_formulas[2])) {
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'Seccion Morteros');
                $objPHPExcel->getActiveSheet()->getStyle("a1")->getFont()->setSize(20);
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'NF');
                $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, 'Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, 'Equivalencia');
                $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, 'Coste');
                $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, 'Vigor');
                foreach ($new_formulas[2] as $formula) {
                    $n++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $formula->numero);
                    $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, $formula->nombreProducto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, $formula->equivalencia);
                    $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, $formula->coste);
                    $estado = $formula->activa == '1' ? 'En Vigor' : 'Descatalogada';
                    $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, $estado);
                    if ($n > $max)
                        break;
                }
            }
            if (isset($new_formulas[3])) {
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'Seccion Otros');
                $objPHPExcel->getActiveSheet()->getStyle("a1")->getFont()->setSize(20);
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'NF');
                $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, 'Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, 'Equivalencia');
                $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, 'Coste');
                $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, 'Vigor');
                foreach ($new_formulas[3] as $formula) {
                    $n++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $formula->numero);
                    $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, $formula->nombreProducto);
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, $formula->equivalencia);
                    $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, $formula->coste);
                    $estado = $formula->activa == '1' ? 'En Vigor' : 'Descatalogada';
                    $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, $estado);
                    if ($n > $max)
                        break;
                }
            }
            //dame($objPHPExcel,1);
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(public_path() . '/files/excel.xlsx');
            header('location: ' . URL::to('/') . '/files/excel.xlsx');
            exit();
        } elseif ($excel_get) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN EXCEL NORMAL
            include(public_path() . "/packages/phpExcel/Classes/PHPExcel.php");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('a')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setAutoSize(true);
            $idSeccion = '';
            $n = 0;
            foreach ($formulas as $formula) {
                if ($formula->idSeccionFormula != $idSeccion or $idSeccion == '') {
                    $idSeccion = $formula->idSeccionFormula;
                    if ($formula->SeccionesFormula) {
                        $seccion_formula = $formula->SeccionesFormula->seccion;
                    } else {
                        $seccion_formula = 'no Seccion DB';
                    }
                    $n++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $seccion_formula);
                    $objPHPExcel->getActiveSheet()->getStyle("a" . $n)->getFont()->setSize(20);
                    $n++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'NF');
                    $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, 'Codigo');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, 'Nombre');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, 'Equivalencia');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, 'Importe');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('f' . $n, 'Vigor');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
                }
                $equivalencias = $coma = '';
                foreach ($formula->FormulasEquivalencia as $eq):
                    $equivalencias .= $coma . $eq->equivalencia;
                    $coma = ', ';
                endforeach;
                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $formula->numero);
                $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, $formula->codigo);
                $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, $formula->nombre);
                $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, $equivalencias);
                $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, Formula::importe($formula->id));
                $estado = $formula->activa == '1' ? 'En Vigor' : 'Descatalogada';
                $objPHPExcel->getActiveSheet()->SetCellValue('f' . $n, $estado);
            }
            //dame($objPHPExcel,1);
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(public_path() . '/files/excel.xlsx');
            header('location: ' . URL::to('/') . '/files/excel.xlsx');
            exit();
        } elseif ($imprimir) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN PRINT
            include(public_path() . "/packages/inc/print-pdf-formulas.php");
            /* $data = array(
              'formulas' => $formulas,
              'idSeccion' => '-1', 'formulaActive' => 'active'
              );
              dame($formulas); */
            //return View::make('formulas/impresiones/print-formulas', $data);
        } else {//////////////////////////////////////////////////////////////////LIST FORMULAS IN HTML
            $url_base = '';
            $url_base_active = '';
            if ($input['esBase'] == '1') {
                $url_base = '-base';
                $url_base_active = 'Base';
            }
            if (isset($input['is_pinturas'])) {
                $view = 'formulas/formulas-list-pinturas';
            } else {
                $view = 'formulas/formulas-list';
            }
            return View::make($view, array(
                        'formulas' => $formulas,
                        'secciones' => SeccionesFormula::dropDown(),
                        'nombres' => Formula::dropDown(),
                        'nombres_formula' => Formula::dropDown(true),
                        'user_type' => Auth::user()->type,
                        'eqs' => FormulasEquivalencia::dropDown(),
                        'codigos' => Producto::dropDown('codigo'),
                        'viejos' => $this->viejos, 'formula' . $url_base_active . 'Active' => 'active',
                        'base' => $input['esBase'],
                        'url_base' => $url_base,
                        'filter' => true
            ));
        }
    }

    private function print_pdf_formula($data) {
        include(public_path() . "/packages/MPDF57/mpdf.php");
        $mpdf = new mPDF('utf-8', array(210, 297));
        $mpdf = new mPDF('', // mode - default
                '', // format - A4, for example, default
                0, // font size - default 0
                '', // default font family
                0, // margin_left
                0, // margin right
                0, // margin top
                16, // margin bottom
                'L');  // L - landscape, P - portrait
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
        //$url = str_replace('pdf', 'print', Request::url() . '/?user_img=0');
        //dame($url,1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://laboratorio/formulas');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        //dame($this->generalData,1);
        curl_close($ch); //dame($content);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
        exit;
    }

    public function get_view($id) {
        $formula = Formula::where('id', '=', $id)->first();
        //dame($formula,1);
        return View::make('formulas/formula-view', array(
                    'formula' => $formula, 'formulaActive' => 'active'
        ));
    }

    public function get_edit($id, $accion) {

        $formula = Formula::where('id', '=', $id)->first();
//        $firstRow = array(
//            'cantidad' => '',
//            'producto' => '',
//            'codigo' => '',
//            'enlucido' => 'MA',
//            'vocIndividual' => '',
//            'proveedor' => '',
//            'proveedorNom' => '',
//            'coste' => '',
//            'voc' => '',
//            'importe' => '',
//            'densidad' => ''
//        );
        $filasDeMas = $formula->FormulasDetalle->count(); //var_dump($filasDeMas);
        $coma = $cant = $codigo = $coste = $enlucido = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = '';
        $n = 0;
        //DVULEVE VALORES
        foreach ($formula->FormulasDetalle as $forDetalle) {
            if (!isset($forDetalle->Producto->codigo))
                continue;
            //dame($forDetalle->Producto->Proveedor->nombre, 1);
            $n++;
            //if ($n == 0) {
//                $firstRow = array(
//                    'cantidad' => $forDetalle->cantidad,
//                    'producto' => $forDetalle->idProducto,
//                    'codigo' => $forDetalle->idProducto,
//                    'enlucido' => $forDetalle->enlucido,
//                    'vocIndividual' => $this->calculo_voc_individual($forDetalle->Producto->VOC, $forDetalle->cantidad, $forDetalle->Producto->densidad),
//                    'proveedorNom' => $forDetalle->Producto->Proveedor->nombre,
//                    'proveedor' => $forDetalle->Producto->idProveedor,
//                    'coste' => $forDetalle->Producto->coste,
//                    'voc' => $forDetalle->Producto->VOC,
//                    'importe' => $forDetalle->Producto->coste * $forDetalle->cantidad,
//                    'densidad' => $forDetalle->Producto->densidad
//                );
            // } else {
            $codigo .= $coma . "'" . $forDetalle->Producto->codigo . "'";
            $cant .= $coma . "'" . $forDetalle->cantidad . "'";
            $enlucido .= $coma . "'" . $forDetalle->enlucido . "'";
            $producto .= $coma . "'" . $forDetalle->Producto->codigo . "'";
            $coma = ', ';
            // }
        }
        //$this->dame($cant, 1);
        $cant = 'cant=Array(' . $cant . ');';
        $codigo = 'var codigo=Array(' . $codigo . ');';
        $enlucido = 'var enlucido=Array(' . $enlucido . ');';
        $producto = 'var producto=Array(' . $producto . ');';
        $n = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n] = $forEq->codigo;
        }
        $pendiente = 0;
        if ($accion == 'pendiente')
            $pendiente = 1;
//        if (Session::has('numComponentes') && $formula->componentes < Session::get('numComponentes')) {
//            Session::flash('mensaje', '<div class="alert alert-warning">
//                                        	<strong>Atención!! </strong> Numero componentes incorrecto .
//                                    	</div>');
//        }

        return View::make('formulas/formulas-edit', array(
                    'formula' => $formula,
                    'proveedores' => Proveedor::dropDown(),
                    'secciones' => SeccionesFormula::dropDown(),
                    'productoName' => Producto::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'cant' => $cant,
                    'codigo' => $codigo,
                    'enlucido' => $enlucido,
                    'producto' => $producto,
                    'filasDeMas' => $filasDeMas,
                    'errorNumComponentes' => $formula->componentes > 0 && $formula->componentes != $filasDeMas,
                    //'firstRow' => $firstRow,
                    'equivalencias' => $equivalencias,
                    'pendiente' => $pendiente, 'formulaActive' => 'active'
        ));
    }

    public function get_new() {
        $this->checkUserAccess([1]);
        return View::make('formulas/formulas-add', array(
                    'secciones' => SeccionesFormula::dropDown(),
                    'bases' => Formula::dropDownBases(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    //'proveedores' => Proveedor::dropDown(),
                    'pendiente' => '0',
                    'filasDeMas' => 0, 'formulaActive' => 'active',
        ));
    }

    protected function post_create() {

        $mBase = '';
        $filasDeMas = Input::get('filasDeMas');
        if (Input::has('id')) {
            $updating = true;

//            if (Input::has('numComponentes') && $filasDeMas > Input::get('numComponentes')) {
//                return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
//                                        	<strong>Atención!! </strong> Numero componentes incorrectoooo .
//                                    	</div>');
//            }
//            } elseif (Input::has('numComponentes')) {
//                Session::flash('numComponentes', Input::get('numComponentes'));
//            }
        } else {
            $updating = false;
        }
        $input = Input::all();
        //dame($input,2);

        $enlucido = false;
        if (Input::get('secciones') == '1') {
            $enlucido = true;
        }
        $pendiente = 0;
        if (Input::has('pendiente')) {
            $pendiente = 1;
        }
        $rules = array(
            'secciones' => 'required',
            'nombre' => 'required',
                //'densidad' => 'required',
        );
        if ($enlucido) {//esta parte se ha suprimido, dejo el codigo por is acaso
            /* $rules += array(
              'codigoMa' => 'required',
              );
              $cod_base_trim=trim(Input::get('codigoBaseMg'));
              if ($cod_base_trim != '') {
              $rules += array(
              'codigoBaseMg' => 'required',
              );
              $mBase = 'Mg';
              } else {
              $rules += array(
              'codigoBaseMp' => 'required',
              );
              $mBase = 'Mp';
              } */
        }
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
            if ($enlucido and false) {
                $rules += array(
                    'det-enlucido-' . $n => 'required'
                );
            }
            $numbered_rows[] = $n;
        }

        $numComponentes = 0;
        foreach ($numbered_rows as $n) {
            //$n = $i + 1;
            $cant_trim = trim(Input::get('det-cantidad-' . $n));
            $cant_producto = trim(Input::get('det-producto-' . $n));
            if ($cant_trim == '' || $cant_producto == '0')
                continue;
            $numComponentes++;
        }


//        if (Input::has('numComponentes') && $numComponentes < Input::get('numComponentes')) {
//            return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
//                                        	<strong>Atención!! </strong> Numero componentes incorrecto, comprobar formula.
//                                    	</div>');
//        }
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
            $coma = $cant = $codigo = $coste = $enlucido = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = '';
            //DVULEVE VALORES
            foreach ($numbered_rows as $i) {
                $n = $i;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                $enlucido .= $coma . "'" . Input::get('det-enlucido-' . $n) . "'";
                $producto .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $coma = ', ';
            }
            $cant = 'cant=Array(' . $cant . ');';
            $codigo = 'var codigo=Array(' . $codigo . ');';
            $enlucido = 'var enlucido=Array(' . $enlucido . ');';
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
            return Redirect::to('add-formula')->withInput()->with(array(
                        'mensaje' => $mensaje,
                        'cant' => $cant,
                        'codigo' => $codigo,
                        'enlucido' => $enlucido,
                        'producto' => $producto,
                        'pendiente' => $pendiente,
                        'convierteFormula' => $convierteFormula,
                        'filasDeMas' => $filasDeMas
            ));
        } else {
            if (Input::has('id')) {
                $formula = Formula::find(Input::get('id'));
                //Si estaba en laboratorio y pasa a ser cualquier otra que no sea laboratorio la formula se activa o si pasa de desccion descatalogado a cualquier otra
                if (($formula->idSeccionFormula == 4 && 4 != Input::get('secciones')) or ( $formula->idSeccionFormula == 6 && 6 != Input::get('secciones'))) {
                    $formula->activa = 1;
                }
                //$idPedido=Input::has('id');
            } else {
                $formula = new Formula();
                $formula->fecha = time();
                $formula->numero = $this->lastFormulaId();
            } //var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->fechaUltEdicion = time();
            $formula->idSeccionFormula = Input::get('secciones');
            $formula->origSeccion = Input::get('secciones');
            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');
            $formula->densidad = Input::get('densidad');
            $formula->codigo = Input::get('codigo');
            $formula->pendienteEdicion = '0';
            if ($enlucido) {
                //if (Input::get('codigoBaseMg'))
                $formula->codigoBaseMg = Input::get('codigoBaseMg');
                //if ((Input::get('codigoBaseMp')))
                $formula->codigoBaseMp = Input::get('codigoBaseMp');
                /* if ($mBase == 'Mg') {
                  $formula->codigoBaseMg = '';
                  if ((Input::get('codigoBaseMg')))
                  $formula->codigoBaseMg = Input::get('codigoBaseMg');
                  $formula->codigoBaseMp = '';
                  } else if ($mBase == 'Mp') {
                  $formula->codigoBaseMp = '';
                  if ((Input::get('codigoBaseMp')))
                  $formula->codigoBaseMp = Input::get('codigoBaseMp');
                  $formula->codigoBaseMg = '';
                  } */
                //if ((Input::get('codigoMa')))
                $formula->codigoMa = Input::get('codigoMa');
            }
            if ($formula->save()) {
                if (Input::has('id')) {
                    $formula->formulasDetalle()->delete();
                    $formula->formulasEquivalencia()->delete();
                }
                for ($i = 1; $i < 6; $i++) {
                    $eq_trim = trim(Input::get('equivalencia-' . $i));
                    $cod_trim = trim(Input::get('codigo-' . $i));
                    if ($eq_trim != '' && $cod_trim != '') {
                        $equivalencia = new FormulasEquivalencia();
                        $equivalencia->codigo = trim(Input::get('codigo-' . $i));
                        $equivalencia->equivalencia = trim(Input::get('equivalencia-' . $i));
                        $equivalencia->idFormula = $formula->id;
                        $equivalencia->save();
                    }
                }
                $numComponentes = 0;
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

                    if ($enlucido) {
                        $formulasDetalle->enlucido = Input::get('det-enlucido-' . $n);
                    }
                    $numComponentes++;
                    $formulasDetalle->save();
                    $formulasDetalle->orden = $formulasDetalle->id;
                    $formulasDetalle->save();
                }
                $formula->componentes = $numComponentes;
                $formula->save();
            } else {
                return Redirect::to('formulas')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }
            if ($pendiente) {
                return Redirect::to('informes-formulas-valoracion')->with('procesarPendientes', true);
            } else {
                if ($updating) {
                    return Redirect::back()->withInput()->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
                } else {
                    return Redirect::to('edit-formula/' . $formula->id . '/edicion');
                }
                //return Redirect::to('formulas')->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
            }
        }
    }

    public function get_delete($id) {
        $this->checkUserAccess([1]);
        Formula::destroy($id);
        return Redirect::to('formulas');
    }

    public function get_delete_base($id) {
        Formula::destroy($id);
        return Redirect::to('formulas-base');
    }

    private function print_pdf() {
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

    public function print_formulas($formulas = NULL) {
        $formulas = new Formula();
        $formulas = $formulas->where('id', '>', '0')->orderBy('idSeccionFormula', 'desc')->get();
        //dame($formulas,1);
        $data = array(
            'formulas' => $formulas,
            'idSeccion' => '-1', 'formulaActive' => 'active'
        );
        //dame($formulas);
        return View::make('formulas/impresiones/print-formulas', $data);
    }

    function get_user_img() {
        if (isset($_GET['user_img'])) {
            $user_img = $_GET['user_img'];
        } else {
            $user_img = $this->generalData['current_user']->img;
        }
        return $user_img;
    }

    public function print_formula_valorada($id, $cantProduccion) {
        //dame($_GET,1);
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('formulas/impresiones/print-formula-valorada', $data);
    }

    public function popup_formula_valorada($id, $cantProduccion) {
        //dame($_GET,1);
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('formulas/impresiones/popup-formula-valorada', $data);
    }

    public function pdf_formula_valorada($id, $cantProduccion) {
        //dame($this->generalData,1);
        $this->print_pdf();
    }

    public function print_formula_sin_valorar($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('formulas/impresiones/print-formula-no-valorada', $data);
    }

    public function pdf_formula_sin_valorar($id, $cantProduccion) {
        $this->print_pdf();
    }

    public function pdf_formula_ajustada($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id); //dame($formula->FormulasDetalle);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        require_once public_path() . "/packages/inc/pdf-formula-ajustada.php";
        //return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }

    /* public function pdf_formula_ajustada($id, $cantProduccion) {
      $this->print_pdf();
      } */

    public function ajax_set_equivalencia_display() {
        $res = DB::table('formulas_equivalencias')->where('id', Input::get('id'))->update(array(
            'display' => Input::get('val')
        ));
        $response = array(
            'status' => $res
        );
        return Response::json($response);
    }

    /* filtra la formual detalles para cojer solo los que pertenecen al tupo especificado en el parametro */

    function filter_enlucidos($formula, $tipo) {
        foreach ($formula->FormulasDetalle as $key => $val) {
            if ($formula->FormulasDetalle[$key]->enlucido != $tipo)
                unset($formula->FormulasDetalle[$key]);
        }
        return $formula;
    }

    public function print_formula_ajustada_ma($id, $cantProduccion, $size) {
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $user_img = $this->get_user_img();
        $formula = $this->filter_enlucidos($formula, 'MA');
        $size = ($size == 'g') ? 'Grande' : 'Pequeña';
        $data = array(
            'formula' => $formula,
            'enlucido' => 'Materia activa',
            'size' => $size, 'formulaActive' => 'active', 'logo_img' => 'logo_color.jpg', 'user_img' => $user_img
        );
        require_once public_path() . "/packages/inc/pdf-formula-ajustada-enlucidos.php";
        //return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }

    public function print_formula_ajustada_base($id, $cantProduccion, $size) {
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $user_img = $this->get_user_img();
        $formula = $this->filter_enlucidos($formula, 'base');
        $size = ($size == 'g') ? 'Grande' : 'Pequeña';
        $data = array(
            'formula' => $formula,
            'enlucido' => 'Base',
            'size' => $size, 'formulaActive' => 'active', 'logo_img' => 'logo_color.jpg', 'user_img' => $user_img
        );
        //dame($formula,1);
        require_once public_path() . "/packages/inc/pdf-formula-ajustada-enlucidos.php";
        //return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }

    /* BASES */

    public function get_new_base() {
        return View::make('formulas/formulas-add-base', array(
                    'secciones' => SeccionesFormula::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    //'proveedores' => Proveedor::dropDown(),
                    'pendiente' => '0',
                    'filasDeMas' => 0,
                    'formulaActive' => 'active',
        ));
    }

    protected function post_create_base() {
        $this->checkUserAccess([1]);
        $mBase = '';
        if (Input::has('id')) {
            $updating = true;
        } else {
            $updating = false;
        }
        $input = Input::all();
        //dame($input,2);
        $filasDeMas = Input::get('filasDeMas');
        $enlucido = false;
        $rules = array(
            'nombre' => 'required',
                //'densidad' => 'required',
        );
        $numbered_rows = [];
        for ($i = 0; $i <= 100; $i++) {
            $n = $i + 1;
            $cantidad = trim(Input::get('det-cantidad-' . $n));
            //dame('det-cantidad-' . $n);
            //dame(Input::has('det-cantidad-' . $n));
            if (($cantidad === '' || Input::get('det-codigo-' . $n) == '0')) {

                continue;
            }

            //IN CASE THAT ROW HAS BEEN DELETED FOR THE NEW REQUIREMENT
            if (!Input::has('det-cantidad-' . $n)) {
                continue;
            }



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
//        dame($rules);
//        dame($numbered_rows,1);
        $validator = Validator::make($input, $rules);
        //        var_dump(Input::get('fecha'));
        //        var_dump($validatorExtra);exit;
        if ($validator->fails()) {
            //$this->dame($validator->messages(), 1);
            if ($updating)
                return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            $coma = $cant = $codigo = $coste = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = $colores = '';
            //DVULEVE VALORES
            foreach ($numbered_rows as $i) {
                $n = $i;

                $codigo_val = (NULL != Input::get('det-codigo-' . $n)) ? Input::get('det-codigo-' . $n) : '';
                $codigo .= $coma . "'" . $codigo_val . "'";

                $cant_val = (NULL != Input::get('det-cantidad-' . $n)) ? Input::get('det-cantidad-' . $n) : '';
                $cant .= $coma . "'" . $cant_val . "'";

                $prod_val = (NULL != Input::get('det-codigo-' . $n)) ? Input::get('det-codigo-' . $n) : '';
                $producto .= $coma . "'" . $prod_val . "'";

                $colores_val = (NULL != Input::get('det-color-' . $n)) ? Input::get('det-color-' . $n) : '';
                $colores .= $coma . "'" . $colores_val . "'";

                $coma = ', ';
            }
            $cant = 'cant=Array(' . $cant . ');';
            $codigo = 'var codigo=Array(' . $codigo . ');';
            $enlucido = 'var enlucido=Array(' . $enlucido . ');';
            $producto = 'var producto=Array(' . $producto . ');';
            $colores = 'var colores=Array(' . $colores . ');';
            //dd($cant);
            $mensaje = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ';
            return Redirect::to('add-formula-base')->withInput()->with(array(
                        'mensaje' => $mensaje,
                        'cant' => $cant,
                        'codigo' => $codigo,
                        'producto' => $producto,
                        'enlucido' => $enlucido,
                        'filasDeMas' => $filasDeMas
            ));
        } else {
            if (Input::has('id')) {
                $formula = Formula::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $formula = new Formula();
                $formula->fecha = time();
                $formula->numero = $this->lastFormulaId();
                //dame($lastFor,1);
            } //var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->fechaUltEdicion = time();
            $formula->idSeccionFormula = 8;
            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');
            $formula->densidad = Input::get('densidad');
            $formula->codigo = Input::get('codigo');
            $formula->esBase = 1;
            if ($formula->save()) {
                if (Input::has('id')) {
                    $formula->formulasDetalle()->delete();
                    $formula->formulasEquivalencia()->delete();
                }
                for ($i = 1; $i < 6; $i++) {
                    $eq_trim = trim(Input::get('equivalencia-' . $i));
                    $cod_trim = trim(Input::get('codigo-' . $i));
                    if ($eq_trim != '' && $cod_trim != '') {
                        $equivalencia = new FormulasEquivalencia();
                        $equivalencia->codigo = trim(Input::get('codigo-' . $i));
                        $equivalencia->equivalencia = trim(Input::get('equivalencia-' . $i));
                        $equivalencia->idFormula = $formula->id;
                        $equivalencia->save();
                    }
                }
                foreach ($numbered_rows as $n) {
                    //$n = $i + 1;
                    $cant_trim = trim(Input::get('det-cantidad-' . $n));
                    $cant_producto = trim(Input::get('det-producto-' . $n));
                    $esColor = trim(Input::get('det-color-' . $n));
                    if (($cant_trim == '' || $cant_producto == '0'))
                        continue;
                    $formulasDetalle = new FormulasDetalle();
                    $formulasDetalle->cantidad = Input::get('det-cantidad-' . $n);
                    $formulasDetalle->idProducto = Input::get('det-producto-' . $n);
                    if (!$esColor) {
                        $formulasDetalle->esColor = 0;
                    } else {
                        $formulasDetalle->esColor = 1;
                    }
                    $formulasDetalle->idFormula = $formula->id;
                    //dame($formulasDetalle,1);
                    $formulasDetalle->save();
                    $formulasDetalle->orden = $formulasDetalle->id;
                    $formulasDetalle->save();
                }
            } else {
                return Redirect::to('formulas-base')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }
            if ($updating) {
                return Redirect::back()->withInput()->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
            } else {
                return Redirect::to('edit-formula-base/' . $formula->id . '/edicion');
            }
        }
    }

    public function get_edit_base($id, $accion) {
        $formula = Formula::where('id', '=', $id)->first();
        $filasDeMas = $formula->FormulasDetalle->count();
        $coma = $cant = $codigo = $coste = $enlucido = $producto = $importe = $proveedor = $proveedorNom = $voc = $densidad = $vocIndividual = $esColor = '';
        $n = 0;
        //DVULEVE VALORES
        $i = 1;
        //$porduct_select = Producto::dropDownToSelect();
        foreach ($formula->FormulasDetalle as $forDetalle) {

            if (isset($forDetalle->Producto->codigo)) {
                //dame($forDetalle->Producto->Proveedor->nombre, 1);
                $n++;
                $codigo .= $coma . "'" . $forDetalle->Producto->codigo . "'";
                $cant .= $coma . "'" . $forDetalle->cantidad . "'";
                $enlucido .= $coma . "'" . $forDetalle->enlucido . "'";
                $producto .= $coma . "'" . $forDetalle->Producto->codigo . "'";
                if ($forDetalle->esColor == 1) {
                    $esColor .= $coma . "'1'";
                } else {
                    $esColor .= $coma . "'0'";
                }
            } elseif ($forDetalle->esColor == 1) {
                $n++;
                $codigo .= $coma . "''";
                $cant .= $coma . "''";
                $enlucido .= $coma . "''";
                $producto .= $coma . "''";
                $esColor .= $coma . "'1'";
            }
            $coma = ', ';
        }
        //$this->dame($cant, 1);
        $cant = 'cant=Array(' . $cant . ');';
        $codigo = 'var codigo=Array(' . $codigo . ');';
        $enlucido = 'var enlucido=Array(' . $enlucido . ');';
        $producto = 'var producto=Array(' . $producto . ');';
        $esColor = 'var esColor=Array(' . $esColor . ');';
        $n = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n] = $forEq->codigo;
        }
        $pendiente = 0;
        if ($accion == 'pendiente')
            $pendiente = 1;
        return View::make('formulas/formulas-edit-base', array(
                    'formula' => $formula,
                    'proveedores' => Proveedor::dropDown(),
                    'productoName' => Producto::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'cant' => $cant,
                    'codigo' => $codigo,
                    'enlucido' => $enlucido,
                    'producto' => $producto,
                    'esColor' => $esColor,
                    'filasDeMas' => $filasDeMas,
                    //'firstRow' => $firstRow,
                    'equivalencias' => $equivalencias,
                    'pendiente' => $pendiente,
                    'formulaActive' => 'active', 'user_type' => Auth::user()->type,
        ));
    }

    public function get_index_base() {
        //$formulas = Formula::all();
        $formulas = new Formula();
        $formulas = $formulas->where('esBase', 1)->paginate(15); //dd($formulas);
        //$formulas = [];
        return View::make('formulas/formulas-list', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'codigos' => Producto::dropDown('codigo'),
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'viejos' => $this->viejos,
                    'user_type' => Auth::user()->type,
                    'formulaActive' => 'active',
                    'base' => '1',
                    'url_base' => '-base',
                    'filter' => false
        ));
    }

    function get_formula_hija_detalle($formula, $colores = []) {
        $coloreada = false;

        //dame($colores, 1);
        $i = 1;
        $porduct_select = Producto::dropDownToSelect('nombreProducto', true);
        $detalles = '<tr id="aClonar" style="display:none;">
                                        <td class="td_color">
                                            <input readonly="" disabled=""  class="form-control color" type="checkbox" value="1"  >
                                        </td>
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
        $index = 16;
        $i_color = 0;

        foreach ($formula->FormulasDetalle as $forDetalle) {
            $i++;
            if (isset($forDetalle->Producto->codigo)) {
                $codigo = $forDetalle->Producto->codigo;
                $cant = $forDetalle->cantidad;
                $codigo_class = 'codigo-color';
                $cantidad_class = 'cantidad-color';
                if ($forDetalle->esColor == 1) {
                    $esColor = 'checked="checked"';
                    $fila_apartir_colores = 'class="fila-apartir-colores fila-apartir"';
                } else {
                    $esColor = '';
                    $fila_apartir_colores = '';
                }

                $readOnly = 'readonly="" disabled=""';
                $tab_index = '-1';

                $detalles .= '<tr ' . $fila_apartir_colores . '>
                                        <td class="td_color">
                                            <input readonly="" disabled="" name="det-color-' . $i . '" id="color-' . $i . '" class="form-control color" type="checkbox" value="1" ' . $esColor . ' >
                                        </td>
                                        <td class="td_codigo">
                                            <input  name="det-codigo-' . $i . '" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 9"  class="form-control codigo ' . $codigo_class . '" type="text"  placeholder="Sale de calculo" ' . $tab_index . ' ' . $readOnly . ' value="' . $codigo . '">
                                        </td>
                                        <td class="td_cantidad">
                                            <input ' . $tab_index . ' name="det-cantidad-' . $i . '"  type="text" class="form-control cantidad cantidad-no-coloreada ' . $cantidad_class . '"  placeholder="Cantidad" ' . $readOnly . ' value="' . $cant . '" data-val="' . $cant . '">
                                        </td>
                                        <td class="td_prod">
                                        <select ' . $readOnly . ' name="det-producto-' . $i . '" class="select2_category form-control producto select2-offscreen"  tabindex="-1" id="producto-' . $i . '" >' . $porduct_select . '</select>
                                        </td>
                                        <td>
                                            <input id="coste-' . $i . '"  class="form-control coste" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input id="importe-' . $i . '"  class="form-control importe" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input id="proveedorNom-' . $i . '"  class="form-control proveedorNom" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input id="voc-' . $i . '" class="form-control voc" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input id="densidad-' . $i . '"  class="form-control densidad" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
                                        </td>
                                        <td>
                                            <input id="vocIndividual-' . $i . '"  class="form-control vocIndividual" type="text" readonly="" placeholder="Sale de formula" tabindex="-1" >
                                        </td>
                                        <td class="boton text-right" colspan="10"></td>
                                    </tr>';


                if ($forDetalle->esColor == 1 && !$coloreada) {
                    $coloreada = true;

                    foreach ($colores as $color) {
                        $i++;
                        $codigo = (isset($color['codigo'])) ? $color['codigo'] : '';
                        $cant = (isset($color['cant'])) ? $color['cant'] : '';
                        $codigo_class = (isset($color['codigo'])) ? 'codigo-color' : '';
                        $cantidad_class = (isset($color['cant'])) ? 'cantidad-color' : '';
                        $esColor = '';
                        $readOnly = '';
                        $tab_index = 'tabIndex="' . $index . '"';
                        $index++;
                        $i_color++;
                        $detalles .= '<tr >
																		<td class="td_color">
																			<input readonly="" disabled="" name="det-color-' . $i . '" id="color-' . $i . '" class="form-control color" type="checkbox" value="1" ' . $esColor . ' >
																		</td>
																		<td class="td_codigo">
																			<input  name="det-codigo-' . $i . '" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 9"  class="form-control codigo ' . $codigo_class . '" type="text"  placeholder="Sale de calculo" ' . $tab_index . ' ' . $readOnly . ' value="' . $codigo . '">
																		</td>
																		<td class="td_cantidad">
																			<input ' . $tab_index . ' name="det-cantidad-' . $i . '"  type="text" class="form-control cantidad ' . $cantidad_class . '"  placeholder="Cantidad" ' . $readOnly . ' value="' . $cant . '" data-val="' . $cant . '">
																		</td>
																		<td class="td_prod">
																		<select ' . $readOnly . ' name="det-producto-' . $i . '" class="select2_category form-control producto select2-offscreen"  tabindex="-1" id="producto-' . $i . '" >' . $porduct_select . '</select>
																		</td>
																		<td>
																			<input id="coste-' . $i . '"  class="form-control coste" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
																		</td>
																		<td>
																			<input id="importe-' . $i . '"  class="form-control importe" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
																		</td>
																		<td>
																			<input id="proveedorNom-' . $i . '"  class="form-control proveedorNom" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" >
																		</td>
																		<td>
																			<input id="voc-' . $i . '" class="form-control voc" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
																		</td>
																		<td>
																			<input id="densidad-' . $i . '"  class="form-control densidad" type="text" readonly="" placeholder="Sale de base" tabindex="-1" >
																		</td>
																		<td>
																			<input id="vocIndividual-' . $i . '"  class="form-control vocIndividual" type="text" readonly="" placeholder="Sale de formula" tabindex="-1" >
																		</td>
																		<td class="boton text-right" colspan="10"><button class="btn red minus-button" style="padding:1px 16px;" type="button">-</button><button class="btn green plus-button" style="padding:1px 14px;" type="button">+</button></td>
																	</tr>';
                    }
                }
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

        return View::make('formulas/formulas-add-base-hija', array(
                    'formula' => $formula,
                    'formulaActive' => 'active',
                    'detalles' => $detalles['detalles'],
                    'filasDeMas' => $detalles['count'],
        ));
    }

    function get_new_base_hija_pre() {
        return View::make('formulas/formulas-add-hija', array(
                    'bases' => Formula::dropDownBases(),
                    'formulaActive' => 'active',
        ));
    }

    function post_create_base_hija() {
        $input = Input::all();
//dame($input,1); 
        if (Input::has('id_edit')) {
            $updating = true;
        } else {
            $updating = false;
        }


        if (!Input::has('parent_id'))
            return Redirect::to('formulas-base');
        $parent_id = Input::get('parent_id');
        $parent = Formula::find($parent_id);
        if (!$parent) {
            return Redirect::to('add-formula-base-hija/' . $parent_id)->withInput();
        }
        $rules = array(
            'nombre' => 'required',
                //'densidad' => 'required',
        );
        $numbered_rows = [];
        for ($i = 0; $i <= 100; $i++) {
            $n = $i + 1;

            if (!Input::has('det-cantidad-' . $n) && Input::get('det-cantidad-' . $n) != NULL) {
                
            }

            //IN CASE THAT ROW HAS BEEN DELETED FOR THE NEW REQUIREMENT
            if (!Input::has('det-codigo-' . $n) or!Input::has('det-cantidad-' . $n))
                continue;

            $rules += array(
                'det-cantidad-' . $n => 'required',
                'det-codigo-' . $n => 'required',
                'det-producto-' . $n => 'required',
            );
            $numbered_rows[] = $n;
        }
//        dame($rules);
//        dame($numbered_rows,1);
        $validator = Validator::make($input, $rules);
        //        var_dump(Input::get('fecha'));
        //        var_dump($validatorExtra);exit;
        if ($validator->fails()) {
            //$this->dame($validator->messages(), 1);

            $colores = [];
            $i_colores = 0;
            //DVULEVE VALORES
            foreach ($numbered_rows as $n) {
                if (Input::has('det-codigo-' . $n))
                    $colores[$i_colores]['codigo'] = Input::get('det-codigo-' . $n);
                if (Input::has('det-cantidad-' . $n))
                    $colores[$i_colores]['cant'] = Input::get('det-cantidad-' . $n);
                $i_colores++;
            }


            $detalles = $this->get_formula_hija_detalle($parent, $colores);




            //dd($cant);
            $mensaje = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ';

            if ($updating) {
                $formula = Formula::find(Input::get('id_edit'));
                $formula->nombre = $input['nombre'];
                $formula->codigo = $input['codigo'];
                $formula->descripcion = $input['descripcion'];
                $formula->codigo = $input['codigo'];
                $formula->densidad = $input['densidad'];
                return View::make('formulas/formulas-edit-base-hija', array(
                            'mensaje' => $mensaje,
                            'detalles' => $detalles['detalles'],
                            'filasDeMas' => $detalles['count'],
                            'formula' => $formula,
                            'old' => $input,
                            'parent' => $parent_id,
                            'formulaActive' => 'active'
                ));
            } else {
                return View::make('formulas/formulas-add-base-hija', array(
                            'mensaje' => $mensaje,
                            'detalles' => $detalles['detalles'],
                            'filasDeMas' => $detalles['count'],
                            'formula' => $parent,
                            'old' => $input,
                            'formulaActive' => 'active'
                ));
            }


//            return Redirect::to('add-formula-base-hija/' . Input::get('id'))->with(array(
//                        'mensaje' => $mensaje,
//                        'detalles' => $detalles,
//                        'formula' => $formula
//            ));
        } else {
            if ($updating) {
                $formula = Formula::find(Input::get('id_edit'));

                //$idPedido=Input::has('id');
            } else {
                $formula = new Formula();
                $formula->parent = $parent_id;
                $formula->fecha = time();
                $lastFor = DB::table('formulas')->select('numeroHija')->orderBy('numeroHija', 'desc')->first();
                if (!isset($lastFor->numeroHija)) {
                    $lastFor = 1;
                } else {
                    $lastFor = $lastFor->numeroHija + 1;
                }
                $formula->numeroHija = $lastFor;
                //dame($lastFor,1);
            } //var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->fechaUltEdicion = time();
            $formula->idSeccionFormula = 10;
            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');
            $formula->densidad = Input::get('densidad');
            $formula->codigo = Input::get('codigo');
            $formula->esBase = 0;

            if ($formula->save()) {
                if ($updating) {
                    $formula->formulasDetalle()->delete();
                    $formula->formulasEquivalencia()->delete();
                }
                for ($i = 1; $i < 6; $i++) {
                    $eq_trim = trim(Input::get('equivalencia-' . $i));
                    $cod_trim = trim(Input::get('codigo-' . $i));
                    if ($eq_trim != '' && $cod_trim != '') {
                        $equivalencia = new FormulasEquivalencia();
                        $equivalencia->codigo = trim(Input::get('codigo-' . $i));
                        $equivalencia->equivalencia = trim(Input::get('equivalencia-' . $i));
                        $equivalencia->idFormula = $formula->id;
                        $equivalencia->save();
                    }
                }

                foreach ($numbered_rows as $n) {
                    //$n = $i + 1;
                    $cant_trim = floatVal(trim(Input::get('det-cantidad-' . $n)));
                    $cant_producto = intVal(trim(Input::get('det-producto-' . $n)));

                    if (($cant_trim == 0 || $cant_producto == 0))
                        continue;
                    $formulasDetalle = new FormulasDetalle();
                    $formulasDetalle->cantidad = Input::get('det-cantidad-' . $n);
                    $formulasDetalle->idProducto = Input::get('det-producto-' . $n);
                    $formulasDetalle->esColor = 0;
                    $formulasDetalle->idFormula = $formula->id;

                    //dame($formulasDetalle,1);
                    $formulasDetalle->save();
                    $formulasDetalle->orden = $formulasDetalle->id;
                    $formulasDetalle->save();
                }
            } else {
                return Redirect::to('formulas-base')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }

            //dame($this->get_message('ok', 'Inserción con éxito!! '),1);

            return Redirect::to('edit-formula-base-hija/' . $formula->id . '/edicion')->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
        }
    }

    public function get_edit_base_hija($id, $accion) {
        $formula = Formula::where('id', '=', $id)->first();

        if (!$formula->parent) {
            return Redirect::to('formulas-base')->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> La formula base selccionada no existe .
                                    	</div>');
        }
        $parent = Formula::where('id', '=', $formula->parent)->first();


        $colores = [];
        $i_colores = 0;
        //DVULEVE VALORES
        foreach ($formula->FormulasDetalle as $f) {
            if (isset($f->Producto->codigo))
                $colores[$i_colores]['codigo'] = $f->Producto->codigo;
            if (isset($f->cantidad))
                $colores[$i_colores]['cant'] = $f->cantidad;

            $i_colores++;
        }
        //dame($colores,1);


        $detalles = $this->get_formula_hija_detalle($parent, $colores);

        $n = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n] = $forEq->codigo;
        }

        return View::make('formulas/formulas-edit-base-hija', array(
                    'equivalencias' => $equivalencias,
                    'detalles' => $detalles['detalles'],
                    'filasDeMas' => $detalles['count'],
                    'formula' => $formula,
                    'parent' => $formula->parent,
                    'formulaActive' => 'active'
        ));
    }

    public function print_formula_valorada_hija($id, $cantProduccion) {
        //dame($_GET,1);
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        $formula->numero = $formula->numeroHija;

        if ($formula->parent) {
            $parent = Formula::find($formula->parent);
            $formula = $this->mix_formula_parent_child($formula, $parent);
        }
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('formulas/impresiones/print-formula-valorada', $data);
    }

    public function pdf_formula_valorada_hija($id, $cantProduccion) {
        $this->print_pdf();
    }

    public function print_formula_sin_valorar_hija($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        $formula->numero = $formula->numeroHija;

        if ($formula->parent) {
            $parent = Formula::find($formula->parent);
            $formula = $this->mix_formula_parent_child($formula, $parent);
        }
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('formulas/impresiones/print-formula-no-valorada', $data);
    }

    public function pdf_formula_sin_valorar_hija($id, $cantProduccion) {
        $this->print_pdf();
    }

    public function pdf_formula_ajustada_hija($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id); //dame($formula->FormulasDetalle);
        $formula->numero = $formula->numeroHija;

        if ($formula->parent) {
            $parent = Formula::find($formula->parent);
            $formula = $this->mix_formula_parent_child($formula, $parent);
        }

        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        require_once public_path() . "/packages/inc/pdf-formula-ajustada.php";
        //return View::make('formulas/impresiones/print-formula-ajustada', $data);
    }

    function mix_formula_parent_child($hija, $parent) {
        $new_detalles = [];

        foreach ($parent->FormulasDetalle as $key => $val) {
            $new_detalles[] = $val;
            if ($val->esColor == '1') {
                foreach ($hija->FormulasDetalle as $f) {
                    $new_detalles[] = $f;
                }
            }
        }

        $hija->FormulasDetalle = $new_detalles;



        return $hija;
    }

    function check_base_has_child() {
        $formulas = Formula::where('parent', Input::get('id'))->get();

        if (!$formulas->isEmpty()) {
            return Response::json(['res' => true]);
        } else {
            return Response::json(['res' => false]);
        }
    }

}
