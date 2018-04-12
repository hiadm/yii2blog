# yii2blog 安装


## 基于yii2框架的一个多用户博客系统 后台rbac权限控制 包含打赏功能 和vip会员功能

### 1.下载程序
```
#先克隆程序到本地

git clone https://github.com/daimajie/yii2blog.git

```

### 2.安装依赖包
```
#进入程序目录 执行composer 命令安装依赖

composer install

```

### 3.执行初始化命令
```
#window下执行如下命令
    
    init.bat  # 选择1 生产模式 选择yes生成文件

#linux 下执行如下命令 如果没有权限记得给个权限
    
    chmod 755 init
    ./init #同样选择1 及yes

```

### 4.配置本地数据
```
#common/config/目录下的  main-local.php和params-local.php
#main-local.php 中配置数据库信息和邮件
		
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=DbName', #数据库地址和名字
            'username' => 'root',  #用户名
            'password' => '***',  #数据库密码
            'charset' => 'utf8',
        ],
        
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.qq.com', #可选其他服务商 如163 126
                // 邮箱登录帐号
                'username' => 'XXXXXX@XX.com',
                // 如果是qq邮箱，这里要填写第三方授权码，而不是你的qq登录密码，参考qq邮箱的帮助文档
                'password' => '******',
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['XXXXXX@XX.com'=>'站点名字']
            ],
        ]	
			
#params-local.php 中配置一个站点url即可
    	
        'domain' => 'http://www.domain.com/',

```


### 5.初始化数据
```
#在此我们使用yii2的迁移工具

    
    #1.在项目根目录命令执行窗口执行如下命令
	
    ./yii migrate
	
	
    
    #2.初始化权限数据
	
    ./yii init-permission/permission
	
	
	
    #3.创建后台管理员和 作者 按提示输入名字 密码 邮箱即可
	
    ./yii init-manager/manager  #创建管理员
	
	
    ./yii init-manager/author   #创建作者
		
	
```

### 6.站点测试 
    www.domain.com 前台界面
    www.domain.com/admin  后台界面

账户和密码是刚刚创建的
