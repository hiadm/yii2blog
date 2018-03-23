<?php

namespace backend\models;

use Yii;
use common\components\Helper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%subject}}".
 *
 * @property string $id 主键
 * @property string $name 专题名
 * @property string $desc 描述
 * @property string $logo Logo
 * @property int $type 类型
 * @property int $status 状态
 * @property int $notice_id 布告
 * @property int $created_by 创建者
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Subject extends \yii\db\ActiveRecord
{
    public $notice; //布告内容

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['subject_id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','logo','type','status','notice'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 18],
            [['desc'], 'string', 'max' => 128],
            [['logo'], 'string', 'max' => 64],
            //[['notice'], 'safe'],
            [['type', 'status'], 'integer', 'max' => 3],
        ];
    }

    /**
     * 行为
     */
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'name' => '专题名',
            'desc' => '描述',
            'logo' => 'Logo',
            'type' => '类型',
            'status' => '状态',
            'notice_id' => '布告ID',
            'created_by' => '创建者',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'notice' => '专题布告',
        ];
    }

    /**
     * 新建专题
     */
    public function store(){
        if ($this->validate()){
            $transaction = self::getDb()->beginTransaction();
            try {
                //保存布告
                $notice = new Notice();
                $notice->notice = $this->notice;
                if(!$notice->save(false)){
                    throw new \Exception('保存布告失败。');
                }

                $this->notice_id = $notice->id;

                //保存专题信息
                if(!$this->save(false)){
                    throw new \Exception('保存专题失败。');
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

        return false;
    }


    /**
     * 更新专题
     */
    public function renew(){
        if ($this->validate()){
            //判断图片是否有改变
            if ($this->logo !== $this->getOldAttribute('logo')){
                //删除旧图片
                Helper::delImage($this->getOldAttribute('logo'));
            }

            $transaction = self::getDb()->beginTransaction();
            try {
                //保存布告
                $notice = Notice::findOne($this->notice_id);
                $notice->notice = $this->notice;
                if(!$notice->save(false)){
                    throw new \Exception('保存布告失败。');
                }


                //保存专题信息
                if(!$this->save(false)){
                    throw new \Exception('保存专题失败。');
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

        return false;
    }

    /**
     * 删除专题
     */
    public function discard(){
        //删除图片
        Helper::delImage($this->logo);
        $transaction = self::getDb()->beginTransaction();
        try {
            //删除布告
            $notice = Notice::findOne($this->notice_id);
            if($notice->delete() === false){
                throw new \Exception('删除布告失败。');
            }

            //保存专题信息
            if($this->delete() === false){
                throw new \Exception('删除专题失败。');
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
}
