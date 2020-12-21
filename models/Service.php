<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property string $working_time
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price', 'working_time'], 'required', 'message'=>'Favor de completar el campo {attribute}.'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['working_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripcion'),
            'price' => Yii::t('app', 'Precio'),
            'working_time' => Yii::t('app', 'Duración'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }
}
