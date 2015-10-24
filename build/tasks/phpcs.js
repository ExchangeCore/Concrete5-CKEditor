module.exports = {
    codeFormatting: {
        src: ['../**/*.php', "!../build/**/*.php", '!../single_pages/**/*.php', '!../elements/**/*.php'],
        options: {
            standard: 'phpcs.xml'
        }
    },
    viewFormatting: {
        src: ['../single_pages/**/*.php', '../elements/**/*.php'],
        options: {
            standard: 'phpcs-views.xml'
        }
    },
    compatibility53: {
        src: ['../**/*.php', "!../build/**/*.php"],
        options: {
            standard: 'PHPCompatibility',
            bin: 'php vendor/bin/phpcs --runtime-set testVersion 5.3'
        }
    },
    compatibility54: {
        src: ['../**/*.php', "!../build/**/*.php"],
        options: {
            standard: 'PHPCompatibility',
            bin: 'php vendor/bin/phpcs --runtime-set testVersion 5.4'
        }
    },
    compatibility55: {
        src: ['../**/*.php', "!../build/**/*.php"],
        options: {
            standard: 'PHPCompatibility',
            bin: 'php vendor/bin/phpcs --runtime-set testVersion 5.5'
        }
    },
    compatibility56: {
        src: ['../**/*.php', "!../build/**/*.php"],
        options: {
            standard: 'PHPCompatibility',
            bin: 'php vendor/bin/phpcs --runtime-set testVersion 5.6'
        }
    },
    compatibility70: {
        src: ['../**/*.php', "!../build/**/*.php"],
        options: {
            standard: 'PHPCompatibility',
            bin: 'php vendor/bin/phpcs --runtime-set testVersion 7.0'
        }
    },
    options: {
        bin: 'php vendor/bin/phpcs'
    }
};