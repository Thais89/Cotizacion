<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto_has_paquete".
 *
 * @property string $producto_codigo
 * @property string $paquete_codigo
 * @property string $cantidad
 *
 * @property Producto $productoCodigo
 * @property Paquete $paqueteCodigo
 */
class ProductoHasPaquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_has_paquete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['producto_codigo', 'paquete_codigo'], 'required'],
            [['producto_codigo', 'paquete_codigo', 'cantidad'], 'integer'],
             [['cantidad','d'], 'integer'],
            [['producto_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['producto_codigo' => 'codigo'], 'message' => 'Registrado previamente'],
            [['paquete_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['paquete_codigo' => 'codigo'], 'message' => 'Registrado previamente'],
           [['cantidad'],'CheckCantidad']
        ];
    }

  
  public function CheckCantidad($attribute, $params)
    {
        $cant = Producto::find()->where(['codigo'=>$this->producto_codigo])->one();
        
        if($cant->disponibilidad<$this->cantidad)
        {
            $this->addError($attribute,'Cantidad insuficiente, Disponibilidad: '.$cant->disponibilidad);
        }
        elseif($cant->disponibilidad<$this->cantidad*$this->d)
        {
            $this->addError($attribute,'Cantidad insuficiente para cubrir la cantidad de paquetes, Disponibilidad: '.$cant->disponibilidad);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'producto_codigo' => 'Producto Codigo',
            'paquete_codigo' => 'Paquete Codigo',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoCodigo()
    {
        return $this->hasOne(Producto::className(), ['codigo' => 'producto_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaqueteCodigo()
    {
        return $this->hasOne(Paquete::className(), ['codigo' => 'paquete_codigo']);
    }
}
