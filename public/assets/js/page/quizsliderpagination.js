var slider_div = $('.slider-div');
var btn_next = $('.btn-next');
var btn_prev = $('.btn-prev');

btn_next.click(function (e) {
    $(this)
            .closest('.slider-div')
            .removeClass('active')
            .next('.slider-div')
            .addClass('active');

    var player = $(this)
            .closest('.slider-div')
            .next('.slider-div')
            .find('.player');
    if (player.length != 0) {
        var audio = player.get(0);
        audio.play();
    }
});
btn_prev.click(function (e) {
    $(this)
            .closest('.slider-div')
            .removeClass('active')
            .prev('.slider-div')
            .addClass('active');
});
    