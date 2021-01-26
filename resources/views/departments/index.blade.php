@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.includes.back_button')
        </div>
        <div class="col-md-8">

            <h2 style="text-align: center">
                Departamentos
                <small>Lista</small>
            </h2>
        </div>
        @hasanyrole('admin')
        <div class="col-md-2">
            <h2>
                <a href="{{route('department_create')}}" type="button" class="btn btn-success float-right "><i
                        class="nav-icon fas fa-plus-square"></i> criar departamento</a>
            </h2>
        </div>
        @endhasanyrole
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped dataTables" style="width:100%">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    @hasanyrole('admin')
                    <th>Ações</th>
                    @endhasanyrole
                </tr>
                </thead>
                <tbody>

                @foreach($items as $item)
                    <tr id="tr_{{$item->id}}">
                        <td>{{$item->name}}</td>
                        <td>{{$item->description ? :''}}</td>
                        <td>
                            @hasanyrole('admin')
                            <a href="{{route('department_edit',$item->id)}}" data-widget="edit" data-toggle="tooltip"
                               title="" data-original-title="Edit">
                                <i class="fas fa-edit text-primary"></i>
                            </a>

                            <a href=""
                               data-department-name="{{$item->name}}" data-trid="{{$item->id}}" onclick="$('.modal-department-name').text($(this).data('department-name'));
                                            $('#confirm-delete').data('trid', $(this).data('trid'))" data-toggle="modal"
                               data-target="#deleteDepartmentModal">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                            @endhasanyrole
                        </td>
                    </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    @hasanyrole('admin')
                    <th>Ações</th>
                    @endhasanyrole
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- Modal delete User -->
    <div class="modal" id="deleteDepartmentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-department-name"></h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <h5>Está preste a eliminar este departmento!</h5>
                    <h5>Tem a certeza?</h5>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-left" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" id="confirm-delete" data-trid="">Apagar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>

        $("#confirm-delete").on("click", function () {

            let trid = $(this).data('trid');

            if (trid) {
                $.ajax({
                    type: "DELETE",
                    url: "/departments/" + trid + "/delete",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                })
                    .done(function () {
                        //location.reload();
                        $("#deleteDepartmentModal").modal('hide');
                        $('#tr_' + trid).hide('slow');
                    })
                    .fail(function () {
                        alert("error");
                    })
            } else {
                alert("error");
            }

        });
    </script>

@endsection
