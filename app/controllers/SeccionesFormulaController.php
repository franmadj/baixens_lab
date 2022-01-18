<?php

class SeccionesFormulaController extends BaseController {

    protected $scroll = "document.getElementById('seccion').scrollIntoView();";
    protected $colors = [14 => '#DC143C',
        15 => '#8B5F65',
        16 => '#FF00FF',
        17 => '#8A2BE2',
        18 => '#0000FF',
        19 => '#104E8B',
        20 => '#00688B',
        21 => '#458B74',
        22 => '#FFA500',
        23 => '#EE6363',
        24 => '#9C9C9C'];

    public function get_edit($id) {
        if ($id == 1)
            return Redirect::to('generales');
        $seccionFormula = SeccionesFormula::where('id', '=', $id)->first();
        $data = array('seccionFormula' => $seccionFormula) + $this->get_variables_generales() + array('scroll' => $this->scroll, 'usuarios_select' => $this->tipos);
        return View::make('generales', $data);
    }

    public function get_delete($id) {
        if ($id == 1)
            return Redirect::to('generales');
        SeccionesFormula::destroy($id);
        return Redirect::to('generales')->with('mensajeSeccion', 'Registro Eliminado')->with('scroll', $this->scroll);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function post_create() {
        $input = Input::all();
        //$this->dame($input, 1);

        $rules = array(
            'seccionesFormula' => 'required',
        );



        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            //$this->dame($producto, 1);
            return Redirect::back()->withInput()->with('mensajeSeccion', '<div class="alert alert-warning">
                                        	<strong>Atención!! </strong> Hay campos sin rellenar .
                                    	</div>')->with('scroll', $this->scroll);
        } else {
            //$this->dame(Input::all(), 1);

            if (Input::has('idSeccion')) {//UPDATING
                if (Input::get('idSeccion') == 1)
                    return Redirect::to('generales');
                $seccionesFormula = SeccionesFormula::find(Input::get('idSeccion'));
            }else {
                $seccionesFormula = new SeccionesFormula();
            }
            $seccionesFormula->seccion = Input::get('seccionesFormula');
            if ($seccionesFormula->save()) {
                if (!Input::has('idSeccion')) {
                    $seccionesFormula->color = isset($this->colors[$seccionesFormula->id]) ? $this->colors[$seccionesFormula->id] : '#000';
                    $seccionesFormula->save();
                }
                return Redirect::to('generales')->with('mensajeSeccion', '<div class="alert alert-success">
                                        	<strong>Inserción con éxito!! </strong>
                                    	</div>')->with('scroll', $this->scroll);
            } else {
                return Redirect::to('generales')->with('mensajeSeccion', '<div class="alert alert-danger">
                                        	<strong>Error!! </strong> Inserción de datos incorrecta.
                                    	</div>')->with('scroll', $this->scroll);
            }
        }
    }

}
