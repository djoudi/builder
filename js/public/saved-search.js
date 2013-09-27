jQuery(document).ready(function($) {

    $('.pls_save_search').fancybox({
        hideOnContentClick: false,
        scrolling: true,
        onStart: function () { append_search_filters(); },
        onClosed: function () { $('.login-form-validator-error').remove(); }
    });

    $('#pl_submit').on('click', function (event) {
        event.preventDefault();
        
        var data = {
            action: "add_saved_search_to_user",
            link_to_search: document.URL,
            name_of_saved_search: $('#user_search_name').val(),
            search_filters: get_search_filters()
        };

        $.post(info.ajaxurl, data, function (response, textStatus, xhr) {
            // console.log(response);
            if (response == 'true') {
                // Close dialog
                $.fancybox.close();

                // Show success message...
                $('#pls_successful_saved_search').show();
                setTimeout(function () { $('#pls_successful_saved_search').fadeOut(); }, 2000);
            } 
            else {
                // Failed, show the error messages...
            }
        });
      
    });

    // Method to retrieve all the keys and values of the search form on the page
    //
    // NOTE: These key value pairs are used to "save" the search in the DB so that it can be re-applied later
    function get_search_filters () {
        var raw_filters = {};
        var search_filters = {};

        // Exclude filters with the following names/keys...
        var unneeded_keys = ["location[address_match]"];

        // Try to access the search form's filters via the search "bootloader" object...
        if (typeof(search_bootloader !== "undefined")) {
            raw_filters = search_bootloader.filter.get_values();
        }
        else {
            // Default back to pulling all form elements via the default CSS class...
            raw_filters = $('.pls_search_form_listings').find('input[name], select[name]').serializeArray();
        }

        // Find the value of all the search elements so that we can save them.
        $.each(raw_filters, function (index, filter) {
            if (filter.value !== "" && filter.value != "0" && unneeded_keys.indexOf(filter.name) == -1) {
                search_filters[filter.name] = filter.value;
            } 
        });

        return search_filters;
    }

    function append_search_filters () {
        var search_filters = get_search_filters();

        //remove any li items in the ul left over from an old search
        $('#saved_search_values ul').empty();

        for (var key in search_filters) {
            //
            var form_attribute_value = search_filters[key];

            //form keys come as the value of their "name" (eg location[locality] ). 
            //form_key_translations is a simple lookup table 
            //to translate them into human readable form.
            if (form_key_translations.hasOwnProperty(key)) {
                key = form_key_translations[key];
            }

            var html = "<li><span>" + key + "</span>: " + form_attribute_value + "</li>";
            $('#saved_search_values ul').append(html);
        }
    }

    // An array that translates search form keys into human readable form
    var form_key_translations = {
        "location[locality]": "City",
        "location[postal]": "Zip",
        "location[address]": "Street",
        "location[neighborhood]": "Neighborhood",
        "location[region]": "State",
        "property_type": "Property Type",
        "purchase_types[]": "Available for",
        "metadata[min_price]": "Min Price",
        "metadata[min_sqft]": "Min Sqft",
        "metadata[min_beds]": "Min Beds",
        "metadata[min_baths]": "Min Baths",
        "metadata[min_price]": "Min Price",
        "metadata[max_price]": "Max Price"
    }

    /* 
     * Bindings for UI that generates the list of saved searches in the user's client profile... 
     */

    $('.pls_remove_search').live('click', function (event) {
        event.preventDefault();
        
        // So we can keep the HTML object context for use in the success call back
        var that = this;
        var data = {};
        data.action = 'delete_user_saved_search'
        data.saved_search_option_key = $(this).attr('ref');

        // console.log(data);

        $.post(info.ajaxurl, data, function(response, textStatus, xhr) {
            // Optional stuff to do after success
            // console.log(response);
            if (response == 1) {
                $('.saved_search_block#' + data.saved_search_option_key).remove();
            } 
            else {
                // show error message
            }
        });
        
    });

    $('#pls_view_search').on('click', function (event) {
        event.preventDefault();
        
        // Act on the event
        $.post(info.ajaxurl, {param1: 'value1'}, function (data, textStatus, xhr) {
            //optional stuff to do after success
        });
    });

});