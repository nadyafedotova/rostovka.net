@foreach($order -> details as $detail)
    <tr>
        <td class="border_table" style="overflow: hidden;"><img src="{{public_path() .'/images/products/'.$detail -> image}}" width="70px" height="70px"></td>
        <td class="border_table">{{$detail -> tovar_name}} ({{$detail -> size_name}})</td>
        <td class="border_table">
            @if(($detail -> this_tovar_in_order_price / $detail -> tovar_in_order_count)/ $detail -> prise == $detail -> box_count)
                Ящик
            @else
                Ростовка
            @endif
        </td>
        <td class="border_table">{{$detail -> tovar_in_order_count}}</td>
        <td class="border_table">
            @if(($detail -> this_tovar_in_order_price / $detail -> tovar_in_order_count)/ $detail -> prise == $detail -> box_count)
                {{$detail -> box_count}}
            @else
                {{$detail -> rostovka_count}}
            @endif
        </td>
        <td class="border_table">{{$detail ->size_name}}</td>
        <td class="border_table">{{$detail ->prise}}</td>
        <td class="border_table">{{$detail ->this_tovar_in_order_price}}</td>
    </tr>
@endforeach