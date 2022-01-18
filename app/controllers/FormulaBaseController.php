<?php

class FormulaBaseController extends BaseController {

    private $viejos = array('codigo' => '0', 'seccion' => '0', 'nombre' => '0', 'nombre_formula' => '0', 'eq' => '0', 'activa' => '-1', 'search' => '');

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

    public function get_index() {

        //$formulas = Formula::all();
        $formulas = [];
        return View::make('formulas/formulas-list', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'codigos' => Producto::dropDown('codigo'),
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'viejos' => $this->viejos,
                    'formulaActive' => 'active'
        ));
    }

    public function get_catalogar($est, $id) {
        if ($est == 0 or $est == 1) {
            $formula = Formula::find($id);
            $formula->activa = $est;
            $formula->save();
        }
        $formulas = Formula::all();
        return View::make('formulas/formulas-list', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'codigos' => Producto::dropDown('codigo'),
                    'viejos' => $this->viejos, 'formulaActive' => 'active'
        ));
    }

    public function post_index() {
        //dame(Input::all());
        $filtrar_get = $excel_get = $excel_new_get = $imprimir = false;
        if (Input::has('filtrar')) {
            $filtrar_get = true;
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

        if (Input::has('nombre')) {

            if ($filtrar_get or $excel_get or $imprimir) {
                $formulas = new Formula();
            } elseif ($excel_new_get) {
                $formulas = new Formula();
                $formulas = $formulas
                        ->select([
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




            $filtra = $porId = $formVacia = false;


            if (Input::get('codigo') != 0) {
                $filtra = true;
                $this->viejos['codigo'] = Input::get('codigo');
                //                $formulasDet = new FormulasDetalle();
                //                $formulasDet=$formulasDet->where('idProducto', Input::get('codigo') )->groupBy('idFormula')->get()->lists('id');
                //                $formulas=$formulas->where('id', Input::get('nombre') );
                if ($filtrar_get or $imprimir or $excel_get) {
                    $formulas = $formulas
                            ->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
                            ->where('formulas_detalle.idProducto', Input::get('codigo'));
                } elseif ($excel_new_get or $imprimir) {
                    $formulas = $formulas
                            ->where('formulas_detalle.idProducto', Input::get('codigo'));
                }
            }


            if (Input::get('nombre') != 0) {
                $formulas = $formulas->where('formulas.id', Input::get('nombre'));
                $filtra = $porId = true;
                $this->viejos['nombre'] = Input::get('nombre');
            }

            if (Input::get('nombre_formula') != 0) {
                $formulas = $formulas->where('formulas.id', Input::get('nombre_formula'));
                $filtra = $porId = true;
                $this->viejos['nombre_formula'] = Input::get('nombre_formula');
            }


            if (Input::get('seccion') != 0) {
                $formulas = $formulas->where('idSeccionFormula', Input::get('seccion'));
                $filtra = true;
                $this->viejos['seccion'] = Input::get('seccion');
            }


            if (Input::get('eq') != 0) {
                $formulasEquivalencias = FormulasEquivalencia::find(Input::get('eq'));
                if (!$porId) {
                    $formulas = $formulas->where('formulas.id', $formulasEquivalencias->idFormula);
                } else {
                    if (Input::get('nombre') != $formulasEquivalencias->idFormula)
                        $formVacia = true;
                }
                $filtra = true;
                $this->viejos['eq'] = Input::get('eq');
            }


            if (Input::get('activa') != '-1') {
                $formulas = $formulas->where('activa', Input::get('activa'));
                $filtra = true;
                $this->viejos['activa'] = Input::get('activa');
            }

            if (Input::get('search') != '') {
                $formulas = $formulas->where('formulas.nombre', 'like', '%' . Input::get('search') . '%')->orWhere('formulas.descripcion', 'like', '%' . Input::get('search') . '%');
                $filtra = true;
                $this->viejos['search'] = Input::get('search');
            }


            if ($filtra) {

                if ($filtrar_get) {
                    //$formulas = $formulas->groupBy('formulas_detalle.id', 'formulas.id','formulas.numero','formulas.nombre','formulas.idSeccionFormula', 'productos.nombreProducto', 'formulas_equivalencias.equivalencia', 'productos.coste')->get();
                    $formulas = $formulas->get();
                } elseif ($excel_get or $imprimir) {
                    $formulas = $formulas->orderBy('idSeccionFormula', 'desc')->orderBy('formulas.id')->get();
                } elseif ($excel_new_get) {

                    //$formulas = $formulas->get();
                    $formulas = $formulas->groupBy('formulas_detalle.id')->get();
                }
            } else {
                if ($filtrar_get or $excel_get or $imprimir) {
                    $formulas = new Formula();
                    $formulas = $formulas->where('id', '>', '0')->orderBy('idSeccionFormula', 'desc')->get();
                } elseif ($excel_new_get) {
                    $formulas = $formulas->groupBy('formulas_detalle.id')->get();
                }
            }
        } else {
            $formulas = Formula::all();
        }
        if ($formVacia)
            $formulas = new stdClass();
        //dame(URL::to('/'),1);
        //dame(DB::getQueryLog(), 1); //dame(Input::get('fechaA') );exit;
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
        }elseif ($excel_get) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN EXCEL NORMAL
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
                    $equivalencias.=$coma . $eq->equivalencia;
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
        }elseif ($imprimir) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN PRINT
            include(public_path() . "/packages/inc/print-pdf-formulas.php");


            /* $data = array(
              'formulas' => $formulas,
              'idSeccion' => '-1', 'formulaActive' => 'active'
              );
              dame($formulas); */
            //return View::make('formulas/impresiones/print-formulas', $data);
        } else {//////////////////////////////////////////////////////////////////LIST FORMULAS IN HTML
            return View::make('formulas/formulas-list', array(
                        'formulas' => $formulas,
                        'secciones' => SeccionesFormula::dropDown(),
                        'nombres' => Formula::dropDown(),
                        'nombres_formula' => Formula::dropDown(true),
                        'eqs' => FormulasEquivalencia::dropDown(),
                        'codigos' => Producto::dropDown('codigo'),
                        'viejos' => $this->viejos, 'formulaActive' => 'active'
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

        $filasDeMas = $formula->FormulasDetalle->count();
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
                    //'firstRow' => $firstRow,
                    'equivalencias' => $equivalencias,
                    'pendiente' => $pendiente, 'formulaActive' => 'active'
        ));
    }

    public function get_new() {
        return View::make('formulas/formulas-add', array(
                    'secciones' => SeccionesFormula::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    //'proveedores' => Proveedor::dropDown(),
                    'pendiente' => '0',
                    'filasDeMas' => 0, 'formulaActive' => 'active',
        ));
    }
    
    public function get_new_base() {
        return View::make('formulas/formulas-add-base', array(
                    'secciones' => SeccionesFormula::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    //'proveedores' => Proveedor::dropDown(),
                    'pendiente' => '0',
                    'filasDeMas' => 0, 'formulaActive' => 'active',
        ));
    }

    protected function post_create() {


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
            'densidad' => 'required',
        );
        if ($enlucido) {//esta parte se ha suprimido, dejo el codigo por is acaso
            $rules += array(
                'codigoMa' => 'required',
            );
            /*$cod_base_trim=trim(Input::get('codigoBaseMg'));
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
            }*/
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

                //$idPedido=Input::has('id');
            } else {
                $formula = new Formula();
                $formula->fecha = time();
                $lastFor = DB::table('formulas')->select('numero')->orderBy('id', 'desc')->first();
                if (!isset($lastFor->numero)) {
                    $lastFor = 1;
                } else {
                    $lastFor = $lastFor->numero + 1;
                }
                $formula->numero = $lastFor;
                //dame($lastFor,1);
            } //var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $formula->fechaUltEdicion = time();
            $formula->idSeccionFormula = Input::get('secciones');
            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');
            $formula->densidad = Input::get('densidad');
            $formula->codigo = Input::get('codigo');
            $formula->pendienteEdicion = '0';
            if ($enlucido) {
				if ((Input::get('codigoBaseMg')))
                    $formula->codigoBaseMg = Input::get('codigoBaseMg');
				if ((Input::get('codigoBaseMp')))
                    $formula->codigoBaseMp = Input::get('codigoBaseMp');
				
                /*if ($mBase == 'Mg') {
					

                    $formula->codigoBaseMg = '';
                    if ((Input::get('codigoBaseMg')))
                        $formula->codigoBaseMg = Input::get('codigoBaseMg');
                    $formula->codigoBaseMp = '';
                } else if ($mBase == 'Mp') {

                    $formula->codigoBaseMp = '';
                    if ((Input::get('codigoBaseMp')))
                        $formula->codigoBaseMp = Input::get('codigoBaseMp');
                    $formula->codigoBaseMg = '';
                }*/
				
				
                if ((Input::get('codigoMa')))
                    $formula->codigoMa = Input::get('codigoMa');
            }
            if ($formula->save()) {
                if (Input::has('id')) {
                    $formula->formulasDetalle()->delete();
                    $formula->formulasEquivalencia()->delete();
                }
                for ($i = 1; $i < 6; $i++) {
                    $eq_trim=trim(Input::get('equivalencia-' . $i));
                    $cod_trim=trim(Input::get('codigo-' . $i));
                    if ( $eq_trim != '' && $cod_trim != '') {
                        $equivalencia = new FormulasEquivalencia();
                        $equivalencia->codigo = trim(Input::get('codigo-' . $i));
                        $equivalencia->equivalencia = trim(Input::get('equivalencia-' . $i));
                        $equivalencia->idFormula = $formula->id;
                        $equivalencia->save();
                    }
                }
                foreach ($numbered_rows as $n) {
                    //$n = $i + 1;
                    $cant_trim=trim(Input::get('det-cantidad-' . $n));
                    $cant_producto=trim(Input::get('det-producto-' . $n));
                    if ($cant_trim == '' || $cant_producto == '0')
                        continue;
                    $formulasDetalle = new FormulasDetalle();
                    $formulasDetalle->cantidad = Input::get('det-cantidad-' . $n);
                    $formulasDetalle->idProducto = Input::get('det-producto-' . $n);
                    $formulasDetalle->idFormula = $formula->id;
					
                    if ($enlucido) {
                        $formulasDetalle->enlucido = Input::get('det-enlucido-' . $n);
                    }
                    //dame($formulasDetalle,1);
                    $formulasDetalle->save();
					$formulasDetalle->orden = $formulasDetalle->id;
					$formulasDetalle->save();
                }
            } else {
                return Redirect::to('formulas')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }
            if ($pendiente) {
                return Redirect::to('informes-formulas-valoracion')->with('procesarPendientes', true);
            } else {
				if ($updating){
					return Redirect::back()->withInput()->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
				}else{
					return Redirect::to('edit-formula/'.$formula->id.'/edicion');
					
					
				}
                //return Redirect::to('formulas')->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
            }
        }
    }

    public function get_delete($id) {
        Formula::destroy($id);
        return Redirect::to('formulas');
    }

    private function set_cantidad($formula, $cantProduccion) {
        $formulasDet = array();
        $cantidad = 0;
        foreach ($formula->FormulasDetalle as $laFormula) {
            $cantidad+=$laFormula->cantidad;
        }
        $valorPromedio = $cantProduccion / $cantidad;
        $i = 0;
        foreach ($formula->FormulasDetalle as $laFormula) {
            $laFormula->cantidad = $laFormula->cantidad * $valorPromedio;
        }
        return $formula;
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

    /*public function pdf_formula_ajustada($id, $cantProduccion) {
        $this->print_pdf();
    }*/

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

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           