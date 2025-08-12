    (function($){
        $(document).ready(function(){
            var $btn = $('#lw-wp-wc-btn');

            // Detectar si el producto tiene variaciones
            $('form.variations_form').on('show_variation', function(event, variation){
                if (variation && variation.variation_description !== undefined) {
                    var selectedVariation = variation.attributes ? Object.values(variation.attributes).join(', ') : '';
                    var baseUrl = $btn.data('base-url');
                    var message = $btn.data('message');
                    var productName = $btn.data('product-name');

                    var fullMessage = message + ' ' + productName;
                    if (selectedVariation.trim() !== '') {
                        fullMessage += ' (' + selectedVariation + ')';
                    }

                    $btn.attr('href', baseUrl + encodeURIComponent(fullMessage));
                    $btn.prop('disabled', false).removeClass('disabled');
                }
            });

            // Bloquear botón cuando se cambia de variación hasta que cargue
            $('form.variations_form').on('check_variations', function(){
                $btn.prop('disabled', true).addClass('disabled');
            });

            // En caso de reset de variaciones
            $('form.variations_form').on('reset_data', function(){
                var baseUrl = $btn.data('base-url');
                var message = $btn.data('message');
                var productName = $btn.data('product-name');

                $btn.attr('href', baseUrl + encodeURIComponent(message + ' ' + productName));
                $btn.prop('disabled', false).removeClass('disabled');
            });
        });
    })(jQuery);