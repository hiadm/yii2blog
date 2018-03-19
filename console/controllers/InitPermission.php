<?php
namespace console\controllers;
use yii\console\Controller;

/**
 * 初始化后台权限
 */
class InitPermission extends Controller
{
    //初始化权限
    public function actionPermission(){

        $auth = \Yii::$app->authManager;

        $admin  = $auth->createPermission('admin');
        $admin->description = '网站管理权限。';
        $auth->add($admin);

        //所有路由
        $all = $auth->getPermission('/*');
        $auth->addChild($admin, $all);

        //创建管理员角色
        $adminRole = $auth->createRole('管理员');
        $auth->add($adminRole);

        //把网站管理权限分配给管理员角色
        $auth->addChild($adminRole, $admin);

        //创建作者权限
        $author  = $auth->createPermission('author');
        $author->description = '文章写作编辑权限。';
        $auth->add($author);

        //文章创建 查看路由
        $create = $auth->getPermission('/content/article/create');
        $index = $auth->getPermission('/content/article/index');
        $upload = $auth->getPermission('/content/article/upload');
        $view = $auth->getPermission('/content/article/view');
        $auth->addChild($author, $create);
        $auth->addChild($author, $index);
        $auth->addChild($author, $upload);
        $auth->addChild($author, $view);
        //专题查看
        $subject_index = $auth->getPermission('/content/subject/index');
        $subject_view = $auth->getPermission('/content/subject/view');
        $auth->addChild($author, $subject_index);
        $auth->addChild($author, $subject_view);
        //标签查看
        $tag_index = $auth->getPermission('/content/tag/index');
        $tag_view = $auth->getPermission('/content/tag/view');
        $auth->addChild($author, $tag_index);
        $auth->addChild($author, $tag_view);

        //创建作者角色
        $authorRole = $auth->createRole('作者');
        $auth->add($authorRole);

        //把作者权限分配给作者角色
        $auth->addChild($authorRole, $author);

        //吧作者权限分配给管理员
        $auth->addChild($admin, $author);

    }
}