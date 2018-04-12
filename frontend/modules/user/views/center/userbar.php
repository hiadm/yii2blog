<div class="row">
    <div class="cont-left col-md-8">
        <!-- 用户信息 -->
        <div class="subject-info row">
            <div class="col-xs-3 col-sm-2 test">
                <a href="javascript:void(0);">
                    <img class="img-responsive img-radius-full" src="/<?= !empty($user['photo'])?$user['photo']:$this->params['userPhoto'];?>">
                </a>
            </div>
            <div class="col-xs-9 col-sm-10 font-pretty">
                <h3 class="subject-title">
                    <?= $user['username']?>
                    <small class="text-success">
                        <?= $user['isvip']? 'VIP用户' : '普通会员' ;?>
                    </small>
                </h3>
                <p class="text-muted">
                    注册时间：<?= date('Y-m-d', $user['created_at'])?>
                </p>
            </div>
        </div>
    </div>
</div>