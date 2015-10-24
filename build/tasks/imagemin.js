module.exports = {
    release: {
        files: [
            {
                expand: true,
                cwd: "./tmp/community_ckeditor/assets",
                src: "**/*.{png,jpg,gif}",
                dest: "./tmp/community_ckeditor/assets"
            },
            {
                src: "./tmp/community_ckeditor/icon.png",
                dest: "./tmp/community_ckeditor/icon.png"
            }
        ]
    }
};