<?php

class ProveedorController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->checkUserAccess([1, 2]);
    }

    public function listProveedores() {
//                $proveedores= Proveedor::with('producto')->get();
//                ddd($proveedores);
        //$proveedores = Proveedor::all();//proveedoresActive
        $proveedores = DB::table('proveedores')->select('*')->orderBy('nombre', 'asc')->get();
        //dame($proveedores);
        return View::make('proveedores/proveedores-list', array('proveedores' => $proveedores, 'proveedoresActive' => 'active'));
    }

    public function verProveedor($id) {
        $proveedor = Proveedor::where('id', '=', $id)->first();
        $productos = DB::table('productos')->select('*')->orderBy('codigo', 'asc')->where('idProveedor', $proveedor->id)->get();


        return View::make('proveedores/proveedores-view', array('proveedor' => $proveedor, 'proveedoresActive' => 'active', 'productos' => $productos));
    }

    public function editProveedorGet($id) {
        $proveedor = Proveedor::where('id', '=', $id)->first();
        return View::make('proveedores/proveedores-edit', array('proveedor' => $proveedor, 'proveedoresActive' => 'active'));
    }

    public function addProveedorGet() {

        return View::make('proveedores/proveedores-add', array('proveedor' => array(), 'proveedoresActive' => 'active'));
    }

    public function delProveedor($id) {
        //$event = Event::fire('proveedor.del', array(Proveedor::find($id)));
        Proveedor::destroy($id);
        return Redirect::to('proveedores');
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function addProveedorPost() {
        $input = Input::all();
        //$this->dame($input, 1);


        $rules = array(
            'nombre' => 'required',
            'domicilio' => 'required',
            'cp' => 'required',
            'poblacion' => 'required',
            'ciudad' => 'required',
            'pais' => 'required',
            'tel' => 'required',
            'fax' => 'required',
            'email' => 'required',
            'contacto' => 'required',
            'datosInteres' => 'required',
            'telPedidos' => 'required',
            'faxPedidos' => 'required',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with('mensaje', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>');
        } else {

            $updating = false;
            if (Input::has('id')) {
                $updating = true;
                $proveedor = Proveedor::find(Input::get('id'));
            } else {
                $proveedor = new Proveedor();
            }
            $proveedor->nombre = Input::get('nombre');
            $proveedor->domicilio = Input::get('domicilio');
            $proveedor->cp = Input::get('cp');
            $proveedor->poblacion = Input::get('poblacion');
            $proveedor->ciudad = Input::get('ciudad');
            $proveedor->pais = Input::get('pais');
            $proveedor->tel = Input::get('tel');
            $proveedor->fax = Input::get('fax');
            $proveedor->email = Input::get('email');
            $proveedor->contacto = Input::get('contacto');
            $proveedor->datosInteres = Input::get('datosInteres');
            $proveedor->telPedidos = Input::get('telPedidos');
            $proveedor->faxPedidos = Input::get('faxPedidos');
            $proveedor->save();
            return Redirect::to('proveedores');
        }
    }

}
