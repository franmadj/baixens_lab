<?php

class FormulaComercialController extends BaseController {

    private $viejos = array('codigo' => '0', 'seccion' => '0', 'nombre' => '0', 'nombre_formula' => '0', 'eq' => '0', 'activa' => '-1', 'search' => '');

    public function get_index() {
        $this->checkUserAccess([5]);
        //$formulas = Formula::all();
        if (Input::has('page') && Input::has('filter') && Session::get('filter')) {
            return $this->post_index(Session::get('filter'));
        }
        $formulas = []; //Formula::orderBy('id', 'DESC')->pinturasValidadas()->where('idSeccionFormula', '!=', $_ENV['SATE'])->paginate(15);

        return View::make('comercial/formulas-list', array(
                    //'codigos'=> $formulas,
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'codigos' => Producto::dropDown('codigo'),
                    'eqs' => FormulasEquivalencia::listItems(),
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
                                        DB::raw('CAST(Max(CAST(formulas.esBase AS int)) As bit) as esBase'),
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
                    ->orWhere('formulas.instrucciones', 'like', '%' . $input['search'] . '%')
                    ->orWhere('formulas.codigo', 'like', '%' . $input['search'] . '%')
                    ->orWhere('formulas.codigo', 'like', '%' . str_replace('-', '', $input['search']) . '%'); //instrucciones
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
        //////////////////////////////////////////////////////////////////LIST FORMULAS IN HTML
        $url_base = '';
        $url_base_active = 'formulaActive';
        if ($input['esBase'] == '1') {
            $url_base = '-base';
            $url_base_active = 'sateActive';
        }
        $view = 'comercial/formulas-list';
        return View::make($view, array(
                    'formulas' => $formulas,
                    'secciones' => SeccionesFormula::dropDown(),
                    'nombres' => Formula::dropDown(),
                    'nombres_formula' => Formula::dropDown(true),
                    'user_type' => Auth::user()->type,
                    'eqs' => FormulasEquivalencia::listItems(),
                    'codigos' => Producto::dropDown('codigo'),
                    'viejos' => $this->viejos,
                    $url_base_active => 'active',
                    'base' => $input['esBase'],
                    'url_base' => $url_base,
                    'filter' => true
        ));
    }

    public function get_edit($id) {
        $accion = 'edit';

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


        return View::make('comercial/formulas-edit', array(
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
                    'pendiente' => $pendiente,
                    'formulaActive' => 'active'
        ));
    }

    protected function post_update() {

        if ($formula = Formula::find(Input::get('id'))) {
            $formula->formulasEquivalencia()->delete();

            for ($i = 1; $i < 15; $i++) {
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

            return Redirect::to('edit-formula-comercial/'.$formula->id)->with('mensaje', $this->get_message('ok', 'Información guardada!! '));
        }
        
        return Redirect::to('formulas-comercial');




        
    }

}
