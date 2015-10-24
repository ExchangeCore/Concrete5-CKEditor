module.exports = {
    release: {
        files: [{
            expand: true,
            cwd: "./tmp/community_ckeditor/assets",
            src: "**/*.css",
            dest: "./tmp/community_ckeditor/assets"
        }]
    }
};