module.exports = {
    release: {
        files: [{
            expand: true,
            cwd: "./tmp/community_ckeditor/assets",
            src: "**/*.js",
            dest: "./tmp/community_ckeditor/assets"
        }]
    }
};