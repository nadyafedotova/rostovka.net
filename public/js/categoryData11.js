'use strict';
var data = [],
  productTheme = $('#template'),
  count_on_page = Number($.find('#product-show option')[0].innerText),
  paginationNum,
  paginationCount = 0,
  page_num = 1,
  filter_value = [],
  savedFilters = localStorage.getItem('filterValues'),
  getSavedFilters,
  selectedCount = Number($.find('#product-show option')[0].innerText),
  choosedType = 0,
  sizeValue = [];
var filter_mobileButton = document.querySelector(".filter--mobileButton");
if (location.href === location.origin + "/rostovka_app/public/5/category") {
  filter_mobileButton.style.display = "none";
}

//Прелоадер при загрузке страницы
$('.product--block').append('<div class="preloader"><i></i></div>');

if (localStorage.getItem('sizeValues') !== null) {
  sizeValue = localStorage.getItem('sizeValues');
  sizeValue = JSON.parse(sizeValue);
  $("#ex2").bootstrapSlider({
    value: [sizeValue[0].sizeValues[0], sizeValue[0].sizeValues[1]]
  });
}

if (localStorage.getItem('pageNum') !== null) {
  page_num = Number(localStorage.getItem('pageNum'));
} else {
  localStorage.setItem('pageNum', page_num);
}

selectedCount = Number(localStorage.getItem('selectedCount'));
getSavedFilters = JSON.parse(savedFilters);

function localData() {
  if (localStorage.getItem('pageNum') !== null) {
    page_num = Number(localStorage.getItem('pageNum'));
  } else {
    page_num = 1;
  }

  if (filter_value === null) {
    filter_value = [];
  } else {
    filter_value = JSON.parse(savedFilters);
  }

  if (selectedCount !== 0) {
    selectedCount = Number(localStorage.getItem('selectedCount'));
  } else {
    selectedCount = 24;
  }
}

///Работа с фильтрами, вызывается с DOM
var values = [],
  targetID = 0;
$('.sidebar-container input[type=checkbox]').on('change', function(event) {
  console.log(455335446);
  var target = $(this)[0].parentNode.parentNode.parentNode;
  targetID = $(this)[0].parentNode.childNodes[1].id;

  if ($(this).is(':not(:checked)')) {
    var unchecked = $(this)[0].parentNode.childNodes[1].defaultValue,
      AppendedLength = $('.choosedFilter li');
    for (var i = 0; i < values.length; i++) {
      if (unchecked === values[i][1]) {
        for (var k = 0; k < AppendedLength.length; k++) {
          AppendedLength[k].remove();
        }
        values.splice(i, 1);
      }
    }
    $('.product--block').append('<div class="preloader"><i></i></div>');

    $.ajax({
      method: 'POST',
      url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
      data: {
        category_id: $('meta[name="category_id"]').attr('content'),
        page_num: 1,
        count_on_page: count_on_page,
        filters: values,
        choosedType: choosedType,
        sizes: sizeValue
      }
    }).done(function(msg) {
      paginationNum = msg;
      paginationCounter(paginationNum);
      activateData();
    });

    localStorage.setItem('pageNum', 1);
    localStorage.setItem('filterValues', JSON.stringify(values));
    $('.error--message').remove();
  }

  if ($(this).is(':checked')) {
    values.push([targetID, $(this)[0].defaultValue, $(target)[0].childNodes[1].dataset.id]);

    localStorage.setItem('filterValues', JSON.stringify(values));
  }

  if (values.length !== 0) {
    data = [];
    var AppendedList = $('.choosedFilter li');
    $('.CFBlock').css('display', 'block');
    localStorage.setItem('pageNum', 1);
    Number(AppendedList.length++);
    console.log(AppendedList);
    for (var y = 0; y < values.length; y++) {
      for (var z = 0; z < AppendedList.length; z++) {
        if ($(this)[0].id === values[y][z]) {
          $(AppendedList)[z].remove();
        }
      }

      $('.choosedFilter').append('' +
        '<li class="appedned__item">' +
        '<span class="item" data-type="' + values[y][0] + '">' + values[y][1] + '</span>' +
        '<i class="fa fa-times-circle removeAppended__Item" aria-hidden="true"></i>' +
        '</li>');
      sizeFilter();

    }
    RemoveItem();

    $('.product--block').append('<div class="preloader"><i></i></div>');
    $.ajax({
      method: 'POST',
      url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
      data: {
        category_id: $('meta[name="category_id"]').attr('content'),
        page_num: 1,
        count_on_page: count_on_page,
        filters: values,
        choosedType: choosedType,
        sizes: sizeValue
      }
    }).done(function(msg) {

      console.log(msg);
      paginationNum = msg;
      paginationCounter(paginationNum);
      activateData();
    });

    filter_value = values;
    return filter_value;
  }

  if (values.length === 0) {
    $('.CFBlock').css('display', 'none');
  }

  return filter_value
});

// Отрисовка данных после выбора фильтра
function activateData() {
  page_num = 1;
  var sizeValue = localStorage.getItem('sizeValues');

  $.ajax({
    method: 'POST',
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: 1,
      count_on_page: count_on_page,
      filters: values,
      choosedType: choosedType,
      sizes: sizeValue
    }
  }).done(function(msg) {
    if (msg.length > 0) {
      localStorage.setItem('pageNum', 1);
      makeFilterData(msg);
      checkPrices(data);
      $('.preloader').remove();
    } else {
      $('.product-list-item ul li').css('display', 'none');
      $('.product-filter-content').css('display', 'none');
      $('.pagination-wraper').css('display', 'none');
      if ($('.error--message').length === 0) {
        $('.product-list-view').append('<div class="col-md-12 error--message">Выбранные фильтры не дали результатов</div>')
        $('.preloader').remove();
      }
    }
  });
}
// Отрисовка данных после выбора фильтра

//Получение сохраненного количество (24 - 36 - 48) товаров на страницеxw
var saved_count_on_page = Number(localStorage.getItem('selectedCount'));

//Выбор количество элементов на странице
$('#product-show').on('change', function() {
  saved_count_on_page = Number($.find('.product-sort-by.pull-right .nice-select-box .current')[0].innerText);
  $('.product--block').append('<div class="preloader"><i></i></div>');


  localStorage.setItem('selectedCount', JSON.stringify(saved_count_on_page));

  initData(saved_count_on_page);
});

//Отрисвока данных сохрененных данных, если localstorage не пуст. Если пуст, заполняются дефолтовые значения
setSavedOptionCount();

function setSavedOptionCount() {
  if (localStorage.getItem('pageNum') !== null) {
    page_num = Number(localStorage.getItem('pageNum'));

    drawItems(page_num);

  } else {
    page_num = 1;
  }

  if (saved_count_on_page !== 0) {
    for (var l = 0; l < $.find('[data-set="selectCount"] option').length; l++) {
      if (Number($.find('[data-set="selectCount"] option')[l].attributes[0].value) === saved_count_on_page) {
        $.find('[data-set="selectCount"] option')[l].setAttribute('selected', 'selected')
      }
    }
  } else {
    saved_count_on_page = 24;
    count_on_page = 24;
    localStorage.setItem('selectedCount', JSON.stringify(count_on_page));
    for (var z = 0; z < $.find('[data-set="selectCount"] option').length; z++) {
      if (Number($.find('[data-set="selectCount"] option')[z].attributes[0].value) === saved_count_on_page) {
        $.find('[data-set="selectCount"] option')[z].setAttribute('selected', 'selected')
      }
    }
  }
}

if (getSavedFilters !== null) {
  setSavedOptionCount();

  var items_Count = Number($.find('.checkbox-circle').length);
  for (var i = 0; i < getSavedFilters.length; i++) {
    for (var b = 0; b < items_Count; b++) {
      if ($.find('.checkbox-circle input')[b].dataset.value === getSavedFilters[i][0]) {
        $.find('.checkbox-circle input')[b].setAttribute("checked", "checked");
      }
    }
  }


  values = getSavedFilters;
  if (values.length !== 0) {
    var AppendedList = $('.choosedFilter li');
    $('.CFBlock').css('display', 'block');

    Number(AppendedList.length++);
    for (var y = 0; y < values.length; y++) {
      for (var z = 0; z < AppendedList.length; z++) {
        if ($.find('.checkbox-circle input')[z].dataset.value === values[y][z]) {
          $(AppendedList)[z].remove();
        }
      }

      $('.choosedFilter').append('' +
        '<li class="appedned__item">' +
        '<span class="item" data-type="' + values[y][0] + '">' + values[y][1] + '</span>' +
        '<i class="fa fa-times-circle removeAppended__Item" aria-hidden="true"></i>' +
        '</li>');
    }
    RemoveItem();
  }

  $('.product--block').append('<div class="preloader"><i></i></div>');

  $.ajax({
    method: 'POST',
    url: "../api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: Number(saved_count_on_page),
      filters: values,
      choosedType: choosedType,
      sizes: sizeValue
    }
  }).done(function(msg) {
    if (msg.length > 0) {
      for (var i = 0; i < msg.length; i++) {
        if (msg[i].photo === null) {
          msg[i].photo = 'undefined';
        }
        data[i] = {
          dataID: msg[i].id,
          imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg[i].photo.photo_url,
          name: msg[i].name,
          rostovka: msg[i].rostovka_count,
          box: msg[i].box_count,
          type: msg[i].types,
          price: Number(msg[i].prise),
          full__price: msg[i].full__price,
          rostovka__price: msg[i].rostovka__price,
          real_id: msg[i].id,
          product_url: msg[i].product_url + '/' + i,
          size: msg[i].size.name,
          old_prise: msg[i].prise_default,
          option_type: 'full__price' // Или full__price или rostovka__price
        };
      }
      checkMinMax(data);
      checkPrices(data);
      pageList = data;
      GetData(pageList);
      drawItems(pageList);
      $('.preloader').remove();
    } else {
      $('.preloader').remove();
      $('.product-list-item ul li').css('display', 'none');
      $('.product-filter-content').css('display', 'none');
      $('.pagination-wraper').css('display', 'none');
      $('.product-list-view').append('<div class="col-md-12 error--message">Выбранные фильтры не дали результатов</div>')
      $('.preloader').remove();
    }
  });

  $.ajax({
    method: 'POST',
    url: "../api/pagination",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: Number(saved_count_on_page),
      filters: values,
      choosedType: choosedType,
      sizes: sizeValue
    }
  }).done(function(msg) {
    paginationNum = msg;
    paginationCounter(paginationNum);
  });
} else {
  initData(count_on_page);
}

//Инициализация созданние деф. данных
function initData(count_on_page) {
  localData();
  data = [];
  if (localStorage !== null) {
    var local_filter_value = localStorage.getItem('filterValues'),
      itemsCount = localStorage.getItem('selectedCount'),
      filter_value = JSON.parse(local_filter_value);

    saved_count_on_page = JSON.parse(itemsCount);
    $.ajax({
      method: "POST",
      url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
      data: {
        category_id: $('meta[name="category_id"]').attr('content'),
        count_on_page: saved_count_on_page,
        filters: filter_value,
        choosedType: choosedType,
        sizes: sizeValue
      }
    }).done(function(msg) {
      paginationNum = Number(msg);
      paginationCounter(paginationNum);
      makeData(page_num, saved_count_on_page);
      if (msg < 1) {
        $('#target').append('<div style="padding-top: 20px;\n' +
          '    text-align: center;\n' +
          '    font-size: 20px;\n' +
          '    text-transform: uppercase;">Нет товаров</div>')
        $('.preloader').remove();

      }
    });
  }
}

var paginationCounter = function(paginationNum) {
  if (Number(paginationNum) !== 0) {
    paginationCount = paginationNum;
    // GetData(data);
    return paginationCount;
  } else {
    $('.pagination-wraper a').remove();
    $('.pagination-wraper span').remove();
    $('.productLine li').remove();
    $('.product-filter-content').css('display', 'none');
    scrolltop();
  }
};

//Создание данных
function makeData(page_num, count_on_page) {
  // data = [];
  $.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: count_on_page,
      filters: filter_value,
      choosedType: choosedType,
      sizes: sizeValue
    }
  }).done(function(msg) {
    if (msg.length !== 0) {
      for (var i = 0; i < msg.length; i++) {
        if (msg[i].photo !== null) {
          data[i] = {
            dataID: msg[i].id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg[i].photo.photo_url,
            name: msg[i].name,
            rostovka: msg[i].rostovka_count,
            box: msg[i].box_count,
            type: msg[i].types,
            price: Number(msg[i].prise),
            full__price: msg[i].full__price,
            rostovka__price: msg[i].rostovka__price,
            real_id: msg[i].id,
            product_url: msg[i].product_url, // раньше было так msg[i].product_url + '/' + i
            size: msg[i].size.name,
            old_prise: Number(msg[i].prise_default),
            option_type: 'full__price' // Или full__price или rostovka__price
          };
          $('.preloader').remove();
          checkMinMax(data);
          checkPrices(data);
        } else {
          data[i] = {
            dataID: msg[i].id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/image/' + 'noimage.jpg',
            name: msg[i].name,
            rostovka: msg[i].rostovka_count,
            box: msg[i].box_count,
            type: msg[i].types,
            price: Number(msg[i].prise),
            full__price: msg[i].full__price,
            rostovka__price: msg[i].rostovka__price,
            real_id: msg[i].id,
            product_url: msg[i].product_url, // раньше было так msg[i].product_url + '/' + i
            size: msg[i].size.name,
            old_prise: Number(msg[i].prise_default),
            option_type: 'full__price' // Или full__price или rostovka__price
          };
          $('.preloader').remove();
          checkMinMax(data);
          checkPrices(data);
        }
        $(document).ready(function() {
          $('.moveTo_start').addClass('not-active');
          $('.previous_Item').addClass('not-active');
        });
        GetData(data);
        $('.preloader').remove();
        //Проверка дублей

        checkPagination();
      }



    }


  }).fail(function(msg) {});
}

//Создание данных по фильтру
var numberPerPage = 24,
  pageList = [],
  currentPage = 1,
  numberOfPages = 0;

function NextData(page_num, count_on_page, filter_value) {
  data = [];

  console.log(page_num, count_on_page, filter_value);

  $('.product--block').append('<div class="preloader"><i></i></div>');
  $.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: count_on_page,
      filters: filter_value,
      choosedType: choosedType,
      sizes: sizeValue
    }
  }).done(function(msg) {

    $('.preloader').remove();
    for (var i = 0; i < msg.length; i++) {
      if (msg[i].photo === null) {
        msg[i].photo = 'undefined';
      }
      data[i] = {
        dataID: msg[i].id,
        imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg[i].photo.photo_url,
        name: msg[i].name,
        rostovka: msg[i].rostovka_count,
        box: msg[i].box_count,
        type: msg[i].types,
        price: Number(msg[i].prise),
        full__price: msg[i].full__price,
        rostovka__price: msg[i].rostovka__price,
        real_id: msg[i].id,
        product_url: msg[i].product_url + '/' + i,
        old_prise: Number(msg[i].prise_default),
        size: msg[i].size.name,
        option_type: 'full__price' // Или full__price или rostovka__price
      };
    }
    pageList = data;
    drawItems(pageList);
    checkMinMax(data);
    checkPrices(data);

    if (Number(page_num) === Number(paginationCount)) {
      $('.next_Item').addClass('not-active');
      $('.moveTo_end').addClass('not-active');
    }

    if (Number(page_num) !== Number(paginationCount)) {
      $('.next_Item').removeClass('not-active');
      $('.moveTo_end').removeClass('not-active');
    }

    if (page_num === 1) {
      $(document).ready(function() {
        $('.moveTo_start').addClass('not-active');
        $('.previous_Item').addClass('not-active');
      });
    } else {
      $(document).ready(function() {
        $('.moveTo_start').removeClass('not-active');
        $('.previous_Item').removeClass('not-active');
      })
    }

  }).fail(function(msg) {

  });
}

//Работа с пагинацией, массивом товаров
function GetData(data) {
  if (data.length > 0) {
    //work with pagination
    var Pagination = {
      code: '',
      Extend: function(data) {
        data = data || {};
        Pagination.size = data.size || 9999;
        Pagination.page = data.page || 1;
        Pagination.step = data.step || 10;
      },

      Add: function(s, f) {
        for (var i = s; i < f; i++) {
          Pagination.code += '<a>' + i + '</a>';
        }
      },

      Last: function() {
        Pagination.code += '<i>...</i><a>' + Pagination.size + '</a>';
        page_num = Pagination.size;
      },

      First: function() {
        Pagination.code += '<a>1</a><i>...</i>';
      },

      Click: function() {
        page_num = Pagination.page = +this.innerHTML;
        localStorage.setItem('pageNum', page_num);
        count_on_page = Number(localStorage.getItem('selectedCount'));
        if (getSavedFilters !== null) {
          filter_value = getSavedFilters;
        }
        NextData(page_num, count_on_page, filter_value);
        Pagination.page = +this.innerHTML;
        Pagination.Start();
        scrolltop();
      },

      Prev: function() {
        Pagination.page--;

        page_num = Pagination.page;
        if (page_num < 1) {
          Pagination.page = 1;
        }

        Pagination.Start();
        scrolltop();

        page_num = Pagination.page;
        NextData(page_num, count_on_page, filter_value);
      },

      Next: function() {
        Pagination.page++;
        if (Pagination.page > Pagination.size) {
          Pagination.page = Pagination.size;
        }

        page_num = Pagination.page;
        Pagination.Start();
        scrolltop();

        page_num = Pagination.page;
        NextData(page_num, count_on_page, filter_value);
      },

      Bind: function() {
        var a = Pagination.e.getElementsByTagName('a');
        for (var i = 0; i < a.length; i++) {
          if (+a[i].innerHTML === Pagination.page) a[i].className = 'current';
          a[i].addEventListener('click', Pagination.Click, false);
        }
        scrolltop();
      },

      Finish: function() {
        Pagination.e.innerHTML = Pagination.code;
        Pagination.code = '';
        Pagination.Bind();
      },

      Start: function() {
        if (Pagination.size < Pagination.step * 2 + 6) {
          Pagination.Add(1, Pagination.size + 1);
        } else if (Pagination.page < Pagination.step * 2 + 1) {
          Pagination.Add(1, Pagination.step * 2 + 4);
          Pagination.Last();
        } else if (Pagination.page > Pagination.size - Pagination.step * 2) {
          Pagination.First();
          Pagination.Add(Pagination.size - Pagination.step * 2 - 2, Pagination.size + 1);
        } else {
          Pagination.First();
          Pagination.Add(Pagination.page - Pagination.step, Pagination.page + Pagination.step + 1);
          Pagination.Last();
        }
        Pagination.Finish();

        var pageNum = Pagination.page;

        nextPage(pageNum);
        scrolltop();
      },

      Buttons: function(e) {
        var nav = e.getElementsByTagName('a');
        nav[0].addEventListener('click', Pagination.Prev, false);
        nav[1].addEventListener('click', Pagination.Next, false);
      },

      Create: function(e) {
        var html = [
          // '<div class="moveTo_start scrollUp" onclick="Pagination.First_Page()"><i class="fa fa-angle-double-left"></i></div>',
          '<a class="previous_Item scrollUp">← предыдущая</a>',
          '<span class="paginationItems scrollUp"></span>',
          '<a class="next_Item scrollUp">следующая →</a>'
          // '<div class="moveTo_end scrollUp" onclick="Pagination.Last_Page()"><i class="fa fa-angle-double-right"></i></div>'
        ];

        e.innerHTML = html.join('');
        Pagination.e = e.getElementsByTagName('span')[0];
        Pagination.Buttons(e);
      },

      Init: function(e, data) {
        if (localStorage.getItem('pageNum') !== null) {
          data.page = Number(localStorage.getItem('pageNum'));
          Pagination.Extend(data);
          Pagination.Create(e);
          Pagination.Start();
        } else {
          Pagination.Extend(data);
          Pagination.Create(e);
          Pagination.Start();
        }
      }
    };
  }
  //
  // function load() {
  //     makePagination();
  //     loadList();
  // }

  /// Work with Data
  function makePagination() {
    numberOfPages = getNumberOfPages();
  }

  function getNumberOfPages() {
    return Math.ceil(data.length / numberPerPage);
  }

  function nextPage(pageNum) {
    currentPage = pageNum;
    loadList(currentPage);
  }

  function loadList(currentPage) {
    var begin = ((currentPage - 1) * numberPerPage);
    var end = begin + numberPerPage;

    pageList = data.slice(begin, end);
    pageList = data;

    drawItems(pageList);
  }

  //Initialization
  var init = function() {
    Pagination.Init(document.getElementById('pagination'), {
      size: Number(paginationCount),
      page: 1,
      step: 3
    });
  };

  if (Number(paginationNum) !== 0) {
    init();
  }
}

//Отрисовка элементов TMPL
function drawItems(pageList) {
  var delay = 0;
  document.getElementById("target").innerHTML = "";
  $(productTheme).tmpl(pageList).appendTo('#target').each(function() {
    delay += 0.1;
    $(this).addClass('animated fadeIn').css('animation-delay', delay + 's');
  });
}

//Проверка дублей расстовки/ящика
function checkMinMax(data) {

  var MinMaxCounter = [];
  for (var i = 0; i < data.length; i++) {
    if (Number(data[i].box) === Number(data[i].rostovka)) {
      var id = data[i].real_id;
      MinMaxCounter.push(id);
    }
  }

  $(document).ready(function() {
    for (var y = 0; y < MinMaxCounter.length; y++) {
      $('[data-id="' + MinMaxCounter[y] + '"] [data-set="minimum"]').css('visibility', 'hidden');
    }
  })
}

// Проверка дублей скидок
function checkPrices(data) {
  var MinMaxCounter = [];
  for (var i = 0; i < data.length; i++) {
    if (Number(data[i].price) === Number(data[i].old_prise)) {
      var id = data[i].real_id;
      MinMaxCounter.push(id);
    }
  }

  $(document).ready(function() {
    for (var y = 0; y < MinMaxCounter.length; y++) {
      $('[data-id="' + MinMaxCounter[y] + '"] [data-set="old--Price"]').css('visibility', 'hidden');
      $('[data-id="' + MinMaxCounter[y] + '"] [data-set="prodPrice"]').css('margin-top', '0');
    }
  })
}

//Удаление итема из фильтра
function RemoveItem() {
  $('.removeAppended__Item').on('click', function() {

    var sizeRemove = document.querySelector(".deleteSize_button");

    if (sizeRemove !== null) {
      $('.sizes--filterItem').remove();
      localStorage.removeItem("sizeValues");


      $("#ex2").bootstrapSlider('refresh');

      if ($('.choosedFilter li').length === 0) {
        $('.CFBlock').css('display', 'none');
      }

      $('.product--block').append('<div class="preloader"><i></i></div>');
      $.ajax({
        method: 'POST',
        url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
        data: {
          category_id: $('meta[name="category_id"]').attr('content'),
          page_num: page_num,
          count_on_page: count_on_page,
          filters: values,
          choosedType: choosedType,
          sizes: sizeValue
        }
      }).done(function(msg) {
        paginationNum = msg;
        paginationCounter(paginationNum);
        activateData();
      });
    } else {
      var clickedTarget = $(this)[0].parentElement.textContent,
        AppendedList = $('.filterInner input');

      $('.error--message').remove();
      $('.product-filter-content').css('display', 'block');
      $('.pagination-wraper').css('display', 'block');

      $(this)[0].parentElement.remove();

      for (var y = 0; y < values.length; y++) {
        if (clickedTarget === values[y][1]) {
          values.splice(y, 1)
        }
      }

      for (var i = 0; i < AppendedList.length; i++) {
        if (AppendedList[i].defaultValue === clickedTarget) {
          AppendedList[i].checked = false;
        }
      }

      if (values.length === 0) {
        $('.CFBlock').css('display', 'none');
      }

      $('.product--block').append('<div class="preloader"><i></i></div>');

      console.log(data);
      $.ajax({
        method: 'POST',
        url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
        data: {
          category_id: $('meta[name="category_id"]').attr('content'),
          page_num: page_num,
          count_on_page: count_on_page,
          filters: values,
          choosedType: choosedType,
          sizes: sizeValue
        }
      }).done(function(msg) {
        paginationNum = msg;
        paginationCounter(paginationNum);
        activateData();
      });

      localStorage.setItem('filterValues', JSON.stringify(values));
    }

  });
}

//Очистка данных (Фильтры, локалсторейдж, установка данных на дефолтовые значения)
$('.removeallFilters span').on('click', function() {
  values = [];
  localStorage.removeItem('filterValues');
  localStorage.removeItem('sizeValues');

  saved_count_on_page = 0;
  var AppendedList = $('.choosedFilter li');
  localStorage.setItem('pageNum', 1);
  $('.error--message').remove();
  $('.product-filter-content').css('display', 'block');
  $('.pagination-wraper').css('display', 'block');

  for (var i = 0; i < AppendedList.length; i++) {
    $(AppendedList)[i].remove();
  }

  if (values.length === 0) {
    $('.CFBlock').css('display', 'none');
  }

  $('input[type=checkbox]').prop('checked', false);

  $('.product--block').append('<div class="preloader"><i></i></div>');
  $.ajax({
    method: 'POST',
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: 1,
      count_on_page: 24,
      filters: values,
      choosedType: choosedType,
      sizes: sizeValue = []
    }
  }).done(function(msg) {
    if (msg.length > 0) {
      pageList = [];
      makeFilterData(msg);
    }

    $('[data-target="goodsCount"] .nice-select-box .current')[0].innerText = 24;
    $('[data-target="goodsCount"] .nice-select-box [data-value="24"]').addClass('selected');
    $('[data-target="goodsCount"] .nice-select-box [data-value="36"]').removeClass('selected');
  });

  $.ajax({
    method: 'POST',
    url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: 1,
      count_on_page: 24,
      filters: null,
      choosedType: null,
      sizes: null
    }
  }).done(function(msg) {
    paginationNum = msg;
    paginationNum = Number(msg);
    page_num = 1;
    count_on_page = 24;
    filter_value = null;
    makeData(page_num, count_on_page);
    paginationCounter(paginationNum);
    setSavedOptionCount();
    $("#ex2").bootstrapSlider('refresh');
  });
});

//Создание данных после выбора фильтров
function makeFilterData(msg) {
  var filtered_data;
  data = [];
  for (var i = 0; i < msg.length; i++) {
    if (msg[i].photo === null) {
      msg[i].photo = 'undefined';
    }

    data[i] = {
      dataID: msg[i].id,
      imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg[i].photo.photo_url,
      name: msg[i].name,
      rostovka: msg[i].rostovka_count,
      box: msg[i].box_count,
      type: msg[i].types,
      price: Number(msg[i].prise),
      full__price: msg[i].full__price,
      rostovka__price: msg[i].rostovka__price,
      real_id: msg[i].id,
      product_url: msg[i].product_url + '/' + i,
      size: msg[i].size.name,
      old_prise: Number(Number(msg[i].prise_default)),
      option_type: 'full__price' // Или full__price или rostovka__price
    };
  }

  pageList = data;
  filtered_data = data;

  drawItems(pageList);
  GetData(filtered_data);

  //Проверка дублей
  checkMinMax(data);
  checkPrices(data);
}

// Сортировка данных
$('#short-by').on('change', function() {
  data = null;
  pageList = null;
  choosedType = Number($('#short-by :selected').val());
  $('.product--block').append('<div class="preloader"><i></i></div>');
  count_on_page = Number(localStorage.getItem('selectedCount'));
  page_num = Number(localStorage.getItem('pageNum'));
  $.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: count_on_page,
      filters: null,
      choosedType: choosedType,
      sizes: null
    }
  }).done(function(msg) {
    if (msg) {
      $('.preloader').remove();
      for (var i in msg) {
        console.log(msg[i]);
        if (msg[i].photo === null) {
          msg[i].photo = 'undefined';
        }

        data[i] = {
          dataID: msg[i].id,
          imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg[i].photo.photo_url,
          name: msg[i].name,
          rostovka: msg[i].rostovka_count,
          box: msg[i].box_count,
          type: msg[i].types,
          price: Number(msg[i].prise),
          full__price: msg[i].full__price,
          rostovka__price: msg[i].rostovka__price,
          real_id: msg[i].id,
          old_prise: Number(msg[i].prise_default),
          product_url: msg[i].product_url + '/' + i,
          size: msg[i].size.name,
          option_type: 'full__price' // Или full__price или rostovka__price
        };
      }

      pageList = data;

      drawItems(pageList);
      checkPrices(data);
      checkMinMax(data);
    }
  }).fail(function(msg) {

  });

  $.ajax({
    method: 'POST',
    url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: page_num,
      count_on_page: count_on_page,
      filters: null,
      sizes: null
    }
  }).done(function(msg) {
    if (msg) {
      console.log(msg);
    } else {
      paginationNum = msg;
      paginationCounter(paginationNum);
    }
  });
});


var GetSlideValue = function() {
  var newVal = $('#ex2').data('bootstrapSlider').getValue(),
    sizeValue = [];

  page_num = Number(localStorage.getItem('pageNum'));

  sizeValue.push({
    'sizeValues': newVal
  });

  localStorage.setItem('sizeValues', JSON.stringify(sizeValue));

  $('.product--block').append('<div class="preloader"><i></i></div>');

  $('.CFBlock').css('display', 'block');
  $('.sizes--filterItem').remove();
  sizeFilter();
  console.log(data);

  $.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + "/api/products",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: 1,
      count_on_page: count_on_page,
      choosedType: choosedType,
      filters: filter_value,
      sizes: sizeValue
    }
  }).done(function(msg) {

    if (msg.length !== 0) {
      localStorage.removeItem('pageNum');
      $('.product-list-view li').css('display', 'block');
      $('.pagination-wraper').css('display', 'block');
      $('.product-filter-content').css('display', 'block');
      $('.alert.alert-warning').remove();
      makeFilterData(msg);

      $('.preloader').remove();
    } else {
      $('.preloader').remove();
      if ($('.productLine')[0].childNodes.length === 0) {
        $('.preloader').remove();
        $('#target').append('<div style="padding-top: 20px;\n' +
          '    text-align: center;\n' +
          '    font-size: 20px;\n' +
          '    text-transform: uppercase;">Нет товаров</div>')

      }
    }
  }).fail(function(msg) {

  });

  $.ajax({
    method: 'POST',
    url: $('meta[name="root-site"]').attr('content') + "/api/pagination",
    data: {
      category_id: $('meta[name="category_id"]').attr('content'),
      page_num: 1,
      count_on_page: count_on_page,
      filters: filter_value,
      sizes: sizeValue
    }
  }).done(function(msg) {
    if (msg.length === 0) {

    } else {
      localStorage.removeItem('pageNum');
      paginationNum = msg;
      paginationCounter(paginationNum);
    }
  });
};
$("#ex2").bootstrapSlider({
  tooltip: 'always'
}).on('slideStop', GetSlideValue);


// Работа с иконками для моб. версии
$('.filter--mobileButton').on('click', function() {
  $('.category--Filters').addClass('active');
  $('.overLay').addClass('active')
});
$('.category--Filters .close-icon, .overLay').on('click', function() {
  $('.category--Filters').removeClass('active');
  $('.overLay').removeClass('active');
});
// Медленный скролл
function scrolltop() {
  var body = $("html, body");
  body.stop().animate({
    scrollTop: 0
  }, 500, 'swing');
}

function checkPagination() {
  if ($('.paginationItems a').length <= 1) {
    $('.next_Item.scrollUp').css('display', 'none')
  } else {
    $('.next_Item.scrollUp').css('display', 'inline-block')
  }
}

sizeFilter();

function sizeFilter() {
  if (localStorage.getItem('sizeValues') !== null) {

    $('.CFBlock').css('display', 'block');
    sizeValue = localStorage.getItem('sizeValues');
    sizeValue = JSON.parse(sizeValue);
    if (sizeValue[0].sizeValues[0] !== 10 || sizeValue[0].sizeValues[1] !== 50) {
      $('.choosedFilter').append('' +
        '<li class="appedned__item sizes--filterItem" data-type="filterType">' +
        '<span class="item" data-type="' + sizeValue[0].sizeValues[0] + '">' + "Размеры: " + sizeValue[0].sizeValues[0] + "-" + sizeValue[0].sizeValues[1] + '</span>' +
        '<i class="fa fa-times-circle removeAppended__Item deleteSize_button" aria-hidden="true"></i>' +
        '</li>');
      RemoveItem();
    } else if (values.length === 0) {
      $('.CFBlock').css('display', 'none');
    }
  }
}
var close_icon = document.querySelector(".close-icon");
var overLay = document.querySelector(".overLay");
overLay.addEventListener('click', function() {
  $("body").css("overflow", "auto");
});
close_icon.addEventListener('click', function() {
  $("body").css("overflow", "auto");
});
filter_mobileButton.addEventListener('click', function() {
  $("body").css("overflow", "hidden");
});
