@section('productsCss')
    <link href="{{url('css/admin/products.css')}}" rel="stylesheet">
        <style>
        .table-striped > thead > tr > th, .table-striped > tbody > tr > th, .table-striped > tfoot > tr > th, .table-striped > thead > tr > td, .table-striped > tbody > tr > td, .table-striped > tfoot > tr > td{
            font-size: 14px;
            border: 1px solid #f4f3ef;
            border-top: 0;
            border-bottom: 0;
            text-align: center;
        }

        label {
            font-weight: unset;
        }
    </style>
@endsection

@extends('admin.main')
@section('products_container')
    <div class="col-md-12 ">
        <div class="col-md-12 header">
            <h4 class="title">Список товаров</h4>
        </div>

        @if($errors->any())
            <h4 class="back--error">{{$errors->first()}}</h4>
        @endif
        <div class="col-md-12">
            <div class="header--add--buttons col-md-4 col-sm-12 col-xs-12">
                <div>
                    <input id="manShowAll" type="checkbox"> 
                    <label for="manShowAll">New Manufacturer Spec Show</label>
                </div>
                <select class="sorting__Option col-md-5 col-sm-12 col-xs-12" name="goods">
                    <option value="1">Обувь</option>
                    <option value="2">Перчатки</option>
                </select>

                <select class="sorting__Option col-md-5 col-sm-12 col-xs-12" name="uploadOptions" onChange="getSelect(event)">
                    <option value="upload">Загрузить</option>
                    <option value="download">Скачать</option>
                    <option value="edit">Редактировать</option>
                    <option value="delete">Удалить</option>
                </select>

                <div class="col-md-12 inputs--group">
                    <input type="file" id="archive" data-filename-placement="inside" name="zip" title="Выбрать фотографии" accept=".zip" class="col-md-5 col-sm-12 col-xs-12" onChange="getFile()">

                    <input type="file" id="xslsx" data-filename-placement="inside" name="xlsx" title="Выбрать XLS" accept=".xls, .xlsx" class="col-md-5 col-sm-12 col-xs-12" onChange="getFileXls()">

                    <select class="sorting__Option manufacturer_Options col-md-5 col-sm-12 col-xs-12" name="manufactures" onChange="getManufactures(event)" style="display: none; float: left; margin-right: 5px;">
                        <option value="0">Все</option>
                        @foreach($manufactures as $manufacture)

                            <option value="{{$manufacture -> id}}">{{$manufacture -> name}}</option>

                        @endforeach
                    </select>

                    <select class="sorting__Option seasone_Options col-md-5 col-sm-12 col-xs-12" name="season" onChange="getSeason(event)" style="display: none">

                        <option value="5">Все</option>

                        @foreach($seasons as $season)

                            <option value="{{$season -> id}}">{{$season -> name}}</option>

                        @endforeach
                    </select>

                    <select class="sorting__Option type_Options col-md-5 col-sm-12 col-xs-12" name="manufactures" onChange="getManufactures(event)" style="display: none; float: left; margin-right: 5px;">

                        <option value="28">Все</option>

                        @foreach($types as $type)

                            <option value="{{$type -> id}}">{{$type -> name}}</option>

                        @endforeach
                    </select>

                    <select class="sorting__Option availability col-md-5 col-sm-12 col-xs-12" name="availability" style="display: none; float: left; margin-right: 5px">
                        <option value="2">Все</option>
                        <option value="1">Да</option>
                        <option value="0">Нет</option>
                    </select>
                    
                    <button data-toggle="collapse" data-target="#test_d" aria-expanded="true" style="right: -70px; top: auto;">Скачать фильтром</button>
                    <button onclick="window.location.href='/admin/novelty'" style="top: -70px;right: -250px;">Лог загрузок</button>
                    <div class="row collapse" id="test_d" aria-expanded="true" style="margin-top:50px">
                        <input id="gloves" type="checkbox" class="col">
                        <label for="gloves">
                            Перчатки
                        </label>
                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-manufactures" aria-expanded="true" data-id="manufactures" >Поставщики</h6>
                                <button onclick="selectall('#filter-manufactures')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-manufactures" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    @foreach($manufactures as $manufacture)
                                        <div>
                                            <input id="man{{$manufacture -> id}}" type="checkbox" value="{{$manufacture -> id}}" class="col">
                                            <label for="man{{$manufacture -> id}}">
                                                {{$manufacture -> name}}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-season" aria-expanded="true" data-id="season" >Сезон</h6>
                                <button onclick="selectall('#filter-season')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-season" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    @foreach($seasons as $season)
                                        <div>
                                            <input id="seas{{$season -> id}}" type="checkbox" value="{{$season -> id}}" class="col">
                                            <label for="seas{{$season -> id}}">
                                                {{$season -> name}}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-type" aria-expanded="true" data-id="type" >Тип</h6>
                                <button onclick="selectall('#filter-type')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-type" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    @foreach($types as $type)
                                        <div>
                                            <input id="type{{$type -> id}}" type="checkbox" value="{{$type -> id}}" class="col">
                                            <label for="type{{$type -> id}}">
                                                {{$type -> name}}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-country" aria-expanded="true" data-id="country" >Страна</h6>
                                <button onclick="selectall('#filter-country')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-country" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    @foreach($countries as $country)
                                        <div>
                                            <input id="country{{$country->manufacturer_country}}" type="checkbox" value="{{$country->manufacturer_country}}" class="col">
                                            <label for="country{{$country->manufacturer_country}}">
                                                {{$country->manufacturer_country}}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-color" aria-expanded="true" data-id="color" >Цвет</h6>
                                <button onclick="selectall('#filter-color')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-color" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    @foreach($colors as $color)
                                        <div>
                                            <input id="color{{$color}}" type="checkbox" value="{{$color}}" class="col">
                                            <label for="color{{$color}}">
                                                {{$color}}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="widget-sidebar widget-filter-size">
                                <h6 class="widget-title" data-toggle="collapse" data-target="#filter-avaible" aria-expanded="true" data-id="avaible" >Наличие</h6>
                                <button onclick="selectall('#filter-avaible')" style="position: static; float: none;">Выбрать все</button>
                                <div id="filter-avaible" aria-expanded="true" class="filterInner collapse in show" style="max-height: 300px; overflow: auto;">

                                    <div>
                                        <input id="avaible1" type="checkbox" value="1" class="col">
                                        <label for="avaible1">
                                            Да
                                        </label>
                                    </div>

                                    <div>
                                        <input id="avaible0" type="checkbox" value="0" class="col">
                                        <label for="avaible0">
                                            Нет
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <button class='col-md-4 col-sm-12 col-xs-12' style='right: 80px;top: -5px;width: 220px;position: static; float: none;'  onclick='testDownload()'>Скачать Excel</button>
                        <button class='col-md-4 col-sm-12 col-xs-12' style='right: 80px;top: -5px;width: 220px;position: static; float: none;'  onclick='testDownloadPDF(true)'>Скачать PDF с фото</button>
                        <button class='col-md-4 col-sm-12 col-xs-12' style='right: 80px;top: -5px;width: 220px;position: static; float: none;'  onclick='testDownloadPDF(false)'>Скачать PDF без фото</button>
                    </div>
                </div>

                <button class="upload col-md-4 col-sm-12 col-xs-12" >Загрузить</button>

            </div>

            <div class="span12 pull-right col-md-5 col-sm-12 col-xs-12" style="padding-right: 0;">
                <form id="custom-search-form" class="form-search form-horizontal pull-right col-sm-12 col-xs-12">
                    <div class="input-append col-sm-12 col-xs-12" style="padding-right: 0;">

                        <h4 class="checkCounter" >Выбрано: <span class="countNumber">0</span></h4>
                            <input type="button" class="clearAll" value="Очистить выбор">
                            <input type="button" class="saveAll" value="Сохранить изменения">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content products--content produtsTablePage">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="content table-responsive table-full-width" style="padding: 0;">

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Фото</th>
                                    <th>Артикул</th>
                                    <th>Размеры</th>
                                    <th>Производитель</th>
                                    <th>Цена закупки</th>
                                    <th>Цена без скидки</th>
                                    <th>Цена на сайте</th>
                                    <th>Скидка </th>
                                    <th>В наличии</tr>
                                <tr>

                                    <th style="width: 50px"><a href="#" id="chooseAll">Выбрать все</a>
                                        <a href="#"id="closeAll"> Отменить все</a></th>
                                    <th></th>
                                    <th>
                                        <input style="border: 1px solid #c5c5c5; max-width: 110px; text-align: center; padding-top: 3px" type="text" value="{{$articleGetParam}}" class="searchArt" placeholder="Поиск">
                                    </th>
                                    <th></th>
                                    <th>
                                        {{--<input style="border: 1px solid #c5c5c5; max-width: 110px; text-align: center; padding-top: 3px"  type="text" class="searchMan" placeholder="Поиск">--}}

                                        <select class="searchMan" style="border: 1px solid #c5c5c5; padding-top: 3px; padding-bottom: 1px; max-width: 110px; text-align: center">
                                            <option value="0">Все</option>
                                            @foreach($manufactures as $manufacture)

                                                <option @if($manufacture -> name == $manufacturerGetParam) selected @endif value="{{$manufacture -> name}}">{{$manufacture -> name}}</option>

                                            @endforeach
                                        </select>

                                    </th>


                                    <th>
                                        <input type="text" class="pricePurchase" style="border: 1px solid #c5c5c5; padding-top: 3px; max-width: 110px; text-align: center" placeholder="Закупка">
                                    </th>

                                    <th>
                                        <input style="border: 1px solid #c5c5c5; max-width: 110px; text-align: center; padding-top: 3px" type="text" class="price" placeholder="Цена">
                                    </th>

                                    <th>
                                    </th>
                                    <th>
                                        <input style="border: 1px solid #c5c5c5; max-width: 110px; text-align: center; padding-top: 3px" type="text" class="discount" placeholder="Скидка">
                                        <select class="discountpr isPercent" style="border: 1px solid #c5c5c5; padding-top: 3px; padding-bottom: 1px; max-width: 110px; text-align: center">
                                            <option value="грн">грн</option>
                                            <option value="%">%</option>
                                        </select>
                                    </th>

                                    <th>
                                        <select class="availability isExist" style="border: 1px solid #c5c5c5; padding-top: 3px; padding-bottom: 1px; max-width: 110px; text-align: center">
                                            <option value="0">Не выбрано</option>
                                            <option value="1">Да</option>
                                            <option value="2">Нет</option>
                                        </select>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($products as $product)



                                    <tr data-id="{{$product -> id}}">
                                        <td><input class="checkTov" type="checkbox" value="{{$product -> id}}"> </td>
                                        <td style="max-width: 80px;">
                                            @if($product -> photo )
                                            <img style="width: 70%;margin-bottom: 30px;" src="{{url('/images/products/'. $product -> photo -> photo_url)}}" />
                                                @endif
                                        </td>

                                        <td class="articul productsArt"><input value="{{$product -> article}}" disabled></td>

                                        <td>{{$product -> size -> name}}</td>


                                        <td>{{$product -> manufacturer -> name}}</td>

                                        <td>{{$product -> prise_zakup}}</td>
                                        
                                        <td>{{$product->prise_default}}</td>



                                        <td>{{$product -> prise}}</td>

                                        <td>@if($product -> discount == null) 0 @else {{$product -> discount}} @endif</td>

                                        <td>@if($product ->show_product == 1) Да @else Нет @endif</td>

                                        <td>{{--$product -> created_at--}}  <a class="remove__product" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <ul class="pagination">
                    @for($i = 1; $i < $productCount+1; $i ++)

                        @if(isset($_GET['page']))

                            @if($_GET['page'] > 4 && $i == 1)
                                @if(isset($_GET['article']) && isset($_GET['manufacturer']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['article']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['manufacturer']))
                                        <li><a href="{{url('products?manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @else
                                        <li><a href="{{url('products?page='.$i)}}">{{$i}}</a></li>
                                @endif
                                        <li><a href="#!">...</a></li>
                            @endif

                            @if(($i >= $_GET['page'] - 2 &&  $i <= $_GET['page'] + 2) || $i + 1 == $productCount)

                                @if(isset($_GET['article']) && isset($_GET['manufacturer']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['article']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['manufacturer']))
                                        <li><a href="{{url('products?manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @else
                                        <li><a href="{{url('products?page='.$i)}}">{{$i}}</a></li>
                                @endif

                            @endif

                            @if($i == $_GET['page'] + 3)
                                    <li><a href="#!">...</a></li>
                            @endif

                        @else
                            @if(($i >= 1 &&  $i <= 5) || $i + 1 == $productCount)
                                @if(isset($_GET['article']) && isset($_GET['manufacturer']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['article']))
                                        <li><a href="{{url('products?article='.$_GET['article'].'&page='.$i)}}">{{$i}}</a></li>

                                @elseif(isset($_GET['manufacturer']))
                                        <li> <a href="{{url('products?manufacturer='.$_GET['manufacturer'].'&page='.$i)}}">{{$i}}</a></li>

                                @else
                                        <li><a  href="{{url('products?page='.$i)}}">{{$i}}</a></li>
                                @endif
                            @endif

                            @if($i == 6)
                                    <li><a href="#!">...</a></li>
                            @endif

                        @endif

                    @endfor

                    </ul>

                    {{--{{$products->links()}}--}}


                </div>
            </div>
        </div>
    </div>
@endsection
@section('productsLib')
    <script src="{{url('js/admin/bootstrap.file-input.js?n=1')}}"></script>
    <script src="{{url('js/admin/products.js?n=1')}}"></script>
@endsection
