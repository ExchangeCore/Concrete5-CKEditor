(function() {
    CKEDITOR.plugins.add('concrete5filemanager', {
        init: function () {
            CKEDITOR.on('dialogDefinition', function(event) {
                var editor = event.editor,
                    dialogDefinition = event.data.definition,
                    tabContent = dialogDefinition.contents.length;

                for (var i = 0; i < tabContent; i++) {
                    var browseButton = dialogDefinition.contents[i].get('browse');

                    if (browseButton !== null) {
                        browseButton.hidden = false;
                        browseButton.onClick = function() {
                            editor._.filebrowserSe = this;
                            ConcreteFileManager.launchDialog(function(data) {
                                jQuery.fn.dialog.showLoader();
                                ConcreteFileManager.getFileDetails(data.fID, function(r) {
                                    jQuery.fn.dialog.hideLoader();
                                    var file = r.files[0];
                                    CKEDITOR.tools.callFunction(editor._.filebrowserFn, file.urlDownload);
                                });
                            });
                        }
                    }
                }
            });
        }
    });
})();