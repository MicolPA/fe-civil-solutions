<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */

$this->title = 'Update Question';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdQuestion, 'url' => ['view', 'id' => $model->IdQuestion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
