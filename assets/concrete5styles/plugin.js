(function() {
    CKEDITOR.plugins.add('concrete5styles', {
        requires: 'stylescombo',
        init: function (editor) {
            $.ajax({
                'type': 'get',
                'dataType': 'json',
                'url': CCM_DISPATCHER_FILENAME + '/ccm/system/backend/editor_data',
                'data': {
                    'ccm_token': CCM_EDITOR_SECURITY_TOKEN,
                    'cID': CCM_CID
                },

                success: function(response) {
                    var additionalStyles = [];
                    jQuery.each(response.classes, function()
                    {
                        var style = {};
                        style.name = this.title;
                        if (typeof this.forceBlock !== 'undefined' && this.forceBlock == 1) {
                            this.element = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'];
                        } else {
                            this.element = 'span';
                        }
                        if (typeof this.spanClass !== 'undefined') {
                            style.attributes = {'class': this.spanClass};
                        }
                        additionalStyles.push(style);
                    });
                    editor.fire( 'stylesSet', { styles: additionalStyles } );
                }
            });
        }
    });
})();