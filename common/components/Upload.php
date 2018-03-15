<?php
namespace common\components;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\base\Exception;
use yii\helpers\FileHelper;
/**
 * 文件上传处理
 */
class Upload extends Model
{
    public $file;
    private $_appendRules;

    public function init ()
    {
        parent::init();
        $extensions = Yii::$app->params['webuploader']['baseConfig']['accept']['extensions'];
        $this->_appendRules = [
            [['file'], 'file', 'extensions' => $extensions],
        ];
    }
    public function rules()
    {
        $baseRules = [];
        return array_merge($baseRules, $this->_appendRules);
    }
    /**
     *
     */
    public function upImage ($prefix='')
    {
        $model = new static;
        $model->file = UploadedFile::getInstanceByName('file');
        if (!$model->file) {
            return false;
        }
        $relativePath = $successPath = '';
        if ($model->validate()) {
            $dir = $prefix . date('Ymd') . '/';

            //上传路径
            $relativePath = Yii::$app->params['imageUploadRelativePath'] . $dir;
            //上传之后文件前缀
            $successPath = Yii::$app->params['imageUploadSuccessPath'] . $dir;
            //文件名
            $fileName = substr(md5($model->file->baseName),1,15) . '.' . $model->file->extension;
            if (!is_dir($relativePath)) {
                FileHelper::createDirectory($relativePath);
            }
            $model->file->saveAs($relativePath . $fileName);
            return [
                'code' => 0,
                'url' => Yii::$app->params['domain'] . $successPath . $fileName,
                'attachment' => $successPath . $fileName
            ];
        } else {
            $errors = $model->errors;
            return [
                'code' => 1,
                'msg' => current($errors)[0]
            ];
        }
    }
}