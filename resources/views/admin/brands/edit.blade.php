@section('edit_userCss')
    <link href="{{url('css/admin/edit-user.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">
@endsection

@extends('admin.main')
@section('edit_user')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Сео Категории - <b>{{$brand -> name}}</b></h4>
                                </div>
                                <div class="content">
                                    @if($errors->any())
                                        <h4 class="back--error">{{$errors->first()}}</h4>
                                    @endif
                                    <form method="POST" action="{{route('adminUpdBrands')}}">

                                        {{csrf_field()}}
                                        <input name="lenght" type="hidden" value="{{ $mans -> count() }}">
                                        <input type="hidden" name="brand_id" value="{!! $brand -> id !!}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ID</label>
                                                    <input class="form-control border-input" data-userid="{{$brand -> id}}" disabled="" type="text" value="{{$brand -> id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-11 product--add">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Название</label>
                                                        <input class="form-control border-input" name="name" type="text" placeholder="Name..." data-userEmail="stree" value="{{$brand -> name}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="card" style="width: 18rem;">
                                                    @if ($brand -> photo)
                                                        <img class="card-img-top" src="{{url('/images/brands/'. $brand -> photo)}}" alt="Card image cap" style="width: 180px;"/>
                                                    @endif
                                                    <div class="card-body">
                                                        <h5 class="card-title">Загрузить фото</h5>
                                                        <input type="file" id="{{$brand -> id}}" data-filename-placement="inside" class="brandLogo" name="photo" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Title</label>
                                                    <input class="form-control border-input" name="title" type="text" placeholder="Title..." data-userContainer="containerNam" value="{{$brand -> title}}">
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Keywords</label>
                                                    <input class="form-control border-input" name="keywords" type="text" placeholder="Keywords..." data-userContainer="containerNam" value="{{$brand -> keywords}}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Description</label>
                                                    <textarea id="text" class="form-control border-input" name="description" type="text" rows="4" placeholder="Description..." data-userContainer="containerNam">{{$brand -> description}}</textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Доступность</label>
                                                        <select class="form-control border-input" name="show_all" data-userContainer="containerNam">
                                                            <option value="1" @if($brand -> show_all)selected @endif>Для всех</option>
                                                            <option value="0" @if(!$brand -> show_all)selected @endif>Для конкретных пользователей</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach( $mans as $key => $man ) 
                                                <div class="row specman" id="parent{{$key+1}}">
                                                    <input type="hidden" name="man_id{{$key + 1}}" value="{{ $man -> id }}_{{ $brand -> id }}">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="man1">Пользователь</label>
                                                            <select id="man1" name="man{{$key + 1}}" class="form-control">
                                                                @foreach( $users as $user )
                                                                    <option value="{{ $user -> id }}_{{ $brand -> id }}" @if ($man -> id == $user -> id ) selected @endif>{{ $user -> first_name }} {{ $user -> last_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="text-align: center">
                                                        <p>Удалить</p>
                                                        <a class="remove__man" href="#!">
                                                            <i data-count="{{$key + 1}}" class="table--icons ti-close" aria-label="Try me! Example: success modal" id="{{ $man -> id }}_{{ $brand -> id }}" data-toggle="tooltip" title="Удалить"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Обновить категорию</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="plusMan">+ Пользователь</button>
            </div>
        </div>
    </div>
@endsection

<div id="template" class="row" style="display:none">
    <div class="col-md-4">
        <div class="form-group">
            <label for="man1">Пользователь</label>
            <select id="man1" name="man1" class="form-control">
                @foreach( $users as $user )
                    <option value="{{ $user -> id }}_{{ $brand -> id }}">{{ $user -> first_name }} {{ $user -> last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2" style="text-align: center">
        <p>Удалить</p>
        <a class="remove__man">
            <i data-count="1" class="table--icons ti-close" aria-label="Try me! Example: success modal"data-toggle="tooltip" title="Удалить"></i>
        </a>
    </div>
</div>

<div class="successful_Buy modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <p class="text-center">Пользователь обновлен</p>
                <p class="text-center min--info"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@section('edit_userLib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{url('js/admin/brands.js')}}"></script>
    <script src="{{url('js/admin/specman.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>

    <script>
        $(document).ready(function() {

            $('#text').summernote();

        });
    </script>
@endsection