<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto">
    <div class="aside-menu-wrapper h-100 bg-dark ">
        <div id="tc_aside_menu" class="aside-menu mb-5">
            <div id="accordion">
                <ul class="nav">

                    <li class="nav-item"> <span class="nav-text"> &nbsp; </span> </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="svg-icon nav-icon"> <br /> </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('inicio')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class=" fa fa-home"> </i> </span>
                            <span class="nav-text"> Inicio </span>
                        </a>
                    </li>

                    @can('products.index')
                    <li class="nav-item" title="Lista de Productos">
                        <a href="{{url('productos')}}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-boxes"></i> </span>
                            <span class="nav-text"> Productos </span>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-item" title="Compra de Mercadería">
                        <a href="{{ route('ingresos.index') }}" class="nav-link">
                            <span class="svg-icon nav-icon"> <i class="fas fa-cart-arrow-down"></i> </span>
                            <span class="nav-text">Compras</span>
                        </a>
                    </li>

                    <li class="dropdown dropright">
                        <button type="button" class="btn dropdown-toggle text-black-50" data-toggle="dropdown" title="Salida de mercadería">
                            <i class="fas fa-dolly-flatbed"></i>
                        </button>
                        <div class="dropdown-menu bg-dark">
                            <a class="dropdown-item text-black-50" href="{{route('salidas.pendientes')}}">
                                Preparar salidas
                            </a>
                            <a class="dropdown-item text-black-50" href="{{route('salidas.index')}}">
                                Salidas finalizadas
                            </a>

                            <a class="dropdown-item text-black-50" href="{{route('senasa.index')}}">
                                Senasa
                            </a>

                            <a class="dropdown-item text-black-50" href="{{route('nc.index')}}">
                                Notas de crédito
                            </a>
                        </div>
                    </li>

                    <li class="nav-item" title="Proveedores">
                        <a href="{{url('proveedores')}}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-industry"></i>
                            </span>
                            <span class="nav-text"> Proveedores </span>
                        </a>
                    </li>
                    <li class="nav-item" title="Lista de Friotekas">
                        <a href="{{ url('tiendas') }}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-store"></i>
                            </span>
                            <span class="nav-text">Tiendas</span>
                        </a>
                    </li>
                    <li class="nav-item" title="Clientes">
                        <a href="{{ url('clientes') }}" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-user-friends"></i>
                            </span>
                            <span class="nav-text">Clientes</span>
                        </a>
                    </li>

                    <li class="dropdown dropright">
                        <button type="button" class="btn dropdown-toggle text-black-50" data-toggle="dropdown">
                            <i class="fas fa-shipping-fast text-black-50"></i>
                        </button>
                        <div class="dropdown-menu bg-dark">
                            <a class="dropdown-item" href="{{ route('rutas.index') }}">
                                <span class="text-black-50">Rutas</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('transportistas.index') }}">
                                <span class="text-black-50">Transportistas</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('vehiculos.index') }}">
                                <span class="text-black-50">Vehículos</span>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown dropright">
                        <button type="button" class="btn dropdown-toggle text-black-50" data-toggle="dropdown">
                            <i class="fas fa-cogs text-black-50"></i>
                        </button>
                        <div class="dropdown-menu bg-dark">
                            <a class="dropdown-item" href="{{ url('users') }}">
                                <span class="text-black-50"> Usuarios </span>
                            </a>

                            @role('superadmin')
                            <a class="dropdown-item" href="{{ route('roles.index') }}">
                                <span class="text-black-50"> Roles </span>
                            </a>
                            <a class="dropdown-item" href="{{ url('permissions') }}">
                                <span class="text-black-50"> Permisos </span>
                            </a>
                            @endrole
                        </div>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</div>