@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Listado
                                    </h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('proveedors.add') }}" class="ml-2">
                                        <span class="bg-secondary h-30px font-size-h5 w-30px d-flex align-items-center justify-content-center  rounded-circle shadow-sm ">
                                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="bi bi-plus white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class=" table-responsive" id="printableTable">
                                    @include('admin.proveedors.table')
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

<script>
    jQuery(document).ready( function () {
        jQuery('#userTable').dataTable( {
        "pagingType": "simple_numbers",    
        "columnDefs": [ {
          "targets"  : 'no-sort',
          "orderable": false,
        }]
    });
    });

    jQuery('.show_confirm').on('click', function (event) {
        var form = jQuery(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: 'Confirma eliminar?',
            text: "No podrá reversar este movimiento !",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si borrar'
        }).then((result) => {
            if (result.value) {
                form.submit()
            }
        })
    });

</script>

@endsection