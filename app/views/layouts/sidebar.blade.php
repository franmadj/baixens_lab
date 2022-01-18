<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>

            @if($generalData['current_user']->type==1 || $generalData['current_user']->type==2)

            <li class="start ">
                @if($generalData['current_user']->type==1)
                <a href="{{ URL::to('/formulas') }}">
                    @else
                    <a href="{{ URL::to('/pedidos') }}">
                        @endif
                        <i class="fa fa-home"></i>
                        <span class="title">
                            Inicio
                        </span>
                    </a>
            </li>

            <li class="{{ isset($proveedoresActive) ? $proveedoresActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Proveedores
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/proveedores') }}">
                            <i class="fa fa-eye"></i>
                            Ver
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-proveedor') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar
                        </a>
                    </li>

                </ul>
            </li>





            <li class="{{ isset($pedidoActive) ? $pedidoActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Pedidos
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/pedidos') }}">
                            <i class="fa fa-eye"></i>
                            Ver
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-pedido') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar
                        </a>
                    </li>

                </ul>
            </li>
            @endif



            @if($generalData['current_user']->type==1)
            <!-- FORMULAS -->
            <li  class="{{ isset($formulaActive) ? $formulaActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Formulas
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/formulas') }}">
                            <i class="fa fa-eye"></i>
                            Ver
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-formula') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-formula-valoracion') }}">
                            <i class="fa fa-pencil"></i>
                            Valorar F.O.
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/formulas-valoracion') }}">
                            <i class="fa fa-eye"></i>
                            Ver valorar F.O.
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/informes-formulas-valoracion') }}">
                            <i class="fa fa-pencil"></i>
                            Informe pro. formula
                        </a>
                    </li>


                    <li>
                        <a href="{{ URL::to('/add-formula-base-hija-pre') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar Coloreada
                        </a>
                    </li>
                </ul>



            </li>
            <!-- GENERALES -->


            <li class="last {{ isset($generalesActive) ? $generalesActive : '' ;}}">
                <a href="{{ URL::to('/generales') }}">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Acciónes generales
                    </span>
                </a>
            </li>
            @endif  

            @if($generalData['current_user']->type==3)

            <li class="last {{ isset($generalesActive) ? $generalesActive : '' ;}}">
                <a href="{{ URL::to('/generales') }}">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Secciones
                    </span>
                </a>
            </li>

            @endif

            <!--

           

           <li  class="{{ isset($formulaBaseActive) ? $formulaBaseActive : '' ;}}">
               BASES 
               <a href="javascript:;">
                   <i class="fa fa-th"></i>
                   <span class="title">
                       Formulas Base
                   </span>
                   <span class="arrow ">
                   </span>
               </a>
               <ul class="sub-menu">
                   <li>
                       <a href="{{ URL::to('/formulas-base') }}">
                           <i class="fa fa-eye"></i>
                           Ver
                       </a>
                   </li>
                   <li>
                       <a href="{{ URL::to('/add-formula-base') }}">
                           <i class="fa fa-pencil"></i>
                           Insertar
                       </a>
                   </li>
               </ul>
           </li>

          
            -->

            @if($generalData['current_user']->type==3 || $generalData['current_user']->type==4)
            <!-- FORMULAS COLOREADAS -->

            <li class="{{ isset($formulaActive) ? $formulaActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Formulas Coloreadas
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/formulas-pinturas') }}">
                            <i class="fa fa-eye"></i>
                            Ver Coloreadas
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-formula-base-hija-pre') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar Coloreadas
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/formulas-base') }}">
                            <i class="fa fa-eye"></i>
                            Ver Bases
                        </a>
                    </li>
                </ul>
            </li>


            <!-- SATE -->

            <li class="{{ isset($sateActive) ? $sateActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        SATE
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/sate') }}">
                            <i class="fa fa-eye"></i>
                            Ver
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-sate') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar
                        </a>
                    </li>

                </ul>
            </li>




            @endif

            @if($generalData['current_user']->type==1 || $generalData['current_user']->type==3)

            <!-- PINTURAS -->

            <li class="{{ isset($pinturasActive) ? $pinturasActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Pinturas
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/pinturas') }}">
                            <i class="fa fa-eye"></i>
                            Ver Pinturas
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-pintura') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar Pinturas
                        </a>
                    </li>

                </ul>
            </li>




            @endif

            @if($generalData['current_user']->type!=4)

            <!-- PRODUCTOS -->

            <li class="{{ isset($productosActive) ? $productosActive : '' ;}}">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">
                        Productos
                    </span>
                    <span class="arrow ">
                    </span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ URL::to('/productos') }}">
                            <i class="fa fa-eye"></i>
                            Ver
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('/add-producto') }}">
                            <i class="fa fa-pencil"></i>
                            Insertar
                        </a>
                    </li>

                </ul>
            </li>

            @endif

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>