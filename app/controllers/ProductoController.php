<?php

class ProductoController extends BaseController {

    public function listProductos() {

        //dame(new Producto(),1);
        //$productos = Producto::all();
        //ddd($producto->proveedor()->first());exit;productosActive
        $productos = DB::table('productos')->select('*')->orderBy('codigo', 'ASC')->get();
        //dame($productos);
        return View::make('productos/productos-list')->with(
                        array('productos' => $productos, 'proveedoresSel' => Proveedor::dropDown(), 'productosSel' => Producto::dropDown(), 'productosCodSel' => Producto::dropDown('codigo'), 'productoSel' => '', 'productoCodSel' => '', 'proveedorSel' => '',
                            'productosActive' => 'active'));
    }

    public function post_index() {
        $filtra = false;
        $selProd = $selProv = false;

        if (Input::has('updating') && Session::get('selProd', false)) {
            $selProd = Session::get('selProd', false);
        } elseif (Input::has('producto') && !Input::has('updating')) {
            $selProd = Input::get('producto');
        }
        $productoSel = '';
        $productoCodSel = '';
        $proveedorSel = '';
        $productoCodSel = '';

        if ($selProd) {
            Session::put('selProd', $selProd);


            $productoSel = '';
            $productoCodSel = '';
            if ($selProd != 0) {
                $productos = new Producto();
                $productos = $productos->where('id', $selProd);
                $productoSel = $productoCodSel = $selProd;

                $filtra = true;
            }
        } else {
            Session::forget('selProd');
        }


        if (Input::has('updating') && Session::get('selProv', false)) {
            $selProv = Session::get('selProv', false);
        } elseif (Input::has('proveedor') && !Input::has('updating')) {
            $selProv = Input::get('proveedor');
        }
        if ($selProv) {
            Session::put('selProv', $selProv);

            $proveedorSel = '';
            $productoCodSel = '';
            if ($selProv != 0) {
                if (!isset($productos))
                    $productos = new Producto();
                $productos = $productos->where('idProveedor', $selProv);
                $proveedorSel = $selProv;
                $filtra = true;
            }
        }else {
            Session::forget('selProv');
        }
        if (!empty($productoSel))
            $productoCodSel = $productoSel;

        if ($filtra) {
            $productos = $productos->orderBy('codigo')->get();
        } else {
            $productos = new Producto();
            $productos = $productos->orderBy('codigo')->get();
        }
        //dame(DB::getQueryLog() );
        return View::make('productos/productos-list')->with(array('productos' => $productos, 'productosSel' => Producto::dropDown(), 'proveedoresSel' => Proveedor::dropDown(), 'productosCodSel' => Producto::dropDown('codigo'), 'productoSel' => $productoSel, 'productoCodSel' => $productoCodSel, 'proveedorSel' => $proveedorSel, 'productosActive' => 'active'));
    }

    public function verProducto($id) {
        $producto = Producto::where('id', '=', $id)->first();
        $historicos = $producto->ProductosHistoricoCoste; //dame($historicos, 1);
        return View::make('productos/producto-view', array('producto' => $producto, 'historicos' => $historicos, 'productosActive' => 'active'));
    }

    public function editProductoGet($id) {
        $producto = Producto::where('id', '=', $id)->first();
        $proveedores = Proveedor::lists('nombre', 'id');
        return View::make('productos/productos-edit', array('producto' => $producto, 'proveedores' => $proveedores, 'productosActive' => 'active',
                    'tipoProductos' => Formula::pinturaTipoProductos()));
    }

    public function addProductoGet() {
        $proveedores = Proveedor::lists('nombre', 'id');
        return View::make('productos/productos-add', array(
                    'proveedores' => $proveedores,
                    'productosActive' => 'active',
                    'tipoProductos' => Formula::pinturaTipoProductos(),
        ));
    }

    public function delProducto($id) {
        //I DONT WANNA DELETE ANY PRODUCT WHICH HAS DEPENDENCIES
        $pedidosDetalle = PedidosDetalle::where('idProducto', '=', $id)->first();
        $formulasDetalle = FormulasDetalle::where('idProducto', '=', $id)->first();
        if ($pedidosDetalle or $formulasDetalle)
            return Redirect::to('productos')->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> El producto Contiene registros dependientes y no puede ser eliminado .
                                    	</div>');


        Producto::destroy($id);
        return Redirect::to('productos');
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function addProductoPost() {
        $input = Input::all();
        //$this->dame($input, 1);
        $historic = true;
		
		$validateId='';
		if (Input::has('id')) {
            //$rules=  array_merge($rules, array('notaCambioPrecio' => 'required'));  
            $updating = true;
			$validateId=','.Input::get('id');
        } else {
            $updating = false;
        }

        $rules = array(
            'proveedores' => 'required',
            'nombreProducto' => 'required',
            'nombreClave' => 'required',
            'codigo' => 'required|unique:productos,codigo'.$validateId,
            'coste' => 'required',
//                    'VOC' => 'required',
//                    'densidad' => 'required' 
        );
		
		//dd($rules);

        

        $messages = array(
            'required' => 'El Campo :attribute es requerido.',
            'unique' => 'El Campo :attribute esta siendo usado por otro producto.',
        );


        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            //$this->dame($validator->messages(), 1);
            //$this->dame($producto, 1);
            $messagesTxt='';
            $messages = $validator->messages();

            foreach ($messages->all() as $message) {
                $messagesTxt.='<p>'.$message.'</p>';
            }
            
            return Redirect::back()->withInput()->with([
                        'mensaje' => '<div class="alert alert-warning">
                                        	'.$messagesTxt.' 
                                    	</div>',
                        'tipoProductos' => Formula::pinturaTipoProductos()]);
        } else {
            //$this->dame(Input::all(), 1);

            if ($updating) {//UPDATING
                $producto = Producto::find(Input::get('id'));
                $lastPrice = $producto->coste;
                if ($lastPrice == Input::get('coste'))
                    $historic = false;
            }else {
                $producto = new Producto();
                //$producto->codigo = rand(11111, 99999);
            }
            $producto->idProveedor = Input::get('proveedores');
            $producto->nombreProducto = Input::get('nombreProducto');
            $producto->nombreClave = Input::get('nombreClave');
            $producto->descripcion = Input::get('descripcion');
            $producto->coste = floatVal(Input::get('coste'));
            $producto->codigo = Input::get('codigo');
            $producto->solidos = Input::get('solidos', 0);
            $producto->tipo = Input::get('tipo', 0);
            if (Input::has('colorimetria')) {
                $producto->colorimetria = 1;
            } else {
                $producto->colorimetria = 0;
            }

            $producto->VOC = floatVal(Input::get('VOC'));
            $producto->densidad = floatVal(Input::get('densidad'));
            if ($producto->save()) {
                if ($updating) {
                    $idProd = Input::get('id');
                } else {
                    $idProd = $producto->id;
                }
                if ($historic) {
                    $historico = new ProductosHistoricoCoste();
                    $historico->idProducto = $idProd;
                    $historico->coste = floatVal(Input::get('coste'));
                    $historico->notas = Input::get('notaCambioPrecio');
                    $historico->creado = time();
                    $historico->actualizado = time();
                    $historico->save();
                }
                if ($updating) {
                    return Redirect::to('productos')->with('updating', '1');
                } else {
                    return Redirect::to('productos')->with('mensaje', '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>');
                }
            } else {
                return Redirect::to('productos')->with('mensaje', '<div class="alert alert-danger">
                                        	<strong>Error!! </strong> Inserción de datos incorrecta.
                                    	</div>');
            }
        }
    }

    protected function getCostePostAjax($codigo = true) {

        if (Input::has('codigo_prod')) {
            $producto = Producto::where('codigo', Input::get('codigo_prod'))->first();
        } elseif (Input::has('idProd')) {
            $producto = Producto::where('id', Input::get('idProd'))->first();
        }
//        if(Auth::user()->type==3 && $producto->colorimetria!=1)
//            $producto=false;

        if (!$producto) {
            $response = array(
                'status' => 'ok',
                'coste' => 0,
                'solidos' => 0,
                'voc' => 0,
                'densidad' => 0,
                'proveedor' => 0,
                'proveedorNom' => 0,
                'productoName' => '',
                'productoCode' => 0,
                'id' => 0,
                'tipo' => 0
            );
        } else {

            $response = array(
                'status' => 'ok',
                'coste' => $producto->coste,
                'solidos' => $producto->solidos,
                'voc' => floatVal($producto->VOC),
                'densidad' => $producto->densidad,
                'proveedor' => $producto->idProveedor,
                'proveedorNom' => $producto->Proveedor->nombre,
                'productoName' => $producto->nombreProducto,
                'productoCode' => $producto->codigo,
                'tipo' => $producto->tipo,
                'id' => $producto->id
            );
        }
        return Response::json($response);
    }

    protected function getProductByProveedorAjax() {
        $productos = Producto::where('idProveedor', Input::get('idProv'))->lists('nombreProducto', 'id');
        //dame($producto);

        return Response::json($productos);
    }

    protected function getProductCodeByProveedorAjax() {
        $productos = Producto::where('idProveedor', Input::get('idProv'))->lists('codigo', 'id');
        //dame($producto);

        return Response::json($productos);
    }

    protected function getProductCodeByIdAjax() {
        $prod_code = Producto::get_data('codigo', 'id', Input::get('id_prod'));
        //dame($producto);

        return Response::json($prod_code);
    }

    protected function getProveedorByProd() {
        $prov = Producto::select('idProveedor')->where('id', Input::get('id_prod'))->first();
        //dame($producto);

        return Response::json($prov);
    }

}
