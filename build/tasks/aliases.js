module.exports = {
    "default": [],
    "release": [
        "clean",
        "copy:release",
        "cssmin:release",
        "uglify:release",
        "imagemin:release",
        "compress:release"
    ],
    "lint": [
        "phpcs"
    ],
    "phpcs:compatibility": [
        "phpcs:compatibility53",
        "phpcs:compatibility54",
        "phpcs:compatibility55",
        "phpcs:compatibility56",
        "phpcs:compatibility70"
    ],
    "phpcs:formatting": [
        "phpcs:codeFormatting"
        //"phpcs:viewFormatting"
    ]
};