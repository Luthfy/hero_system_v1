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
                        {!! Form::open(['url' => 'affiliate/levelmember', 'method' => 'post']) !!}
                    @else

                    @endif

                    <div class="form-group">
                        {!! Form::label('name_level_member', 'Nama Level Member') !!}
                        {!! Form::text('name_level_member', null, ['class'=>'form-control', 'placeholder'=>'Masukan Nama Level Member']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('poin_level_member', 'Poin') !!}
                        {!! Form::number('poin_level_member', null, ['class'=>'form-control', 'placeholder'=>'Masukan Nama Level Member', 'min'=>0, 'step'=>500]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('bonus_sponsor', 'Bonus Sponsor (%)') !!}
                        {!! Form::number('bonus_sponsor', null, ['class'=>'form-control', 'placeholder'=>'Masukan Nama Level Member', 'min'=>0, 'max'=>100, 'step'=> 1]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description_level_member', 'Deskripsi') !!}
                        {!! Form::textarea('description_level_member', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group text-right">
                        <input type="reset" value="Batal" class="btn btn-danger">
                        {!! Form::submit('Simpan Level Member', ['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
