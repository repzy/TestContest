<?php

use yii\helpers\Html;

/* @var $model app\models\Advertisement */
?>

    <table>
        <th><h3><?= $model->title ?></h3></th>
        <tr>
            <td><?= Html::img('/images/' . $model->image, ['style' => 'float:left' ]); ?></td>
            <td><?= $model->body ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <span>Author ip: <?= $model->author->ip ?>,</span>
                <span>browser lang: <?= $model->author->browser ?>,</span>
                <span>country: <?= $model->author->country ?>.</span>
            </td>
        </tr>
    </table>