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
                 'route'=>'task_store',
                 'method'=>'POST',
                 'accept-charset'=>'UTF-8',
                 'class'=>'form-horizontal'
         ))}}

    <div class="row">
        <div class="col-md-2">
            @include('layouts.includes.back_button')
        </div>

        <div class="col-md-8">
            <h2 style="text-align: center"> Criar uma nova tarefa</h2>
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
                {{Form::label('description','Descrição:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::textarea('description',null, ['class'=>'form-control','placeholder'=>'Descrição'])}}
                </div>
            </div>

            <div class="form-group row">
                {{Form::label('priority','Prioridade:',array('id'=>'','class'=>'col-lg-1 col-form-label'))}}
                <div class="col-lg-11">
                    {{Form::select('priority',[null=>null]+$priorities,null, ['class'=>'form-control select2','required','data-placeholder'=>'Selecione uma prioridade'])}}
                </div>
            </div>


            {{Form::submit('criar tarefa', ['class'=>'btn btn-success float-right'])}}

        </div>

    </div>
    {{ Form::close()}}
@stop
