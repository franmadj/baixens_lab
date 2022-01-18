<?php

class PedidoController extends BaseController {

    var $viejos = array('proveedor' => '0', 'fechaDe' => '', 'fechaA' => '', 'fechaDeE' => '', 'fechaAE' => '', 'estadoPedidos' => '0');
    
    function __construct() {
        parent::__construct();
        $this->checkUserAccess([1,2]);
    }

    private function get_pedido($id) {
        $pedido = Pedido::where('id', '=', $id)->first();
        //dame($pedido->relationsToArray(), 1);
        $pedido->envio = ($pedido->envio == 'e') ? 'envio' : 'recogen';
        $pedidoDetalle = $pedido->PedidosDetalle; //$this->dame($pedido->envio, 1);
        return ['pedido' => $pedido,
            'pedidoDetalle' => $pedidoDetalle,
            'pedidoActive' => 'start active'];
    }

    public function listPedidos() {
        $pedidos = Pedido::orderBy('id', 'desc')->take(20)->get();
//        dame('$pedidos');
//
//
        return View::make('pedidos/pedidos-list', array('pedidos' => $pedidos, 'proveedores' => Proveedor::dropDown(), 'viejos' => $this->viejos, 'pedidoActive' => 'start active'));
    }

    public function post_index() {

        if (Input::has('proveedores')) {
            $pedidos = new Pedido();
            $filtra = false;
            if (Input::get('proveedores') != '0') {
                $pedidos = $pedidos->where('idProveedor', Input::get('proveedores'));
                $filtra = true;
                $this->viejos['proveedor'] = Input::get('proveedores');
            }

            if (Input::get('estadoPedidos') != '0') {//echo Input::get('estadoPedidos');exit;
                $pedidos = $pedidos->where('estadoPedido', trim(Input::get('estadoPedidos')));
                $filtra = true;
                $this->viejos['estadoPedidos'] = Input::get('estadoPedidos');
            }
            if (date_validate(Input::get('fechaDe')) && date_validate(Input::get('fechaA'))) {//exit;
                $pedidos = $pedidos->whereBetween('fecha', array(
                    strtotime(swip_date_us_eu(Input::get('fechaDe'))),
                    strtotime(swip_date_us_eu(Input::get('fechaA')))));

                $filtra = true;
                $this->viejos['fechaDe'] = Input::get('fechaDe');
                $this->viejos['fechaA'] = Input::get('fechaA');
            }
            
            if (date_validate(Input::get('fechaDeE')) && date_validate(Input::get('fechaAE'))) {//exit;
                $pedidos = $pedidos->whereBetween('plazoEntrega', array(
                    strtotime(swip_date_us_eu(Input::get('fechaDeE'))),
                    strtotime(swip_date_us_eu(Input::get('fechaAE')))));

                $filtra = true;
                $this->viejos['fechaDeE'] = Input::get('fechaDeE');
                $this->viejos['fechaAE'] = Input::get('fechaAE');
            }
            
            
            
            if ($filtra) {
                $pedidos = $pedidos->get();
            } else {
                $pedidos = Pedido::all();
            }
        } else {
            $pedidos = Pedido::all();
        }
        //dame($pedidos,1);
        //dame(DB::getQueryLog(),1 );dame(Input::get('fechaA') );//exit;
        if (Input::has('excel_valorado') or Input::has('excel')) {

            $all_products = [];
            foreach ($pedidos as $pedido) {
                foreach ($pedido->pedidosDetalle as $pd) {
                    if (!array_key_exists($pd->idProducto, $all_products)) {
                        $all_products[$pd->idProducto] = isset($pd->Producto->nombreProducto)?$pd->Producto->nombreProducto:'';
                    }
                }
            }
            //dame($all_products,1);

            $reult = [];
            $i = 0;

            foreach ($all_products as $id_prod => $name_prod) {
                $tot_coste_prod = $tot_cant_prod = [];
                $proveedor = Producto::find($id_prod)->Proveedor->nombre;


                foreach ($pedidos as $pedido) {


                    foreach ($pedido->pedidosDetalle as $pd) {

                        if ($id_prod == $pd->idProducto) {
                            if (!isset($tot_coste_prod[$pd->idFormatoPedido])) {
                                $tot_coste_prod[$pd->idFormatoPedido] = 0;
                                $tot_cant_prod[$pd->idFormatoPedido] = 0;
                            }
                            $tot_coste_prod[$pd->idFormatoPedido]+=$pd->Producto->coste;
                            $tot_cant_prod[$pd->idFormatoPedido]+=$pd->cantidad;
                        }
                    }
                }
                foreach ($tot_coste_prod as $key => $val) {
                    $reult[$i]['proveedor'] = $proveedor;
                    $reult[$i]['producto'] = $name_prod;
                    $reult[$i]['coste'] = $val;
                    $reult[$i]['cantidad'] = $tot_cant_prod[$key];
                    $reult[$i]['formato'] = FormatosPedido::get_data('formato', 'id', $key);

                    $i++;
                }
            }





            include(public_path() . "/packages/phpExcel/Classes/PHPExcel.php");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getColumnDimension('a')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('d')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('e')->setAutoSize(true);
            $idSeccion = '';
            $n =  0;
            $row =50;
            foreach ($reult as $re) {
                if ($row >= 50) {
                    $row = 0;
                    $n++;
                    


                    $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, 'Prveedor');
                    $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, 'Producto');
                    $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, 'Formato');
                    $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, 'Cantidad');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('b')->setAutoSize(true);
                    if(Input::has('excel_valorado'))
                        $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, 'Coste');
                    //$objPHPExcel->getActiveSheet()->getColumnDimension('c')->setAutoSize(true);


                }
                $row++;

                $n++;
                $objPHPExcel->getActiveSheet()->SetCellValue('a' . $n, $re['proveedor']);
                $objPHPExcel->getActiveSheet()->SetCellValue('b' . $n, $re['producto']);
                $objPHPExcel->getActiveSheet()->SetCellValue('c' . $n, $re['formato']);
                $objPHPExcel->getActiveSheet()->SetCellValue('d' . $n, $re['cantidad']);
                if(Input::has('excel_valorado'))
                    $objPHPExcel->getActiveSheet()->SetCellValue('e' . $n, $re['coste']);

            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$file=public_path().'\files\excel.xlsx';
			if(file_exists($file)){
				chmod($file,0644);
			}
				
            $objWriter->save($file);
			if(file_exists($file))
				chmod($file,0644);
            header('location: ' . URL::to('/') . '/files/excel.xlsx');
            exit();
        } else {
            return View::make('pedidos/pedidos-list', array('pedidos' => $pedidos, 'proveedores' => Proveedor::dropDown(), 'viejos' => $this->viejos, 'pedidoActive' => 'start active'));
        }
    }

    public function get_view($id) {
        $datos = $this->get_pedido($id);
        return View::make('pedidos/pedido-view', $datos);
    }

    public function email_pedido($id) {
        $pedido = Pedido::where('id', '=', $id)->first();
        $email = $pedido->Proveedor->email;
        $this->create_pdf(true);


        //PLANTILLA
        Mail::send('pedidos.pedido-email', [], function($message) use ($email) {
            global $id;
			
            $message->from($this->generalData['EMAIL'], 'Baixens');
            $message->to($this->generalData['EMAIL']);
            $message->to($email)->subject('Pedido');
			//$message->to('info@jnacher.com');
            //$message->to('fmc03@hotmail.es')->subject('Pedido');
			$destinationPath = '../public/files';
            $message->attach($destinationPath . '/filename.pdf', array(
                //'as' => 'pdf-report.zip',
                'mime' => 'application/pdf')
            );
        });
        //echo 'ok';
        return Redirect::to('ver-pedido/' . $id)->with(array('pedidoActive' => 'start active', 'pedido_view_message' => '<div class="alert alert-success">
                                        	<strong>Email enviado !! </strong>
                                    	</div>'));
    }

    public function get_edit($id) {
        $pedido = Pedido::where('id', '=', $id)->first();

        $filasDeMas = $pedido->PedidosDetalle->count() - 1;


        //$this->dame($validator->messages(), 1);
        $coma = $cant = $productoCode = $productoNameR = $formato = $precio = '';
        $n = 0;
        //DVULEVE VALORES
        $firstRow = array(
            'cantidad' => '',
            'productoName' => '',
            'formatos' => '',
            'precio' => '',);
        foreach ($pedido->PedidosDetalle as $pedDetalle) {//$this->dame($pedDetalle->cantidad, 1);
            $n++;

            if ($n == 1) {
                $firstRow = array(
                    'cantidad' => $pedDetalle->cantidad,
                    'productoName' => $pedDetalle->idProducto,
                    'formatos' => $pedDetalle->idFormatoPedido,
                    'precio' => $pedDetalle->Producto->coste);
            } else {

                $cant .= $coma . "'" . $pedDetalle->cantidad . "'";
                $productoNameR .= $coma . "'" . $pedDetalle->idProducto . "'";
                $formato .= $coma . "'" . $pedDetalle->idFormatoPedido . "'";
                $precio .= $coma . "'" . $pedDetalle->Producto->coste . "'";
                $coma = ', ';
            }
        }
        //$this->dame($cant, 1);
        $cant = 'cant=Array(' . $cant . ');';
        $productoNameR = 'var productoName=Array(' . $productoNameR . ');';
        $formato = 'var formato=Array(' . $formato . ');';
        $precio = 'var precio=Array(' . $precio . ');';

        $productoNameRFr = 'var productoNameRFr="' . $firstRow['productoName'] . '";';



        //$this->dame(FormatosPedido::dropDown(), 1);
        return View::make('pedidos/pedidos-edit', array(
                    'pedido' => $pedido,
                    'proveedores' => Proveedor::dropDown(),
                    'formatos' => FormatosPedido::dropDown(),
                    'productoName' => Producto::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'cant' => $cant,
                    'formato' => $formato,
                    'productoNameR' => $productoNameR,
                    'productoNameRFr' => $productoNameRFr,
                    'precio' => $precio,
                    'filasDeMas' => $filasDeMas,
                    'firstRow' => $firstRow,
                    'pedidoActive' => 'start active'
        ));
    }

    public function get_new() {


        return View::make('pedidos/pedidos-add', array(
                    'proveedores' => Proveedor::dropDown(),
                    'formatos' => FormatosPedido::dropDown(),
                    'productoName' => Producto::dropDown(),
                    'productoCode' => Producto::dropDown('codigo'),
                    'filasDeMas' => 0,
                    'pedidoActive' => 'start active'
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
            'proveedores' => 'required',
            //'observaciones' => 'required',
            'recibidoPor' => 'required',
            'envio' => 'required',
            'det-cantidad-1' => 'required',
            'det-precio-1' => 'required',
            'det-productoCode-1' => 'required',
            'det-productoName-1' => 'required',
            'det-formatos-1' => 'required'
        );
        for ($i = 1; $i <= $filasDeMas; $i++) {
            $n = $i + 1;
            $rules += array(
                'det-cantidad-' . $n => 'required',
                'det-precio-' . $n => 'required',
                'det-productoCode-' . $n => 'required',
                'det-productoName-' . $n => 'required',
                'det-formatos-' . $n => 'required'
            );
        }


        if (Input::has('id')) {
            $updating = true;
        } else {
            $updating = false;
        }
        $validatorExtra = (date_validate(Input::get('fecha')) && date_validate(Input::get('plazoEntrega')));

        $validator = Validator::make($input, $rules);
//        var_dump(Input::get('fecha'));
//        var_dump($validatorExtra);exit;

        if ($validator->fails() || !$validatorExtra) {
            //dame($validator, 1);
            if ($updating)
                return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
            //$this->dame($validator->messages(), 1);
            $coma = $cant = $productoCode = $productoName = $formato = $precio = '';
            $pos = 0;
            //DVULEVE VALORES
            for ($i = 1; $i <= $filasDeMas; $i++) {
                $n = $i + 1;
                $cant .= $coma . "'" . Input::get('det-cantidad-' . $n) . "'";
                $productoCode .= $coma . "'" . Input::get('det-productoCode-' . $n) . "'";
                $productoName .= $coma . "'" . Input::get('det-productoName-' . $n) . "'";
                $formato .= $coma . "'" . Input::get('det-formatos-' . $n) . "'";
                $precio .= $coma . "'" . Input::get('det-precio-' . $n) . "'";
                $coma = ', ';
            }

            $cant = 'cant=Array(' . $cant . ');';
            $productoCode = 'var productoCode=Array(' . $productoCode . ');';
            $productoName = 'var productoName=Array(' . $productoName . ');';
            $formato = 'var formato=Array(' . $formato . ');';
            $precio = 'var precio=Array(' . $precio . ');';



            //dd($cant);

            return Redirect::to('add-pedido')->withInput()->with(array(
                        'mensaje' => '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar o sin Formato.
                                    	</div> ',
                        'cant' => $cant,
                        'productoName' => $productoName,
                        'productoCode' => $productoCode,
                        'formato' => $formato,
                        'precio' => $precio,
                        'filasDeMas' => $filasDeMas,
                        'pedidoActive' => 'start active'
            ));
        } else {

            if ($updating) {
                $pedido = Pedido::find(Input::get('id'));
                //$idPedido=Input::has('id');
            } else {
                $pedido = new Pedido();
                $pedido->idSolicitadoPor = Auth::id();
                $lastPedido = DB::table('pedidos')->select('numero')->orderBy('id', 'desc')->first();
				
                if (!isset($lastPedido->numero)) {
                    $lastPedido = 1;
                } else {
                    $lastPedido = $lastPedido->numero;
                }
                $pedido->numero = $lastPedido+1;
            }//var_dump(strtotime(swip_date_us_eu(Input::get('fecha')))); exit;
            $pedido->fecha = strtotime(swip_date_us_eu(Input::get('fecha')));
            $pedido->envio = Input::get('envio');
            $pedido->recibidoPor = Input::get('recibidoPor');
            $pedido->plazoEntrega = strtotime(Input::get('plazoEntrega'));
            $pedido->observaciones = Input::get('observaciones');
            $pedido->idProveedor = Input::get('proveedores');
            if ($pedido->save()) {
                if ($updating) {
                    $pedido->pedidosDetalle()->delete();
                }
                for ($i = 0; $i <= $filasDeMas; $i++) {
                    $n = $i + 1;
                    $pedidoDetalle = new PedidosDetalle();
                    $pedidoDetalle->cantidad = Input::get('det-cantidad-' . $n);
                    $pedidoDetalle->idProducto = Input::get('det-productoCode-' . $n);
                    $pedidoDetalle->idFormatoPedido = Input::get('det-formatos-' . $n);
                    $pedidoDetalle->idPedido = $pedido->id;
                    $pedidoDetalle->save();
                }
            }
            return Redirect::to('pedidos')->with(array('pedidoActive' => 'start active'));
        }
    }

    public function get_delete($id) {

        Pedido::destroy($id);
        return Redirect::to('pedidos')->with(array('pedidoActive' => 'start active'));
    }

    public function print_pedido($id) {
        if (isset($_GET['user_img'])) {
            $user_img = $_GET['user_img'];
        } else {
            $user_img = $this->generalData['current_user']->img;
        }

        $pedido = Pedido::find($id);
        //dame($pedido->pedidoDetalle,1);
        $data = array(
            'pedido' => $pedido,
            'horarioDescarga' => Option::where('meta_key', '=', 'nuevoHorario')->first(),
            'pedidoActive' => 'start active',
            'user_img' => $user_img,
            'logo_img' => 'logo_color.jpg'
        );
        return View::make('pedidos/pedido-print', $data);
    }

    public function pdf_pedido($id) {
        $this->create_pdf();
        exit;
    }

    function create_pdf($save = false) {
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
		 'P');  // L - landscape, P - portrait
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        //$url=  str_replace('pdf', 'print', Request::url()); 
		$slug='pdf';
		if($save)$slug='email';
        $url = str_replace($slug, 'print', Request::url() . '/?user_img=' . $this->generalData['current_user']->img);
		//dame($url,1);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        $mpdf->WriteHTML($content);
        if ($save) {
            $destinationPath = '../public/files';
            $mpdf->Output($destinationPath . '/filename.pdf', 'F');
            return;
        } else {
            $mpdf->Output();
            exit;
        }
    }

    public function ajax_set_estado_pedido() {
        if (Input::has('idPedido')) {
            $estado = Input::get('recibido') == 'r' ? 'rec' : 'pend';
            $pedido = Pedido::find(Input::get('idPedido'));

            $res = DB::table('pedidos')->where('id', Input::get('idPedido'))->update(array(
                'estadoPedido' => $estado
            ));
            $response = array(
                'status' => $res
            );
            return Response::json($response);
        }
    }

}