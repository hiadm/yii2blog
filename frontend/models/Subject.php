<?php
namespace frontend\models;
use backend\models\Subject as SubjectModel;
use yii\data\Pagination;

class Subject extends SubjectModel
{
    /**
     * 获取活跃的专题数据
     */
    public static function getActiveSubject(){
        return self::find()
            ->select(['id','name','logo','type'])
            ->where(['!=','type',2])
            ->orderBy(['updated_at'=>SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();
    }

    /**
     * 获取指定类型的专题集合
     * @param string $type #获取类型
     * @return array #专题集合
     */
    public static function getSubjects($type){
        $query = self::find()->andWhere(['!=', 'type', 2]);
        //添加条件
        switch ($type) {
            case 'vip':

                $query->Where(['type'=>1]);//vip专题
                break;
            case 'finished':

                $query->Where(['status'=>1]); //完结状态
                break;
        }


        $pagination = new Pagination(['totalCount'=>$query->count()]);



        $ret = $query->select(['id','logo','name','desc','total'])
            ->orderBy(['updated_at'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        return [
            'subjects' => $ret,
            'pagination' => $pagination,
        ];
    }



    /**
     * ajax 搜索专题名称
     * @param string $name #要搜索的专题名称
     * @return array #专题集合
     */
    public static function SearchSubjects($name){
        $data = self::find()
            ->select(['id','logo','name','desc','total'])
            ->orderBy(['updated_at'=>SORT_DESC])
            ->where(['!=', 'type', 2])
            ->andWhere(['like', 'name', $name])
            ->limit(9)
            ->asArray()
            ->all();
        return $data;
    }


    /**
     * 获取指定专题的详细信息
     * @param int $subject_id #专题id
     * @return array|null
     */
    public static function getDetail($subject_id){
        $ret = self::find()
            ->alias('s')
            ->leftJoin(['n'=>'{{%notice}}'],'n.id = s.notice_id')
            ->select(['s.*','n.notice'])
            ->where(['s.id'=>$subject_id])
            ->asArray()
            ->one();
        return $ret;
    }




}