module.exports = {
    release: {
        options: {
            archive: 'community_ckeditor.zip'
        },
        files: [
            {
                expand: true,
                cwd: "./tmp/",
                src: [
                    "community_ckeditor/**/*"
                ]
            }
        ]
    }
};