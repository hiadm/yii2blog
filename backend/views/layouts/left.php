<?php
use mdm\admin\components\MenuHelper;
use dmstr\widgets\Menu;

?>
<aside class="main-sidebar">

    <section class="sidebar">
        <div class="user-panel"></div>
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= \Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <div class="user-panel"></div>



        <?php dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2Blog', 'options' => ['class' => 'header']],
                    [
                        'label' => '内容管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '专题', 'icon' => 'send-o', 'url' => ['/content/subject']],
                            ['label' => '标签', 'icon' => 'send-o', 'url' => ['/content/tag']],
                            ['label' => '文章', 'icon' => 'send-o', 'url' => ['/content/article']],
                        ],
                    ],
                    [
                        'label' => '用户管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '用户', 'icon' => 'send-o', 'url' => ['/admin/user']],
                            ['label' => '用户添加', 'icon' => 'send-o', 'url' => ['/admin/user/signup']],
                            ['label' => '指派', 'icon' => 'send-o', 'url' => ['/admin/assignment']],
                            ['label' => '角色', 'icon' => 'send-o', 'url' => ['/admin/role']],
                            ['label' => '权限', 'icon' => 'send-o', 'url' => ['/admin/permission']],
                            ['label' => '路由', 'icon' => 'send-o', 'url' => ['/admin/route']],
                            ['label' => '规则', 'icon' => 'send-o', 'url' => ['/admin/rule']],
                            ['label' => '菜单', 'icon' => 'send-o', 'url' => ['/admin/menu']],
                        ],
                    ],
                    [
                        'label' => '系统工具',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                        ],
                    ],

                ],
            ]
        ) ?>


        <?php
        $callback = function($menu){
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => [$menu['route']],
            ];
            //处理我们的配置
            if ($data) {
                //visible
                isset($data['visible']) && $return['visible'] = $data['visible'];
                //icon
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                //other attribute e.g. class...
                $return['options'] = $data;
            }
            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'circle-o-notch';
            $items && $return['items'] = $items;
            return $return;
        };
        echo Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback)
        ]);
        ?>

    </section>

</aside>
