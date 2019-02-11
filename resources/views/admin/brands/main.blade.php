@extends('admin.main')
@section('editingFilters')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Бренды</h4>
                    </div>
                    
                    <div class="row align-items-center h-100">
                        <div class="col-md-12">
                            <div class="typesBlock" style="margin-top: 30px;">
                                <table class="table table-striped table-bordered">
                                    <tbody>

                                        @foreach($brands as $key => $brand)

                                            <tr data-id="{{$brand -> id}}" id="parent{{$brand -> id}}">

                                                <td style="width: 60px;"> {{ $brand -> id }} </td>
                                                <td style="max-width: 80px;">
                                                    @if($brand -> photo )
                                                        <img style="max-height: 50px;" src="{{url('/images/brands/'. $brand -> photo)}}" />
                                                    @else
                                                        <input type="file" id="{{$brand -> id}}" data-filename-placement="inside" class="brandLogo" name="photo" title="Выбрать фотографии" accept="image/*">
                                                    @endif
                                                </td>

                                                <td id="name{{$brand -> id}}">{{$brand -> name}}</td>

                                                <td style="width: 60px;"><a href="brand/{{$brand -> id}}"><i class="table--icons ti-pencil type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Редактировать"></i></a></td>

                                                <td style="width: 60px;"><a class="remove__order" href="#!">
                                                    <i class="table--icons ti-close type-success"
                                                       aria-label="Try me! Example: success modal" id="{{$brand -> id}}" data-toggle="tooltip"
                                                       title="Удалить"></i>
                                                </a></td>

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
    </div>
@endsection

@section('filterPageLIb')
    <script src="{{url('js/admin/filterTypesLib.js?n=1')}}"></script>
    <script src="{{url('js/admin/brands.js')}}"></script>
@endsection