<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TipoProducto;
use  yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      
      <div class="col-md-4"> <?= $form->field($model, 'fk_tipo_producto')->dropDownList(

        ArrayHelper::map(TipoProducto::find()->all(), 'idtipo_producto','descripcion'), 
        ['prompt'=>'Seleccione el tipo de producto']
        ) ?></div>


    <div class="col-md-6"><?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?></div>

    </div>

    <div class="row">
      
       <div class="col-md-2"> <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?></div>

   <div class="col-md-2"> <?= $form->field($model, 'precio')->textInput() ?></div>

   <div class="col-md-2"> <?= $form->field($model, 'impuesto')->textInput() ?></div>

    </div>
      
    </div>
   


    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? 'Rigistrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
