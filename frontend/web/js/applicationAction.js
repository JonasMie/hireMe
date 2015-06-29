/**
 * Created by jonas on 21.06.15.
 *
 * Used to delete multiple rows from table
 */

 var identifiers = [];

jQuery('#appAction.dropdown').on('click', '.action_archive, .action_invite, .action_hire', function (e) {
    e.preventDefault();
    identifiers = [];
    var $_this = jQuery(this);
    $gridView = $('#w' + $_this.closest("div #appAction").data('index'));
    $gridView.bulkAction($_this,"application");
});

(function ($) {
    $.fn.bulkAction = function (object, page) {
        var type = object.attr('class');
        var keys = this.yiiGridView('getSelectedRows');
        console.log(keys);
        if (keys.length <= 0)
            return;
        switch (type) {
            case "action_archive":
                var r = confirm("Wollen Sie die markierten Bewerbungen wirklich archivieren?");
                keys.forEach(function (key) {
                   var realID = jQuery("tr[data-key='" + key + "']").children('td.footable-last-column').text();
                   identifiers.push(realID);
                });
                console.log("identifiers: "+identifiers);
                if (r === true) {
                    jQuery.ajax({
                        url: "/" + page + "/dropdown-action",
                        data: {ids: identifiers,action:"archive"},
                        type: 'POST',
                        async: false
                    });
                } else {
                    removeChecks()
                }
                break;
            case "action_invite":
                keys.forEach(function (key) {
                   var realID = jQuery("tr[data-key='" + key + "']").children('td.footable-last-column').text();
                   identifiers.push(realID);
                });
                console.log("identifiers: "+identifiers);
                    jQuery.ajax({
                        url: "/" + page + "/dropdown-action",
                        data: {ids: identifiers,action:"invite"},
                        type: 'POST',
                        async: false
                });
                break;
            case "action_hire":
                keys.forEach(function (key) {
                   var realID = jQuery("tr[data-key='" + key + "']").children('td.footable-last-column').text();
                   identifiers.push(realID);
                });
                console.log("identifiers: "+identifiers);
                    jQuery.ajax({
                        url: "/" + page + "/dropdown-action",
                        data: {ids: identifiers,action:"hire"},
                        type: 'POST',
                        async: false
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

