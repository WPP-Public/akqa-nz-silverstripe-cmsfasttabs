<?php

Object::add_extension('CMSMain', 'FastTabsCMSMainExtension');
Object::add_extension('ModelAdmin_RecordController', 'FastTabsCMSMainExtension');
Object::add_extension('FieldSet', 'FastTabsFieldSetExtension');

if (!file_exists(BASE_PATH . '/themes/cmsfasttabs')) {

    function tab_theme_copy()
    {

        exec('cp -R ' . BASE_PATH . '/silverstripe-cmsfasttabs/themes/cmsfasttabs ' . BASE_PATH . '/themes/cmsfasttabs');

        return file_exists(BASE_PATH . '/themes/cmsfasttabs');

    }

    if (PHP_SHLIB_SUFFIX != 'so' || !tab_theme_copy()) {

        user_error('FastTab: You need to copy the silverstripe-cmsfasttabs theme into the \'themes\' directory', E_USER_ERROR);

    } else {

        SSViewer::flush_template_cache();

    }

}
