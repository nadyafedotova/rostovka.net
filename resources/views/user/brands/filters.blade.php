
<form id="form1">
    <!-- Filter By Size -->
	<div class="widget-sidebar widget-filter-category">
        <h6 class="widget-title" data-toggle="collapse" data-target="#filter-category" aria-expanded="true" data-id="category" >Категория</h6>
        <div id="filter-category" aria-expanded="true" class="filterInner collapse show">

            @foreach($categories as $category)
            	@if($category -> id != 4)
	                <div class="checkbox checkbox-warning checkbox-circle">
	                    <input id="category{{$category -> id}}" name="category{{$category -> id}}" type="checkbox" value="{{$category->name}}" data-value="category{{$category -> id}}">
	                    <label for="category{{$category -> id}}">
	                        {{$category->name}}
	                    </label>
	                </div>
                @endif
            @endforeach
        </div>
    </div>
    
	<div class="widget-sidebar widget-filter-size">
        <h6 class="widget-title" data-toggle="collapse" data-target="#filter-price" aria-expanded="true" data-id="dimensions">Цена</h6>
        <div class="collapse show sizeBlock" id="filter-price" aria-expanded="true">
            <span class="oi oi-caret-top"></span>
            <div class="filterInner">
                <div class="col-md-6 no-paddig pull-left">
                    <input type="text" id="minchoose" class="pull-left" value="{{ $min }}">
                </div>

                <div class="col-md-6 no-paddig pull-right">
                    <input type="text" id="maxchoose" class="pull-left sintype" value="{{ $max }}">
                </div>
            </div>

            <div>
                <input id="ex2" type="text" value="" data-slider-min="{{ $min }}" data-slider-tooltip="hide" data-slider-max="{{ $max }}" data-slider-step="1" data-slider-value="[{{ $min }}, {{ $max }}]"/>
            </div>
        </div>
    </div>
    
    <div class="widget-sidebar widget-filter-size" id="detskoe-pol" style="display:none">
        <h6 class="widget-title" data-toggle="collapse" data-target="#filter-sex" aria-expanded="true" data-id="sex" >Пол</h6>
        <div id="filter-sex" aria-expanded="true" class="filterInner collapse show">


            <div class="checkbox checkbox-warning checkbox-circle">
                <input id="sex1" name="sex1" type="checkbox" value="мальчик" data-value="sex1">
                <label for="sex1">
                    Мальчик
                </label>
            </div>

            <div class="checkbox checkbox-warning checkbox-circle">
                <input id="sex2" name="sex2" type="checkbox" value="девочка" data-value="sex2">
                <label for="sex2">
                    Девочка
                </label>
            </div>

        </div>
    </div>

    @if ($types -> count() > 0)
        <div class="widget-sidebar widget-filter-size">
            <h6 class="widget-title" data-toggle="collapse" data-target="#filter-tip" aria-expanded="true" data-id="tip">Тип</h6>
            <div id="filter-tip" aria-expanded="true" class="filterInner collapse show">

                @foreach($types as $type)
                    <div class="checkbox checkbox-warning checkbox-circle">
                        <input id="type{{$type -> id}}" name="type{{$type -> id}}" type="checkbox" value="{{$type -> name}}" data-value="type{{$type -> id}}">
                        <label for="type{{$type -> id}}">
                            {{$type -> name}}
                        </label>
                    </div>
                    @endforeach
            </div>
        </div>
    @endif

    @if ($seasons -> count() > 0)
        <div class="widget-sidebar widget-filter-size">
            <h6 class="widget-title" data-toggle="collapse" data-target="#filter-season" aria-expanded="true" data-id="season">Сезон</h6>
            <div id="filter-season" aria-expanded="true" class="filterInner collapse show">

                @foreach($seasons as $season)

                    <div class="checkbox checkbox-warning checkbox-circle">
                        <input id="season{{$season -> id}}" type="checkbox" name="season{{$season -> id}}" value="{{$season -> name}}" data-value="season{{$season -> id}}">
                        <label for="season{{$season -> id}}">
                            {{$season -> name}}
                        </label>
                    </div>
                    @endforeach
            </div>
        </div>
    @endif
    
    @if ($colors)
        <div class="widget-sidebar widget-filter-color">
            <h6 class="widget-title" data-toggle="collapse"  aria-expanded="true" data-id="color">Цвета</h6>
            <div id="" class="filterInner collapse show">
                <div id="" class="row" style="margin: 0">
                    @foreach($colors as $color) 
                        <label class="filters__color" style="@if($color -> name == 'Микс')background:linear-gradient(cyan,transparent),linear-gradient(-45deg,magenta,transparent),linear-gradient(45deg,yellow,transparent);background-blend-mode: multiply; @else background: #{{ $color -> hex }}; @endif" title="{{ $color -> name }}">
    						<input id="color{{$color -> id}}" type="checkbox" name="color{{ $color -> id }}" data-value="color{{$color -> id}}" class="filters__checkbox filters__checkbox--color" value="{{ $color -> name }}">
    						<span class="filters__checkbox-color-checked"></span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    @if ($sizes -> count() > 0)
        <div class="widget-sidebar widget-filter-size">
            <h6 class="widget-title" data-toggle="collapse" data-target="#filter-size" aria-expanded="true" data-id="size">Размеры</h6>
            <div id="filter-size" class="filterInner collapse show">
                <div id="fsizes" class="row" style="margin: 0">
                    @foreach($sizes as $size)
                        <div class="col-sm-4 col-4" style="padding: 0 5px 5px 0">
                            <input id="size{{$size -> id}}" type="checkbox" name="size{{$size -> id}}" value="{{$size -> name}}" data-value="size{{$size -> id}}" class="checkbox-input" style="display:none">
                            <label for="size{{$size -> id}}" class="checkbox-label">
                                {{$size -> name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if ($countries -> count() > 0)
        <div class="widget-sidebar widget-filter-size">
            <h6 class="widget-title" data-toggle="collapse" data-target="#filter-countries" aria-expanded="true" data-id="countries">Страны</h6>
            <div id="filter-countries" aria-expanded="true" class="filterInner collapse show">
                @foreach($countries as $country)
                    <div class="checkbox checkbox-warning checkbox-circle">
                        <input id="countries{{$country->manufacturer_country}}" type="checkbox" value="{{$country->manufacturer_country}}" data-value="country{{$country->manufacturer_country}}">
                        <label for="countries{{$country->manufacturer_country}}">
                            {{ $country->manufacturer_country }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</form>