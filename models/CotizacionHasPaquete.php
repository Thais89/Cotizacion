<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotizacion_has_paquete".
 *
 * @property string $fkCotizacion
 * @property string $fkPaquete
 * @property string $cantidad
 * @property double $subtotal
 * @property double $descuento
 * @property double $total
 *
 * @property Cotizacion $fkCotizacion0
 * @property Paquete $fkPaquete0
 */
class CotizacionHasPaquete extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizacion_has_paquete';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fkCotizacion', 'fkPaquete'], 'required'],
            [['fkCotizacion', 'fkPaquete', 'cantidad'], 'integer'],
            [['subtotal', 'descuento', 'total'], 'number'],
            [['fkCotizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizacion::className(), 'targetAttribute' => ['fkCotizacion' => 'idcotizacion']],
            [['fkPaquete'], 'exist', 'skipOnError' => true, 'targetClass' => Paquete::className(), 'targetAttribute' => ['fkPaquete' => 'codigo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fkCotizacion' => 'Cotizacion',
            'fkPaquete' => 'Paquete',
            'cantidad' => 'Cantidad',
            'subtotal' => 'Subtotal',
            'descuento' => 'Descuento',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkCotizacion0()
    {
        return $this->hasOne(Cotizacion::className(), ['idcotizacion' => 'fkCotizacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkPaquete0()
    {
        return $this->hasOne(Paquete::className(), ['codigo' => 'fkPaquete']);
    }
}
