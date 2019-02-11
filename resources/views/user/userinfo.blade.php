@extends('user.markup.markup')
@section('register')
    <div class="logReg_page regPage" style="height: 100%;">
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Информация</h3>
                        <div class="container">

                            <form class="well form-horizontal" action="{{url('/userUpdate')}}" method="post" >
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="_method" value="POST">
                                <fieldset>
                                    <div class="form-field-wrapper form-center col-sm-12">
                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            @if ($errors->has('email'))
                                                <p>  {{$errors -> first('email')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Ваш E-Mail</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input name="email" placeholder="" class="form-control" type="text" value="{{$client -> email}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            @if ($errors->has('first_name'))
                                                <p> {{$errors -> first('first_name')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Имя</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input name="first_name" placeholder="имя" class="input-md form-full-width form-control" type="text" value="{{$client -> first_name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            @if ($errors->has('last_name'))
                                                <p> {{$errors -> first('last_name')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Фамилия</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input name="last_name" placeholder="имя" class="input-md form-full-width form-control" type="text" value="{{$client -> last_name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Text input-->
                                    </div>
                                    <!-- Text input-->

                                    <div class="form-field-wrapper form-center col-sm-12">
                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            <label class="col-md-12 control-label">Ваш Телефон</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input placeholder="" name="phone" class="form-control" type="text" value="{{$client -> phone}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            <label class="col-md-12 control-label">Ваш Адрес</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <input placeholder="" name="address" class="form-control" type="text" value="{{$client -> address}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="form-field-wrapper form-center col-sm-12">--}}
                                        {{--<div class="col-md-6 form-field-wrapper form-group has-feedback">--}}
                                            {{--<label class="col-md-12 control-label">Способ доставки</label>--}}
                                            {{--<div class="input-group col-md-12 deliverySelect">--}}
                                                {{--<select name="deliveryMethod" id="deliveryMethod" class="nice-select-box">--}}
                                                    {{--<option selected="selected" value="1">Новая почта</option>--}}
                                                    {{--<option value="1">Delivery</option>--}}
                                                    {{--<option value="1">Автолюкс</option>--}}
                                                    {{--<option value="1">InTime</option>--}}
                                                    {{--<option value="1">Подвести к автобусу</option>--}}
                                                    {{--<option value="1">Самовывоз</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="col-md-6 form-field-wrapper form-group has-feedback">--}}
                                            {{--<label class="col-md-12 control-label">Информация по доставке</label>--}}
                                            {{--<div class="col-md-12 inputGroupContainer">--}}
                                                {{--<div class="input-group">--}}
                                                    {{--<input placeholder="" class="form-control" type="text" value="Доставьте в отделение №3">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                        @if ($errors->has('password'))
                                            <p> {{$errors -> first('password')}} </p>
                                        @endif
                                        <label class="col-md-12 control-label">Ваш пароль</label>
                                        <div class="col-md-12 inputGroupContainer">

                                            <div class="input-group">
                                                <input name="password" placeholder="пароль" class="form-control"
                                                       type="password" value="{{old('password')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                        <label class="col-md-12 control-label">Повторите пароль</label>
                                        <div class="col-md-12 inputGroupContainer">

                                            <div class="input-group">
                                                <input name="confirmPassword" placeholder="пароль" class="form-control"
                                                       type="password" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="col-md-12 form-field-wrapper form-group has-feedback">
                                        <button type="submit" class="btn btn-warning submit btn btn-md btn-color">Изменить</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div><!-- /.container -->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('auth_reg')
    {{--<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{asset('js/resizer.js')}}"></script>--}}
@endsection