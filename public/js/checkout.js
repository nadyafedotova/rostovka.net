Cart_data = localStorage.getItem('Cart_data');
Cart_data = JSON.parse(Cart_data);

if(Cart_data === null || Cart_data[0].cartProducts_summ == 0) {
    window.location.href = "https://rostovka.net/cart";
}

if(Cart_data === null) {
    $('.has-feedback button').attr("disabled", "disabled");
}

if(Cart_data !== null){
    var orderTotal = Cart_data[0].cartProducts_summ;
}

$('.order-total span')[0].innerText = orderTotal + ' грн';
$('.is--Mobile .order-total .amount')[0].innerText = orderTotal + ' грн';

if($('.checkoutPage')){
    $('.cartBl').css('display', 'none');
}
$('.successful_Buy button').on('click', function () {
    //dataLayer.push({'event': 'zakaz'});
    Cart_data = null;
    localStorage.setItem('Cart_data', JSON.stringify(Cart_data));
    window.location.href = "https://rostovka.net";

});
'use strict';
$(document).ready(function() {
    var success = null;
    $('#contact_form').bootstrapValidator({
        live: 'enabled',
        submitButton: '[type="submit"]',
        message: '',
        submitHandler: function(validator, form, submitButton, e) {
            if(Cart_data === null) {
                console.log('asdasdas');
                e.preventDefault();
                return false
            } else {
                var inputArray = $(form).serializeArray();
                console.log(inputArray);
                for (var i = 0; i < Cart_data[0].row.length; i++){
                    inputArray = inputArray.concat(
                        {'name' : 'tovar['+i+'][product_id]','value': Cart_data[0].row[i].productID},
                        {'name' : 'tovar['+i+'][quantity]','value': Cart_data[0].row[i].quantity},
                        {'name' : 'tovar['+i+'][selected_value]','value': Cart_data[0].row[i].selected_value},
                        {'name' : 'tovar['+i+'][quantityPrice]','value': Cart_data[0].row[i].quantityPrice});
                }


                inputArray = inputArray.concat({'name' : 'summ','value': Cart_data[0].cartProducts_summ});

                $.ajax({
                    type: 'POST',
                    url: $('meta[name="checkout_url"]').attr('content'),
                    data: inputArray,
                    success: function(result) {
                        $('.successful_Buy').modal();
                        $('.form-field-wrapper input').val('');
                        localStorage.clear();
                        $.find('[data-set="cart-summ"]')[0].innerText = 0;
                        $.find('[data-set="cartCount"]')[0].innerText = 0;
                        $.find('[data-set="cart-inner-summ"]')[0].innerText = 0;
                        Cart_data = null;
                        localStorage.setItem('Cart_data', JSON.stringify(Cart_data));
                        $('.dropdownCart ul li').remove();
                        $('.dropdownCart ul').append('<span class="isClear">Корзина пуста</span>');;
                    }
                });
                return false;
            }
        },
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            first_name: {
                validators: {
                    stringLength: {
                        min: 2
                    },
                    notEmpty: {
                        message: 'Введите имя'
                    }
                }
            },
            last_name: {
                validators: {
                    stringLength: {
                        min: 2
                    },
                    notEmpty: {
                        message: 'Введите фамилия'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Введите вашу почту'
                    },
                    emailAddress: {
                        message: 'Введите корректный адрес эл. почты'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9-_@\.]+$/,
                        message: 'Введите корректный адрес эл. почты'
                    }
                }
            },

            phone: {
                validators: {
                    notEmpty: {
                        message: 'Введите ваш номер телефона'
                    },
                    stringLength: {
                        min: 8,
                        message: 'Введите корректный номер телефон'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'Введите ваш адрес'
                    }
                }
            },
            city: {
                validators: {
                    notEmpty: {
                        message: 'Введите ваш город проживания'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'Введите вашу страну проживания'
                    }
                }
            },
            zip: {
                validators: {
                    stringLength: {
                        min: 5,
                        message: 'Введите корректный почтовый индекс'
                    },
                    notEmpty: {
                        message: 'Введите почтовый индекс'
                    },
                    regexp: {
                        regexp: /^[0-9\.]+$/,
                        message: 'Введите корректный почтовый индекс'
                    }
                }
            },
            password: {
                validators: {
                    stringLength: {
                        min: 6,
                        message: 'Минимально 6 символов'
                    },
                    notEmpty: {
                        message: 'Пароль обязательно'
                    },
                    identical: {
                        field: 'confirmPassword'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'Подтвердите пароль!'
                    },
                    stringLength: {
                        min: 6
                    },
                    identical: {
                        field: 'password',
                        message: 'Пароли должны совпадать'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        $('#success_message').slideDown({ opacity: "show" }, "slow");// Do something ...
        $('#contact_form').data('bootstrapValidator').resetForm();

        // Prevent form submission
        e.preventDefault();

        // Get the form instance
        var $form = $(e.target);

        // Get the BootstrapValidator instance
        var bv = $form.data('bootstrapValidator');

        success = true;

        sendData();
    });
});

function sendData() {
    console.log(success)
}

var adress = document.querySelector(".adress");
var secession =document.querySelector(".secession");
var pickup = document.querySelector(".pickup");
var pickup_mob = document.querySelector(".pickup_mob");
var shipping_method =document.getElementsByClassName("shipping_method");
for(var i =0;i<shipping_method.length;i++){
    shipping_method[i].addEventListener("change",function () {
        if(this.checked===true){
            adress.style.display="block";
            secession.style.display="block";
        }
    })
}
pickup.addEventListener("click",function () {
    if(pickup.checked===true){
        adress.style.display="none";
        secession.style.display="none";
    }
});
pickup_mob.addEventListener("click",function () {
    if(pickup_mob.checked===true){
        adress.style.display="none";
        secession.style.display="none";
    }
});
var filter_mobileButton=document.querySelector(".filter--mobileButton");
if(location.href===location.origin+"/rostovka_app/public/checkout"){
    filter_mobileButton.style.display="none";
}


function redirectBack() {
    if ( document.referrer.indexOf("https://rostovka.net/male") != -1 )
        window.location.replace("https://rostovka.net/male"); 
    else if ( document.referrer.indexOf("https://rostovka.net/female") != -1 )
        window.location.replace("https://rostovka.net/female");
    else if ( document.referrer.indexOf("https://rostovka.net/kids") != -1 )
        window.location.replace("https://rostovka.net/kids");
    else if ( document.referrer.indexOf("https://rostovka.net/sales") != -1 )
        window.location.replace("https://rostovka.net/sales");
    else if ( Cart_data[0].cartCount != 0 ) {
        let category = Cart_data[0].row[Cart_data[0].row.length - 1].cart_product_url;
        category = category.substring(0, category.indexOf('/'));
        window.location.replace("https://rostovka.net/" + category);
    }
    else window.location.replace("https://rostovka.net/"); 
}

$('#backtostore').on('click', function() {
    redirectBack();
});

console.log(Cart_data[0].row[0])

for (var i = 0; i < Cart_data[0].row.length; i++) {
    var cards = 
    `<div class="card" style="border-radius: 0; border: 0;">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4 justify-content-center align-self-center">
                            <img src="${Cart_data[0].row[i].imgUrl}" class="w-100">
                    </div>
                    <div class="col-md-8">
                        <div>
                            <a href="/${Cart_data[0].row[i].cart_product_url}">${Cart_data[0].row[i].name}</a>
                            <p class="priceBil" style="margin:0">${Cart_data[0].row[i].price} грн.</p>
                            <p style="margin:0">${(Cart_data[0].row[i].selected_value == 0)? 'В ящике' : 'Минимум'}</p>
                            <p style="margin:0">${Cart_data[0].row[i].quantity} шт.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 justify-content-center align-self-center">
                <p class="priceBil" style="font-size: 18px; margin:0">${Cart_data[0].row[i].quantityPrice} грн</p>
            </div>
        </div>
    </div>
    <hr style="margin: 10px 0;" />`;

    $('.cards')[0].innerHTML += cards;
}

// if (Cart_data[0].row.length > 3) $('#cardsMore')[0].innerHTML = `
//     <div class="col-md-12 show-order" style="text-align: center">
//         <span id="innerText">Показать все товары</span>
//     </div>`;

// $('#cardsMore').click(function() {
//     if ($('.responsive-table .cards').height() == 350) {
//         $('.responsive-table .cards').animate({height: $(".responsive-table .cards").get(0).scrollHeight}, 1500);
//         $('#innerText')[0].innerText = 'Скрыть все товары';
//     }
//     else {
//         $('.responsive-table .cards').animate({height: '350px'}, 1500);
//         $('#innerText')[0].innerText = 'Показать все товары';
//     }
// });
