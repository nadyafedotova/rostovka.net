@extends('user.markup.markup')
@section('login')
    <div class="logReg_page regPage">
        <div class="page-content-wraper">
            <!-- Page Content -->
            <section class="content-page">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-border-box">
                                <form action="/login" method="post" id="contact_form">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="_method" value="POST">
                                    <h2 class="normal"><span>Авторизация</span></h2>
                                    <div class="form-field-wrapper">
                                        <div class="form-group has-error">
                                            @if ($errors->has('login_error'))
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-danger"> {{ $error }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <label>Введите Email <span class="required">*</span></label>
                                        <input id="author-email" class="input-md form-full-width" name="author" placeholder="email" value="" size="30" aria-required="true" required="" type="email">
                                    </div>
                                    <div class="form-field-wrapper">
                                        <label>Введите пароль <span class="required">*</span></label>
                                        <input id="author-pass" class="input-md form-full-width" name="author-pass" placeholder="пароль" value="" size="30" aria-required="true" required="" type="password">
                                    </div>
                                    <div class="form-field-wrapper">
                                        <input name="submit" id="submit" class="submit btn btn-md btn-black" value="Авторизация" type="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-border-box">
                                <form>
                                    <h2 class="normal"><span>Регистрация</span></h2>
                                    <div class="form-field-wrapper">
                                        <a href="register" class="submit btn btn-md btn-color col-12">Создать аккаунт</a>
                                    </div>

                                    <div class="form-field-wrapper">
                                        <a href="password/reset" class="submit btn btn-md btn-color col-12">Забыл пароль</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Page Content -->
        </div>
    </div>
@endsection

@section('auth_lib')
    <script type="text/javascript" src="/public/js/resizer.js"></script>
@endsection