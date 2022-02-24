@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    Inicio
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h3 class="card-label mb-0 text-body">
                            Bienvenido <strong> {{ ucfirst(Auth::user()->username) }} </strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection