<?php
return [
    'adminEmail' => 'admin@example.com',
    // 图片服务器的域名设置，拼接保存在数据库中的相对地址，可通过web进行展示
    'domain' => 'http://www.dev.com/',
    'webuploader' => [
        // 后端处理图片的地址，value 是相对的地址
        'uploadUrl' => 'upload',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => 'http://img1.imgtn.bdimg.com/it/u=2056478505,162569476&fm=26&gp=0.jpg',
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => 'Images',
                'extensions' => 'gif,jpg,jpeg,bmp,png',
                'mimeTypes' => 'image/*',
            ],
            'pick' => [
                'multiple' => false,
            ],
        ],
    ],
    'imageUploadRelativePath' => '../static/uploaded/', // 图片上传的path
    'imageUploadSuccessPath' => 'static/uploaded/', // 图片上传成功后，url
    //标签上限
    'tagsLimit' => 2,
];
