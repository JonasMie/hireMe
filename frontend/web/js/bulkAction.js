/**
 * Created by jonas on 21.06.15.
 *
 * Used to delete multiple rows from table
 */

jQuery('#bulkActions.dropdown').on('click', '.bulkRead, .bulkUnread, .bulkDelete', function (e) {
    e.preventDefault();
    var $_this = jQuery(this);
    $gridView = $_this.closest('div.grid-view');
    $gridView.bulkAction($_this, $gridView.data('type'));
});

(function ($) {
    $.fn.bulkAction = function (object, page) {
        var type = object.attr('class');
        var keys = this.yiiGridView('getSelectedRows');
        if (keys.length <= 0)
            return;
        switch (type) {
            case "bulkDelete":
                var r = confirm("Wollen Sie die markierten Einträge wirklich löschen?");
                if (r === true) {
                    jQuery.ajax({
                        url: "/" + page + "/delete",
                        data: {keys: keys},
                        type: 'POST',
                        async: false
                    });
                } else {
                    removeChecks()
                }
                break;
            case "bulkUnread":
                jQuery.get("/message/read", {keys: keys, type: 'unread'}, function (res) {
                    changeClasses(keys, type, res);
                });
                break;
            case "bulkRead":
                jQuery.get("/message/read", {keys: keys, type: 'read'}, function (res) {
                    changeClasses(keys, type, res)
                });
                break;
        }
    };
    var changeClasses = function (keys, type, res, form) {
        if (res.success) {
            if (type == "bulkRead") {
                keys.forEach(function (key) {
                    jQuery("tr[data-key='" + key + "']").removeClass("unread");
                });
            } else if (type == "bulkUnread") {
                keys.forEach(function (key) {
                    jQuery("tr[data-key='" + key + "'].receiver").addClass("unread");
                });
            }
            removeChecks(form);
        } else {
            // TODO: set error message
        }
    };

    var removeChecks = function () {
        jQuery('input').iCheck('uncheck');
    }
})(window.jQuery);

