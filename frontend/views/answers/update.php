<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */

$this->title = 'Update Answer';
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdAnswer, 'url' => ['view', 'id' => $model->IdAnswer]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="answers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'question' => $question,
    ]) ?>

</div>
