<?php

class FormatosPedidoController extends BaseController {
	

        
        protected $scroll="document.getElementById('formato').scrollIntoView();";
        
        public function get_edit($id)
	{	
		$formatosPedido = FormatosPedido::where('id', '=', $id)->first();
                $data=array('formatoPedido'=> $formatosPedido)+$this->get_variables_generales()+array('scroll'=>$this->scroll);
          
		return View::make('generales', $data);      
	}
        
        
        
        
        
        
        
        public function get_delete($id){
            $ped_det=  PedidosDetalle::where('idFormatoPedido', '=', $id)->first();
            if(!$ped_det){
                FormatosPedido::destroy($id);
            }else{
                
                $formmatosPedido = FormatosPedido::find($id); 
                $formmatosPedido->desactivado = 1;
		$formmatosPedido->save();
                
                
            }
            return Redirect::to('generales')->with('mensajeFormato', '<div class="alert alert-success">
                                        	<strong>Registro Eliminado!! </strong>
                                    	</div>')->with('scroll', $this->scroll);
        }


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function post_create()
	{
		$input = Input::all();
                //$this->dame($input, 1);

		$rules = array(
                    'formatoPedido' => 'required',   
		);
		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withInput()->with('mensajeFormato', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>')->with('scroll', $this->scroll);
		}
		else
		{
			//$this->dame(Input::all(), 1);
                        
                        if (Input::has('idFormato')){//UPDATING
                            $formmatosPedido = FormatosPedido::find(Input::get('idFormato'));  
                        }else{
                            $formmatosPedido = new FormatosPedido();
                        }
			$formmatosPedido->formato = Input::get('formatoPedido');
			if($formmatosPedido->save()){
                            return Redirect::to('generales')->with('mensajeFormato', '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>')->with('scroll', $this->scroll);
                        }else{
                            return Redirect::to('generales')->with('mensajeFormato', '<div class="alert alert-danger">
                                        	<strong>Error!! </strong> Inserción de datos incorrecta.
                                    	</div>')->with('scroll', $this->scroll);
                        }

			
		}
	}
        
        
	
	

}
