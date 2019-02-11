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
                                    <h4 class="title">Личный кабинет</h4>
                                </div>
                                {{--{{dd($user -> id)}}--}}

                                <div class="content">
                                    <form method="POST" action="{{url('/personal/update')}}">
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>ID</label>
                                                    <input class="form-control border-input" disabled="" type="text"  value="{{$user->id}}">
                                                </div>
                                            </div>

                                            <input type="hidden" name="id" value="{{$user->id}}">

                                            <div class="col-md-5 product--add">
                                                <div class="form-group">
                                                    <label>Тип пользователя</label>
                                                    <select name="type" class="form-control border-input user__type">
                                                        <option value="admin">Админ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email адрес</label>
                                                    <input class="form-control border-input" name="email" type="email" value="{{$user -> email}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input class="form-control border-input" name="first_name" type="text" value="{{$user->first_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input class="form-control border-input" name="last_name" type="text" value="{{$user->last_name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input class="form-control border-input" name="address" placeholder="Home Address" type="text" value="{{$user->address}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input class="form-control border-input" name="city" placeholder="City" type="text" value="{{$user->city}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <input class="form-control border-input" name="country" placeholder="Country" type="text" value="{{$user->country}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Postal Code</label>
                                                    <input class="form-control border-input" name="postal_code" placeholder="ZIP Code" type="number" value="{{$user->postal_code}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Обновить профиль</button>
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

@section('edit_userLib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    {{--<script src="{{url('js/admin/user_edit.js')}}"></script>--}}
@endsection