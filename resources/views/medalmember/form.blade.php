@extends('adminlte::page')

@section('title', 'Level Member')

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
                        {!! Form::open(['method' => 'post', 'url' => 'affiliate/medalmember', 'files' => true]) !!}
                    @else
                        {!! Form::model($data, ['method'=>'put', 'url' => url("affiliate/medalmember/$data->id"), 'files' => true]) !!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('name_medal', 'Nama Medal') !!}
                        {!! Form::text('name_medal', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Medal', 'require' => 'true']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('reward_medal', 'Reward (%)') !!}
                        {!! Form::number('reward_medal', null, ['class' => 'form-control', 'placeholder' => 'Masukan Persentase Reward', 'min' =>  0, 'max' => 100]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('max_penarikan', 'Maximum Penarikan') !!}
                        {!! Form::number('max_penarikan', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nominal Maksimum Penarikan', 'min' => 0]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('min_saldo', 'Minimal Saldo Penarikan') !!}
                        {!! Form::number('min_saldo', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nominal Minimal Saldo Tersisa', 'min' => 0]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('persyaratan_medal', 'Persyaratan Medal') !!}
                        {!! Form::textarea('persyaratan_medal', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('icon_medal', 'Icon Medal' , ['class' => 'mr-2']) !!}
                        {!! Form::file('icon_medal', ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group text-right">
                        <input type="reset" value="Batal" class="btn btn-danger">
                        {!! Form::submit('Simpan Medal', ['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop
