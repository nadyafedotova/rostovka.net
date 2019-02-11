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
                                    <h4 class="title">О нас</b></h4>
                                </div>
                                <div class="content">
                                    @if($errors->any())
                                        <h4 class="back--error">{{$errors->first()}}</h4>
                                    @endif
                                    <form method="POST" action="{{route('adminUpdAbout')}}">

                                        {{csrf_field()}}
                                        <input type="hidden" name="brand_id" value="{!! $about -> id !!}">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tab1</label>
                                                <textarea class="text" class="form-control border-input" name="tab1" type="text" rows="4" data-userContainer="containerNam">{{$about -> tab1}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tab2</label>
                                                <textarea class="text" class="form-control border-input" name="tab2" type="text" rows="4" data-userContainer="containerNam">{{$about -> tab2}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tab3</label>
                                                <textarea class="text" class="form-control border-input" name="tab3" type="text" rows="4" data-userContainer="containerNam">{{$about -> tab3}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tab4</label>
                                                <textarea class="text" class="form-control border-input" name="tab4" type="text" rows="4" data-userContainer="containerNam">{{$about -> tab4}}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Обновить страницу</button>
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