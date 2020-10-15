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
                        {!! Form::open(['url' => url('affiliate/bonusgenerasi'), 'method' => 'post']) !!}
                    @else
                        {!! Form::model($data, ['url' => url("affiliate/bonusgenerasi/$data->id"), 'method' => 'put']) !!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('level_generasi', 'Level Generasi') !!}
                        {!! Form::number('level_generasi', null, ['class'=>'form-control', 'placeholder'=>'Masukan Level Generasi', 'min'=>1]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('bonus_persen', 'Bonus Persen') !!}
                        {!! Form::number('bonus_persen', null, ['class'=>'form-control', 'placeholder'=>'Masukan Bonus Persen', 'min'=>0, 'max'=> 100]) !!}
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
