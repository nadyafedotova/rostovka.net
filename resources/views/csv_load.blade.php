csv load test


<form  method="post" action="{{url('api/checkData')}}" enctype="multipart/form-data" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="_method" value="POST">

    @if ($errors->any()&& $errors -> first('files'))
        <div class="alert alert-danger">
            {{$errors -> first('files')}}
        </div>
    @endif

    <p>CSV</p>
    <input type="file" name="files">
    <p>Photos</p>
    <input type="file" name="photo" >

    <input type="submit">
</form>