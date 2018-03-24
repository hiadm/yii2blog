<?php
use yii\helpers\Html;
use common\components\Helper;
$this->registerCssFile('static/home/css/content.css',['depends'=>'frontend\assets\HomeAsset']);
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <!-- 文章内容 -->
                <div class="art-cont font-pretty">
                    <div class="article">
                        <div class="title">
                            <a class="txt-link" href="javascript:void(0);">
                                <h2><?= Html::encode($article['title'])?></h2>
                            </a>
                        </div>
                        <div class="posted">
                            <a class="photo" href="javascript:void(0);">
                                <img src="<?= !empty($user['photo'])?$user['photo']:$this->params['userPhoto']?>">
                            </a>
                            <div class="name text-muted">
                                <a href="#"><?= $user['username']?></a>
                                <i class="type copy">
                                    <?php
                                        $tmp = ['原创','转载','翻译'];
                                        echo $tmp[$article['type']];
                                    ?>
                                </i>
                                <?php
                                    if($article['isbest'] == 1){
                                        echo '<i class="type pull">推荐</i>';
                                    }
                                ?>
                                <p>
                                    <?= Yii::$app->formatter->asRelativeTime($article['created_at']);?>
                                    字数 <?= Helper::strlen_utf8($article['content'])?>,
                                    阅读 <?= $article['visited']?>,
                                    喜欢 <?= $article['favorite']?>,
                                    收藏 <?= $article['collect']?>
                                    <span>专题 <?= Html::a($article['subject']['name'], ['subject/view', 'id'=>$article['subject']['id']])?></span>
                                </p>
                            </div>
                        </div>
                        <div class="data">
                            <!-- 文章内容 -->
                            <div data-note-content="" class="show-content">
                                <?= Html::encode($article['content'])?>
                            </div>
                            <div class="heart">
                                <div class="heart-l pull-left">
                                    <ul>
                                        <!-- 打赏 -->
                                        <li><a href="JavaScript:;">￥打赏｡◕‿◕｡</a></li>
                                        <!-- 喜欢 -->
                                        <li><a href="JavaScript:;">♡喜欢</a></li>
                                        <!-- 收藏 -->
                                        <li><a href="JavaScript:;">+收藏</a></li>
                                    </ul>

                                </div>
                                <div class="heart-r pull-right">
                                    <!-- 分享 -->
                                    <a href="JavaScript:;">分享...</a>
                                </div>
                            </div>
                            <div class="nextprev">
                                <div class="prev">
                                    <a class="btn btn-info" type="submit" href="<?= $prevAndNext['prev']['url']?>">
                                        上一篇
                                    </a>
                                    <a class="text-muted" href="<?= $prevAndNext['prev']['url']?>"><?= $prevAndNext['prev']['title']?></a>
                                </div>
                                <p></p>
                                <div class="next">
                                    <a class="btn btn-success" type="submit" href="<?= $prevAndNext['next']['url']?>">
                                        下一篇
                                    </a>
                                    <a class="text-muted" href="<?= $prevAndNext['next']['url']?>"><?= $prevAndNext['next']['title']?></a>
                                </div>
                            </div>
                        </div>
                        <div class="comment">
                            <!-- 发表评论 -->
                            <div class="row">
                                <div class="col-xs-2 col-sm-1 posted"><a class="photo" href="#"><img src="static/home/img/photo1.jpg"></a></div>
                                <div class="col-xs-10 col-sm-11">
                                    <div class="textform">
                                        <textarea class="form-control" rows="5" placeholder="说点什么吧..."></textarea>
                                        <div class="mode">
                                            <div class="sincelogin text-center">
                                                <a href="#">登陆</a> &nbsp; 后发表评论！
                                            </div>
                                        </div>

                                    </div>
                                    <div class="postbtn">
                                        <span class="pull-left text-muted">Ctrl+Enter 发表</span>
                                        <span class="pull-right">

			    							<input class="btn btn-link" type="reset" name="" value="取消">
			    							<button class="btn btn-success" type="submit">发射<span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
			    						</span>
                                    </div>
                                </div>
                            </div>
                            <!-- 评论计数 -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="comment-count">59条评论 </p>
                                </div>
                            </div>
                            <hr>
                            <!-- 评论列表 -->
                            <div class="row">
                                <div class="col-xs-12 comment-data">
                                    <div class="comment-author">
                                        <div class="photo pull-left"><img src="static/home/img/photo.jpg"></div>
                                        <div class="info pull-left">
                                            <p class="text-primary">无声告白1</p>
                                            <p class="text-muted">4楼 · 2018.01.18 15:29</p>
                                        </div>
                                    </div>
                                    <div class="comment-str">
                                        <p>我是四川的，在河北上三本学校。宿舍里有河北的，他们300多分，我500.我四川小伙伴辛辛苦苦复读一年500多，我们还是上了同一所学校同一个专业，住进了同一个宿舍。他们惊讶我们分数高不值得到这学校，可我们苦笑，没有谁愿意跑这么远来。其实我想说，每一个为了高考努力彻夜奋战的人都是可爱的，每个省的考生都是一样的，没有日夜兼程，都攀不上高考这座山峰的顶端，不仅是河北，每个地方在努力拼搏的考生都很苦，都会早上四五点钟起床，凌晨入睡，两点一线，三点一线的生活他们也都经历过！</p>
                                    </div>
                                    <div class="comment-zan">
                                        <p>
                                            <span><a class="txt-link" href="#"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> 17人赞</a></span>&nbsp;&nbsp;
                                            <span><a class="txt-link" href="#"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 回复</a></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xs-12 comment-reply">
                                    <!-- 回复 -->
                                    <div class="reply-list">
                                        <div class="reply-item">
                                            <p> <span class="text-primary">夕夏未央</span> : <span class="text-warning">@夕夏未央</span> 河南人路过，深有体会。</p>
                                            <p>2018.01.18 20:09  <a href="#">回复</a></p>
                                        </div>
                                        <div class="reply-item">
                                            <p> <span class="text-primary">夕夏未央</span> : <span class="text-warning">@夕夏未央</span> 河南人路过，深有体会。</p>
                                            <p>2018.01.18 20:09  <a href="#">回复</a></p>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                    <span class="input-group-btn">
										        <button class="btn btn-default" type="button">提交</button>
										      </span>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <p class="pull-right text-muted">Ctrl+Enter 发表</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

