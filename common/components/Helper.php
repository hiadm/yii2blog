<?php
namespace common\components;
use Yii;
use yii\imagine\Image;

class Helper
{
    //删除图片
    public static function delImage($img){
        //获取根路径
        $uproot = \Yii::getAlias('@public') . '/';
        if(@unlink($uproot . $img)){
            return true;
        }
        return false;
    }

    //截取多字节字符串
    public static function truncate_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
        {
            $result .= $etc;
        }
        return $result;
    }


    //读取文章字数
    public static function strlen_utf8($str)
    {
        $i = 0;
        $count = 0;
        $len = strlen($str);
        while ($i < $len)
        {
            $chr = ord($str[$i]);
            $count++;
            $i++;
            if ($i >= $len)
            {
                break;
            }
            if ($chr & 0x80)
            {
                $chr <<= 1;
                while ($chr & 0x80)
                {
                    $i++;
                    $chr <<= 1;
                }
            }
        }

        return $count;
    }


    /**
     * 剪切图片
     * @param $file string #文件
     * @param $width int #宽度
     * @param $height int #高度
     */
    public static function thumbImage($file, $width=350, $height=350){
        //获取上传根路径
        $root = Yii::getAlias('@public') . '/';
        $file = $root . $file;
        if (!is_file($file)){
            return false;
        }

        $dir = 'static/uploaded/'.date('Ymd') . '/';
        $newName = time() . rand(0000,9999);
        $ext = self::get_ext($file);
        if(!is_dir($root . $dir)){
            mkdir($root . $dir, true);
        }


        $newFile = $root . $dir . $newName . '.' . $ext;
        $ret = Image::thumbnail($file, $width , $height)
            ->save($newFile, ['quality' => 80]);

        if ($ret){
            @unlink($file);
            return $dir . $newName . '.' . $ext;
        }
        return false;


    }

    public static function get_ext($file){
        $tmp = parse_url($file, PHP_URL_PATH);
        $ext = pathinfo($tmp, PATHINFO_EXTENSION);

        return $ext;
    }
}