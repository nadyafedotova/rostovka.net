@section('suppliersCss')
    <link href="{{url('css/admin/products.css')}}" rel="stylesheet">
@endsection

@extends('admin.main')
@section('suppliers_container')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Список поставщиков</h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <div class="span12 pull-right">
                                <form id="custom-search-form" class="form-search form-horizontal pull-right">
                                    <div class="input-append span12">
                                        <input type="text" class="search-query" placeholder="Поиск">
                                        <button type="submit" class="btn"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Поставщик</th>
                                    <th>Улица</th>
                                    <th>Номер <br/> контейнера</th>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>Телефон</th>
                                    <th>Cкидка</th>
                                    <th>Курс доллара</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($manufacturers as $manufacturer)

                                    <tr data-id="{{$manufacturer -> id}}">
                                        <td class="articul productsArt" style="display: none;"><input value="{{$manufacturer -> id}}" disabled></td>
                                        <th>{{$manufacturer -> name}}</th>
                                        <th>{{$manufacturer -> street}}</th>
                                        <th>{{$manufacturer -> numberContainer}}</th>
                                        <th>{{$manufacturer -> firstName}}</th>
                                        <td>{{$manufacturer -> secondName}}</td>
                                        <td>{{$manufacturer -> phone}}</td>
                                        <td>{{$manufacturer -> discount}}</td>
                                        <td>@if($manufacturer -> koorse > 1) {{$manufacturer -> koorse}} @else - @endif</td>
                                        <td><a class="remove__product" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a><a href="{{url('/suppliers_edit/'.$manufacturer -> id)}}"><i class="table--icons ti-pencil-alt" data-toggle="tooltip" title="Редактировать"></i></a> </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{$manufacturers->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('suppliersLib')
    <script src="{{url('js/suppliers.js?n=1')}}"></script>
@endsection
