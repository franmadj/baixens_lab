<?php

class GeneralController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */
    
    function __construct() {
        parent::__construct();
        $this->checkUserAccess([1]);
    }

    public function get_index() {
        



        //$variables_generales=get_variables_generales();
        return View::make('generales', $this->get_variables_generales() + array('scroll' => "", 'generalesActive' => 'active', 'usuarios_select' => $this->getUserRoles()));
    }

    public function post_edit() {
        //$variables_generales=get_variables_generales();


        $horario = Input::get('nuevoHorario');
        if (isset($horario)) {
            if ($horario == '')
                $horario = ' ';
            if (!$option = Option::where('meta_key', '=', 'nuevoHorario')->first()) {
                $option = new Option();
            }
            $option->meta_value = $horario;
            if (!$option->save()) {
                $variables_generales = $this->get_variables_generales();

                $variables_generales['mensajeHorario'] = '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>';
            } else {
                $variables_generales = $this->get_variables_generales();
                $variables_generales['mensajeHorario'] = '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>';
            }
        }



        return View::make('generales', $variables_generales + array('scroll' => "", 'generalesActive' => 'active'));
    }

}
