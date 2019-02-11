@extends('user.markup.markup')
@section('register')
    <div class="logReg_page regPage">
        <section class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Регистрация</h3>
                <div class="container">

                    <form class="well form-horizontal" action="{{route('register')}}" method="post" id="contact_form">
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
                                            <input name="email" placeholder="e-mail" class="form-control" type="text" value="{{old('email')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                    @if ($errors->has('phone'))
                                        <p>  {{$errors -> first('phone')}} </p>
                                    @endif
                                    <label class="col-md-12 control-label">Ваш номер телефона</label>
                                    <div class="col-md-12 inputGroupContainer">

                                        <div class="input-group">
                                            <input name="phone" placeholder="Номер телефона" class="form-control userPhone" type="text" value="{{old('phone')}}">
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
                                            <input name="first_name" placeholder="имя" class="input-md form-full-width form-control" type="text" value="{{old('first_name')}}">
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
                                            <input name="last_name" placeholder="фамилия" class="input-md form-full-width form-control" type="text" value="{{old('last_name')}}">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                    @if ($errors->has('address'))
                                        <p> {{$errors -> first('address')}} </p>
                                    @endif
                                    <label class="col-md-12 control-label">Адрес</label>
                                    <div class="col-md-12 inputGroupContainer">

                                        <div class="input-group">
                                            <input name="address" placeholder="Адрес" class="input-md form-full-width form-control" type="text" value="{{old('address')}}">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                    @if ($errors->has('city'))
                                        <p> {{$errors -> first('city')}} </p>
                                    @endif
                                    <label class="col-md-12 control-label">Город</label>
                                    <div class="col-md-12 inputGroupContainer">

                                        <div class="input-group">
                                            <input name="city" placeholder="Адрес" class="input-md form-full-width form-control" type="text" value="{{old('city')}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- Text input-->
                            </div>
                            <!-- Text input-->

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
                                <button type="submit" class="btn btn-warning submit btn btn-md btn-color">Зарегистрироваться</button>
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


<div class="successful_Buy modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <p class="text-center">Вы успешно зарегистрировались</p>
                <p class="text-center min--info"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@section('auth_reg')
<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
<script type="text/javascript" src="{{asset('js/resizer.js')}}"></script>
@endsection