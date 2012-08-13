$(function(){

    //update product info

    if($('#ProductGroupVersion').length){
        $vers = $('#ProductGroupVersion');
        $size = $('#ProductGroupSize');

        function updateProductInfo(){
            $('#ProductGroupSize, #ProductGroupVersion').change(function(){
                var data = {'data[ProductGroup][version]':$('#ProductGroupVersion').val(), 'data[ProductGroup][size]':$('#ProductGroupSize').val() }
                var url = webroot + 'product_groups/change_options/' + $('#ProductGroupSlug').val();
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    dataType : 'json',
                    success: function(data) {
                        for(var p in data){
                            var elem = $('td.prodinfo-' + p);
                            if(elem.length){
                                elem.text(data[p]);
                            }
                        }
                    }
                });
            });
        }
        updateProductInfo();

    }

    //submit link
    function submitFormButtons(){
        //clicking button submits form
        $("#content").delegate("a.submit", "click", function(e) {
            e.preventDefault();
            $(this).closest("form").submit();
        });

        //pressing return submits form
        $("#content").delegate("form input", "keypress", function(e) {
            if(e.which == 13){
                e.preventDefault();
                $(this).closest("form").submit();
            }
        });
        //replace submit element with anchor
        $('form input[type="submit"]').each(function(){
            var $newBtn = '<a href="#" class="submit">' + $(this).val() + '<span>&raquo;</span></a>';
            $(this).after($newBtn).remove();
        });
    }
    submitFormButtons();

    //placeholder text support for all browsers
    function initPlaceholderText(){
        jQuery.support.placeholder = false;
        test = document.createElement('input');
        if('placeholder' in test) jQuery.support.placeholder = true;

        if(!$.support.placeholder) {
            var active = document.activeElement;
            $(':text').focus(function () {
                if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
                    $(this).val('').removeClass('hasPlaceholder');
                }
            }).blur(function () {
                    if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
                        $(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
                    }
                });
            $(':text').blur();
            $(active).focus();
            $('form').submit(function () {
                $(this).find('.hasPlaceholder').each(function() { $(this).val(''); });
            });
        }
    }
    initPlaceholderText();

    //flash messages
    $('#flashMessage').delay(10000).fadeOut();

    // debug output
    $('div.cake-debug-output').appendTo('body');

});