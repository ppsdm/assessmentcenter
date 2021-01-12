<?php

use yii\helpers\Html;

?>
<div class="project-default-index">
    <h1>Admin Main Page</h1>

</div>

<?php
echo '<h1>';
echo Html::a(Yii::t('app', 'Projects'), ['projects'], ['class' => 'btn btn-primary']);
echo '</h1><h1>';
echo Html::a(Yii::t('app', 'Users'), ['users'], ['class' => 'btn btn-primary']);
echo '</h1>';
?>
