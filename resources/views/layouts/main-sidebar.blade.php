<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img"
                            class="avatar avatar-xl brround"
                            src="{{URL::asset('assets/img/faces/'. Auth::user()->image )}}"
                            onerror="src='{{URL::asset('assets/img/faces/6.jpg')}}'"
                            >
                            <span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
							<span class="mb-0 text-muted">{{Auth::user()->email}}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">@lang('site.Main')</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('dashboard.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">@lang('site.dashboard')</span></a>
					</li>

                    @can('client')
                        <li class="side-item side-item-category">@lang('site.clients')</li>
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg><span class="side-menu__label">@lang('site.clients')</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('client-list')
                                <li><a class="slide-item" href="{{ route('dashboard.client.index') }}">@lang('site.clients')</a></li>
                                @endcan
                                @can('order-list')
                                <li><a class="slide-item" href="{{ route('dashboard.orders.index') }}">@lang('site.orders')</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('category')
                        <li class="side-item side-item-category">@lang('site.category')</li>
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg><span class="side-menu__label">@lang('site.category')</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('category-list')
                                <li><a class="slide-item" href="{{ route('dashboard.categories.index') }}">@lang('site.category')</a></li>
                                @endcan
                                @can('product-list')
                                <li><a class="slide-item" href="{{ route('dashboard.product.index') }}">@lang('site.product')</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('user')
                        <li class="side-item side-item-category">@lang('site.admins')</li>
                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg><span class="side-menu__label">@lang('site.admins')</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                @can('user-list')
                                <li><a class="slide-item" href="{{ route('dashboard.users.index') }}">@lang('site.admin')</a></li>
                                @endcan
                                @can('Permission-list')
                                <li><a class="slide-item" href="{{ route('dashboard.roles.index') }}">@lang('site.Permission') </a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

					
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
