<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Paquete;
use  yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Cotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cotizacion-form">

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

   
 <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?></div>

    <div class="col-md-6"><?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?></div>
 
 </div>

    <div class="row">
        
        <div class="col-md-2"><?= $form->field($model, 'ruc')->textInput(['maxlength' => true]) ?></div>

         <div class="col-md-4"><?= $form->field($model, 'descuento')->textInput() ?></div>

        <div class="col-md-6"><?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?></div>


    </div>

 <div class="row col-md-12">
        
        <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Paquetes</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 15, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsCotizacionitems[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'fk_producto',
                    'cantidad',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsCotizacionitems as $i => $modelsCotizacionitems): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Paquete</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelsCotizacionitems->isNewRecord) {
                                echo Html::activeHiddenInput($modelsCotizacionitems, "[{$i}]fkPaquete");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsCotizacionitems, "[{$i}]fkPaquete")->dropDownList(

                                    ArrayHelper::map(Paquete::find()->all(), 'codigo','nombre'), 
                                    ['prompt'=>'Seleccione paquete']
                                ) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelsCotizacionitems, "[{$i}]cantidad")->textInput(['maxlength' => true]) ?>
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
