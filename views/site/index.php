<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-index">

    <?php Pjax::begin(['enablePushState' => false])?>

    <a href="<?= \yii\helpers\Url::to(['index', 'sort' => 'SORT_ASC'])?>"><button class="btn btn-success">Sort ASC</button></a>
    <a href="<?= \yii\helpers\Url::to(['index', 'sort' => 'SORT_DESC'])?>"><button class="btn btn-success">Sort DESC</button></a>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view',
    ]) ?>

    <?php Pjax::end()?>
</div>
