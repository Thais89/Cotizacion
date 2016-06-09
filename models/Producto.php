<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property string $codigo
 * @property string $fk_tipo_producto
 * @property string $nombre
 * @property string $cantidad
 * @property double $precio
 * @property double $impuesto
 *
 * @property TipoProducto $fkTipoProducto
 * @property ProductoHasPaquete[] $productoHasPaquetes
 * @property Paquete[] $paqueteCodigos
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fk_tipo_producto'], 'required'],
            [['fk_tipo_producto', 'cantidad'], 'integer'],
            [['precio', 'impuesto'], 'number'],
            [['nombre'], 'string', 'max' => 100],
            [['fk_tipo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProducto::className(), 'targetAttribute' => ['fk_tipo_producto' => 'idtipo_producto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'fk_tipo_producto' => 'Tipo Producto',
            'nombre' => 'Nombre',
            'cantidad' => 'Cantidad',
            'precio' => 'Precio',
            'impuesto' => 'Impuesto (%)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFkTipoProducto()
    {
        return $this->hasOne(TipoProducto::className(), ['idtipo_producto' => 'fk_tipo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoHasPaquetes()
    {
        return $this->hasMany(ProductoHasPaquete::className(), ['producto_codigo' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaqueteCodigos()
    {
        return $this->hasMany(Paquete::className(), ['codigo' => 'paquete_codigo'])->viaTable('producto_has_paquete', ['producto_codigo' => 'codigo']);
    }
}
