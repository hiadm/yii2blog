<?php
use yii\helpers\Url;
?>
<div class="cont-right col-md-4 hidden-xs hidden-sm">
    <div class="notice font-pretty">
        <h4 class="text-muted">个人设置</h4>
        <p>
            <a href="<?= Url::to(['reset-password'])?>">修改密码</a>
        </p>
        <p><a href="<?= Url::to(['reset-email'])?>">修改邮箱</a></p>
        <p><a href="<?= Url::to(['reset-photo'])?>">修改头像</a></p>
    </div>

    <hr>
    <div class="shared font-pretty">
        <h4 class="text-muted">VIP订阅</h4>
        <div>
            <p><a href="<?= Url::to(['/index/contact'])?>">订阅VIP</a></p>
            <p><a href="<?= Url::to(['/index/contact'])?>">成为作者</a></p>
        </div>
    </div>

    <hr>

</div>