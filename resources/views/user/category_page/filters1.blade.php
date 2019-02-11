
<form id="form1">
    <!-- Filter By Size -->
	
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

    @if($category -> id == 1 || $category -> id == 5 )

        <div class="widget-sidebar widget-filter-size">
            <h6 class="widget-title" data-toggle="collapse" data-target="#filter-sex" aria-expanded="true" data-id="sex" >Пол</h6>
            <div id="filter-sex" aria-expanded="true" class="filterInner collapse show">


                <div class="checkbox checkbox-warning checkbox-circle">
                    <input id="sex1" name="sex1" type="checkbox" value="мальчик" data-value="sex1">
                    <label for="sex1">
                        мальчик
                    </label>
                </div>

                <div class="checkbox checkbox-warning checkbox-circle">
                    <input id="sex2" name="sex2" type="checkbox" value="девочка" data-value="sex2">
                    <label for="sex2">
                        девочка
                    </label>
                </div>

            </div>
        </div>

    @endif

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

    <div class="widget-sidebar widget-filter-size">
        <h6 class="widget-title" data-toggle="collapse" data-target="#filter-size" aria-expanded="true" data-id="size">Размеры</h6>
        <div id="filter-size" class="filterInner collapse show">
            <div id="fsizes" class="row" style="margin: 0">
                @foreach($sizes as $size)
                    <div class="col-sm-4" style="padding: 0 5px 5px 0">
                        <input id="size{{$size -> id}}" type="checkbox" name="size{{$size -> id}}" value="{{$size -> name}}" data-value="size{{$size -> id}}" class="checkbox-input" style="display:none">
                        <label for="size{{$size -> id}}" class="checkbox-label">
                            {{$size -> name}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="widget-sidebar widget-filter-size">
        <h6 class="widget-title" data-toggle="collapse" data-target="#filter-manufacturers" aria-expanded="true" data-id="manufacturers">Производители</h6>
        <div id="filter-manufacturers" aria-expanded="true" class="filterInner collapse show">
            @foreach($manufacturers as $manufacturer)
                <div class="checkbox checkbox-warning checkbox-circle">
                    <input id="manufacturer{{$manufacturer -> id}}" type="checkbox" value="{{$manufacturer -> name}}" data-value="manufacturer{{$manufacturer -> id}}">
                    <label for="manufacturer{{$manufacturer -> id}}">
                        {{$manufacturer -> name}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</form>