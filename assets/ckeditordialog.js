$.concrete.dialog.prototype._allowInteraction = function (event) {
    if ($.ui.dialog.prototype._allowInteraction.call(this, event)) {
        return true;
    }

    return !!$(event.target).closest('.ccm-interaction-dialog').length || !!$(event.target).closest(".cke_dialog").length;
};
