<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="project-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

<?php
$url = Url::to('https://cat.ppsdm.com');

//echo Yii::$app->user->isGuest;
echo Html::a('Click here to go to assessment', $url, ['class' => 'btn btn-primary','target'=>'_blank']);
?>
