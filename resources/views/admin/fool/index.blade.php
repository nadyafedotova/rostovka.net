@extends('admin.main')

@section('productsCss')
    <style>
        .file-input-wrapper{
            border-radius: 0;
            border: 1px solid #a6a6a6;
            background: #fff;
            float: left;
            padding: 5px 10px 4px 10px;
            margin-bottom: 10px;
            margin-right: 6px;
        }

        .file-input-wrapper:hover{
            background: transparent;
        }
    </style>
@endsection

@section('editingFilters')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-md-12">
                            <div class="header">
                                <h4 class="title">Проблемные заказчики</h4>

                                <p>Загрузить список:</p>
                                <input type="file" id="foolsList" data-filename-placement="inside" name="fools" title="Выбрать XLS" accept=".xls, .xlsx" class="col-md-5 col-sm-12 col-xs-12">
                                <button id="foolsSubmit">Загрузить</button>
                                <button id="foolsAdd">Добавить вручную</button>
                            </div>
                        </div>

                        <div class="content table-responsive table-full-width" style="margin: 150px 0 0 0; padding: 0; overflow: unset;">
                            <table class="table table-striped">
                                <tbody>
                                    @foreach($fools as $fool)

                                        <tr id="parent{{$fool -> id}}" data-id="{{$fool -> id}}">
                                            <td class="Name" id="name{{$fool -> id}}">{{$fool -> name}}</td>
                                            @if ($fool -> reason) <td>{{ $fool -> reason }}</td>
                                            @else <td>Причина добавления не указана</td>
                                            @endif
                                            <td><a class="remove__fool" id="{{ $fool -> id }}" href="#!"><i id="{{ $fool -> id }}" class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('productsLib')
    <script src="{{url('js/admin/bootstrap.file-input.js?n=1')}}"></script>
    <script>
        $( document ).ready(() => {
            $('input[type=file]').bootstrapFileInput();
        });
    </script>
    <script src="{{url('js/admin/fools.js')}}"></script>
@endsection