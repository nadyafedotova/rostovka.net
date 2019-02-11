@extends('admin.main')
@section('editingFilters')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Редактированиие категорий</h4>
                        </div>

                        <div class="typesBlock" style="margin-top: 30px;">
                            <table class="table table-striped">
                                <tbody>
                                    <tr data-id="0">
                                        <td class="articul productsArt" style="display: none;"><input value="0" disabled></td>
                                        <th class="Name">Главная</th>

                                        <td><a href="seo/0"><i class="table--icons ti-pencil type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Редактировать"></i></a></td>
                                    </tr>
                                @foreach($categories as $category)

                                    <tr data-id="{{$category -> id}}">
                                        <td class="articul productsArt" style="display: none;"><input value="{{$category -> id}}" disabled></td>
                                        <th class="Name">{{$category -> name}}</th>

                                        <td><a href="seo/{{$category -> id}}"><i class="table--icons ti-pencil type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Редактировать"></i></a></td>
                                    </tr>

                                    {{--{{url('seo/'.$category -> id)}}--}}
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

@section('filterPageLIb')
    <script src="{{url('js/admin/filterTypesLib.js?n=1')}}"></script>
@endsection