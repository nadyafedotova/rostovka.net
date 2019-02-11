'use strict';

var TopSallesData = [],
  productTheme = $('#template');

$(productTheme).tmpl(data).appendTo('#target');

$(productTheme).tmpl(TopSallesData).appendTo('#topSalles');

var values = [],
  targetID = 0;

$('.sidebar-container input[type=checkbox]').on('change', function() {
  var target = $(this)[0].parentNode.parentNode.parentNode;
  targetID = $(this)[0].parentNode.childNodes[1].id;
  console.log(6789);
  if ($(this).is(':checked')) {
    values.push([targetID, $(this)[0].defaultValue, $(target)[0].childNodes[1].dataset.id]);
  }


  if (values.length !== 0) {
    var AppendedList = $('.choosedFilter li');
    $('.CFBlock').css('display', 'block');

    Number(AppendedList.length++);
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
    }
    RemoveItem();
  }

  if ($(this).is(':not(:checked)')) {
    var unchecked = $(this)[0].parentNode.childNodes[1].defaultValue,
      AppendedLength = $('.choosedFilter li');

    for (var i = 0; i < values.length; i++) {
      if (unchecked === values[i][1]) {
        for (var k = 0; k < AppendedLength.length; k++) {
          if (AppendedLength[k].innerText === values[i][1]) {
            AppendedLength[k].remove()
          }
        }
        values.splice(i, 1);
      }
    }
  }

  if (values.length === 0) {
    $('.CFBlock').css('display', 'none');
  }
});

function RemoveItem() {
  $('.removeAppended__Item').on('click', function() {
    var clickedTarget = $(this)[0].parentElement.textContent,
      AppendedList = $('.filterInner input');

    $(this)[0].parentElement.remove();

    for (var y = 0; y < values.length; y++) {
      if (clickedTarget === values[y][1]) {
        console.log('asda' + values.splice(y, 1))
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
  });
}

$('.removeallFilters span').on('click', function() {
  values = [];
  var AppendedList = $('.choosedFilter li');

  for (var i = 0; i < AppendedList.length; i++) {
    $(AppendedList)[i].remove();
  }

  if (values.length === 0) {
    $('.CFBlock').css('display', 'none');
  }

  $('input[type=checkbox]').prop('checked', false);
});

$('.submit_onChoose button').on('click', function() {
  values = [];
  $('.submit_onChoose').removeClass('showed');
  $('input[type=checkbox]').prop('checked', false)
});
