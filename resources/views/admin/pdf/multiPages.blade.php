<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table</title>

</head>
<body>

<style>

    body { font-family: DejaVu Sans, sans-serif; }

    .page-break {
        page-break-after: always;
    }
</style>

@for($i = 0; $i < $pageCount; $i ++)

    <table border="1" style="border-style: solid">

        <tr>
            <td>Тут будет дата</td>
            <td></td>
            <td>Тут будет инфа про заказчика</td>
            <td>Тут будет инфа про постовщика</td>
            <td colspan="3">Тут будет картинка</td>
            <td></td>
        </tr>

        @foreach()
            @endforeach
    </table>

    @if($i + 1 != $pageCount)
        <div class="page-break"></div>
    @endif

    @endfor
</body>
</html>