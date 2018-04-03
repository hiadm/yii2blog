<?php

use yii\db\Migration;

/**
 * Class m180318_122250_insert_menu_data
 */
class m180318_122250_insert_menu_data extends Migration
{
    const TABLE_NAME = '{{%menu}}';
    public $menuData =
        [
            [
                'id'=>1,
                'name' => '内容管理',
                'parent' => null,
                'route' => null,
                'order' => '11',
                'data' => null,
            ],
            [
                'id'=>2,
                'name' => '专题',
                'parent' => '1',
                'route' => '/content/subject/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>3,
                'name' => '标签',
                'parent' => '1',
                'route' => '/content/tag/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>4,
                'name' => '文章',
                'parent' => '1',
                'route' => '/content/article/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>5,
                'name' => '评论',
                'parent' => '1',
                'route' => '/content/comment/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>6,
                'name' => '回复',
                'parent' => '1',
                'route' => '/content/reply/index',
                'order' => null,
                'data' => null,
            ],
            ///////////////
            [
                'id'=>7,
                'name' => '权限管理',
                'parent' => null,
                'route' => null,
                'order' => '12',
                'data' => null,
            ],
            [
                'id'=>8,
                'name' => '角色',
                'parent' => '7',
                'route' => '/admin/role/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>9,
                'name' => '权限',
                'parent' => '7',
                'route' => '/admin/permission/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>10,
                'name' => '路由',
                'parent' => '7',
                'route' => '/admin/route/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>11,
                'name' => '规则',
                'parent' => '7',
                'route' => '/admin/rule/index',
                'order' => null,
                'data' => null,
            ],
            /////////////////////
            [
                'id'=>12,
                'name' => '站点设置',
                'parent' => null,
                'route' => null,
                'order' => '17',
                'data' => null,
            ],
            [
                'id'=>13,
                'name' => '菜单',
                'parent' => '12',
                'route' => '/admin/menu/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>14,
                'name' => '日志',
                'parent' => '12',
                'route' => '/setting/log/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>15,
                'name' => 'SEO设置',
                'parent' => '12',
                'route' => '/setting/seo/update',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>16,
                'name' => '友链',
                'parent' => '12',
                'route' => '/setting/friend/index',
                'order' => null,
                'data' => null,
            ],
            /////////////////////////
            [
                'id'=>17,
                'name' => '系统工具',
                'parent' => null,
                'route' => null,
                'order' => '18',
                'data' => null,
            ],
            [
                'id'=>18,
                'name' => 'Debug',
                'parent' => '17',
                'route' => '/debug/default/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>19,
                'name' => 'Gii',
                'parent' => '17',
                'route' => '/gii/default/index',
                'order' => null,
                'data' => null,
            ],
            //////////////////////
            [
                'id'=>20,
                'name' => '成员管理',
                'parent' => null,
                'route' => null,
                'order' => '14',
                'data' => null,
            ],
            [
                'id'=>21,
                'name' => '用户',
                'parent' => '20',
                'route' => '/member/user/index',
                'order' => null,
                'data' => null,
            ],
            [
                'id'=>22,
                'name' => '作者',
                'parent' => '20',
                'route' => '/member/author/sponsor',
                'order' => null,
                'data' => null,
            ],





        ];
    /*[
    0 => [
        'id'=>16,
        'name' => '内容管理',
        'parent' => null,
        'route' => null,
        'order' => '11',
        'data' => null,
    ],
    1 => [
        'id'=>15,
        'name' => '专题',
        'parent' => '16',
        'route' => '/content/subject/index',
        'order' => null,
        'data' => null,
    ],
    2 => [
        'id'=>17,
        'name' => '标签',
        'parent' => '16',
        'route' => '/content/tag/index',
        'order' => null,
        'data' => null,
    ],
    3 => [
        'id'=>18,
        'name' => '文章',
        'parent' => '16',
        'route' => '/content/article/index',
        'order' => null,
        'data' => null,
    ],
    4 => [
        'id'=>19,
        'name' => '权限管理',
        'parent' => null,
        'route' => null,
        'order' => '12',
        'data' => null,
    ],
    5 => [
        'id'=>22,
        'name' => '角色',
        'parent' => '19',
        'route' => '/admin/role/index',
        'order' => null,
        'data' => null,
    ],
    6 => [
        'id'=>23,
        'name' => '权限',
        'parent' => '19',
        'route' => '/admin/permission/index',
        'order' => null,
        'data' => null,
    ],
    7 => [
        'id'=>24,
        'name' => '路由',
        'parent' => '19',
        'route' => '/admin/route/index',
        'order' => null,
        'data' => null,
    ],
    8 => [
        'id'=>25,
        'name' => '规则',
        'parent' => '19',
        'route' => '/admin/rule/index',
        'order' => null,
        'data' => null,
    ],
    9 => [
        'id'=>32,
        'name' => '站点设置',
        'parent' => null,
        'route' => null,
        'order' => '17',
        'data' => null,
    ],
    10 => [
        'id'=>26,
        'name' => '菜单',
        'parent' => '32',
        'route' => '/admin/menu/index',
        'order' => null,
        'data' => null,
    ],
    11 => [
        'id'=>33,
        'name' => '日志',
        'parent' => '32',
        'route' => '/setting/log/index',
        'order' => null,
        'data' => null,
    ],
    12 => [
        'id'=>34,
        'name' => 'SEO设置',
        'parent' => '32',
        'route' => '/setting/seo/update',
        'order' => null,
        'data' => null,
    ],
    13 => [
        'id'=>27,
        'name' => '系统工具',
        'parent' => null,
        'route' => null,
        'order' => '18',
        'data' => null,
    ],
    14 => [
        'id'=>28,
        'name' => 'Debug',
        'parent' => '27',
        'route' => '/debug/default/index',
        'order' => null,
        'data' => null,
    ],
    15 => [
        'id'=>29,
        'name' => 'Gii',
        'parent' => '27',
        'route' => '/gii/default/index',
        'order' => null,
        'data' => null,
    ],
    17 => [
        'id'=>30,
        'name' => '成员管理',
        'parent' => null,
        'route' => null,
        'order' => '14',
        'data' => null,
    ],
    18 => [
        'id'=>31,
        'name' => '用户',
        'parent' => '30',
        'route' => '/member/user/index',
        'order' => null,
        'data' => null,
    ],





];*/

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $count = count($this->menuData);
        for($i=0; $i<$count; ++$i){
            $this->insert(self::TABLE_NAME, $this->menuData[$i]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180318_122250_insert_menu_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180318_122250_insert_menu_data cannot be reverted.\n";

        return false;
    }
    */
}
