@extends('layouts.main')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ Form::model($item, array(
                 'route'=>['user_update',$item->id],
                 'method'=>'PUT',
                 'accept-charset'=>'UTF-8',
                 'class'=>'form-horizontal'
         ))}}


    <div class="row">
        <div class="col-md-2">

            @include('layouts.includes.back_button')
        </div>

        <div class="col-md-8">
            <h2 style="text-align: center"> Editar utilizador: <b>{{$item->name}}</b></h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="form-group row">
                {{Form::label('name','Nome:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::text('name',null, ['class'=>'form-control','required','placeholder'=>'Nome'])}}
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('email','Email:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::email('email',null,['class'=>'form-control','placeholder'=>'Email','required'])}}
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('department_id','Departamento:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::select('department_id',$departments,null,['class'=>'form-control select2','required','data-placeholder'=>'Departamento'])}}
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('role_id','Permissão:',array('class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::select('role_id',$roles,$user_roles, ['class'=>'form-control select2','required','data-placeholder'=>'Selecione uma permissão'])}}
                </div>
            </div>

            {{Form::submit('guardar', ['class'=>'btn btn-success float-right'])}}
        </div>
    </div>
    {{ Form::close()}}


@stop
