$('#search-field').keypress(function (e) {
    //Pressing enter
    if (e.which === 13) {
        console.log('searching');
        console.log($('.module-selector option:selected').val());

        var type = $('.module-selector option:selected').val();
        var term = encodeURIComponent($(this).val());
        
        var ajaxurl = public_path + 'search/' + type + '?term=' + term;
        console.log(ajaxurl);
        
        window.location = ajaxurl;
        
    }
});

function OpenInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}