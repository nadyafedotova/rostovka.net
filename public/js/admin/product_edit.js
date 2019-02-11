var categoryData = [
    {
        id: '1',
        text: 'Категория 1'
    },
    {
        id: '2',
        text: 'Категория 2'
    },
    {
        id: '3',
        text: 'Категория 3'
    },
    {
        id: '4',
        text: 'Категория 4'
    },
    {
        id: '5',
        text: 'Категория 5'
    },
    {
        id: '6',
        text: 'Категория 6'
    },
    {
        id: '7',
        text: 'Категория 7'
    }
];
$('.category--select').select2({
    data: categoryData,
    placeholder: 'Выберите категорию'
});

var manufacturerData = [
    {
        id: '1',
        text: 'Производитель 1'
    },
    {
        id: '2',
        text: 'Производитель 2'
    },
    {
        id: '3',
        text: 'Производитель 3'
    },
    {
        id: '4',
        text: 'Производитель 4'
    },
    {
        id: '5',
        text: 'Производитель 5'
    },
    {
        id: '6',
        text: 'Производитель 6'
    },
    {
        id: '7',
        text: 'Производитель 7'
    }
];
$('.manufacturer--select').select2({
    data: manufacturerData,
    placeholder: 'Выберите производителя'
});

var currencyData = [
    {
        id: '1',
        text: 'Производитель 1'
    },
    {
        id: '2',
        text: 'Производитель 2'
    },
    {
        id: '3',
        text: 'Производитель 3'
    },
    {
        id: '4',
        text: 'Производитель 4'
    },
    {
        id: '5',
        text: 'Производитель 5'
    },
    {
        id: '6',
        text: 'Производитель 6'
    },
    {
        id: '7',
        text: 'Производитель 7'
    }
];
$('.currency--select').select2({
    data: currencyData,
    placeholder: 'Выберите валюту'
});

var sizeData = [
    {
        id: '1',
        text: 'Производитель 1'
    },
    {
        id: '2',
        text: 'Производитель 2'
    },
    {
        id: '3',
        text: 'Производитель 3'
    },
    {
        id: '4',
        text: 'Производитель 4'
    },
    {
        id: '5',
        text: 'Производитель 5'
    },
    {
        id: '6',
        text: 'Производитель 6'
    },
    {
        id: '7',
        text: 'Производитель 7'
    }
];
$('.size--select').select2({
    data: sizeData,
    placeholder: 'Выберите размер'
});

var seasonData = [
    {
        id: '1',
        text: 'Производитель 1'
    },
    {
        id: '2',
        text: 'Производитель 2'
    },
    {
        id: '3',
        text: 'Производитель 3'
    },
    {
        id: '4',
        text: 'Производитель 4'
    },
    {
        id: '5',
        text: 'Производитель 5'
    },
    {
        id: '6',
        text: 'Производитель 6'
    },
    {
        id: '7',
        text: 'Производитель 7'
    }
];
$('.season--select').select2({
    data: seasonData,
    placeholder: 'Выберите размер'
});

var typeData = [
    {
        id: '1',
        text: 'Производитель 1'
    },
    {
        id: '2',
        text: 'Производитель 2'
    },
    {
        id: '3',
        text: 'Производитель 3'
    },
    {
        id: '4',
        text: 'Производитель 4'
    },
    {
        id: '5',
        text: 'Производитель 5'
    },
    {
        id: '6',
        text: 'Производитель 6'
    },
    {
        id: '7',
        text: 'Производитель 7'
    }
];
$('.type--select').select2({
    data: typeData,
    placeholder: 'Выберите размер'
});

$('.switch-toggle-event').change(function() {
    console.log('Show ' + $(this).prop('checked'));
});

$('.available--product').change(function() {
    console.log('Available ' + $(this).prop('checked'));
});

var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '/' +
    ((''+month).length<2 ? '0' : '') + month + '/' +
    ((''+day).length<2 ? '0' : '') + day;

$('.add--date').val(output);

$("#input-44").fileinput({
    uploadUrl: "/file-upload-batch/1",
    uploadAsync: false,
    allowedFileExtensions: ["jpg", "png"],
    language: 'ru',
    minFileCount: 1,
    maxFileCount: 5,
    resizeImage: true,
    overwriteInitial: false,
    maxFileSize: 1500,
    initialPreview: [
        "http://lorempixel.com/800/460/people/1",
        "http://lorempixel.com/800/460/people/2"
    ],
    initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
    initialPreviewFileType: 'image', // image is the default and can be overridden in config below
    initialPreviewConfig: [
        {caption: "People-1.jpg", size: 576237, width: "120px", url: "/site/file-delete", key: 1},
        {caption: "People-2.jpg", size: 932882, width: "120px", url: "/site/file-delete", key: 2}
    ]
}).on('filesorted', function(e, params) {
    console.log('file sorted', e, params);
}).on('fileuploaded', function(e, params) {
    console.log('file uploaded', e, params);
});