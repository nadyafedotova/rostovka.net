'use strict';
Cart_data = localStorage.getItem('Cart_data');
Cart_data = JSON.parse(Cart_data);

if (Cart_data === null) {
  var Cart_data = [{
    row: [],
    cartCount: 0,
    cartProducts_summ: 0
  }];
  localStorage.setItem('Cart_data', JSON.stringify(Cart_data));
} else {
  var Cart_data = [{
    row: [],
    cartCount: 0,
    cartProducts_summ: 0
  }];
}

function Cart_template(Cart_data) {
  $.get($('meta[name="root-site"]').attr('content') + '/cartTmpl/cart.html', {}, function(templateBody) {
    $.tmpl(templateBody, Cart_data).appendTo('#cartTemplate');
    $.tmpl(templateBody, Cart_data).appendTo('#cartLolTemplate');
  });

  window.addEventListener("storage", function(e) {
    if (e.key === "Cart_data") {
      if (JSON.parse(e.newValue)[0].cartProducts_summ !== JSON.parse(e.oldValue)[0].cartProducts_summ) {
        localStorage.setItem("Cart_data", e.newValue);
      }
    }
  });
}

var hidden__price, targetID;

$(document).on("click", '[data-set="buyButton"]', function(event) {
  $('.dropdownCart .cartButton').css('display', 'block');
  $('.cartButton').css('margin', '0');
  Cart_data = localStorage.getItem('Cart_data');
  Cart_data = JSON.parse(Cart_data);
  if ($.find('.one--product').length > 0) {
    if (event.target.className == 'popular') {
      console.log(event.target.className);
      console.log(event.target);
      var checkif_true = false,
        domtargetID = 0,
        choosedType = 1;
      domtargetID = Number(event.target.offsetParent.parentElement.parentElement.dataset.id);
      console.log(event.target.offsetParent.parentElement.parentElement.dataset.id);
      checkDomPage(event, domtargetID, checkif_true);
    } else {
      targetID = Number($('#productID')[0].dataset.prodid);

      var itemQuant = Number($('.quantity').val()),
        domItem_price = Number($.find('.choosed')[0].firstElementChild.lastElementChild.firstChild.innerText),
        trueTarget = false,
        choosedType = String($('.radio.choosed input').val());

      if (Cart_data[0].row.length === 0) {
        getProductData(targetID, itemQuant, domItem_price, choosedType);
      } else {
        for (var l = 0; l < Cart_data[0].row.length; l++) {
          if (targetID === Cart_data[0].row[l].buy_real_id) {
            targetID = l;
            additocart(targetID, itemQuant, domItem_price);
            return false
          } else {
            trueTarget = false;
          }
        }

        if (trueTarget === false) {
          getProductData(targetID, itemQuant, domItem_price, choosedType);
        }
      }
    }
  } else if ($.find('.searchPage').length > 0) {
    var checkif_true = false,
      domtargetID = 0,
      choosedType = 1;
    domtargetID = Number(event.target.offsetParent.offsetParent.offsetParent.dataset.id);
    console.log(domtargetID);
    checkDomPage(event, domtargetID, checkif_true);
  } else {
    var checkif_true = false,
      domtargetID = 0,
      choosedType = 1;


    if ($('.mainpageGoodsBlock').length > 0) {
      domtargetID = Number(event.target.offsetParent.offsetParent.offsetParent.dataset.id);
      console.log(domtargetID);
      checkDomPage(event, domtargetID, checkif_true);
    } else {
      domtargetID = Number(event.target.offsetParent.offsetParent.offsetParent.dataset.id);
      console.log(domtargetID);
      checkDomPage(event, domtargetID, checkif_true);
    }
  }
});

function checkDomPage(event, domtargetID, checkif_true) {
  for (var i = 0; i < data.length; i++) {
    if (domtargetID === Number(data[i].dataID)) {
      hidden__price = data[i].full__price;
    }
  }
  targetID = domtargetID;
  if (Cart_data[0].row.length === 0) {
    console.log('add')
    initAdd(event, targetID, Cart_data);
  } else {
    checkDublicate(event, targetID, checkif_true);
  }
}

function removeItemAdd() {
  $('.chooseItem').remove();
  $('.product-price').remove();
  $('.single-variation-wrap').append('' +
    '<div class="product--is--inCart">' +
    '<span>Товар в корзине</span>' +
    '<div class="move--to--cart"><a class="cart--url">Перейти в корзину</a></div>' +
    '</div>');
  setUrl();
}

function setUrl() {
  var url = $('meta[name="root-site"]').attr('content') + '/cart';
  $('.cart--url').attr("href", url);
}

function getProductData(targetID, itemQuant, domItem_price, choosedType) {
  var poductinnerID = Number($.find('[data-prodid]')[0].dataset.prodid),
    productData = [];

  $('button.buyProduct_inner').attr("disabled", true);

  $.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + "/api/product",
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      id: poductinnerID
    }
  }).done(function(msg) {
    $('button.buyProduct_inner').attr("disabled", false);
    productData.push(msg);

    if (Cart_data[0].row.length !== 0) {
      pushtoCart(choosedType);
    } else {
      pushtoCart(choosedType);
      $('.isClear').remove()
    }

    function pushtoCart(choosedType) {
      console.log($.find('[data-set="boxset"] .iPrice'));
      if (msg.photo === null) {
        msg.photo = 'undefined';
      }

      Cart_data[0].row.push({
        productID: productData[0].id,
        targetID: productData[0].id,
        imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + msg.photo.photo_url,
        name: productData[0].name,
        names: productData[0].names,
        quant: 'count',
        price: Number($('.choosed .iPrice')[0].innerText),
        quantity: Number($('.quantity.input-lg').val()),
        quantityPrice: Number($('.choosed .iPrice')[0].innerText) * Number($('.quantity.input-lg').val()),
        rostovka__price: Number($.find('[data-set="rotovkaset"] .iPrice')[0].innerText),
        buy_real_id: productData[0].id,
        size: productData[0].size.name,
        cart_product_url: productData[0].product_url,
        names: productData[0].names,
        selected_value: choosedType,
        price_per_pair: productData[0].prise,
        box__price: Number($.find('[data-set="boxset"] .iPrice')[0].innerText)
      });

      $('.dropdownCart ul li').remove();
      Cart_data[0].cartCount = Cart_data[0].row.length;
      removeItemAdd();
      getPrice();
      cartSumm();
      Cart_template(Cart_data);
    }
  }).fail(function(msg) {

  });
}

function additocart(targetID, itemQuant, domItem_price) {
  Cart_data[0].row[targetID].quantity += itemQuant;
  Cart_data[0].row[targetID].quantityPrice = Cart_data[0].row[targetID].quantity * domItem_price;
  Cart_data[0].row[targetID].price = domItem_price;

  var allPrice = 0;
  for (var i = 0; i < Cart_data[0].row.length; i++) {
    allPrice += domItem_price * Cart_data[0].row[i].quantity;
  }
  Cart_data[0].cartProducts_summ = allPrice;

  cartSumm();
  localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
  $('.dropdownCart ul li').remove();
  Cart_template(Cart_data);
}

function checkDublicate(event, targetID, checkif_true) {
  if (checkif_true === false) {
    for (var i = 0; i < Cart_data[0].row.length; i++) {
      if (targetID === Number(Cart_data[0].row[i].productID)) {
        checkif_true = false;
        dublicate(targetID, Cart_data);
        break;
      } else {
        checkif_true = true;
      }
    }
  }

  if (checkif_true !== false) {
    initAdd(event, targetID, Cart_data);
  }
}

function initAdd(event, targetID, Cart_data) {
  console.log('initAdd')
  addtoCart(event, targetID);
  Cart_template(Cart_data);
  getPrice();
  cartSumm();
}

var arrayItemId = 0;

function dublicate(targetID, Cart_data) {
  //если индификторы совпадают, увеличиваем колличество и записываем ID элемента в объекте
  for (var i = 0; i < Cart_data[0].row.length; i++) {
    if (Cart_data[0].row[i].buy_real_id === targetID) {
      // conversion(Cart_data[0].row[i].buy_real_id);
      Cart_data[0].row[i].quantity++;
      arrayItemId = i;
    }
  }
  //если индификторы совпадают, увеличиваем колличество и записываем ID элемента в объекте

  mainPrice = Cart_data[0].row[arrayItemId].price;
  updPrice = mainPrice * Cart_data[0].row[arrayItemId].quantity;

  var valueofPrice = $.find('[product-id="' + targetID + '"] .price');
  $(valueofPrice)[0].innerText = updPrice;

  Cart_data[0].row[arrayItemId].quantityPrice = updPrice;

  localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

  var valueofQuantity = $.find('[product-id="' + targetID + '"] input');
  $(valueofQuantity).val(Cart_data[0].row[arrayItemId].quantity);

  counterFn(mainPrice, targetID, updPrice);
}

var topSalesActive = false;

function topSalesTab(event) {
  return topSalesActive = true
}

function defaultTab(event) {
  return topSalesActive = false
}

function addDublicate(targetID) {
  // for(var i = 0; )
  console.log(targetID);
}
var qid = 0,
  counter = 0;

function addtoCart(event, targetID) {

  if ($('.searchPage').length > 0) {
    var storageData = localStorage.getItem("Cart_data"),
      flag = null,
      getTargetId = null;
    Cart_data = JSON.parse(storageData);

    $.ajax({
    method: "POST",
      url: $('meta[name="root-site"]').attr('content') + "/api/product",
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: targetID
      }
    }).done(function(data) {
    	console.log(data);
      if (Cart_data[0].row.length !== 0) {
        for (var i in Cart_data[0].row) {
          if (Cart_data[0].row[i].productID === searchPagegoodID) {
            flag = true;
            getTargetId = i;
          }
        }

        if (flag === true) {
          Cart_data[0].row[getTargetId].quantity++;
          Cart_data[0].row[getTargetId].quantityPrice = Cart_data[0].row[getTargetId].quantity * Cart_data[0].row[getTargetId].rostovka__price;

          Number($('.cart-count')[0].innerText = counter);

          if (Cart_data.length > 0) {
            $('.isClear').remove()
          }
          localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
          $('.cartBl li').remove();
          getPrice();
          cartSumm();
          Cart_template(Cart_data);
          flag = false;
          getTargetId = null;
          return false;
        } else {
          if (data.photo === null) {
            data.photo = '';
          }

          Cart_data[0].row.push({
            productID: data.id,
            targetID: data.id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + data.photo.photo_url,
            name: data.name,
            names: data.names,
            quant: 0,
            price: data.full__price,
            size: data.size.name,
            quantity: 1,
            quantityPrice: data.full__price,
            rostovka__price: data.rostovka__price,
            buy_real_id: data.id,
            cart_product_url: data.product_url,
            selected_value: '0',
            price_per_pair: data.prise,
            box__price: data.full__price
          });
          localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

          $('.cartBl li').remove();

          counter++;

          Number($('.cart-count')[0].innerText = counter);

          if (Cart_data.length > 0) {
            $('.isClear').remove()
          }

          $('.dropdownCart ul li').remove();
          Cart_data[0].cartCount = Cart_data[0].row.length;

          localStorage.Cart_data = JSON.stringify(Cart_data);

          getPrice();
          cartSumm();
          Cart_template(Cart_data);
          flag = false;
          return false;
        }

      } else {
        if (data.photo === null) {
          data.photo = '';
        }

        Cart_data[0].row.push({
          productID: data.id,
          targetID: data.id,
          imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/' + data.photo.photo_url,
          name: data.name,
          names: data.names,
          quant: 0,
          price: data.full__price,
          size: data.size.name,
          quantity: 1,
          quantityPrice: data.full__price,
          rostovka__price: data.rostovka__price,
          buy_real_id: data.id,
          cart_product_url: data.product_url,
          selected_value: '0',
          price_per_pair: data.prise,
          box__price: data.full__price
        });
        localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

        $('.cartBl li').remove();

        counter++;

        Number($('.cart-count')[0].innerText = counter);

        if (Cart_data.length > 0) {
          $('.isClear').remove()
        }

        $('.dropdownCart ul li').remove();
        Cart_data[0].cartCount = Cart_data[0].row.length;

        localStorage.Cart_data = JSON.stringify(Cart_data);

        getPrice();
        cartSumm();
        Cart_template(Cart_data);
      }
    });

  } else {
    var imgurl, gTitle, gQuant, gprice, productIndex, selected_quantity, rostovkaPrice;
    Number($('.cart-count')[0].innerText = counter);

    if (Cart_data.length > 0) {
      $('.isClear').remove()
    }

    if (topSalesActive === true) {
      data = TopSallesData;

      for (var a = 0; a < data.length; a++) {
        if (targetID === data[a].real_id) {
          targetID = a;
        }
      }
    } else {
      for (var z = 0; z < data.length; z++) {
        if (targetID === data[z].real_id) {
          targetID = z;
          break;
        }
      }
    }
    counter++;

    Number($('.cart-count')[0].innerText = counter);

    if (Cart_data.length > 0) {
      $('.isClear').remove()
    }

    if (topSalesActive === true) {
      data = TopSallesData;

      for (var a = 0; a < data.length; a++) {
        if (targetID === data[a].real_id) {
          targetID = a;
        }
      }
    } else {
      for (var z = 0; z < data.length; z++) {
        if (targetID === data[z].real_id) {
          targetID = z;
          break;
        }
      }
    }

    productIndex = Number(data[targetID].real_id);
    gTitle = data[targetID].name;
    selected_quantity = 1;
    gQuant = 0;
    gprice = Number(data[targetID].full__price);
    imgurl = data[targetID].imgUrl;
    rostovkaPrice = data[targetID].rostovka__price;

    Cart_data[0].row.push({
      productID: productIndex,
      targetID: productIndex,
      imgUrl: imgurl,
      name: gTitle,
      names: data[targetID].names,
      quant: gQuant,
      price: gprice,
      size: data[targetID].size,
      quantity: selected_quantity,
      quantityPrice: gprice,
      rostovka__price: rostovkaPrice,
      buy_real_id: data[targetID].real_id,
      cart_product_url: data[targetID].product_url,
      selected_value: '0',
      price_per_pair: data[targetID].price,
      box__price: gprice
    });

    qid++;

    $('.dropdownCart ul li').remove();
    Cart_data[0].cartCount = Cart_data[0].row.length;

    localStorage.Cart_data = JSON.stringify(Cart_data);
  }
}
// localStorage.clear();
function CartEmpty() {
  $('.dropdownCart ul').append('<span class="isClear">Корзина пуста</span>');
  $('.dropdownCart .cartButton').css('display', 'none');
  $('.cartButton').css('margin', '0');
}

$(document).on('click', '.removeItem__cart', function() {
  var clicked_targetID = Number($(this)[0].parentElement.dataset.id);

  for (var i = 0; i < Cart_data[0].row.length; i++) {
    if (Cart_data[0].row[i].targetID === clicked_targetID) {
      Cart_data[0].cartProducts_summ = Cart_data[0].cartProducts_summ - Cart_data[0].row[i].quantityPrice;
      Cart_data[0].row.splice(i, 1);
      $(this)[0].parentElement.remove();
    }
  }

  Cart_data[0].cartCount = Cart_data[0].row.length;
  if (Cart_data[0].row.length === 0) {
    CartEmpty()
  }

  counter--;
  Number($('.cart-count')[0].innerText = counter);

  localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
  cartSumm();
});

var updPrice = 0,
  mainPrice = 0,
  quantity = 0,
  target, target_id = 0;

$(document).on('click', '.Cart_Button_Plus', function() {
  var target_dataset, flag = false,
    minus = false;

  if ($(this).closest('li').attr('data-id') === undefined) {
    var parentFinder = $(this).parents()[5];
    target_dataset = $(parentFinder).attr('data-id');
    flag = false;
    conversion(target_dataset, flag, minus);
    $.find('[data-set="totalCost"]')[0].innerHTML = Cart_data[0].cartProducts_summ + ' грн';
  } else {
    target_dataset = Number($(this).closest('li').attr('data-id'));
    flag = true;
    conversion(target_dataset, flag, minus);
  }
});

$(document).on('click', '.Cart_Button_Minus', function() {
  var target_dataset, flag = false,
    minus = true;

  if ($(this).closest('li').attr('data-id') === undefined) {
    var parentFinder = $(this).parents()[5];
    target_dataset = $(parentFinder).attr('data-id');
    flag = false;
    conversion(target_dataset, flag, minus);


    $.find('[data-set="totalCost"]')[0].innerHTML = Cart_data[0].cartProducts_summ + ' грн';
  } else {
    target_dataset = Number($(this).closest('li').attr('data-id'));
    flag = true;
    conversion(target_dataset, flag, minus);
  }
});

function conversion(target_dataset, flag, minus) {
  updPrice = 0;
  if (minus !== true) {
    for (var i = 0; i < Cart_data[0].row.length; i++) {
      if (Number(target_dataset) === Cart_data[0].row[i].targetID) {
        target_id = i;
        mainPrice = Cart_data[0].row[i].price;
        Cart_data[0].row[i].quantity++;
      }
    }

    updPrice = mainPrice * Cart_data[0].row[target_id].quantity;
    Cart_data[0].row[target_id].quantityPrice = updPrice;
    localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
  } else {
    for (var y = 0; y < Cart_data[0].row.length; y++) {
      if (Number(target_dataset) === Cart_data[0].row[y].targetID) {
        target_id = y;
        mainPrice = Cart_data[0].row[y].price;
      }
    }
    if (Cart_data[0].row[target_id].quantity > 1) {
      Cart_data[0].row[target_id].quantity--;
    }

    if (Cart_data[0].row[target_id].quantityPrice > mainPrice) {
      updPrice = Cart_data[0].row[target_id].quantityPrice;
      updPrice -= mainPrice;
      Cart_data[0].row[target_id].quantityPrice = updPrice;
    } else {
      updPrice = Cart_data[0].row[target_id].quantityPrice;
    }
    Cart_data[0].row[target_id].quantityPrice = updPrice;
    localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
  }

  if (flag !== false) {
    $.find('[data-cart-summ="cartCount"]')[target_id].innerText = updPrice;
  } else {
    drawPrice(updPrice, target_dataset);
  }

  counterFn(mainPrice, targetID, updPrice);
}

function drawPrice(updPrice, target_dataset) {
  if (updPrice !== 0) {
    $('[data-id="' + target_dataset + '"] .counting')[0].innerText = updPrice + ' грн';
  }
}

function getPrice() {
  var allPrice = 0;
  for (var i = 0; i < Cart_data[0].row.length; i++) {
    allPrice += Cart_data[0].row[i].quantityPrice;
  }
  Cart_data[0].cartProducts_summ = allPrice;
  localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

  return allPrice
}

function counterFn(mainPrice) {
  var price = getPrice();
  if (price >= mainPrice) {
    Cart_data[0].cartProducts_summ = price;
    cartSumm();
  }
}

function cartSumm() {
  if ($.find('[data-set="cart-summ"]').length !== 0) {
    $.find('[data-set="cart-summ"]')[0].innerText = Math.round(Cart_data[0].cartProducts_summ);
    $.find('[data-set="cartCount"]')[0].innerText = Cart_data[0].cartCount;
    $.find('[data-set="cart-inner-summ"]')[0].innerText = Math.round(Cart_data[0].cartProducts_summ) + ' грн';
  }
}

cartSumm();

function getData() {
  var retrievedData = localStorage.getItem("Cart_data");
  if (retrievedData !== null) {
    Cart_data = JSON.parse(retrievedData);
    $('.isClear').remove();
    cartSumm();
    Cart_template(Cart_data);
  }
}

getData();

if (Cart_data[0].row.length === 0) {
  $('.dropdownCart ul').append('<span class="isClear">Корзина пуста</span>');
  $('.dropdownCart .cartButton').css('display', 'none');
  $('.cartButton').css('margin', '0')
}
var filter_mobileButton = document.querySelector(".filter--mobileButton");
if (location.href === location.origin + "/rostovka_app/public/cart") {
  filter_mobileButton.style.display = "none";
}
if (location.href === location.origin + "/rostovka_app/public/userinfo") {
  filter_mobileButton.style.display = "none";
}

let delArray = [];
function updateCart() {
  Cart_data = localStorage.getItem('Cart_data');
  Cart_data = JSON.parse(Cart_data);
  let ids = []
  for (let key = 0; key < Cart_data[0].row.length; key++) {
    ids.push(Cart_data[0].row[key].productID);
  }

  if ( ids.length > 0 )
    $.ajax({
      method: "POST",
      url: $('meta[name="root-site"]').attr('content') + "/api/checkCard",
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        ids: ids
      }
    }).done(function(result) {
      result.forEach((msg) => {
        Cart_data[0].row.forEach((product, key) => {
          if ( product.productID == msg.id )
            if ( !msg || msg.accessibility != '1' || msg.show_product != '1' ) {
              delArray.push(key);
            } else {
              Cart_data[0].row[key].imgUrl = $('meta[name="root-site"]').attr('content') + '/images/products/' + msg.photo.photo_url;
              Cart_data[0].row[key].name = msg.name;
              Cart_data[0].row[key].price = (Cart_data[0].row[key].selected_value == '0')? msg.full__price: msg.rostovka__price;
              Cart_data[0].row[key].size = msg.size.name;
              Cart_data[0].row[key].quantityPrice = (Cart_data[0].row[key].selected_value == '0')? Cart_data[0].row[key].quantity * msg.full__price : Cart_data[0].row[key].quantity * msg.rostovka__price;
              Cart_data[0].row[key].rostovka__price = msg.rostovka__price;
              Cart_data[0].row[key].buy_real_id = msg.id;
              Cart_data[0].row[key].cart_product_url = msg.product_url;
              Cart_data[0].row[key].price_per_pair = msg.prise;
              Cart_data[0].row[key].box__price = msg.full__price;
            }
        })
      })
    });
}

updateCart();

$(document).ajaxStop(function () {
  for (var i = Cart_data[0].row.length - 1; i >= 0; i--) {
    if(delArray.includes(i)) Cart_data[0].row.splice(i, 1);
  }

  Cart_data[0].cartCount = Cart_data[0].row.length;
  getPrice();
  cartSumm();
  localStorage.setItem('Cart_data', JSON.stringify(Cart_data));
});
