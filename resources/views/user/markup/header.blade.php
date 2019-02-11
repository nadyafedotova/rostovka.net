
                <ul>
                    <li>
                        <a class="mainforMobile" href="{{url('/')}}"> Главная</a>
                    </li>

                    <li>
                        <a href="/brands">Бренды</a>
                    </li>

                    @foreach($categories as $category)

                        <li>
                            <a href="{{url($category -> link)}}">{{$category -> name}}@if($category -> name == "АКЦИИ")<span class="nav-label-sale"></span>@endif</a>
                        </li>

                     @endforeach


                </ul>