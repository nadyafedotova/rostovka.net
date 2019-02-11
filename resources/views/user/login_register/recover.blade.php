@extends('user.markup.markup')
@section('login')
    <div class="logReg_page regPage">
        <div class="page-content-wraper">
            <!-- Page Content -->
            <section class="content-page">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-border-box">
                                <form action="{{url('/recovery')}}" method="post" id="contact_form">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="_method" value="POST">
                                    <h2 class="normal"><span>Восстановление пароляzz</span></h2>
                                    <div class="form-field-wrapper">
                                        <div class="form-group has-error">
                                            @if ($errors->has('recovery_error'))
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-danger"> {{ $error }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <label>Введите Email <span class="required">*</span></label>
                                        <input id="author-email" class="input-md form-full-width" name="author" placeholder="email" value="" size="30" aria-required="true" required="" type="email">
                                    </div>
                                    <div class="form-field-wrapper">
                                        <input name="submit" id="submit" class="submit btn btn-md btn-black" value="Восстановить пароль" type="submit">
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
    <script type="text/javascript" src="{{asset('js/resizer.js')}}"></script>
@endsection