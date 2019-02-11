<form action="{{url('csvLoadUpdatePhoto')}}" method="post" enctype="multipart/form-data">

    {{csrf_field()}}

    Архив <input class="file" type="file" placeholder="Архив" name="photo">
    CSV <input class="file" type="file" placeholder="CSV" name="files">

    <input class="sender" type="submit"/>
</form>
