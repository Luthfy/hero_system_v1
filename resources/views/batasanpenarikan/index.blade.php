@extends('adminlte::page')

@section('title', 'Batasan Penarikan Member')

@section('content_header')
    <h1 class="m-0 text-dark">Master Batasan Penarikan Member</h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @include('components.flash_messages')
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}

<script>
    function delete_batasan_penarikan(id)
    {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Ini tidak akan dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, hapus sekarang!'
        }).then((result) => {

            if (result.value) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })

                $.ajax({
                    type : "DELETE",
                    url : "batasanpenarikan/"+id,
                    success : function(data, status) {
                        console.log(data)
                        setTimeout(function(){$('#batasanpenarikan-table').DataTable().ajax.reload();}, 1000);
                        Swal.fire(
                            'Dihapus!',
                            'Batasan Penarikan telah dihapus',
                            'success'
                        )
                    },
                    error : function (xhr) {
                        Swal.fire(
                            'Gagal!',
                            'Batasan Penarikan gagal dihapus',
                            'error'
                        )
                    }
                });

            }
        })
    }
</script>
@endpush

