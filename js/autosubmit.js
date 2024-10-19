(function ($) {
    Drupal.behaviors.custom = {
        attach: function (context) {
            $("#FIELD-ID").autocomplete({
                select: function (event, ui) {
                    if (ui.item) {
                        var itemLink = $(ui.item.label).attr('href');
                        window.location.href = itemLink;
                    }
                }
            });
        }
    };
}(jQuery));