<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string|null $birthday
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required','message'=>'Favor de completar el campo {attribute}.'],
            [['birthday'], 'safe'],
            [['name', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nombre'),
            'phone' => Yii::t('app', 'Teléfono'),
            'email' => Yii::t('app', 'Correo electrónico'),
            'birthday' => Yii::t('app', 'Fecha de nacimiento'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
