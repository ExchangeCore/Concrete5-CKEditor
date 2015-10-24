module.exports = {
    release: {
        files: [
            {
                src: "../docs/changelog.md",
                dest: "./tmp/community_ckeditor/CHANGELOG"
            },
            {
                cwd: "../",
                expand: true,
                src: [
                    "**/*",
                    "!**/*.git*",
                    "!build/**/*",
                    "!docs/**/*",
                    "!mkdocs.yml",
                    "!README.md"
                ],
                filter: "isFile",
                dest: "./tmp/community_ckeditor/"
            }
        ]
    }
};