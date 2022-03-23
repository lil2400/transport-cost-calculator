function autoComplete() {
        $(document).ready(function() {
            $(".form-control").focus(function() {
                initAutocomplete(this)
            });
        });

        function initAutocomplete(inp) {
            inputField = inp
            autocomplete = new google.maps.places.Autocomplete(inputField, {
                componentRestrictions: {
                    country: ["dk"]
                },
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            autocomplete.addListener("place_changed", fillInAddress);
        }

        function fillInAddress() {
            const place = autocomplete.getPlace();
        }
    }

    $(function() {
        $('.btn-radio').click(function(e) {
            $('.btn-radio').not(this).removeClass('active').siblings('input').prop('checked', false).siblings('.img-radio').css('opacity', '0.5');
            $(this).addClass('active').siblings('input').prop('checked', true).siblings('.img-radio').css('opacity', '1');
        });
    });