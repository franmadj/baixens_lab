

<div class="col-md-12" style="margin-bottom: 15px;">
    <button id="calcular_campos" class="btn btn-info btn-block" type="button">Calcular</button>
</div>

<table class="extra-campos">
    <tbody>
        <tr>
            <th></th>
            <th>Objetivo</th>
            <th>Teorico</th>
            <th>Pesado</th>
            <th>Medido</th>
        </tr>
        <tr>
            <td>% Sólidos</td>
            <td><input type="text" name="porcentaje_solidos_objetivo" class="form-control"
                       {{ isset($formula->porcentaje_solidos_objetivo)? 'value="'.trim($formula->porcentaje_solidos_objetivo).'"': ''  }}{{ (Input::old('porcentaje_solidos_objetivo')) ? 'value="'.Input::old('porcentaje_solidos_objetivo').'"' : '' }}/></td>
            <td>
                <input type="text" name="porcentaje_solidos_teorico" class="form-control porcentaje_solidos_teorico" readonly=""
                       {{ isset($formula->porcentaje_solidos_teorico)? 'value="'.trim($formula->porcentaje_solidos_teorico).'"': ''  }}{{ (Input::old('porcentaje_solidos_teorico')) ? 'value="'.Input::old('porcentaje_solidos_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="porcentaje_solidos_pesado" class="form-control porcentaje_solidos_pesado" readonly=""
                       {{ isset($formula->porcentaje_solidos_pesado)? 'value="'.trim($formula->porcentaje_solidos_pesado).'"': ''  }}{{ (Input::old('porcentaje_solidos_pesado')) ? 'value="'.Input::old('porcentaje_solidos_pesado').'"' : '' }}></td>
            <td class="porcentaje_solidos_medio">
                <input type="text" name="porcentaje_solidos_medio" class="form-control"
                       {{ isset($formula->porcentaje_solidos_medio)? 'value="'.trim($formula->porcentaje_solidos_medio).'"': ''  }}{{ (Input::old('porcentaje_solidos_medio')) ? 'value="'.Input::old('porcentaje_solidos_medio').'"' : '' }}/>
            </td>
        </tr>
        <tr>
            <td>% PVC</td>
            <td><input type="text" name="pvc_objetivo" class="form-control"
                       {{ isset($formula->pvc_objetivo)? 'value="'.trim($formula->pvc_objetivo).'"': ''  }}{{ (Input::old('pvc_objetivo')) ? 'value="'.Input::old('pvc_objetivo').'"' : '' }}/></td>
            <td>
                <input type="text" name="pvc_teorico" class="form-control pvc_teorico" readonly=""
                       {{ isset($formula->pvc_teorico)? 'value="'.trim($formula->pvc_teorico).'"': ''  }}{{ (Input::old('pvc_teorico')) ? 'value="'.Input::old('pvc_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="pvc_pesado" class="form-control pvc_pesado" readonly=""
                       {{ isset($formula->pvc_pesado)? 'value="'.trim($formula->pvc_pesado).'"': ''  }}{{ (Input::old('pvc_pesado')) ? 'value="'.Input::old('pvc_pesado').'"' : '' }}></td> 
            <td></td>
        </tr>
        <tr>
            <td>Densidad (g/mL)</td>
            <td><input type="text" name="densidad_objetivo" class="form-control densidad_objetivo"
                       {{ isset($formula->densidad_objetivo)? 'value="'.trim($formula->densidad_objetivo).'"': ''  }}{{ (Input::old('densidad_objetivo')) ? 'value="'.Input::old('densidad_objetivo').'"' : '' }}/></td>
            <td><input type="text" name="densidad_teorico" class="form-control densidad_teorico" readonly=""
                       {{ isset($formula->densidad_teorico)? 'value="'.trim($formula->densidad_teorico).'"': ''  }}{{ (Input::old('densidad_teorico')) ? 'value="'.Input::old('densidad_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="densidad_pesado" class="form-control densidad_pesado" readonly=""
                       {{ isset($formula->densidad_pesado)? 'value="'.trim($formula->densidad_pesado).'"': ''  }}{{ (Input::old('densidad_pesado')) ? 'value="'.Input::old('densidad_pesado').'"' : '' }}></td>
            <td class="densidad_medio">
                <input type="text" name="densidad_medio" class="form-control densidad_medido" 
                       {{ isset($formula->densidad_medio)? 'value="'.trim($formula->densidad_medio).'"': ''  }}{{ (Input::old('densidad_medio')) ? 'value="'.Input::old('densidad_medio').'"' : '' }}/>

            </td>
        </tr>
        <tr>
            <td>% TiO2</td>
            <td><input type="text" name="tio2_objetivo" class="form-control"
                       {{ isset($formula->tio2_objetivo)? 'value="'.trim($formula->tio2_objetivo).'"': ''  }}{{ (Input::old('tio2_objetivo')) ? 'value="'.Input::old('tio2_objetivo').'"' : '' }}/></td>
            <td><input type="text" name="tio2_teorico" class="form-control porcentaje_tio_teorico" readonly=""
                       {{ isset($formula->tio2_teorico)? 'value="'.trim($formula->tio2_teorico).'"': ''  }}{{ (Input::old('tio2_teorico')) ? 'value="'.Input::old('tio2_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="tio2_pesado" class="form-control porcentaje_tio_pesado" readonly=""
                       {{ isset($formula->tio2_pesado)? 'value="'.trim($formula->tio2_pesado).'"': ''  }}{{ (Input::old('tio2_pesado')) ? 'value="'.Input::old('tio2_pesado').'"' : '' }}></td>

            </td>
            <td></td>
        </tr>
        <tr>
            <td>% Ligante</td>
            <td><input type="text" name="ligante_objetivo" class="form-control"
                       {{ isset($formula->ligante_objetivo)? 'value="'.trim($formula->ligante_objetivo).'"': ''  }}{{ (Input::old('ligante_objetivo')) ? 'value="'.Input::old('ligante_objetivo').'"' : '' }}/></td>
            <td><input type="text" name="ligante_teorico" class="form-control porcentaje_ligante_teorico" readonly=""
                       {{ isset($formula->ligante_teorico)? 'value="'.trim($formula->ligante_teorico).'"': ''  }}{{ (Input::old('ligante_teorico')) ? 'value="'.Input::old('ligante_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="ligante_pesado" class="form-control porcentaje_ligante_pesado" readonly=""
                       {{ isset($formula->ligante_pesado)? 'value="'.trim($formula->ligante_pesado).'"': ''  }}{{ (Input::old('ligante_pesado')) ? 'value="'.Input::old('ligante_pesado').'"' : '' }}></td>

            </td>
            <td></td>
        </tr>
        <tr>
            <td>Precio (€/Kg)</td>
            <td><input type="text" name="precio_eu_kg_objetivo" class="form-control"
                       {{ isset($formula->precio_eu_kg_objetivo)? 'value="'.trim($formula->precio_eu_kg_objetivo).'"': ''  }}{{ (Input::old('precio_eu_kg_objetivo')) ? 'value="'.Input::old('precio_eu_kg_objetivo').'"' : '' }}/></td>
            <td><input type="text" name="precio_eu_kg_teorico" class="form-control precio_euro_kg_teorico" readonly=""
                       {{ isset($formula->precio_eu_kg_teorico)? 'value="'.trim($formula->precio_eu_kg_teorico).'"': ''  }}{{ (Input::old('precio_eu_kg_teorico')) ? 'value="'.Input::old('precio_eu_kg_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="precio_eu_kg_pesado" class="form-control precio_euro_kg_pesado" readonly=""
                       {{ isset($formula->precio_eu_kg_pesado)? 'value="'.trim($formula->precio_eu_kg_pesado).'"': ''  }}{{ (Input::old('precio_eu_kg_pesado')) ? 'value="'.Input::old('precio_eu_kg_pesado').'"' : '' }}></td>

            </td>
            <td></td>
        </tr>
        <tr>
            <td>Precio (€/L)</td>
            <td><input type="text" name="precio_eu_lt_objetivo" class="form-control"
                       {{ isset($formula->precio_eu_lt_objetivo)? 'value="'.trim($formula->precio_eu_lt_objetivo).'"': ''  }}{{ (Input::old('precio_eu_lt_objetivo')) ? 'value="'.Input::old('precio_eu_lt_objetivo').'"' : '' }}/></td>
            <td><input type="text" name="precio_eu_lt_teorico" class="form-control precio_euro_lt_teorico" readonly=""
                       {{ isset($formula->precio_eu_lt_teorico)? 'value="'.trim($formula->precio_eu_lt_teorico).'"': ''  }}{{ (Input::old('precio_eu_lt_teorico')) ? 'value="'.Input::old('precio_eu_lt_teorico').'"' : '' }}></td>
            <td>
                <input type="text" name="precio_eu_lt_pesado" class="form-control precio_euro_lt_pesado" readonly=""
                       {{ isset($formula->precio_eu_lt_pesado)? 'value="'.trim($formula->precio_eu_lt_pesado).'"': ''  }}{{ (Input::old('precio_eu_lt_pesado')) ? 'value="'.Input::old('precio_eu_lt_pesado').'"' : '' }}></td>

            </td>
            <td><input type="text" name="precio_eu_lt_medido" class="form-control precio_euro_lt_medido" readonly=""
                       {{ isset($formula->precio_eu_lt_medido)? 'value="'.trim($formula->precio_eu_lt_medido).'"': ''  }}{{ (Input::old('precio_eu_lt_medido')) ? 'value="'.Input::old('precio_eu_lt_medido').'"' : '' }}></td></td>
        </tr>
        <tr>
            <td>Viscosidad (cP)</td>
            <td><input type="text" name="viscosidad_objetivo" class="form-control"
                       {{ isset($formula->viscosidad_objetivo)? 'value="'.trim($formula->viscosidad_objetivo).'"': ''  }}{{ (Input::old('viscosidad_objetivo')) ? 'value="'.Input::old('viscosidad_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="viscosidad_medio" class="form-control" 
                       {{ isset($formula->viscosidad_medio)? 'value="'.trim($formula->viscosidad_medio).'"': ''  }}{{ (Input::old('viscosidad_medio')) ? 'value="'.Input::old('viscosidad_medio').'"' : '' }}/></td>
        </tr>
        
        
        <tr>
            <td>pH</td>
            <td><input type="text" name="ph_objetivo" class="form-control"
                       {{ isset($formula->ph_objetivo)? 'value="'.trim($formula->ph_objetivo).'"': ''  }}{{ (Input::old('ph_objetivo')) ? 'value="'.Input::old('ph_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="ph_medio" class="form-control" 
                       {{ isset($formula->ph_medio)? 'value="'.trim($formula->ph_medio).'"': ''  }}{{ (Input::old('ph_medio')) ? 'value="'.Input::old('ph_medio').'"' : '' }}/></td>
        </tr>
        
        
        <tr>
            <td>Brillo 60º</td>
            <td><input type="text" name="brillo_60_objetivo" class="form-control"
                       {{ isset($formula->brillo_60_objetivo)? 'value="'.trim($formula->brillo_60_objetivo).'"': ''  }}{{ (Input::old('brillo_60_objetivo')) ? 'value="'.Input::old('brillo_60_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="brillo_60_medio" class="form-control"
                       {{ isset($formula->brillo_60_medio)? 'value="'.trim($formula->brillo_60_medio).'"': ''  }}{{ (Input::old('brillo_60_medio')) ? 'value="'.Input::old('brillo_60_medio').'"' : '' }}/></td> 
        </tr>
        <tr>
            <td>Brillo 85º</td>
            <td><input type="text" name="brillo_85_objetivo" class="form-control"
                       {{ isset($formula->brillo_85_objetivo)? 'value="'.trim($formula->brillo_85_objetivo).'"': ''  }}{{ (Input::old('brillo_85_objetivo')) ? 'value="'.Input::old('brillo_85_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="brillo_85_medio" class="form-control"
                       {{ isset($formula->brillo_85_medio)? 'value="'.trim($formula->brillo_85_medio).'"': ''  }}{{ (Input::old('brillo_85_medio')) ? 'value="'.Input::old('brillo_85_medio').'"' : '' }}/>
            </td>
        </tr>
        <tr>
            <td>Tipo Brillo</td>
            <?php
                $tipoBrilloOld = (Input::old('tipo_brillo_objetivo')) ? Input::old('tipo_brillo_objetivo') : '';
                $tipoBrilloEdit = (isset($formula->tipo_brillo_objetivo)) ? trim($formula->tipo_brillo_objetivo) : '';
                $tipoBrilloObj = ($tipoBrilloOld!='') ? $tipoBrilloOld : $tipoBrilloEdit;
                ?>
            <td>{{ Form::select('tipo_brillo_objetivo', $tipoBrillos, $tipoBrilloObj,  array('class'=>'select2_category form-control', 'data-placeholder'=>'Tipo Brillo' )) }}</td>
            <td></td>
            <td></td>
            <td>
                <?php
                $tipoBrilloOld = (Input::old('tipo_brillo_medio')) ? Input::old('tipo_brillo_medio') : '';
                $tipoBrilloEdit = (isset($formula->tipo_brillo_medio)) ? trim($formula->tipo_brillo_medio) : '';
                $tipoBrillo = ($tipoBrilloOld!='') ? $tipoBrilloOld : $tipoBrilloEdit;
                ?>

                {{ Form::select('tipo_brillo_medio', $tipoBrillos, $tipoBrillo,  array('class'=>'select2_category form-control', 'data-placeholder'=>'Tipo Brillo' )) }}

            </td>

        </tr>
        



        <tr>
            <td>Cubrición</td>
            <td><input type="text" name="cubricion_objetivo" class="form-control"
                       {{ isset($formula->cubricion_objetivo)? 'value="'.trim($formula->cubricion_objetivo).'"': ''  }}{{ (Input::old('cubricion_objetivo')) ? 'value="'.Input::old('cubricion_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="cubricion_medio" class="form-control"
                       {{ isset($formula->cubricion_medio)? 'value="'.trim($formula->cubricion_medio).'"': ''  }}{{ (Input::old('cubricion_medio')) ? 'value="'.Input::old('cubricion_medio').'"' : '' }}/></td>
        </tr>
        <tr>
            <td>Resistencia Frote</td>
            <td><input type="text" name="res_flote_objetivo" class="form-control"
                       {{ isset($formula->res_flote_objetivo)? 'value="'.trim($formula->res_flote_objetivo).'"': ''  }}{{ (Input::old('res_flote_objetivo')) ? 'value="'.Input::old('res_flote_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="res_flote_medio" class="form-control"
                       {{ isset($formula->res_flote_medio)? 'value="'.trim($formula->res_flote_medio).'"': ''  }}{{ (Input::old('res_flote_medio')) ? 'value="'.Input::old('res_flote_medio').'"' : '' }}/></td>
        </tr>
        
        
        <tr>
            <td>Clase</td>
            <td><input type="text" name="clase_objetivo" class="form-control"
                       {{ isset($formula->clase_objetivo)? 'value="'.trim($formula->clase_objetivo).'"': ''  }}{{ (Input::old('clase_objetivo')) ? 'value="'.Input::old('clase_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td>
                
                <?php
                $claseMedidoOld = (Input::old('clase_medio')) ? Input::old('clase_medio') : '';
                $claseMedidoEdit = (isset($formula->clase_medio)) ? trim($formula->clase_medio) : '';
                $claseMedido = ($claseMedidoOld!='') ? $claseMedidoOld : $claseMedidoEdit;
                ?>
                {{ Form::select('clase_medio', $clasesMedidos, $claseMedido,  array('class'=>'select2_category form-control', 'data-placeholder'=>'Clase medido' )) }}

            </td>
        </tr>
        
        <tr>
            <td>Rendimiento</td>
            <td><input type="text" name="rendimiento_objetivo" class="form-control"
                       {{ isset($formula->rendimiento_objetivo)? 'value="'.trim($formula->rendimiento_objetivo).'"': ''  }}{{ (Input::old('rendimiento_objetivo')) ? 'value="'.Input::old('rendimiento_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="rendimiento_medio" class="form-control"
                       {{ isset($formula->rendimiento_medio)? 'value="'.trim($formula->rendimiento_medio).'"': ''  }}{{ (Input::old('rendimiento_medio')) ? 'value="'.Input::old('rendimiento_medio').'"' : '' }}/></td>
        </tr>
        
        
        
        
        <tr>
            <td>L</td>
            <td><input type="text" name="l_objetivo" class="form-control"
                       {{ isset($formula->l_objetivo)? 'value="'.trim($formula->l_objetivo).'"': ''  }}{{ (Input::old('v')) ? 'value="'.Input::old('l_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="l_medio" class="form-control" 
                       {{ isset($formula->l_medio)? 'value="'.trim($formula->l_medio).'"': ''  }}{{ (Input::old('l_medio')) ? 'value="'.Input::old('l_medio').'"' : '' }}/></td>
        </tr>
        <tr>
            <td>a</td>
            <td><input type="text" name="a_objetivo" class="form-control"
                       {{ isset($formula->a_objetivo)? 'value="'.trim($formula->a_objetivo).'"': ''  }}{{ (Input::old('a_objetivo')) ? 'value="'.Input::old('a_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="a_medio" class="form-control" 
                       {{ isset($formula->a_medio)? 'value="'.trim($formula->a_medio).'"': ''  }}{{ (Input::old('a_medio')) ? 'value="'.Input::old('a_medio').'"' : '' }}/></td>
        </tr>
        <tr>
            <td>b</td>
            <td><input type="text" name="b_objetivo" class="form-control"
                       {{ isset($formula->b_objetivo)? 'value="'.trim($formula->b_objetivo).'"': ''  }}{{ (Input::old('v')) ? 'value="'.Input::old('b_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="b_medio" class="form-control" 
                       {{ isset($formula->b_medio)? 'value="'.trim($formula->b_medio).'"': ''  }}{{ (Input::old('b_medio')) ? 'value="'.Input::old('b_medio').'"' : '' }}/></td>
        </tr>
        <tr>
            <td>Y</td>
            <td><input type="text" name="y_objetivo" class="form-control"
                       {{ isset($formula->y_objetivo)? 'value="'.trim($formula->y_objetivo).'"': ''  }}{{ (Input::old('v')) ? 'value="'.Input::old('y_objetivo').'"' : '' }}/></td>
            <td></td>
            <td></td>
            <td><input type="text" name="y_medio" class="form-control" 
                       {{ isset($formula->y_medio)? 'value="'.trim($formula->y_medio).'"': ''  }}{{ (Input::old('y_medio')) ? 'value="'.Input::old('y_medio').'"' : '' }}/></td>
        </tr>





    </tbody>
</table>

<hr>


@if(isset($formula))

<!-- END SAMPLE TABLE PORTLET-->
                    <div class="portlet box purple">
                        <div class="portlet-title">
                            <div class="caption">
                                Equivalencias, seleccionar.
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="hidden-xs" style="width:40px;">

                                            </th>
                                            <th>
                                                Nombre equivalencia
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($formula->FormulasEquivalencia as $formEq)
                                        <tr>
                                            <td style="padding:15px; text-align:right;">
                                                <input type="checkbox" class="eq-checked" <?php echo ($formEq->display) ? 'checked=""' : ''; ?> value="{{$formEq->id}}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" disabled="" value="{{$formEq->equivalencia}}" placeholder="Sale de base">
                                            </td>
                                        </tr>


                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
@endif


<button type="submit" class="btn btn-success" id="enviar_formula" tabindex="19">Aceptar</button>