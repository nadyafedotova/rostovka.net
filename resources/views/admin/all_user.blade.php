

@extends('admin.main')
@section('all_user')
<div class="content mainPage--content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 admin--usersPage">
                <div class="card" style="padding-top: 10px;">
                    <div class="header" style="float: left;">
                        <h4 class="title">Список пользователей</h4>
                    </div>

                    <div class="span12 pull-right col-md-3 col-sm-12 col-xs-12">
                        <form id="custom-search-form" class="form-search form-horizontal pull-right col-sm-12 col-xs-12">
                            <div class="input-append col-sm-12 col-xs-12">
                                <input type="text" class="search-query col-sm-12 col-xs-12" placeholder="Поиск">
                                <button type="submit" class="btn"><i class="ti-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped" style="margin-top: 50px;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>E-mail</th>
                                <th>Телефон</th>
                                <th>Место проживания</th>
                                <th>Дата регистрации</th>
                                <th>Тип пользователя</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)

                                <tr>
                                    <td>{{$client -> id}}</td>
                                    <td>{{$client -> first_name}}</td>
                                    <td>{{$client -> last_name}}</td>
                                    <td>{{$client -> email}}</td>
                                    <td>{{$client -> phone}}</td>
                                    <td>{{$client -> city}}</td>
                                    <td>{{$client -> created_at}}</td>
                                    <td class="edit--Icons">@if($client -> type == "user")Покупатель @elseif($client -> type == "opt") <div class="userOpt">Оптовик</div> @elseif($client -> type == "admin") <div class="userAdmin">Админ</div> @elseif($client -> type == "moder") <div class="userModer">Модератор</div> @else Оптовик @endif <a href="{{url('/user_edit/'.$client -> id)}}"><i class="table--icons ti-pencil-alt" data-toggle="tooltip" title="Редактировать"></i></a> <a class="remove"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$clients -> links()}}
            </div>
        </div>
    </div>
</div>

    <script>
        $('.form-search button').on('click', function (e) {
            e.preventDefault();
            window.location = $('meta[name="root-site"]').attr('content') + '/admin_index/' + $('.search-query').val();
        });
    </script>

@endsection
