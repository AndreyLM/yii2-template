<?php
namespace common\bootstrap;

use yii\base\Application;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton('domain\services\IArticleService', 'domain\services\ArticleService');
        $container->setSingleton('domain\services\ICategoryService', 'domain\services\CategoryService');
        $container->setSingleton('domain\services\IGalleryService', 'domain\services\GalleryService');
        $container->setSingleton('domain\services\IMenuService', 'domain\services\MenuService');

        $container->setSingleton('domain\repositories\IArticleRepository', 'domain\repositories\MySqlArticleRepository');
        $container->setSingleton('domain\repositories\ICategoryRepository', 'domain\repositories\MySqlCategoryRepository');
        $container->setSingleton('domain\repositories\IGalleryRepository', 'domain\repositories\MySqlGalleryRepository');
        $container->setSingleton('domain\repositories\IMenuRepository', 'domain\repositories\MySqlMenuRepository');


    }
}