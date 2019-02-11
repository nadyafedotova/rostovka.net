@extends('admin.main')
@section('editingFilters')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Редактированиие фильтров</h4>
                        </div>

                        <div class="content table-responsive table-full-width">
                            <div class="typesBlock" style="margin-top: 30px; padding: 0; float: left; width: 50%">
                                <table class="table table-striped">
                                    <tbody>
                                    @foreach($types as $type)

                                        <tr data-id="{{$type -> id}}">
                                            <td class="articul productsArt" style="display: none;"><input value="{{$type -> id}}" disabled></td>
                                            <th class="Name">{{$type -> name}}</th>
                                            <td>Количество товаров: {{$type -> productsCount}}</td>
                                            <td><a href="/type/{{$type -> id}}"><i class="table--icons ti-pencil type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Редактировать"></i></a></td>
                                            <td><a class="remove__product" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></td>
                                        </tr>

                                        {{--{{url('type/'.$type -> id)}}--}}
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>


                            <div class="seasons" style="margin-top: 30px; padding: 0; float: left; width: 50%">
                                <table class="table table-striped">
                                    <tbody>
                                    @foreach($seasons as $season)

                                        <tr data-id="{{$season -> id}}">
                                            <td class="articul productsArt" style="display: none;"><input value="{{$season -> id}}" disabled></td>
                                            <th class="Name">{{$season -> name}}</th>
                                            <td>Количество товаров: {{$season -> productsCount}}</td>
                                            <td><a class="remove__product" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></td>
                                        </tr>
                                        {{--{{url('seasonRemove/'.$season -> id)}}--}}

                                    @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('filterPageLIb')
    <script src="{{url('js/admin/filterTypesLib.js?n=1')}}"></script>
@endsection