<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit965415d9cf4e6eb7ae410d44f3e11187
{
    public static $classMap = array (
        'Astoundify_CI_ImportManager' => __DIR__ . '/../..' . '/app/class-importmanager.php',
        'Astoundify_CI_Import_Item' => __DIR__ . '/../..' . '/app/abstracts/abstract-import-item.php',
        'Astoundify_CI_Import_Item_ChildTheme' => __DIR__ . '/../..' . '/app/import-items/class-childtheme.php',
        'Astoundify_CI_Import_Item_Comment' => __DIR__ . '/../..' . '/app/import-items/class-comment.php',
        'Astoundify_CI_Import_Item_Factory' => __DIR__ . '/../..' . '/app/factories/class-import-item-factory.php',
        'Astoundify_CI_Import_Item_Interface' => __DIR__ . '/../..' . '/app/interfaces/interface-import-item.php',
        'Astoundify_CI_Import_Item_NavMenu' => __DIR__ . '/../..' . '/app/import-items/class-navmenu.php',
        'Astoundify_CI_Import_Item_NavMenuItem' => __DIR__ . '/../..' . '/app/import-items/class-navmenuitem.php',
        'Astoundify_CI_Import_Item_Object' => __DIR__ . '/../..' . '/app/import-items/class-object.php',
        'Astoundify_CI_Import_Item_Setting' => __DIR__ . '/../..' . '/app/import-items/class-setting.php',
        'Astoundify_CI_Import_Item_Term' => __DIR__ . '/../..' . '/app/import-items/class-term.php',
        'Astoundify_CI_Import_Item_ThemeMod' => __DIR__ . '/../..' . '/app/import-items/class-thememod.php',
        'Astoundify_CI_Import_Item_User' => __DIR__ . '/../..' . '/app/import-items/class-user.php',
        'Astoundify_CI_Import_Item_Widget' => __DIR__ . '/../..' . '/app/import-items/class-widget.php',
        'Astoundify_CI_Importer' => __DIR__ . '/../..' . '/app/abstracts/abstract-importer.php',
        'Astoundify_CI_Importer_Factory' => __DIR__ . '/../..' . '/app/factories/class-importer.php',
        'Astoundify_CI_Importer_Interface' => __DIR__ . '/../..' . '/app/interfaces/interface-importer.php',
        'Astoundify_CI_Importer_Json' => __DIR__ . '/../..' . '/app/importers/class-json.php',
        'Astoundify_CI_PluginInterface' => __DIR__ . '/../..' . '/app/interfaces/interface-plugin.php',
        'Astoundify_CI_Plugin_EasyDigitalDownloads' => __DIR__ . '/../..' . '/app/plugins/class-plugin-easydigitaldownloads.php',
        'Astoundify_CI_Plugin_FrontendSubmissions' => __DIR__ . '/../..' . '/app/plugins/class-plugin-frontendsubmissions.php',
        'Astoundify_CI_Plugin_MultiplePostThumbnails' => __DIR__ . '/../..' . '/app/plugins/class-plugin-multiplepostthumbnails.php',
        'Astoundify_CI_Plugin_WPJobManager' => __DIR__ . '/../..' . '/app/plugins/class-plugin-wpjobmanager.php',
        'Astoundify_CI_Plugin_WPJobManagerProducts' => __DIR__ . '/../..' . '/app/plugins/class-plugin-wpjobmanagerproducts.php',
        'Astoundify_CI_Plugin_WPJobManagerResumes' => __DIR__ . '/../..' . '/app/plugins/class-plugin-wpjobmanagerresumes.php',
        'Astoundify_CI_Plugin_WooCommerce' => __DIR__ . '/../..' . '/app/plugins/class-plugin-woocommerce.php',
        'Astoundify_CI_Plugin_WooCommerceProductVendors' => __DIR__ . '/../..' . '/app/plugins/class-plugin-woocommerceproductvendors.php',
        'Astoundify_CI_Plugin_WooThemesTestimonials' => __DIR__ . '/../..' . '/app/plugins/class-plugin-woothemestestimonials.php',
        'Astoundify_CI_Sortable_Interface' => __DIR__ . '/../..' . '/app/interfaces/interface-sortable.php',
        'Astoundify_CI_Theme_Listify' => __DIR__ . '/../..' . '/app/themes/class-theme-listify.php',
        'Astoundify_CI_Utils' => __DIR__ . '/../..' . '/app/class-utils.php',
        'Astoundify_CI_WP_Importer' => __DIR__ . '/../..' . '/app/class-wp-importer.php',
        'Astoundify_ContentImporter' => __DIR__ . '/../..' . '/app/class-contentimporter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit965415d9cf4e6eb7ae410d44f3e11187::$classMap;

        }, null, ClassLoader::class);
    }
}
