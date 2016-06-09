<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-4 col-md-offset-4"> <?= $form->field($model, 'rol')->dropDownList(
        ['0'=>'Administrador','1'=>'Vendedor'],['prompt'=>'Seleccione rol']
    ) ?></div>

    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?></div>

        <div class="col-md-6"> <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?></div>
    </div>

  <div class="row">
        <div class="col-md-6"> <?= $form->field($model, 'usuario')->textInput(['maxlength' => true]) ?></div>

       <div class="col-md-6"> <?= $form->field($model, 'contrasena')->textInput(['maxlength' => true]) ?></div>
  </div>

   

    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Rigistrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
