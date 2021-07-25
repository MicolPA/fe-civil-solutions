<?php

use app\models\Category;
use app\models\QuestionType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $model2 app\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Question')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'IdQuestionType')->dropDownList(
        ArrayHelper::map(QuestionType::find()->all(), 'IdQuestionType','QuestionType'),
        ['prompt' => 'Select a Question Type',
         'id' => 'QuestionTypeSelect',
         'onchange' => 'questionType();',
        ]
        
        ) 
    ?>

    <div id="lblQuestionType" class="d-none">
        <?= $form->field($model2, 'Answer')->textarea(['rows' => '6',
            'class' => 'form-control',
            'id' => 'CorrectAnswer',
            'name' => 'CorrectAnswer'
        ]) ?>
    </div>


    <?= $form->field($model, 'IdCategory')->dropDownList(
        ArrayHelper::map(Category::find()->all(), 'IdCategory','Name'),
        ['prompt' => 'Select a Category'       
        ]) 
    ?>

    <?= $form->field($model2, 'Image')->fileInput([
        
        ]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
