var intElemOffsetHeight = $( window ).height();

$(window).resize(function() {
    intElemOffsetHeight = $( window ).height();
    setHeight(intElemOffsetHeight);
});
function setHeight(intElemOffsetHeight) {
    $('.content-page').css('height', ''+intElemOffsetHeight+'');
}

setHeight(intElemOffsetHeight);