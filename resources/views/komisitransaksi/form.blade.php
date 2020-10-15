@extends('adminlte::page')

@section('title', 'Form Batasan Penarikan Member')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $title }}</h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @include('components.flash_messages')
            <div class="card">
                <div class="card-body">
                    @if ($data == null)
                        {!! Form::open(['url' => url('affiliate/komisitransaksi'), 'method' => 'post']) !!}
                    @else
                        {!! Form::model($data, ['url' => url("affiliate/komisitransaksi/$data->id"), 'method' => 'put']) !!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('jenis_komisi', 'Jenis Komisi') !!}
                        {!! Form::text('jenis_komisi', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Jenis Komisi']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('besaran_komisi', 'Besaran Komisi') !!}
                        {!! Form::number('besaran_komisi', null, ['class'=>'form-control', 'placeholder'=>'Masukan Besaran Komisi yang didapatkan']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('jenis_besaran', 'Jenis Besaran Komisi') !!}
                        {!! Form::select('jenis_pesaran', ['rupiah' => 'Rupiah', 'persen' => 'Persen'], null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group text-right">
                        <input type="reset" value="Batal" class="btn btn-danger">
                        {!! Form::submit('Simpan Batasan Penarikan', ['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
