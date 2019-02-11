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
                                    <h4 class="title">СЕО фильтра - <b>{{$type -> name}}</b></h4>
                                </div>
                                <div class="content">
                                    @if($errors->any())
                                        <h4 class="back--error">{{$errors->first()}}</h4>
                                    @endif
                                    <form method="POST" action="{{route('typeUpd')}}">

                                        {{csrf_field()}}
                                        <input type="hidden" name="type_id" value="{!! $type -> id !!}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ID</label>
                                                    <input class="form-control border-input" data-userid="{{$type -> id}}" disabled="" type="text" value="{{$type -> id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-11 product--add">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Название</label>
                                                        <input class="form-control border-input" name="name" type="text" placeholder="Name..." data-userEmail="stree" value="{{$type -> name}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="com-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="exampleInputEmail1">Детское</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="exampleInputEmail1">Мужское</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="exampleInputEmail1">Женское</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="com-md-12">
                                            <label>Title</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="ktitle" type="text" placeholder="Kids Title..." data-userContainer="containerNam" value="{{$type -> ktitle}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="mtitle" type="text" placeholder="Male Title..." data-userContainer="containerNam" value="{{$type -> mtitle}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="ftitle" type="text" placeholder="Female Title..." data-userContainer="containerNam" value="{{$type -> ftitle}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="com-md-12">
                                            <label>Description</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="kdescription" type="text" placeholder="Kids Description..." data-userContainer="containerNam" value="{{$type -> kdescription}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="mdescription" type="text" placeholder="Male Description..." data-userContainer="containerNam" value="{{$type -> mdescription}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="fdescription" type="text" placeholder="Female Description..." data-userContainer="containerNam" value="{{$type -> fdescription}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="com-md-12">
                                            <label>Keywords</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="kkeywords" type="text" placeholder="Kids Keywords..." data-userContainer="containerNam" value="{{$type -> kkeywords}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="mkeywords" type="text" placeholder="Male Keywords..." data-userContainer="containerNam" value="{{$type -> mkeywords}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input class="form-control border-input" name="fkeywords" type="text" placeholder="Female Keywords..." data-userContainer="containerNam" value="{{$type -> fkeywords}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Детское:</label>
                                                <textarea class="text" class="form-control border-input" name="kids" type="text" rows="4" data-userContainer="containerNam">{{$type -> kids}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Мужское:</label>
                                                <textarea class="text" class="form-control border-input" name="male" type="text" rows="4" data-userContainer="containerNam">{{$type -> male}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Женское:</label>
                                                <textarea class="text" class="form-control border-input" name="female" type="text" rows="4" data-userContainer="containerNam">{{$type -> female}}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Обновить фильтр</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>

    <script>
        $(document).ready(function() {

            $('.text').summernote();

        });
    </script>
@endsection