define([
    'jquery',
    'mage/adminhtml/browser'
], function($) {
    $.widget("dlambauer.mediabrowser", $.mage.mediabrowser, {
        insert: function(event) {
            console.log("My Custom Widget");
            var fileRow = $(event.currentTarget);

            if (!fileRow.prop('id')) {
                return false;
            }
            var targetEl = this.getTargetElement();

            if (!targetEl.length) {
                MediabrowserUtility.closeDialog();
                throw "Target element not found for content update";
            }

            /**
             * @mod: Added media_path_only param.
             */
            return $.ajax({
                url: this.options.onInsertUrl,
                data: {
                    filename: fileRow.attr('id'),
                    node: this.activeNode.id,
                    store: this.options.storeId,
                    as_is: targetEl.is('textarea') ? 1 : 0,
                    form_key: FORM_KEY,
                    media_path_only: this.options.media_path_only || false
                },
                context: this,
                showLoader: true
            }).done($.proxy(function(data) {
                if (targetEl.is('textarea')) {
                    this.insertAtCursor(targetEl.get(0), data);
                } else {
                    targetEl.val(data).trigger('change');
                }
                MediabrowserUtility.closeDialog();
                targetEl.focus();
                jQuery(targetEl).change();
            }, this));
        }
    });

    return $.dlambauer.mediabrowser;
});