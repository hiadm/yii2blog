<?php
namespace common\rbac;
use yii\db\Query;
use yii\rbac\Rule;
//use backend\models\Article;

/**
 * 检查 authorID 是否和通过参数传进来的 user 参数相符
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {
        //return isset($params['author_id']) ? $params['author_id'] == $user : false;
        $create_by = (new Query())
            ->select('created_by')
            ->from('{{%article}}')
            ->where(['id'=>$params['id']])
            ->scalar();
        return $user == $create_by;
    }
}
