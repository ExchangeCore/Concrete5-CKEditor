(function () {
    CKEDITOR.plugins.add('concrete5uploadimage', {
        requires: 'uploadimage',
        init: function (editor) {
            editor.on('fileUploadRequest', function (evt) {
                var fileLoader = evt.data.fileLoader;
                var xhr = fileLoader.xhr;
                var formData = new FormData();

                formData.append('ccm_token', CCM_SECURITY_TOKEN);
                formData.append('files[]', fileLoader.file, fileLoader.fileName);

                xhr.send(formData);

                evt.stop();
            });

            editor.on('fileUploadResponse', function (evt) {
                evt.stop();

                var data = evt.data,
                    xhr = data.fileLoader.xhr;

                if (xhr.status == 200) {
                    var files = jQuery.parseJSON(xhr.responseText);
                    if (files.length > 0) {
                        data.url = files[0].urlInline;
                    }
                } else {
                    data.message = xhr.responseText;
                    evt.cancel();
                }
            });
        }
    });
})();