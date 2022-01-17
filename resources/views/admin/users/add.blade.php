@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid addproduct-main">

        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-white border-0">

                    <div class="card-header align-items-center  border-0">
                        <div class="card-title mb-0">
                            <h3 class="card-label mb-0 font-weight-bold text-body">Agregar nuevo usuario</h3>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                @include('admin.users.form-details')
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
<script src="{{asset('assets/api/select2/select2.min.js')}}"></script>
<script>
    jQuery("#btn-guardar-user").click(function(){
            var elements = document.querySelectorAll('.is-invalid');
            var form = jQuery('#formUser').serialize();

            jQuery.ajax({
                url:"{{ route('users.store') }}",
                type:'POST',
                data:form,
                beforeSend: function() {
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].classList.remove('is-invalid');
                    }
                },
                success:function(data){
                    if(data['type'] == 'success'){
                        Swal.fire({
                            title: "Exito!",
                            html: data['msj'],
                            type: "success",
                            confirmButtonClass: "btn btn-primary",
                            buttonsStyling: !1
                        }).then((value) => {
                            setTimeout(function(){ document.getElementById("formUser").reset(); },0);
                        });                      

                    }else{
                        Swal.fire({
                            title: "Error!",
                            html: data['msj'],
                            type: "error",
                            confirmButtonClass: "btn btn-primary",
                            buttonsStyling: !1
                        }) ;
                    }
                },
                error: function (data) {
                    var lista_errores="";
                    var data = data.responseJSON;
                    jQuery.each(data.errors,function(index, value) {
                        lista_errores+=value+'<br />';
                        jQuery('#'+index).addClass('is-invalid');
                    });
                    Swal.fire({
                        title: "Error!",
                        html: lista_errores,
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                }
            });

        });
</script>
@endsection