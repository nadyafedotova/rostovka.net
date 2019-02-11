

var TopSallesData= [],
    data = [],
    productTheme = $('#template');

$.ajax({
    method: "POST",
    url: $('meta[name="api_url"]').attr('content'),
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        category_id : 1
    }
}).done(function(msg) {
    for(var i= 0; i < msg.length; i++ ) {
        if(msg[i].photo === null){
            msg[i].photo = 'undefined';
        }

        data[i] = {
            dataID: msg[i].id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/'+msg[i].photo.photo_url,
            name: msg[i].name,
            names: msg[i].names,
            rostovka: msg[i].rostovka_count,
            box: msg[i].box_count,
            type: msg[i].types,
            price: Number (msg[i].prise),
            full__price: msg[i].full__price,
            rostovka__price: msg[i].rostovka__price,
            real_id: msg[i].id,
            old_prise: Number (msg[i].prise_default),
            product_url: msg[i].product_url,
            option_type: 'full__price',
            prodNew: msg[i].prodNew,
            size: msg[i].size.name
        };
    }
    $(productTheme).tmpl(data).appendTo('#newest');
    var checkData = data;
    checkPrices(data);
    checkNewest(checkData);
}) .fail(function(msg) {});

$.ajax({
    method: "POST",
    url: $('meta[name="top_tovar_url"]').attr('content'),
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        category_id : 1
    }
}).done(function(msg) {
    for(var i= 0; i < msg.length; i++ ) {
        if(msg[i].photo === null){
            msg[i].photo = 'undefined';
        }

        TopSallesData[i] = {
            dataID: msg[i].id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/'+msg[i].photo.photo_url,
            name: msg[i].name,
            names: msg[i].names,
            rostovka: msg[i].rostovka_count,
            box: msg[i].box_count,
            type: msg[i].types,
            price: Number (msg[i].prise),
            full__price: msg[i].full__price,
            rostovka__price: msg[i].rostovka__price,
            real_id: msg[i].id,
            old_prise: Number (msg[i].prise_default),
            product_url: msg[i].product_url,
            option_type: 'full__price',
            prodNew: msg[i].prodNew,
            size: msg[i].size.name
        };
    }
    $(productTheme).tmpl(TopSallesData).appendTo('#topSalles');
    var checkData = TopSallesData;
    checkTopSales(checkData);
    checkPrices(checkData);
}) .fail(function(msg) {});

function checkPrices(data) {
    var MinMaxCounter = [];
    for (var i = 0; i < data.length; i++) {
        if(data[i].price === data[i].old_prise) {
            var id = data[i].real_id;
            MinMaxCounter.push(id);
        }
    }
    $(document).ready(function(){
        for(var y = 0; y < MinMaxCounter.length; y++){
            $('[data-id="'+MinMaxCounter[y]+'"] [data-set="old--Price"]').css('visibility', 'hidden');
            $('[data-id="'+MinMaxCounter[y]+'"] [data-set="prodPrice"]').css('margin-top', '0');
        }
    })
}

function checkNewest(checkData) {
    var MinMaxCounter = [];
    for (var i = 0; i < checkData.length; i++){
        if(checkData[i].box === checkData[i].rostovka){
            var id = checkData[i].real_id;
            MinMaxCounter.push(id)
        }
    }
    disableMinimum(MinMaxCounter)
}
function checkTopSales(checkData) {
    var MinMaxCounter = [];
    for (var i = 0; i < checkData.length; i++){
        if(checkData[i].box === checkData[i].rostovka){
            var id = checkData[i].real_id;
            MinMaxCounter.push(id)
        }
    }
    disableMinimum(MinMaxCounter)
}

function disableMinimum(MinMaxCounter) {
    for(var y = 0; y < MinMaxCounter.length; y++){
        $('[data-id="'+MinMaxCounter[y]+'"] [data-set="minimum"]').css('visibility', 'hidden')
    }
}