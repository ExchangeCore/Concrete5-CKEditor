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
                            var dialog = this.getDialog();
                            ConcreteFileManager.launchDialog(function(data) {
                                jQuery.fn.dialog.showLoader();
                                ConcreteFileManager.getFileDetails(data.fID, function(r) {
                                    jQuery.fn.dialog.hideLoader();
                                    var file = r.files[0];
                                    var fileLink = file.urlDownload;
                                    if ( dialog.getName() == 'image' || dialog.getName() == 'image2') {
                                        fileLink = file.urlInline;
                                    }
                                    CKEDITOR.tools.callFunction(editor._.filebrowserFn, fileLink, function() {
                                        if ( dialog.getName() == 'image' || dialog.getName() == 'image2') {
                                            dialog.dontResetSize = true;
                                            dialog.getContentElement( 'info', 'txtAlt').setValue(file.title);
                                            dialog.getContentElement( 'info', 'txtWidth').setValue('');
                                            dialog.getContentElement( 'info', 'txtHeight').setValue('');
                                            dialog.getContentElement( 'Link', 'txtUrl').setValue(file.urlDownload);
                                        }
                                    });
                                });
                            });
                        }
                    }
                }
            });
        }
    });
})();