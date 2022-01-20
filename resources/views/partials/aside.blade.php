<div>
    <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="tc_aside">

        <div class="brand flex-column-auto" id="tc_brand">
            <a href="{{url('/home')}}" class="brand-logo">
                <div class="brand-image">FTK </div>
                <span class="brand-text"><img style="height: 40px;margin-right:20px" alt="fenovo" src="{{asset('assets/images/misc/logo.png')}}" /></span>
            </a>
        </div>

        <div class="aside-menu-wrapper flex-column-fluid overflow-auto h-100" id="tc_aside_menu_wrapper">
            <div id="tc_aside_menu" class="aside-menu  mb-5" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                <div id="accordion">
                    <ul class="nav flex-column">

                        <li class="nav-item @if(Route::is('home') ) active @endif">
                            <a href="{{url('/home')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </span>
                                <span class="nav-text">
                                    Dashboard
                                </span>
                            </a>
                        </li>

                        <li class="nav-item @if(Route::is('product.*') ||Route::is('products.*') ) active @endif">
                            <a href="{{url('products')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-boxes font-size-h4"></i>
                                </span>
                                <span class="nav-text">
                                    Productos
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#catalogPurchase" role="button" aria-expanded="false" aria-controls="catalogPurchase">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-money-check-alt font-size-h4"></i>
                                </span>
                                <span class="nav-text">Movimientos</span>
                                <i class="fas fa-chevron-right fa-rotate-90"></i>
                            </a>
                            <div class="collapse nav-collapse" id="catalogPurchase" data-parent="#accordion">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="purchase-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">Ingresos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="purchase-add.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">Salidas</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="purchase-add.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                </svg>
                                            </span>
                                            <span class="nav-text">SENASA</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('proveedors')}}" class="nav-link">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-user-friends font-size-h4"></i>
                                </span>
                                <span class="nav-text">
                                    Proveedores
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#setting" role="button" aria-expanded="false" aria-controls="setting">
                                <span class="svg-icon nav-icon">
                                    <i class="fas fa-cogs font-size-h4"></i>
                                </span>
                                <span class="nav-text">Configuración</span>
                                <i class="fas fa-chevron-right fa-rotate-90"></i>
                            </a>
                            <div class="collapse nav-collapse" id="setting" data-parent="#accordion">
                                <div id="accordion3">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('stores') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Tiendas</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('customers') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Clientes</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('users') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Usuarios</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('roles') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Roles</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('permissions') }}" class="nav-link sub-nav-link">
                                                <span class="svg-icon nav-icon d-flex justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                    </svg>
                                                </span>
                                                <span class="nav-text">Permisos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
