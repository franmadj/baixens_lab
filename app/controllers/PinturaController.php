<?php

class PinturaController extends BaseController {

    private $viejos = array('ajustar_a' => '0', 'tipo' => '0', 'nombre' => '0', 'numero_pintura' => '0', 'estado' => '', 'codigoProducto' => '0', 'codigo' => '-1', 'search' => '', 'solMin' => '',
        'solMax' => '', 'pvcMin' => '', 'pvcMax' => '', 'denMin' => '', 'denMax' => '', 'tioMin' => '', 'tioMax' => '', 'ligMin' => '', 'ligMax' => '', 'ekMin' => '',
        'ekMax' => '', 'elMin' => '', 'elMax' => '', 'fechaDe' => '', 'fechaA' => '', 'reFMin' => '', 'reFMax' => '', 'cubMin' => '', 'cubMax' => '', 'eq' => '0', 'seccion' => '0');
    private $excelFields = ['res_flote_medio' => 'Res. Flote', 'cubricion_medio' => 'Cubrición', 'porcentaje_solidos_pesado' => 'Solidos', 'pvc_pesado' => 'PVC', 'densidad_pesado' => 'Densidad', 'tio2_pesado' => 'TiO2',
        'ligante_pesado' => 'Ligante', 'precio_eu_kg_pesado' => 'Precio €/Kg', 'precio_eu_lt_medido' => 'Precio €/L', 'viscosidad_medio' => 'Viscosidad', 'brillo_60_medio' => 'Brillo 60 grados', 'brillo_85_medio' => 'Brillo 80 grados',
        'l_medio' => 'L', 'a_medio' => 'A', 'b_medio' => 'B', 'y_medio' => 'Y'
        , 'clase_medio' => 'Clase', 'rendimiento_medio' => 'Rendimiento'];

    public function get_index() {
        //$formulas = Formula::all();
        if (Input::has('page') && Input::has('filter') && Session::get('filter')) {
            return $this->post_index(Session::get('filter'));
        }
        $formulas = [];
        return View::make('pinturas/formulas-list', array(
                    'formulas' => $formulas,
                    'tipos' => Formula::pinturaTipos(true),
                    'estados' => Formula::pinturaEstados(true, true),
                    'nombres' => Formula::formulasByCategory(['0' => 'Formulas'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'nombre'),
                    'codigos' => Formula::formulasByCategory(['0' => 'NF'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'numero'),
                    'numero_pinturas' => Formula::formulasByCategory(['0' => 'N Pintura'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'numero_pintura'),
                    'codigosProducto' => Producto::dropDown('codigo'),
                    'viejos' => $this->viejos,
                    'pinturasActive' => 'active',
                    'user_type' => Auth::user()->type,
                    'eqs' => FormulasEquivalencia::dropDown(),
                    'excelFields' => $this->excelFields,
                    'secciones' => SeccionesFormula::dropDown(),
        ));
    }

    public function post_index($filterPaginated = false) {
        //dame(Input::all(), 1);
        $input = $filterPaginated ? $filterPaginated : Input::all();

        $filtrar_get = $excel_get = $imprimir = false;
        if (Input::has('excel') && Input::has('excel-fields')) {
            $excel_get = true;
            $max = 10000;
        } else {
            $filtrar_get = true;
            if (!$filterPaginated)
                Session::put('filter', Input::all());
        }

        if (isset($input['nombre'])) {

            $formulas = new Formula();
            //$formulas = $formulas->select('formulas.*');
            if ($filtrar_get) {
                
            } elseif ($excel_get) {
                $selectFields = [];
                foreach ($this->excelFields as $key => $fields) {
                    $selectFields[] = $key;
                }

                $formulas = $formulas
                        //formulas.res_flote_medio,formulas.cubricion_medio,formulas.porcentaje_solidos_pesado,formulas.pvc_pesado,densidad_pesado,formulas.tio2_pesado,formulas.ligante_pesado,formulas.precio_eu_kg_pesado,formulas.precio_eu_lt_medido
                        ->select([
                    DB::raw(implode(',', $selectFields)),
//                            DB::raw('Max(formulas.id) as id'),
//                            DB::raw('Max(formulas.numero) as numero'),
//                            DB::raw('Max(formulas.activa) as activa'),
//                            DB::raw('Max(formulas.nombre) as nombre'),
//                            DB::raw('Max(formulas.idSeccionFormula) as idSeccionFormula'),
//                            DB::raw('Max(productos.nombreProducto) as nombreProducto'),
//                            DB::raw('Max(formulas_equivalencias.equivalencia) as equivalencia'),
//                            DB::raw('Max(productos.coste) as coste'),
//                            DB::raw('formulas_detalle.id as formulas_detalle_id')
                ]);
                //->select('*');
                //->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
                //->join('formulas_equivalencias', 'formulas.id', '= ', 'formulas_equivalencias.idFormula', 'full outer')
                //->join('productos', 'formulas_detalle.idProducto', '= ', 'productos.id');
            }





            $filtra = $porId = $formVacia = false;
//            if ($input['codigoProducto'] != 0) {
//                $filtra = true;
//                $this->viejos['codigoProducto'] = $input['codigoProducto'];
//
//                $formulas = $formulas
//                        ->join('formulas_detalle', 'formulas.id', '= ', 'formulas_detalle.idFormula')
//                        ->where('formulas_detalle.idProducto', $input['codigoProducto']);
//            }

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

            if ($input['numero_pintura'] != 0) {
                $formulas = $formulas->where('formulas.id', $input['numero_pintura']);
                $filtra = $porId = true;
                $this->viejos['numero_pintura'] = $input['numero_pintura'];
            }
            
            if ($input['selected-ids'] != 0) {
                $formulas = $formulas->whereIn('formulas.id', explode(',',$input['selected-ids']));
                $filtra = $porId = true;
                
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

            if ($input['tipo'] != '') {
                $formulas = $formulas->where('formulas.pintura_tipo', $input['tipo']);
                $filtra = true;
                $this->viejos['tipo'] = $input['tipo'];
            }
            
            if ($input['seccion'] != 0) {
                $formulas = $formulas->where('formulas.idSeccionFormula', $input['seccion']);
                $filtra = true;
                $this->viejos['seccion'] = $input['seccion'];
            }

            if ($input['estado'] != '') {
                $formulas = $formulas->where('formulas.pintura_estado', $input['estado']);
                $filtra = true;
                $this->viejos['estado'] = $input['estado'];
            }

            if ($input['reFMin'] != '' && $input['reFMax'] != '') {
                $formulas = $formulas->whereBetween('res_flote_medio', array($input['reFMin'], $input['reFMax']));
                $filtra = true;
                $this->viejos['reFMin'] = $input['reFMin'];
                $this->viejos['reFMax'] = $input['reFMax'];
            }

            if ($input['cubMin'] != '' && $input['cubMax'] != '') {
                $formulas = $formulas->whereBetween('cubricion_medio', array($input['cubMin'], $input['cubMax']));
                $filtra = true;
                $this->viejos['cubMin'] = $input['cubMin'];
                $this->viejos['cubMax'] = $input['cubMax'];
            }

            if ($input['solMin'] != '' && $input['solMax'] != '') {
                $formulas = $formulas->whereBetween('porcentaje_solidos_pesado', array($input['solMin'], $input['solMax']));
                $filtra = true;
                $this->viejos['solMin'] = $input['solMin'];
                $this->viejos['solMax'] = $input['solMax'];
            }

            if ($input['pvcMin'] != '' && $input['pvcMax'] != '') {
                $formulas = $formulas->whereBetween('pvc_pesado', array($input['pvcMin'], $input['pvcMax']));
                $filtra = true;
                $this->viejos['pvcMin'] = $input['pvcMin'];
                $this->viejos['pvcMax'] = $input['pvcMax'];
            }

            if ($input['denMin'] != '' && $input['denMax'] != '') {
                $formulas = $formulas->whereBetween('densidad_pesado', array($input['denMin'], $input['denMax']));
                $filtra = true;
                $this->viejos['denMin'] = $input['denMin'];
                $this->viejos['denMax'] = $input['denMax'];
            }

            if ($input['tioMin'] != '' && $input['tioMax'] != '') {
                $formulas = $formulas->whereBetween('tio2_pesado', array($input['tioMin'], $input['tioMax']));
                $filtra = true;
                $this->viejos['tioMin'] = $input['tioMin'];
                $this->viejos['tioMax'] = $input['tioMax'];
            }

            if ($input['ligMin'] != '' && $input['ligMax'] != '') {
                $formulas = $formulas->whereBetween('ligante_pesado', array($input['ligMin'], $input['ligMax']));
                $filtra = true;
                $this->viejos['ligMin'] = $input['ligMin'];
                $this->viejos['ligMax'] = $input['ligMax'];
            }

            if ($input['ekMin'] != '' && $input['ekMax'] != '') {
                $formulas = $formulas->whereBetween('precio_eu_kg_pesado', array($input['ekMin'], $input['ekMax']));
                $filtra = true;
                $this->viejos['ekMin'] = $input['ekMin'];
                $this->viejos['ekMax'] = $input['ekMax'];
            }

            if ($input['elMin'] != '' && $input['elMax'] != '') {
                $formulas = $formulas->whereBetween('precio_eu_lt_medido', array($input['elMin'], $input['elMax']));
                $filtra = true;
                $this->viejos['elMin'] = $input['elMin'];
                $this->viejos['elMax'] = $input['elMax'];
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
                $terms = explode(',', $input['search']);
                $formulas = $formulas->where(function ($query)use($terms) {
                    foreach ($terms as $term)
                        $query->orWhere('formulas.nombre', 'like', '%' . trim($term) . '%')
                                ->orWhere('formulas.descripcion', 'like', '%' . trim($term) . '%');
                });

                //$formulas = $formulas->where('formulas.nombre', 'like', '%' . Input::get('search'] . '%')->orWhere('formulas.descripcion', 'like', '%' . Input::get('search') . '%');
                $filtra = true;
                $this->viejos['search'] = $input['search'];
            }
            //var_dump($this->viejos);exit;
            if ($filtra) {
                //$formulas = $formulas->groupBy('formulas_detalle.id', 'formulas.id','formulas.numero','formulas.nombre','formulas.idSeccionFormula', 'productos.nombreProducto', 'formulas_equivalencias.equivalencia', 'productos.coste')->get();
                $formulas = $formulas->select('formulas.*')->pinturaSection();


                //var_dump($formulas);exit;
            } else {



                //$formulas = new Formula();
                $formulas = $formulas->where('id', '>', '0')->pinturaSection()->orderBy('id', 'desc');
            }
        } else {
            //$formulas = Formula::where('idSeccionFormula', $_ENV['PINTURAS_DECORATIVAS']);
        }

        if ($filtrar_get)
            $formulas = $formulas->paginate(50);

        //dame(URL::to('/'),1);
        //dame(DB::getQueryLog(), 1); //dame(Input::get('fechaA') );exit;
        //dame(Input::get(),1);
        //dame($formulas->count(), 1);

        if ($excel_get) {//////////////////////////////////////////////////////////////////LIST FORMULAS IN EXCEL NORMAL
            $formulas = $formulas
                    //->groupBy('id')
                    ->orderBy('formulas.idSeccionFormula', 'ASC')
                    ->get();
            include(public_path() . "/packages/phpExcel/Classes/PHPExcel.php");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $cols = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
            $i = 0;
//            foreach ($input['excel-fields'] as $field) {
//                $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$i])->setAutoSize(true);
//                $i++;
//            }
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
                    $objPHPExcel->getActiveSheet()->getStyle("a" . $n)->getFont()->setSize(10);
                    $objPHPExcel->getActiveSheet()->getStyle("a" . $n)->getFont()->setBold(true);
                    $n++;
                    $i = 0;
                    $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, 'Nombre')->getColumnDimension($cols[$i])->setAutoSize(true);
                    $i++;
                    $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, 'Número')->getColumnDimension($cols[$i])->setAutoSize(true);
                    $i++;
                    foreach ($input['excel-fields'] as $key => $field) {
                        $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, $field)->getColumnDimension($cols[$i])->setAutoSize(true);
                        $i++;
                    }
                }
                $n++;
                $i = 0;

                $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, $formula->nombre);
                $i++;
                $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, $formula->numero_pintura);
                $i++;
                foreach ($input['excel-fields'] as $key => $field) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($cols[$i] . $n, $formula->{$key});
                    $i++;
                }
            }
            //dame($objPHPExcel,1);
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(public_path() . '/files/excel.xlsx');
            header('location: ' . URL::to('/') . '/files/excel.xlsx');
            exit();
        } else {

            $view = 'pinturas/formulas-list';
            return View::make($view, array(
                        'formulas' => $formulas,
                        'tipos' => Formula::pinturaTipos(true),
                        'estados' => Formula::pinturaEstados(true),
                        'nombres' => Formula::formulasByCategory(['0' => 'Nombres'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'nombre'),
                        'codigos' => Formula::formulasByCategory(['0' => 'NF'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'numero'),
                        'numero_pinturas' => Formula::formulasByCategory(['0' => 'N Pintura'], [$_ENV['PINTURAS_DECORATIVAS'], $_ENV['PINTURA_VALIDADA_ACTIVA'], $_ENV['PINTURA_VALIDADA_RESERVA']], 'numero_pintura'),
                        'codigosProducto' => Producto::dropDown('codigo'),
                        'user_type' => Auth::user()->type,
                        'viejos' => $this->viejos,
                        'pinturasActive' => 'active',
                        'eqs' => FormulasEquivalencia::dropDown(),
                        'excelFields' => $this->excelFields,
                        'secciones' => SeccionesFormula::dropDown(),
            ));
        }
    }

    public function get_view($id) {
        $formula = Formula::where('id', '=', $id)->first();
        //dame($formula,1);
        return View::make('pinturas/formula-view', array(
                    'formula' => $formula,
                    'pinturasActive' => 'active',
        ));
    }

    private function set_default_test_values() {
        $cantidad_pesada = 'var cant=Array("353.150","3.780","21.000","175.100","141.000","7.500");';
        $codigo = 'var codigo=Array("1000","648","713","763","715","117");';
        $tipo = 'var tipo=Array("agua","aditivo","aditivo","tio2","carga","ligante");';
        //$producto = 'var producto=Array(' . $producto . ');';
        $porcentaje_teorico = 'var porcentaje_teorico=Array("46.850","0.550","3.000","25.000","20.000","1.000");';


        /* $cantidad_pesada = 'var cant=Array("327.800","0.200","1.100","3.780","21.000","0.345","1.950","175.100","141.000","13.900","0.600","7.500","6.950");';
          $codigo = 'var codigo=Array("1000","660","483","648","713","856","358","763","715","321","320","117","541");';
          $tipo = 'var tipo=Array("agua","carga","aditivo","aditivo","aditivo","aditivo","aditivo","tio2","carga","aditivo","aditivo","ligante","disolvente");';
          //$producto = 'var producto=Array(' . $producto . ');';
          $porcentaje_teorico = 'var porcentaje_teorico=Array("46.850","0.030","0.150","0.550","3.000","0.050","0.270","25.000","20.000","2.000","0.100","1.000","1.000");'; */


        Session::flash('cantidad_pesada', $cantidad_pesada);
        Session::flash('codigo', $codigo);
        Session::flash('tipo', $tipo);
        Session::flash('porcentaje_teorico', $porcentaje_teorico);
        //var_dump(Session::all());exit;
    }

    private function set_default_values() {
        $cantidad_pesada = 'var cant=Array("","","","","","","","","","");';
        $codigo = 'var codigo=Array("1000","660","483","648","358","856","763","720","117","852");';
        $tipo = 'var tipo=Array("","","","","","","","","","");';
        //$producto = 'var producto=Array(' . $producto . ');';
        $porcentaje_teorico = 'var porcentaje_teorico=Array("","","","","","","","","","");';


        /* $cantidad_pesada = 'var cant=Array("327.800","0.200","1.100","3.780","21.000","0.345","1.950","175.100","141.000","13.900","0.600","7.500","6.950");';
          $codigo = 'var codigo=Array("1000","660","483","648","713","856","358","763","715","321","320","117","541");';
          $tipo = 'var tipo=Array("agua","carga","aditivo","aditivo","aditivo","aditivo","aditivo","tio2","carga","aditivo","aditivo","ligante","disolvente");';
          //$producto = 'var producto=Array(' . $producto . ');';
          $porcentaje_teorico = 'var porcentaje_teorico=Array("46.850","0.030","0.150","0.550","3.000","0.050","0.270","25.000","20.000","2.000","0.100","1.000","1.000");'; */


        Session::flash('cantidad_pesada', $cantidad_pesada);
        Session::flash('codigo', $codigo);
        Session::flash('tipo', $tipo);
        Session::flash('porcentaje_teorico', $porcentaje_teorico);
        //var_dump(Session::all());exit;
    }

    public function get_new() {
        $filasDeMas = 0;
        $this->set_default_values();
        $filasDeMas = 10;

        return View::make('pinturas/formulas-add', array(
                    'secciones' => SeccionesFormula::dropDown(),
                    'tipos' => Formula::pinturaTipos(true),
                    //'estados' => Formula::pinturaEstados(true),
                    'tipoProductos' => Formula::pinturaTipoProductos(),
                    'tipoBrillos' => Formula::pinturaTipoBrillos(),
                    'clasesMedidos' => Formula::pinturaClasesMedidos(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    'pendiente' => '0',
                    'filasDeMas' => $filasDeMas,
                    'pinturasActive' => 'active'

                        /* 'cantidad_pesada' => $cantidad_pesada,
                          'codigo' => $codigo,
                          'tipo' => $tipo,
                          //'producto' => $producto,
                          'porcentaje_teorico' => $porcentaje_teorico,
                         */
        ));
    }

    function get_formula_detalle($formula) {
        $i = 1;
        $products = Producto::dropDown('nombreProducto');
        $porductSelect = Producto::dropDownToSelect('', false, $products);


        $tipos = Formula::pinturaTipoProductos();
        $tiposSelect = Formula::pinturaTipoProductosSelect($tipos);
        $detalles = '<tr id="aClonar" style="display:none;">
                                        <td class="td_codigo">
                                            <input name="det-codigo-1" id="codigo-1" class="form-control codigo" type="text"  placeholder="Sale de calculo" tabindex="15">
                                        </td>
                                        <td class="td_cantidad">
                                            <input tabindex="16" name="det-cantidad-1"  type="text" class="form-control cantidad_pesada"  placeholder="Cantidad pesada">
                                        </td>
                                        <td class="td_prod">
                                        
                                         <select  class="select2_category form-control producto select2-offscreen"  tabindex="17"  >' . $porductSelect . '</select>   

                                        </td>
                                        <td class="tipo">
                                            <select  class="select2_category form-control tipo select2-offscreen"  tabindex="18"  >' . $tiposSelect . '</select>
                                        </td>
                                        <td>
                                            <input name="det-porcentaje_teorico-1" id="porcentaje_teorico-1"  class="form-control porcentaje_teorico" type="text" tabindex="-1">
                                        </td>
                                        <td>
                                            <input name="det-cantidad_teorica-1" id="cantidad_teorica-1"  class="form-control cantidad_teorica" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1">
                                        </td>

                                        <td>
                                            <input name="det-porcentaje_pesado-1" id="porcentaje_pesado-1"  class="form-control porcentaje_pesado" type="text" readonly="" placeholder="Sale de base" tabindex="-1">
                                        </td>
                                        <td class="product_values">
                                            <input name="det-aportacion_precio_teorico-1" id="aportacion_precio_teorico-1" class="form-control aportacion_precio_teorico" type="text" readonly="" placeholder="Sale de base" tabindex="-1">
                                            
                                        </td>

                                        <td class="boton text-right" colspan="10"></td>

                                    </tr>';
        $totCant = $totPorT = $totCantTeorica = 0;



        foreach ($formula->FormulasDetalle as $forDetalle) {
            $i++;
            if (isset($forDetalle->Producto->codigo)) {
                $codigo = $forDetalle->Producto->codigo;

                $cant = $forDetalle->cantidad ?: 0;
                $totCant += $cant;
                $porductSelect = Producto::dropDownToSelect('', false, $products, $forDetalle->idProducto);
                $tiposSelect = Formula::pinturaTipoProductosSelect($tipos, $forDetalle->tipo);

                $porT = $forDetalle->porcentaje_teorico;
                $totPorT += $porT;
                $porP = $forDetalle->porcentaje_pesado;
                $cantTeorica = $forDetalle->cantidad_teorica;
                $totCantTeorica += $cantTeorica;
                $apPreTeo = $forDetalle->aportacion_precio_teorico;

                $coste = $forDetalle->Producto->coste ?: 0;
                $densidad = $forDetalle->Producto->densidad ?: 0;
                $solidos = $forDetalle->Producto->solidos ?: 0;
                $voc = $forDetalle->Producto->VOC ?: 0;


                $tab_index = '-1';

                $detalles .= '<tr class="new-rows">
                    
<td class="td_codigo">
                                            <input name="det-codigo-' . $i . '" id="codigo-' . $i . '" class="form-control codigo" type="text"  placeholder="Sale de calculo" tabindex="15" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 9" value="' . $codigo . '">
                                        </td>
                                        <td class="td_cantidad">
                                            <input tabindex="16" name="det-cantidad-' . $i . '"  type="text" class="form-control cantidad_pesada"  placeholder="Cantidad pesada" value="' . $cant . '" data-val="' . $cant . '">
                                        </td>
                                        <td class="td_prod">
                                        
                                         <select name="det-producto-' . $i . '" class="select2_category form-control producto select2-offscreen"  tabindex="17"  >' . $porductSelect . '</select>   

                                        </td>
                                        <td class="tipo">
                                            <select name="det-tipo-' . $i . '" class="select2_category form-control tipo select2-offscreen"  tabindex="18"  >' . $tiposSelect . '</select>
                                        </td>
                                        <td>
                                            <input name="det-porcentaje_teorico-' . $i . '" id="porcentaje_teorico-' . $i . '"  class="form-control porcentaje_teorico" type="text" tabindex="-1" value="' . $porT . '">
                                        </td>
                                        <td>
                                            <input name="det-cantidad_teorica-' . $i . '" id="cantidad_teorica-' . $i . '"  class="form-control cantidad_teorica" type="text" readonly="" placeholder="Sale de calculo" tabindex="-1" value="' . $cantTeorica . '">
                                        </td>

                                        <td>
                                            <input name="det-porcentaje_pesado-' . $i . '" id="porcentaje_pesado-' . $i . '"  class="form-control porcentaje_pesado" type="text" readonly="" placeholder="Sale de base" tabindex="-1" value="' . $porP . '">
                                        </td>
                                        <td class="product_values">
                                            <input name="det-aportacion_precio_teorico-' . $i . '" id="aportacion_precio_teorico-' . $i . '" class="form-control aportacion_precio_teorico" type="text" readonly="" placeholder="Sale de base" tabindex="-1" value="' . $apPreTeo . '">
                                            <input type="hidden" class="coste" value="' . $coste . '"> 
                                            <input type="hidden" class="densidad" value="' . $densidad . '"> 
                                            <input type="hidden" class="solidos" value="' . $solidos . '"> 
                                                <input type="hidden" class="voc" value="' . $voc . '"> 
                                                    <input type="hidden" class="vocIndividual" value="0"> 
                                        </td>
                                        <td class="boton text-right" colspan="10">
                                        <button class="btn red del-row" style="padding:1px 16px;" type="button">-</button>
                                        <button class="btn green add-row" style="padding:1px 14.5px;" type="button">+</button>
                                        </td>
  
                                    </tr>';
            }
        }

        //dame($detalles,1);

        return ['detalles' => $detalles, 'count' => $i, 'totCant' => $totCant, 'totPorT' => $totPorT, 'totCantTeorica' => $totCantTeorica];
    }

    public function get_edit($id) {

        $formula = Formula::where('id', '=', $id)->first();
        $detalles = $this->get_formula_detalle($formula);

        //Session::flash('noAutoPopulateTipo', '1');

        $n = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n] = $forEq->codigo;
        }

        return View::make('pinturas/formulas-edit', array(
                    'formula' => $formula,
                    'pinturasActive' => 'active',
                    'detalles' => $detalles['detalles'],
                    'filasDeMas' => $detalles['count'],
                    'totCant' => $detalles['totCant'],
                    'totPorT' => $detalles['totPorT'],
                    'totCantTeorica' => $detalles['totCantTeorica'],
                    'tipos' => Formula::pinturaTipos(true),
                    'estados' => Formula::pinturaEstados(true, false, $formula->pintura_estado),
                    'tipoProductos' => Formula::pinturaTipoProductos(),
                    'tipoBrillos' => Formula::pinturaTipoBrillos(),
                    'clasesMedidos' => Formula::pinturaClasesMedidos(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    'pendiente' => 0,
                    'equivalencias' => $equivalencias,
                    'secciones' => SeccionesFormula::dropDown(),
        ));


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
        $filasDeMas = $formula->formulasDetalle->count();
        $coma = $codigo = $porcentaje_teorico = $producto = $tipo = $cantidad_pesada = '';
        $n = 0;
        //DVULEVE VALORES
        foreach ($formula->formulasDetalle as $forDetalle) {
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
            $cantidad_pesada .= $coma . "'" . $forDetalle->cantidad . "'";
            $porcentaje_teorico .= $coma . "'" . $forDetalle->porcentaje_teorico . "'";
            //$producto .= $coma . "'" . $forDetalle->Producto->codigo . "'";
            $tipo .= $coma . "'" . $forDetalle->tipo . "'";

            $coma = ', ';
            // }
        }
        //$this->dame($cant, 1);



        $cantidad_pesada = 'cant=Array(' . $cantidad_pesada . ');';
        $codigo = 'var codigo=Array(' . $codigo . ');';
        $tipo = 'var tipo=Array(' . $tipo . ');';
        $producto = 'var producto=Array(' . $producto . ');';
        $porcentaje_teorico = 'var porcentaje_teorico=Array(' . $porcentaje_teorico . ');';
        Session::flash('noAutoPopulateTipo', '1');

        $n = 0;
        $equivalencias = array();
        foreach ($formula->FormulasEquivalencia as $forEq) {
            $n++;
            $equivalencias['equivalencia' . $n] = $forEq->equivalencia;
            $equivalencias['codigo' . $n] = $forEq->codigo;
        }

        //dd($formula->clase_medio);


        return View::make('pinturas/formulas-edit', array(
                    'tipos' => Formula::pinturaTipos(true),
                    'estados' => Formula::pinturaEstados(true, false, $formula->pintura_estado),
                    'tipoProductos' => Formula::pinturaTipoProductos(),
                    'tipoBrillos' => Formula::pinturaTipoBrillos(),
                    'clasesMedidos' => Formula::pinturaClasesMedidos(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'productoName' => Producto::dropDown(),
                    'formula' => $formula,
                    'cantidad_pesada' => $cantidad_pesada,
                    'codigo' => $codigo,
                    'tipo' => $tipo,
                    'producto' => $producto,
                    'porcentaje_teorico' => $porcentaje_teorico,
                    'filasDeMas' => $filasDeMas,
                    //'firstRow' => $firstRow,
                    'pendiente' => 0,
                    'pinturasActive' => 'active',
                    'equivalencias' => $equivalencias,
        ));
    }

    function lastPinturaId() {
        $lastPin = DB::table('formulas')->select('numero_pintura')->where('numero_pintura', '<>', 0)->orderBy('id', 'desc')->first();
        if (!isset($lastPin->numero_pintura)) {
            $lastPin = 1;
        } else {
            $lastPin = $lastPin->numero_pintura + 1;
        }
        return $lastPin;
    }

    protected function post_create() {
        Input::merge(array_map('trim', Input::all()));
        $rules = array(
            'nombre' => 'required',
            'pintura_ajustar_a' => 'required',
            'pintura_tipo' => 'required',
            'pintura_estado' => 'required',
            'secciones' => 'required|integer|min:1',
        );
        //dd(Input::all());
        if (Input::has('id')) {
            $updating = true;
            $formula = Formula::find(Input::get('id'));
            if (Input::get('pintura_estado') == '' && $formula->pintura_estado == 'confirmada') {
                Input::merge(['pintura_estado' => 'confirmada']);
            }
        } else {
            $updating = false;
        }
        $input = Input::all();
        //var_dump($input['tipo_brillo_medio']);exit;
        $filasDeMas = Input::get('filasDeMas');
        $pendiente = 0;

        $numbered_rows = [];
        for ($i = 0; $i <= 50; $i++) {
            $n = $i + 1;
            $cantidad = trim(Input::get('det-cantidad-' . $n));
            //dame('det-cantidad-' . $n);
            //dame(Input::has('det-cantidad-' . $n));
            //if ($cantidad == '')
            //continue;
            //IN CASE THAT ROW HAS BEEN DELETED FOR THE NEW REQUIREMENT
            if (!Input::has('det-cantidad-' . $n))
                continue;
            $rules += array(
                //'det-cantidad-' . $n => 'required',
                'det-codigo-' . $n => 'required',
                'det-producto-' . $n => 'required',
                'det-tipo-' . $n => 'required',
                'det-porcentaje_teorico-' . $n => 'required',
            );
            $numbered_rows[] = $n;
        }
        //dd($rules);
        //dame($numbered_rows,1);
        $validator = Validator::make($input, $rules);
        //        var_dump(Input::get('fecha'));
        //        var_dump($validatorExtra);exit;
        if ($validator->fails()) {
//            $this->dame($validator->messages());
//            $this->dame($input, 1);
            if ($updating) {
                return Redirect::back()->withInput()->with(['mensaje' => '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>', 'noAutoPopulateTipo' => '0']);
            }
//                return Redirect::back()->withInput()->with(['mensaje' => '<div class="alert alert-warning">
//                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
//                                    	</div>','noAutoPopulateTipo'=>'1']);
            $coma = $cant = $codigo = $producto = $tipo = $porcentaje_teorico = $cantidad_pesada = '';
            //DVULEVE VALORES
            foreach ($numbered_rows as $i) {
                $n = $i;
                $codigo .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $cantidad_pesada .= $coma . "'" . Input::get('det-cantidad-' . $n, 0) . "'";
                $tipo .= $coma . "'" . Input::get('det-tipo-' . $n) . "'";
                //$producto .= $coma . "'" . Input::get('det-codigo-' . $n) . "'";
                $porcentaje_teorico .= $coma . "'" . Input::get('det-porcentaje_teorico-' . $n) . "'";
                $coma = ', ';
            }
            $cantidad_pesada = 'cant=Array(' . $cantidad_pesada . ');';
            $codigo = 'var codigo=Array(' . $codigo . ');';
            $tipo = 'var tipo=Array(' . $tipo . ');';
            //$producto = 'var producto=Array(' . $producto . ');';
            $porcentaje_teorico = 'var porcentaje_teorico=Array(' . $porcentaje_teorico . ');';
            //dd($cant);
            $mensaje = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formatoo.
                                    	</div> ';
            //($tipo);

            $convierteFormula = false;
            Session::flash("_old_input", $input);
            Session::flash("mensaje", $mensaje);
            Session::flash("cantidad_pesada", $cantidad_pesada);
            Session::flash("codigo", $codigo);
            Session::flash("tipo", $tipo);
            Session::flash("producto", $producto);
            Session::flash("porcentaje_teorico", $porcentaje_teorico);
            Session::flash("pendiente", $pendiente);
            Session::flash("convierteFormula", $convierteFormula);
            Session::flash("filasDeMas", $filasDeMas);
            Session::flash("pinturasActive", 'active');
            Session::flash("noAutoPopulateTipo", '1');
            return View::make('pinturas/formulas-add', array(
                        'tipos' => Formula::pinturaTipos(true),
                        'estados' => Formula::pinturaEstados(true),
                        'tipoProductos' => Formula::pinturaTipoProductos(),
                        'tipoBrillos' => Formula::pinturaTipoBrillos(),
                        'clasesMedidos' => Formula::pinturaClasesMedidos(),
                        'productoCode' => Producto::dropDown('codigo'),
                        'productoName' => Producto::dropDown(),
                        'pendiente' => '0',
                        'filasDeMas' => $filasDeMas,
                        'pinturasActive' => 'active',
                        'secciones' => SeccionesFormula::dropDown(),
            ));
//            return Redirect::back()->withInput()->with(array(
//                        'mensaje' => $mensaje,
//                        'cantidad_pesada' => $cantidad_pesada,
//                        'codigo' => $codigo,
//                        //'tipo' => $tipo,
//                        'producto' => $producto,
//                        'porcentaje_teorico' => $porcentaje_teorico,
//                        'pendiente' => $pendiente,
//                        'convierteFormula' => $convierteFormula,
//                        'filasDeMas' => $filasDeMas,
//                        'pinturasActive' => 'active', 'noAutoPopulateTipo' => '1'
//            ));
        } else {
            $formulaValidada = $isFormulasDetalleUpdate = false;
            if (Input::has('id')) {
                $formula->allow_notifications = 1;
                $isFormulasDetalleUpdate = $this->isFormulasDetalleUpdate($formula->formulasDetalle, $numbered_rows);

                if (Input::get('pintura_estado') != 'desarrollo' && $formula->pintura_estado != 'desarrollo' && !$isFormulasDetalleUpdate)
                    $formula->allow_notifications = 0;






                if (Input::get('pintura_estado') != 'desarrollo' && $formula->pintura_estado == 'desarrollo' && $formula->numero_pintura) {


//                    if ($formula->pintura_estado == 'validada-activa') {
//                        $formula->idSeccionFormula = $_ENV['PINTURA_VALIDADA_ACTIVA']; //validada
//                    } elseif ($formula->pintura_estado == 'validada-reserva') {
//                        $formula->idSeccionFormula = $_ENV['PINTURA_VALIDADA_RESERVA']; //reserva
//                    }
                    //$formulaValidada = true;



                    if ($formula->numero == 0) {
                        $formula->numero = $this->lastFormulaId();
                    }
                }

                //$idPedido=Input::has('id');
            } else {
                $formula = new Formula();
                $formula->fecha = time();


                $formula->numero_pintura = $this->lastPinturaId();
                $formula->numero = 0;
                $formula->allow_notifications = 1;
            }

            $formula->nombre = Input::get('nombre');
            $formula->descripcion = Input::get('descripcion');
            $formula->instrucciones = Input::get('instrucciones');

            //pintura campos
            $formula->pintura_ajustar_a = Input::get('pintura_ajustar_a');
            $formula->pintura_tipo = Input::get('pintura_tipo');
            $formula->pintura_estado = Input::get('pintura_estado');

            if (Input::has('brillo_60_medio'))
                $formula->brillo_60_medio = Input::get('brillo_60_medio', NULL);
            if (Input::has('brillo_60_objetivo'))
                $formula->brillo_60_objetivo = Input::get('brillo_60_objetivo', NULL);

            if (Input::has('viscosidad_medio'))
                $formula->viscosidad_medio = Input::get('viscosidad_medio', 'NULL');
            if (Input::has('viscosidad_objetivo'))
                $formula->viscosidad_objetivo = Input::get('viscosidad_objetivo', 'NULL');

            if (Input::has('tipo_brillo_medio'))
                $formula->tipo_brillo_medio = Input::get('tipo_brillo_medio', '');
            if (Input::has('tipo_brillo_objetivo'))
                $formula->tipo_brillo_objetivo = Input::get('tipo_brillo_objetivo', '');

            if (Input::has('clase_medio'))
                $formula->clase_medio = Input::get('clase_medio', '');
            if (Input::has('clase_objetivo'))
                $formula->clase_objetivo = Input::get('clase_objetivo', '');


            if (Input::has('brillo_85_medio'))
                $formula->brillo_85_medio = Input::get('brillo_85_medio', NULL);
            if (Input::has('brillo_85_objetivo'))
                $formula->brillo_85_objetivo = Input::get('brillo_85_objetivo', NULL);

            if (Input::has('cubricion_medio'))
                $formula->cubricion_medio = Input::get('cubricion_medio', 'NULL');
            if (Input::has('cubricion_objetivo'))
                $formula->cubricion_objetivo = Input::get('cubricion_objetivo', 'NULL');

            if (Input::has('res_flote_medio'))
                $formula->res_flote_medio = Input::get('res_flote_medio', '');
            if (Input::has('res_flote_objetivo'))
                $formula->res_flote_objetivo = Input::get('res_flote_objetivo', '');

            if (Input::has('rendimiento_medio'))
                $formula->rendimiento_medio = Input::get('rendimiento_medio', '');
            if (Input::has('rendimiento_objetivo'))
                $formula->rendimiento_objetivo = Input::get('rendimiento_objetivo', '');


            if (Input::has('porcentaje_solidos_medio'))
                $formula->porcentaje_solidos_medio = Input::get('porcentaje_solidos_medio', '');
            if (Input::has('porcentaje_solidos_objetivo'))
                $formula->porcentaje_solidos_objetivo = Input::get('porcentaje_solidos_objetivo', '');
            if (Input::has('porcentaje_solidos_pesado'))
                $formula->porcentaje_solidos_pesado = Input::get('porcentaje_solidos_pesado', '');
            if (Input::has('porcentaje_solidos_teorico'))
                $formula->porcentaje_solidos_teorico = Input::get('porcentaje_solidos_teorico', '');

            if (Input::has('pvc_teorico'))
                $formula->pvc_teorico = Input::get('pvc_teorico', '');
            if (Input::has('pvc_pesado'))
                $formula->pvc_pesado = Input::get('pvc_pesado', '');
            if (Input::has('pvc_objetivo'))
                $formula->pvc_objetivo = Input::get('pvc_objetivo', '');

            if (Input::has('densidad_teorico'))
                $formula->densidad_teorico = Input::get('densidad_teorico', '');
            if (Input::has('densidad_pesado'))
                $formula->densidad_pesado = Input::get('densidad_pesado', '');
            if (Input::has('densidad_medio'))
                $formula->densidad_medio = Input::get('densidad_medio', '');
            if (Input::has('densidad_objetivo'))
                $formula->densidad_objetivo = Input::get('densidad_objetivo', '');

            if (Input::has('tio2_teorico'))
                $formula->tio2_teorico = Input::get('tio2_teorico', '');
            if (Input::has('tio2_pesado'))
                $formula->tio2_pesado = Input::get('tio2_pesado', '');
            if (Input::has('tio2_objetivo'))
                $formula->tio2_objetivo = Input::get('tio2_objetivo', '');

            if (Input::has('ligante_teorico'))
                $formula->ligante_teorico = Input::get('ligante_teorico', '');
            if (Input::has('ligante_pesado'))
                $formula->ligante_pesado = Input::get('ligante_pesado', '');
            if (Input::has('ligante_objetivo'))
                $formula->ligante_objetivo = Input::get('ligante_objetivo', '');

            if (Input::has('precio_eu_kg_teorico'))
                $formula->precio_eu_kg_teorico = Input::get('precio_eu_kg_teorico', '');
            if (Input::has('precio_eu_kg_pesado'))
                $formula->precio_eu_kg_pesado = Input::get('precio_eu_kg_pesado', '');
            if (Input::has('precio_eu_kg_objetivo'))
                $formula->precio_eu_kg_objetivo = Input::get('precio_eu_kg_objetivo', '');

            if (Input::has('precio_eu_lt_teorico'))
                $formula->precio_eu_lt_teorico = Input::get('precio_eu_lt_teorico', '');
            if (Input::has('precio_eu_lt_pesado'))
                $formula->precio_eu_lt_pesado = Input::get('precio_eu_lt_pesado', '');
            if (Input::has('precio_eu_lt_medido'))
                $formula->precio_eu_lt_medido = Input::get('precio_eu_lt_medido', '');
            if (Input::has('precio_eu_lt_objetivo'))
                $formula->precio_eu_lt_objetivo = Input::get('precio_eu_lt_objetivo', '');

            if (Input::has('ph_medio'))
                $formula->ph_medio = Input::get('ph_medio', '');
            if (Input::has('ph_objetivo'))
                $formula->ph_objetivo = Input::get('ph_objetivo', '');

            if (Input::has('l_medio'))
                $formula->l_medio = Input::get('l_medio', '');
            if (Input::has('l_objetivo'))
                $formula->l_objetivo = Input::get('l_objetivo', '');

            if (Input::has('a_medio'))
                $formula->a_medio = Input::get('a_medio', '');
            if (Input::has('a_objetivo'))
                $formula->a_objetivo = Input::get('a_objetivo', '');

            if (Input::has('b_medio'))
                $formula->b_medio = Input::get('b_medio', '');
            if (Input::has('b_objetivo'))
                $formula->b_objetivo = Input::get('b_objetivo', '');

            if (Input::has('y_medio'))
                $formula->y_medio = Input::get('y_medio', '');
            if (Input::has('y_objetivo'))
                $formula->y_objetivo = Input::get('y_objetivo', '');

            //Forulas campos
            $formula->fechaUltEdicion = time();
//            if (!$formulaValidada)
//                $formula->idSeccionFormula = $_ENV['PINTURAS_DECORATIVAS']; //


            $formula->idSeccionFormula = Input::get('secciones');

            $formula->origSeccion = $_ENV['PINTURAS_DECORATIVAS'];
            $formula->densidad = 0;
            $formula->codigo = '';
            $formula->pendienteEdicion = '0';
            $formula->activa = 1;
            $formula->esBase = 0;
            $formula->numeroHija = 0;

//            var_dump($this->isFormulasDetalleUpdate($formula->formulasDetalle));
//            echo '<br>';
//            var_dump($formula->formulasDetalle, $input);
//            exit;




            if ($formula->save()) {
                if (Input::has('id')) {


                    if ($isFormulasDetalleUpdate)
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

                if ($isFormulasDetalleUpdate || !$updating)
                    foreach ($numbered_rows as $n) {
                        //$n = $i + 1;
                        $cant_trim = trim(Input::get('det-cantidad-' . $n));
                        $cant_producto = trim(Input::get('det-producto-' . $n));
                        if ($cant_producto == '0')
                            continue;
                        $formulasDetalle = new FormulasDetalle();
                        $formulasDetalle->cantidad = Input::get('det-cantidad-' . $n, 0) ?: 0;
                        $formulasDetalle->idProducto = Input::get('det-producto-' . $n) ?: 0;
                        $formulasDetalle->porcentaje_teorico = Input::get('det-porcentaje_teorico-' . $n) ?: 0;
                        $formulasDetalle->porcentaje_pesado = Input::get('det-porcentaje_pesado-' . $n) ?: 0;
                        $formulasDetalle->aportacion_precio_teorico = Input::get('det-aportacion_precio_teorico-' . $n) ?: 0;
                        $formulasDetalle->cantidad_teorica = Input::get('det-cantidad_teorica-' . $n) ?: 0;
                        $formulasDetalle->tipo = Input::get('det-tipo-' . $n) ?: 0;
                        $formulasDetalle->idFormula = $formula->id;

                        //Forulas campos
                        $formulasDetalle->esColor = 0;

                        //dame($formulasDetalle,1);
                        $formulasDetalle->save();
                    }
            } else {
                return Redirect::to('pinturas')->with('mensaje', $this->get_message('ko', 'Error de Inserción!! '));
            }
            if ($updating) {
                return Redirect::back()->withInput()->with(['mensaje' => $this->get_message('ok', 'Actualización con éxito!! '), 'noAutoPopulateTipo' => '1']);
            } else {
                return Redirect::to('edit-pintura/' . $formula->id)->with('mensaje', $this->get_message('ok', 'Inserción con éxito!! '));
            }
        }
    }

    public function get_delete($id) {
        Formula::destroy($id);
        return Redirect::to('pinturas');
    }

    public function pdf_pintura($id, $cantProduccion) {
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

    public function print_pintura($id, $cantProduccion) {
        $user_img = $this->get_user_img();
        $formula = Formula::find($id);
        if ($cantProduccion != 0) {
            $formula = $this->set_cantidad($formula, $cantProduccion);
        }
        $data = array(
            'formula' => $formula, 'formulaActive' => 'active', 'user_img' => $user_img, 'logo_img' => 'logo_color.jpg',
        );
        return View::make('pinturas/impresiones/print-pintura', $data);
    }

    public function duplicar_pintura($id) {
        $pintura = Formula::find($id);
        $newPintura = $pintura->replicate();
        $newPintura->nombre = 'Copy - ' . $newPintura->nombre;
        $newPintura->numero_pintura = $this->lastPinturaId();
        $newPintura->numero = 0;
        $newPintura->viscosidad_medio = NULL;
        $newPintura->brillo_60_medio = NULL;
        $newPintura->brillo_85_medio = NULL;
        $newPintura->tipo_brillo_medio = NULL;
        $newPintura->clase_medio = NULL;
        $newPintura->porcentaje_solidos_teorico = NULL;
        $newPintura->porcentaje_solidos_pesado = NULL;
        $newPintura->porcentaje_solidos_medio = NULL;
        $newPintura->pvc_teorico = NULL;
        $newPintura->pvc_pesado = NULL;
        $newPintura->densidad_teorico = NULL;
        $newPintura->densidad_pesado = NULL;
        $newPintura->densidad_medio = NULL;
        $newPintura->tio2_pesado = NULL;
        $newPintura->tio2_teorico = NULL;
        $newPintura->ligante_teorico = NULL;
        $newPintura->ligante_pesado = NULL;
        $newPintura->precio_eu_kg_teorico = NULL;
        $newPintura->precio_eu_kg_pesado = NULL;
        $newPintura->precio_eu_lt_teorico = NULL;
        $newPintura->precio_eu_lt_pesado = NULL;
        $newPintura->precio_eu_lt_medido = NULL;
        $newPintura->cubricion_medio = NULL;
        $newPintura->res_flote_medio = NULL;
        $newPintura->rendimiento_medio = NULL;


        $newPintura->viscosidad_medio = NULL;
        $newPintura->brillo_60_medio = NULL;
        $newPintura->tipo_brillo_medio = NULL;
        $newPintura->clase_medio = NULL;

        $newPintura->porcentaje_solidos_medio = NULL;

        $newPintura->densidad_medio = NULL;

        $newPintura->precio_eu_lt_medido = NULL;
        $newPintura->brillo_85_medio = NULL;
        $newPintura->cubricion_medio = NULL;
        $newPintura->res_flote_medio = NULL;
        $newPintura->rendimiento_medio = NULL;
        $newPintura->ph_medio = NULL;
        $newPintura->a_medio = NULL;
        $newPintura->b_medio = NULL;
        $newPintura->y_medio = NULL;

        $newPintura->l_medio = NULL;
        $newPintura->fecha = time();


        if ($newPintura->save()) {
            $newId = $newPintura->id;
            $pintura->formulasDetalle->each(function($detalle)use($newId) {
                $newDetalle = $detalle->replicate();
                $newDetalle->idFormula = $newId;
                $newDetalle->cantidad = '';
                $newDetalle->save();
            });
        }
        return Redirect::to('/edit-pintura/' . $newPintura->id);
        //return $this->get_edit($newPintura->id);
    }

    /* solidos y densidad varchar */
}
