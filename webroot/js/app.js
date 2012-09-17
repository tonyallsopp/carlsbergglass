$(function(){

    //set side menu height
    (function setMenuHeight(){
        $menu = $('#main-header');
        $content = $('#content');
        $container = $('#container');
        if($menu.length && ($content.outerHeight() > $menu.outerHeight())){
            $menu.height($content.height()+100);
        }
    })();



    //submit link
    (function submitFormButtons(){
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
        //insert >> into standard buttons
        $('a.btn-details').append('<span>&raquo;</span>');
    })();

    //placeholder text support for all browsers
    (function initPlaceholderText(){
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
    })();

    // "jump to" type filters
    (function jumpToSelectors(){
        if($('#CategoryBrandsForm').length){
            $("body").on('click', 'div[rel="CategoryFilterSlug"] li', function() {
                var url = $('#CategoryFilterUrl').val();
                var slug = $('div[rel="CategoryFilterSlug"] input').val();
                if(slug){
                    window.location = url + slug;
                }
            });
        }
    })();

    //replace select fields
    (function replaceSelect(){
        $('select').each(function(){
            prettySelect($(this));
        });
    })();

    //flash messages
    $('#flashMessage').delay(10000).fadeOut();

    // debug output
    $('div.cake-debug-output').appendTo('body');

    //update product info
    if($('.product-details').length){
        //branded products
        if($('.product-details').hasClass('branded')){
            $productVersionSelect = $('div[rel="ProductGroupVersion"] li');
            $productSizeSelect = $('div[rel="ProductGroupSize"] li');
            $productVersionVal =  $('input[name="data[ProductGroup][version]"]');
            $productSizeVal =  $('input[name="data[ProductGroup][size]"]');

            function updateProductInfo(){
                //version click event
                $("body").on('click', 'div[rel="ProductGroupVersion"] li', function() {
                    ajaxUpdate($(this).find('span.value').text(), $productSizeVal.val());
                });
                //size click event
                $("body").on('click', 'div[rel="ProductGroupSize"] li', function() {
                    ajaxUpdate($productVersionVal.val(), $(this).find('span.value').text());
                });

                function ajaxUpdate(version, size){
                    console.log(version);
                    console.log(size);
                    var data = {'data[ProductGroup][version]':version, 'data[ProductGroup][size]':size }
                    var url = webroot + 'product_groups/change_options/' + $('#ProductGroupSlug').val();
                    $.ajax({
                        url: url,
                        data: data,
                        type: 'post',
                        dataType : 'json',
                        success: function(data) {
                            for(var p in data){
                                var elem = $('.prodinfo-' + p);
                                if(elem.length){
                                    elem.text(data[p]);
                                }
                            }
                        }
                    });
                }
            }
            updateProductInfo();
        }
        //custom products
        if($('.product-details').hasClass('custom')){
//            $productVersionSelect = $('div[rel="ProductGroupVersion"] li');
//            $productSizeSelect = $('div[rel="ProductGroupSize"] li');
//            $productVersionVal =  $('input[name="data[ProductGroup][version]"]');
//            $productSizeVal =  $('input[name="data[ProductGroup][size]"]');

            (function updateCustomProductInfo(){
                var $form = $('#OrderViewCustomForm');
                // options change
                $('#OrderItem0Qty, form .custom_option').change(function(){
                    ajaxUpdate();
                });
                //size change
                $("body").on('click', 'div[rel="ProductGroupSize"] li', function() {
                    ajaxUpdate();
                });
                //no colours change
                $("body").on('click', 'div[rel="OrderItem0Colours"] li', function() {
                    ajaxUpdate();
                });

                function ajaxUpdate(){
                    var url = webroot + 'product_groups/update_custom_price/';
                    var data = $form.serializeArray();
                    $.ajax({
                        url: url,
                        data: data,
                        type: 'post',
                        dataType : 'json',
                        success: function(data) {
                            console.log(data);
                            for(var p in data['ProductUnit']){
                                var elem = $('.prodinfo-' + p);
                                if(elem.length){
                                    elem.text(data['ProductUnit'][p]);
                                }
                            }
                            //price
                            $('.prodinfo-price').text(data['OrderItem'][0]['unit_price']);
                        }
                    });
                }
            })();
        }

    }

});

function prettySelect($elem){
    //console.log($elem);
    var $hiddenField = $('<input type="hidden"/>').attr('name',$elem.attr('name')).val($elem.val());
    var $prettSelect = $('<div class="dropdown"><span class="selected">' + $elem.find('option:selected').text() + '</span></div>');
    $prettSelect.attr('rel',$elem.attr('id'));
    var $prettyOpts = $('<ul class="options"></ul>');
    $elem.find('option').each(function(){
        var prettyItem = $('<li><span class="label">' + $(this).text() + '</span><span class="value">' + $(this).attr('value') + '</span></li>');
        prettyItem.appendTo($prettyOpts);
    });
    $prettyOpts.appendTo($prettSelect);
    //console.log($hiddenField);
    $hiddenField.appendTo($prettSelect);
    $prettSelect.insertAfter($elem);
    var $input = $prettSelect.find('span.selected');
    var $options = $prettSelect.find('li');
    $input.click(function(){
        var $div = $(this).closest('div.dropdown');
        $div.toggleClass('open');
    });
    $options.click(function(){
        var $dropdown = $(this).closest('div.dropdown');
        var val = $(this).find('span.value').text();
        var label = $(this).find('span.label').text();
        $dropdown.find('input').val(val);
        $dropdown.find('span.selected').text(label);
        $dropdown.removeClass('open');
    });
    $elem.remove();
}