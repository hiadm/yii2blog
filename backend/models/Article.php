<?php

namespace backend\models;

use common\components\Helper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id 主键ID
 * @property string $title 文章标题
 * @property string $brief 文章简介
 * @property string $smallimg 文章图片
 * @property string $bigimg 文章海报
 * @property string $favorite 喜欢数
 * @property string $collect 收藏数
 * @property string $visited 阅读数
 * @property int $type 文章类型
 * @property int $isbest 精品推荐
 * @property int $isdraft 草稿箱
 * @property int $isrecycle 回收站
 * @property string $subject_id 所属专题
 * @property string $content_id 内容ID
 * @property string $created_by 作者
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Article extends \yii\db\ActiveRecord
{
    public $content;
    public $tag_ids;
    public $tag_str;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';


    /**
     * 绑定事件
     */
    public function init ()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'onAfterDelete']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'onAfterInsert']);
    }

    /**
     * 新建文章后更新专题收录数目
     * @param $event
     */
    public function onAfterInsert($event){
        Subject::updateAllCounters(['total'=>1], ['id'=>$this->subject_id]);
    }


    /**
     * 删除文章后 更新专题收录数目
     *
     * @param $event
     */
    public function onAfterDelete($event){
        Subject::updateAllCounters(['total'=>-1], ['id'=>$this->subject_id]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','brief','smallimg','type','isbest','isdraft','subject_id','content'],'required'],
            [['subject_id','type', 'isbest', 'isdraft'], 'integer'],
            ['tag_ids', 'safe'],
            [['title'], 'string', 'max' => 125],
            [['tag_str'], 'string', 'max' => 64],
            [['brief'], 'string', 'max' => 225],
            [['content'], 'string'],
            [['smallimg', 'bigimg'], 'string'],

            [['isbest'], 'validBest'],
        ];
    }

    /**
     * 检测是否为精品 是精品文章则海报必填
     */
    public function validBest($attribute){
        if (!$this->hasErrors()){
            if($this->$attribute){
                //精品文章 检测是否有上传海报
                if (empty($this->bigimg))
                    $this->addError('bigimg', '请添加一个文章海报。');
            }
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'title' => '文章标题',
            'brief' => '文章简介',
            'smallimg' => '文章图片',
            'bigimg' => '文章海报',
            'favorite' => '喜欢数',
            'collect' => '收藏数',
            'visited' => '阅读数',
            'type' => '文章类型',
            'isbest' => '精品推荐',
            'isdraft' => '草稿箱',
            'isrecycle' => '回收站',
            'subject_id' => '所属专题',
            'content_id' => '内容ID',
            'created_by' => '作者',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'content' => '文章内容',
            'tag_ids' => '选择标签',
            'tag_str' => '新建标签'
        ];
    }

    //行为
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => null,
            ],
        ];
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * 关联标签
     * @return $this #获取标签
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable("{{%article_tag}}", ['article_id' => 'id']);
    }

    /**
     * 获取当前文章关联数据
     */
    public function getRelateDate(){
        $this->content = Content::findOne($this->content_id)->content;
        $this->tag_ids = (new yii\db\Query())->from('{{%article_tag}}')
            ->select(['tag_id'])
            ->where(['article_id' => $this->id])
            ->orderBy('tag_id')
            ->column();
    }

    /**
     * 文章保存
     */
    public function store(){

        if (!$this->validate()){
            return false;
        }
        //新建标签
        if (!empty($this->tag_str)){
            if($this->subject_id){
                $tags = str_replace('，',',',$this->tag_str);
                $tagArr = explode(',',$tags);

                $newIds = [];
                foreach($tagArr as $item){
                    if(empty($item))
                        continue;

                    $model = new Tag();
                    $model->subject_id = $this->subject_id;
                    $model->name = $item;
                    if ($model->store())
                        $newIds[] = $model->id;
                }
                $tagIds = !empty($this->tag_ids) ? $this->tag_ids : [];
                $this->tag_ids = array_merge($tagIds, $newIds);

            }

        }

        //保存 内容 文章 标签关联信息
        if ($this->doSave()){
            return true;
        }

        return false;
    }


    /**
     * 保存 文章内容 文章信息 标签关联信息
     */
    public function doSave(){
        $transaction = self::getDb()->beginTransaction();


        try {
            //保存内容
            $content = new Content();
            $content->content = $this->content;
            if (!$content->save(false))
                throw new \Exception('保存内容失败');
            $this->content_id = $content->id;

            //保存文章
            if(!$this->save(false))
                throw new \Exception('保存文章失败');

            //保存文章与标签关联信息
            if($this->tag_ids){

                $rel = [];
                foreach($this->tag_ids as $id){
                    $rel[] = [
                        'article_id' => $this->id,
                        'tag_id' => $id
                    ];

                }

                $ret = Yii::$app->db->createCommand()
                    ->batchInsert("{{%article_tag}}", ['article_id', 'tag_id'], $rel)
                    ->execute();
                if ($ret === false)
                    throw new \Exception('保存文章标签关联数据失败.');
            }



            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * 更新文章
     */
    public function renew(){

        //验证数据
        if(!$this->validate())
            return false;

        //如果上传新的文章图片 就删除原有图片
        if($this->smallimg !== $this->getOldAttribute('smallimg')){
            //删除原有图片
            Helper::delImage($this->getOldAttribute('smallimg'));
        }

        //如果上传新的文章海报 或 取消精品推荐 就删除原有图片
        $oldIsbest = (int)$this->getOldAttribute('isbest');
        $newIsbest = (int)$this->isbest;
        $oldBigimg = $this->getOldAttribute('bigimg');
        $newBigimg = $this->bigimg;
        if ($oldIsbest === 1 && $newIsbest === 0){
            Helper::delImage($this->bigimg);
            $this->bigimg='';
        }

        if($newBigimg !== $oldBigimg){
            Helper::delImage($oldBigimg);
        }

        //新建标签
        if (!empty($this->tag_str)){
            if($this->subject_id){
                $tags = str_replace('，',',',$this->tag_str);
                $tagArr = explode(',',$tags);

                $newIds = [];
                foreach($tagArr as $item){
                    if(empty($item))
                        continue;

                    $model = new Tag();
                    $model->subject_id = $this->subject_id;
                    $model->name = $item;
                    if ($model->store())
                        $newIds[] = $model->id;
                }
                $tagIds = !empty($this->tag_ids) ? $this->tag_ids : [];
                $this->tag_ids = array_merge($tagIds, $newIds);

            }

        }

        //保存 内容 文章 标签关联信息
        if ($this->doRenew()){
            return true;
        }

        return false;

    }

    /**
     * 保存 文章内容 文章信息 标签关联信息
     */
    public function doRenew(){
        $transaction = self::getDb()->beginTransaction();

        try {
            //保存内容
            $content = Content::findOne(['id'=>$this->content_id]);
            $content->content = $this->content;
            if (!$content->save(false))
                throw new \Exception('保存内容失败');

            //保存文章
            if($this->save(false) === false)
                throw new \Exception('保存文章失败');

            //删除文章标签关联数据
            $ret = Yii::$app->db->createCommand()->delete('{{%article_tag}}', 'article_id = '.$this->id)->execute();
            if ($ret === false)
                throw new \Exception('删除文章与标签关联数据失败');

            //保存文章与标签关联信息
            $rel = [];
            foreach($this->tag_ids as $id){
                $rel[] = [
                    'article_id' => $this->id,
                    'tag_id' => $id
                ];

            }

            $ret = Yii::$app->db->createCommand()
                ->batchInsert("{{%article_tag}}", ['article_id', 'tag_id'], $rel)
                ->execute();
            if ($ret === false)
                throw new \Exception('保存文章标签关联数据失败.');



            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * 删除文章
     *
     */
    public function discard(){
        //删除图片
        $this->removeImg();

        $transaction = self::getDb()->beginTransaction();
        try {
            //删除内容
            if(Content::findOne(['id'=>$this->content_id])->delete() === false){
                throw new \Exception('删除文章内容失败.');
            }

            //删除标签关联数据
            $ret = Yii::$app->db->createCommand()->delete("{{%article_tag}}", 'article_id = '.$this->id)->execute();
            if ($ret === false)
                throw new \Exception('删除标签关联失败.');

            //删除文章
            if ($this->delete() ===false)
                throw new \Exception('删除文章失败.');

            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

    }


    /**
     * 删除文章的图片
     */
    public function removeImg(){
        //删除图片
        if ($this->smallimg){
            Helper::delImage($this->smallimg);
        }
        if ($this->bigimg){
            Helper::delImage($this->bigimg);
        }
    }




}
