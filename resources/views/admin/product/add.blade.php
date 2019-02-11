add product
<form action="{{url('/product')}}" method="post" id="contact_form" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="_method" value="POST">
<br/>
    article
    @if ($errors->has('article'))


        <p> {{$errors -> first('article')}} </p>

    @endif
    <input type="text" name="article">
    <br/>
    name
    @if ($errors->has('name'))


        <p> {{$errors -> first('name')}} </p>

    @endif
    <input type="text" name="name">
    <br/>
    rostovka_count
    @if ($errors->has('rostovka_count'))


        <p> {{$errors -> first('rostovka_count')}} </p>

    @endif
    <input type="number" name="rostovka_count">
    <br/>
    box_count
    @if ($errors->has('box_count'))


        <p> {{$errors -> first('box_count')}} </p>

    @endif
    <input type="number" name="box_count">
    <br/>
    prise
    @if ($errors->has('prise'))


        <p> {{$errors -> first('prise')}} </p>

    @endif
    <input type="number" name="prise">
    <br/>
    manufacturer
    @if ($errors->has('password'))


        <p> {{$errors -> first('password')}} </p>

    @endif
    <select name="manufacturer">
        @foreach($manufacturers as $manufacturer)
            <option value="{{$manufacturer -> id}}">{{$manufacturer -> name}}</option>
        @endforeach
    </select>
    <br/>
    category
    @if ($errors->has('password'))


        <p> {{$errors -> first('password')}} </p>

    @endif
    <select name="category">
        @foreach($categories as $category)
            <option value="{{$category -> id}}">{{$category -> name}}</option>
        @endforeach
    </select>
    <br/>
    show_product
    @if ($errors->has('show_product'))


        <p> {{$errors -> first('show_product')}} </p>

    @endif
    <input type="checkbox"  name="show_product">
    <br/>
    currency
    @if ($errors->has('currency'))


        <p> {{$errors -> first('currency')}} </p>

    @endif
    <input type="checkbox" name="currency">
    <br/>
    fill_description
    @if ($errors->has('fill_description'))


        <p> {{$errors -> first('fill_description')}} </p>

    @endif
    <input type="text" name="fill_description">
    <br/>
    discount
    @if ($errors->has('discount'))


        <p> {{$errors -> first('discount')}} </p>

    @endif
    <input type="text" name="discount">
    <br/>
    accessibility
    @if ($errors->has('accessibility'))


        <p> {{$errors -> first('accessibility')}} </p>

    @endif
    <input type="checkbox" name="accessibility">
    <br/>
    stamps<br/>
    <input type="checkbox" name="stamps[]" value="stamp_1">stamp 1<br/>
    <input type="checkbox" name="stamps[]" value="stamp_2">stamp 2<br/>

    image_url
    @if ($errors->has('image_url'))


        <p> {{$errors -> first('image_url')}} </p>

    @endif
    <input type="file" name="image_url">
    <br/>
    type
    @if ($errors->has('type'))


        <p> {{$errors -> first('type')}} </p>

    @endif
    <select name="type">
        @foreach($types as $type)
            <option value="{{$type -> id}}">{{$type -> name}}</option>
        @endforeach
    </select>
    <br/>
    season
    @if ($errors->has('season'))


        <p> {{$errors -> first('season')}} </p>

    @endif
    <select name="season">
        @foreach($seasons as $season)
            <option value="{{$season -> id}}">{{$season -> name}}</option>
        @endforeach
    </select>
    <br/>
    size
    @if ($errors->has('size'))


        <p> {{$errors -> first('size')}} </p>

    @endif
    <select name="size">
        @foreach($sizes as $size)
            <option value="{{$size -> id}}">{{$size -> name}}</option>
        @endforeach
    </select>
    <br/>
    <input type="submit">
</form>