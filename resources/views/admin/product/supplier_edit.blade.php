@section('edit_userCss')
    <link href="{{url('css/admin/edit-user.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
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
                                    <h4 class="title">Поставщика - <b>{{$manufacturer -> name}}</b></h4>
                                </div>
                                <div class="content">
                                    @if($errors->any())
                                        <h4 class="back--error">{{$errors->first()}}</h4>
                                    @endif
                                    <form method="POST" action="{{url('suppliers_update')}}">

                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{!! $manufacturer -> id !!}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ID</label>
                                                    <input class="form-control border-input" data-userid="{{$manufacturer -> id}}" disabled="" type="text" value="{{$manufacturer -> id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-5 product--add">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Улица</label>
                                                        <input class="form-control border-input" name="street" type="text" placeholder="Улица" data-userEmail="stree" value="{{$manufacturer -> street}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Номер контейнера</label>
                                                    <input class="form-control border-input" name="numberContainer" type="text" placeholder="10E" data-userContainer="containerNam" value="{{$manufacturer -> numberContainer}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Имя</label>
                                                    <input class="form-control border-input" name="firstName" type="text" placeholder="Имя" data-userName="userName" value="{{$manufacturer -> firstName}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Фамилия</label>
                                                    <input class="form-control border-input" name="secondName" type="text" placeholder="Фамилия" data-userLastName="userLastName" value="{{$manufacturer -> secondName}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input class="form-control border-input" name="phone" placeholder="Телефон" data-userPhone="userPhone" type="text" value="{{$manufacturer -> phone}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Скидка (записывается в формате **% или **грн, например: 10% и 123 грн)</label>
                                                    <input class="form-control border-input" name="discount" placeholder="Скидка" data-userDiscount="userCity" value="{{$manufacturer -> discount}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Срок (число дней, оставьте поле пустым если скидка бессрочна)</label>
                                                    <input class="form-control border-input" type="number" min="0" step="1" name="expiresdis" placeholder="Дней" data-userDiscount="userCity" value="{{ $manufacturer -> expiresdis ? Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($manufacturer -> expiresdis)) : ''}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group currency col-md-3" style="padding: 0;">
                                                    <label>Валюта</label>
                                                    <select class="form-control border-input currency--select" disabled="">
                                                        <option value="дол">Дол $</option>
                                                    </select>
                                                </div>

                                                <div class="chooseBox" style="float: left;margin-top: 35px;margin-left: 20px;">
                                                    <label for="justBox">
                                                        <input type="checkbox" @if($manufacturer ->box == 1) checked @endif name="justBox" id="justBox">
                                                        Только в ящике
                                                    </label>
                                                </div>

                                                <div class="form-group currency">
                                                    <input class="form-control border-input" name="koorse" value="{{$manufacturer -> koorse}}" placeholder="{{$manufacturer -> koorse}}">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Обновить поставщика</button>
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
    {{--<script src="{{url('js/admin/user_edit.js?n=1')}}"></script>--}}
@endsection