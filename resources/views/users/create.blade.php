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


    {{ Form::open(array(
                 'route'=>'user_store',
                 'method'=>'POST',
                 'accept-charset'=>'UTF-8',
                 'class'=>'form-horizontal'
         ))}}

    <div class="row">
        <div class="col-md-2">
            @include('layouts.includes.back_button')
        </div>

        <div class="col-md-8">
            <h2 style="text-align: center"> Criar um novo utilizador</h2>
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
                {{Form::label('email','Email:',array('id'=>'','class'=>'col-lg-1 control-label'))}}
                <div class="col-lg-11">
                    {{Form::email('email',null,['class'=>'form-control','placeholder'=>'Email','required'])}}
                </div>
            </div>

            <div class="form-group row">
                <label for="password" id="" class="col-lg-1 col-form-label">Password:</label>
                <div class="col-lg-11">
                    <input name="password" type="password" id="password" placeholder="Password" class="form-control"
                           required>
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('department_id','Departamento:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::select('department_id',[null=>null]+$departments,null, ['class'=>'form-control select2','required','data-placeholder'=>'Selecione um Departamento'])}}
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('role_id','Permissão:',array('class'=>'col-lg-1 control-label'))}}
                <div class="col-lg-11">
                    {{Form::select('role_id',[null=>null]+$roles,null, ['class'=>'form-control select2','required','data-placeholder'=>'Selecione uma permissão'])}}
                </div>
            </div>

            {{Form::submit('criar utilizador', ['class'=>'btn btn-success float-right'])}}

        </div>

    </div>
    {{ Form::close()}}
@stop
