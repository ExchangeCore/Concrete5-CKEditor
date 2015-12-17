# Quick Start Guide

## Installation

1. Copy the files to /packages/community_ckeditor such that controller.php resides at /packages/community_ckeditor/controller.php
2. Install the Community CKEditor package from the Concrete5 Dashboard Add Functionality page

## Configuration

By default CKEditor is shipped with a reasonable set of plugins enabled. You can enable additional plugins and
functionality from the Concrete5 Dashboard Rich Text Editor page (`/index.php/dashboard/system/basics/editor`)

For more advanced users we also allow [CKEditor styles](http://docs.ckeditor.com/#!/guide/dev_howtos_styles) to be 
configured using JSON format via `index.php/dashboard/system/basics/editor/ckeditor_styles`. These styles, once added,
will then show up in the CKEditor Styles dropdown in the User Interface. Note: If you uninstall the package, all styles
will be reset to the defaults, we highly recommend you keep a copy or database backup of your styles.

## Support

* For support please open an issue on our [github page](https://github.com/ExchangeCore/Concrete5-CKEditor/issues). We
ask that you first search the existing issues to see if your problem might have already been reported or fixed.