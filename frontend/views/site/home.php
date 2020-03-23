<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = 'Assessment Center';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome <?php echo Yii::$app->user->identity->username; ?></h1>



        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Project A</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><?= Html::a('Masuk >>', ['project/view', 'id' => '1'], ['class' => 'btn btn-default']) ?></p>
            </div>

        </div>

    </div>
</div>
