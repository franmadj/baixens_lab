<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
@include('layouts/head')
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="pedidos" >
			<img src="{{ url('img/logo.png') }}" alt="logo" height="20px;" class="" style="margin-top:-10px;" />
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="{{ url('assets/img/menu-toggler.png') }}" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
        
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<span class="username">
					{{ $generalData['current_user']->username }}
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="javascript:;" id="trigger_fullscreen">
							<i class="fa fa-arrows"></i> Pantalla completa
						</a>
					</li>
					<li>
						<a href="{{URL::to('logout')}}">
							<i class="fa fa-key"></i> Salir
						</a>
					</li>
				</ul>
			</li>
                        
			@if($generalData['admin_notifications']->count())

			<li class="nav-item dropdown dropdown-list">
				<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-toggle="dropdown" aria-expanded="false">
					<em class="fa fa-bell"></em>
					<span class="badge badge-danger">{{$generalData['admin_notifications']->count()}}</span>
				</a><!-- START Dropdown menu-->
                  <div class="dropdown-menu dropdown-menu-right animated flipInX">
                     <div class="dropdown-item">
                        <!-- START list group-->
                        <div class="list-group">
                           <!-- list item-->
                           @foreach($generalData['admin_notifications'] as $notification)
                           
                           <div class="list-group-item list-group-item-action">
                           	<span class="d-flex align-items-center">
                           		<a href="/edit-pintura/{{$notification->id}}">{{$notification->nombre}}</a>
                           	</span>
                           </div>
                           @endforeach
                        </div><!-- END list group-->
                     </div>
                  </div><!-- END Dropdown menu-->
               </li>
               @endif


			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	@include('layouts.sidebar')
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
        @yield('content')
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include('layouts/footer')
@yield('scripts')
</body>
<!-- END BODY -->
</html>