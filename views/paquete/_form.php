<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Producto;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Paquete */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paquete-form">

     <?php $form = ActiveForm::begin([
    'id' => 'dynamic-form',
    ]); ?>

   <div class="row">
       
            <div class="col-md-6"> <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?></div>

            <div class="col-md-2"><?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?></div>


           <div class="col-md-2"> <?= $form->field($model, 'descuento')->textInput() ?></div>
   </div>

     <div class="row col-md-12">
        
        <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Productos</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 15, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsProductoHasPaquete[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'fk_producto',
                    'cantidad',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsProductoHasPaquete as $i => $modelsProductoHasPaquete): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Productos</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelsProductoHasPaquete->isNewRecord) {
                                echo Html::activeHiddenInput($modelsProductoHasPaquete, "[{$i}]codigo");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsProductoHasPaquete, "[{$i}]producto_codigo")->dropDownList(

                                    ArrayHelper::map(Producto::find()->all(), 'codigo','nombre'), 
                                    ['prompt'=>'Seleccione producto']
                                ) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelsProductoHasPaquete, "[{$i}]cantidad")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Rigistrar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
