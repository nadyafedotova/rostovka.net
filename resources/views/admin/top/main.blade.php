@extends('admin.main')
@section('editingFilters')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Товары в топе</h4>
                        </div>
                        
                        <div class="row align-items-center h-100">
                            <div class="col-md-6">
                                <div class="typesBlock" style="margin-top: 30px;">
                                    @if ( $products )
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Фото</th>
                                                        <th>Название</th>
                                                        <th>До (включительно)</th>
                                                    </tr>
                                                </thead>
                                                @foreach($products as $key => $product)

                                                    <tr data-id="{{$product -> id}}" id="parent{{$product -> id}}">

                                                        <td> {{$key + 1}} </td>
                                                        <td style="max-width: 80px;">
                                                            @if($product -> photo )
                                                                <img style="width: 70%;margin-bottom: 30px;" src="{{url('/images/products/'. $product -> photo -> photo_url)}}" />
                                                                @endif
                                                        </td>

                                                        <td id="name{{$product -> id}}">{{$product -> name}}</td>

                                                        <td>{{$product -> expires}}</td>

                                                        <td style="width: 60px;"><a class="remove__order" href="#!">
		                                                    <i class="table--icons ti-close type-success" aria-label="Try me! Example: success modal" id="{{$product -> id}}" data-toggle="tooltip" title="Удалить"></i>
		                                                </a></td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else <p>Нет товаров</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: auto; margin-bottom: auto;">
                                @if($errors->any())
                                    <h4 class="back--error">{{$errors->first()}}</h4>
                                @endif
                                <div class="card card-block w-25">
                                    <div class="card-body">
                                        <h5 class="card-title">Поднять в топ</h5>
                                        <p class="card-text">Введите товар для поднятия на первую страницу раздела</p>
                                        <div class="form-group">
                                            <label for="usr">Название:</label>
                                            <input type="text" class="form-control" id="prod_name" placeholder="Название товара">
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">Дней:</label>
                                            <input type="number" class="form-control" id="days" placeholder="Дней в топе" step="1" min="1" max="30">
                                        </div>
                                        <button id="totop" class="btn btn-primary">В ТОП</button>
                                    </div>
                                </div>
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