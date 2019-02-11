@section('product_addCss')
    <link href="{{url('css/admin/edit-user.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@extends('admin.main')
@section('add_product_content')
    <div class="content product--add">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Добавить товар</h4>
                                </div>
                                <div class="content">
                                    <form>
                                        <div class="row ">
                                            <div class="col-md-2 fline">
                                                <div class="form-group">
                                                    <label>Актиул товара</label>
                                                    <input class="form-control border-input" type="text" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Название товара</label>
                                                    <input class="form-control border-input" type="text" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-1 pull-right">
                                                <div class="form-group">
                                                    <label class="show-product">Дата</label>
                                                    <input class="add--date form-control border-input" value="" disabled="">
                                                </div>
                                            </div>

                                            <div class="col-md-1 pull-right">
                                                <div class="form-group">
                                                    <label class="show-product">Отображать</label>
                                                    <input class="switch-toggle-event" type="checkbox" data-toggle="toggle" data-on="Да" data-off="Нет">
                                                </div>
                                            </div>

                                            <div class="col-md-1 pull-right">
                                                <div class="form-group">
                                                    <label class="show-product">Доступен</label>
                                                    <input class="available--product" type="checkbox" data-toggle="toggle" data-on="Да" data-off="Нет">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Произвоитель</label>
                                                    <select class="form-control border-input manufacturer--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Категория</label>
                                                    <select class="form-control border-input category--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>В ростовке</label>
                                                    <input class="form-control border-input" type="number" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>В ящике</label>
                                                    <input class="form-control border-input" type="number" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row product--option">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Тип</label>
                                                    <select class="form-control border-input type--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Сезон</label>
                                                    <select class="form-control border-input season--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Размер</label>
                                                    <select class="form-control border-input size--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-md-offset-2">
                                                <div class="form-group currency">
                                                    <label>Валюта</label>
                                                    <select class="form-control border-input currency--select">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>Цена</label>
                                                    <input class="form-control border-input" type="number">
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>Скидка %</label>
                                                    <input class="form-control border-input" type="number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Добавить фотографии</label>
                                                    <div class="file-loading">
                                                        <input id="input-44" name="input44[]" type="file" multiple>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Описание товара</label>
                                                    <textarea class="product--info col-md-12"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-info btn-fill btn-wd" type="submit">Добавить товар</button>
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

@section('product_addLib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.5/js/locales/ru.js"></script>
    <script src="{{url('js/admin/addProduct.js?n=1')}}"></script>
@endsection