@extends('layouts.base')

@section('content')
<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            Baixens <small>aplicación formulación</small>
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="index.html">
                    Inicio
                </a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Acciónes generales
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->

<div class="row ">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        @if($generalData['current_user']->type==1)
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Horarios descarga de pedidos
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                @if($mensajeHorario)
                <div class="col-md-12" style="color:red;">{{$mensajeHorario}}</div>
                @endif
                <hr>
                <h4>Nuevo horario</h4>

                <form class="form-horizontal" role="form" method="post" action="{{URL::to('generales')}}">
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Horario</label>
                        <div class="col-md-10">
                            <textarea name="nuevoHorario" class="form-control" rows="3">{{ isset($nuevoHorario)?$nuevoHorario:''; }}</textarea>
                            <p class="form-control-static">
                                Este horario aparecerá en la ficha de pedidos
                            </p>
                        </div>
                    </div>


                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
        @endif
        <!-- END SAMPLE FORM PORTLET-->
        <!-- BEGIN SAMPLE FORM PORTLET-->
        @if($generalData['current_user']->type==1 || $generalData['current_user']->type==3)
        <div id="seccion" class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Secciones formulas
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <h4>Nueva sección</h4>
                @if(Session::has('mensajeSeccion'))
                <div class="col-md-12"  style="color:red;">{{Session::get('mensajeSeccion')}}</div>
                @endif

                <hr>
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{URL::to('add-seccion-formula')}}">
                    {{ isset($seccionFormula->id)?'<input type="hidden" name="idSeccion" value="'.$seccionFormula->id.'" />':'' }}
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre sección</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="seccionesFormula" {{isset($seccionFormula->seccion)?'value="'.$seccionFormula->seccion.'"':'' }} placeholder="Nombre sección">
                        </div>
                    </div>


                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Añadir</button>
                        </div>
                    </div>
                </form>

                <table class="table table-striped table-bordered table-hover table-full-width">
                    <thead>
                        <tr>
                            <td class="tdst-group-item">Sección</td> 
                            <td class="tdst-group-item" style="width:100px;">Editar</td> 
                            <td class="tdst-group-item" style="width:100px;">Borrar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($secciones as $seccion)
                        <tr>

                            <td>
                                {{ $seccion->seccion }}
                            </td>

                            <td>
                                @if($seccion->id != 1)
                                <a href="{{ URL::to('edit-seccion-formula')}}/{{ $seccion->id }}" class="btn btn-info btn-xs fullButton">Editar</a>
                                @endif
                            </td>
                            <td>
                                @if($seccion->id != 1)
                                <a onclick="return confirm('deseas borrar este registro?')" href="{{ URL::to('borrar-seccion-formula')}}/{{ $seccion->id }}" class="btn btn-danger btn-xs fullButton">Borrar</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        @endif
        <!-- END SAMPLE FORM PORTLET-->
        
        @if($generalData['current_user']->type==1)

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div id="formato" class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Pedido formatos
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <h4>Nueva formato</h4>
                @if(Session::has('mensajeFormato'))
                <div class="col-md-12"  style="color:red;">{{Session::get('mensajeFormato')}}</div>
                @endif
                <hr>
                <form class="form-horizontal" role="form" method="post" action="{{ URL::to('add-formato-pedido') }}">
                    {{ isset($formatoPedido->id)?'<input type="hidden" name="idFormato" value="'.$formatoPedido->id.'" />':'' }}
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre formato</label>
                        <div class="col-md-10">
                            <input name="formatoPedido" {{ isset($formatoPedido->formato) ? 'value="'.$formatoPedido->formato.'"' : '' }} type="text" class="form-control" id="inputEmail1" placeholder="Nombre formato">
                        </div>
                    </div>


                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Añadir</button>
                        </div>
                    </div>
                </form>

                <table class="table table-striped table-bordered table-hover table-full-width">
                    <thead>
                        <tr>
                            <td class="tdst-group-item">Formato</td> 
                            <td class="tdst-group-item" style="width:100px;">Editar</td> 
                            <td class="tdst-group-item" style="width:100px;">Borrar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formatos as $formato)
                        <tr>

                            <td>
                                {{ $formato->formato }}
                            </td>

                            <td>
                                <a href="{{URL::to('edit-formato-pedido')}}/{{ $formato->id }}" class="btn btn-info btn-xs fullButton">Editar</a>
                            </td>
                            <td>
                                <a onclick="return confirm('deseas borrar este registro?')" href="{{URL::to('borrar-formato-pedido')}}/{{ $formato->id }}" class="btn btn-danger btn-xs fullButton">Borrar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
        @endif

        <!-- BEGIN SAMPLE FORM PORTLET-->
        @if($generalData['current_user']->type==1)
        <div id="usuarios" class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    Solicitante de pedido y Usuario aplicación
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <h4>Solicitante de pedido y Usuario aplicación</h4>
                @if(Session::has('mensajeUsuarios'))
                <div class="col-md-12" style="color:red;">{{Session::get('mensajeUsuarios')}}</div>
                @endif
                <hr>
                <form method="post" action="{{ URL::to('add-usuario') }}" enctype="multipart/form-data" class="form-horizontal" role="form">

                    {{ isset($user->id)?'<input type="hidden" name="idUser" value="'.$user->id.'" />':'' }}
                    {{ Form::token() }}
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Nombre</label>
                        <div class="col-md-10">
                            <input name="nombre" {{ isset($user->nombre) ? 'value="'.$user->nombre.'"' : '' }} type="text" class="form-control" id="inputEmail1" placeholder="Nombre encargado/a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Usuario</label>
                        <div class="col-md-10">
                            <input name="username" {{ isset($user->username) ? 'value="'.$user->username.'"' : '' }} type="text" class="form-control" id="inputEmail1" placeholder="Usuario">

                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Tipo Usuario</label>
                        <div class="col-md-10">

                            <select name="type" class="select2_category form-control"><option value="">Tipo usuario<option>{{$usuarios_select}}</select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail1" class="col-md-2 control-label">Contraseña</label>
                        <div class="col-md-10">
                            <input name="password" type="password" class="form-control" id="inputEmail1" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Imagen firma</label>
                        <div class="col-md-10">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new">
                                            Selecciona imagen
                                        </span>
                                        <span class="fileinput-exists">
                                            Cambiar
                                        </span>
                                        <input type="file" name="image">
                                    </span>
                                    <a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
                                        Quitar
                                    </a>
                                </div>
                            </div>
                            <?php if (isset($user)) { ?>
                                <div class="imagen" style='float:right;'>
                                    {{ HTML::image('img/'.$user->img, 'Imagen usuario', array('width'=>'300', 'height'=>'auto')) }} </div>
                            <?php } ?>
                        </div>
                    </div>


                    <hr>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>

                <table class="table table-striped table-bordered table-hover table-full-width">
                    <thead>

                        <tr>
                            <td class="tdst-group-item">Nombre encargado/a</td> 
                            <td class="tdst-group-item">Usuario</td> 
                            <td class="tdst-group-item">Contraseña</td> 
                            <td class="tdst-group-item" style="width:100px;">Editar</td> 
                            <td class="tdst-group-item" style="width:100px;">Borrar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $myuser)
                        <tr>

                            <td>
                                {{ $myuser->nombre  }}
                            </td>

                            <td>
                                {{ $myuser->username  }}
                            </td>

                            <td>
                                contraseña
                            </td>

                            <td>
                                <a href="{{URL::to('edit-usuario')}}/{{ $myuser->id }}" class="btn btn-info btn-xs fullButton">Editar</a>
                            </td>
                            <td>
                                <a onclick="return confirm('deseas borrar este registro?')" href="{{URL::to('borrar-usuario')}}/{{ $myuser->id }}" class="btn btn-danger btn-xs fullButton">Borrar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        @endif


















        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- END PAGE CONTENT-->
@stop

@section('scripts')
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="{{ url('assets/plugins/jquery-1.10.2.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ url('assets/plugins/select2/select2.min.js') }}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ url('assets/scripts/core/app.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-form-tools.js') }}"></script>
<script src="{{ url('assets/scripts/custom/components-pickers.js') }}"></script>
<script src="{{ url('assets/scripts/custom/form-samples.js') }}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
                                    jQuery(document).ready(function () {
                                        // initiate layout and plugins
                                        App.init();
                                        FormSamples.init();
                                        {
                                            {
                                                $scroll
                                            }
                                        }
                                    });
</script>
@stop                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               