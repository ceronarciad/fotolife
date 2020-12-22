<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "meeting".
 *
 * @property int $id key
 * @property string $title
 * @property string $description
 * @property string $start
 * @property string $time_init
 * @property int $status
 * @property int $user_id_log
 * @property string|null $location
 * @property int $id_service
 * @property string $latitude
 * @property string $longitude
 *
 * @property Service $service
 */
class Meeting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meeting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'start', 'time_init', 'id_service'], 'required', 'message'=>'Favor de completar el campo {attribute}.'],
            [['description', 'location'], 'string'],
            [['start', 'time_init'], 'safe'],
            [['status', 'user_id_log', 'id_service'], 'integer'],
            [['title', 'latitude', 'longitude'], 'string', 'max' => 100],
            [['id_service'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['id_service' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'key'),
            'title' => Yii::t('app', 'Titulo'),
            'description' => Yii::t('app', 'Descripcion'),
            'start' => Yii::t('app', 'Fecha'),
            'time_init' => Yii::t('app', 'Hora'),
            'status' => Yii::t('app', 'Estatus'),
            'user_id_log' => Yii::t('app', 'User Id Log'),
            'location' => Yii::t('app', 'Ubicación'),
            'id_service' => Yii::t('app', 'ServicioID'),
            'latitude' => 'Latitud',
            'longitude' => 'Longitud',
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery|ServiceQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'id_service']);
    }

    /**
     * {@inheritdoc}
     * @return MeetingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MeetingQuery(get_called_class());
    }

    public function dateTime(){
        return $genial = $this->start . ' ' . $this->time_init;
    }
}
