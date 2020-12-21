<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property float $amount
 * @property string $date_payment
 * @property int $id_ticket
 *
 * @property Ticket $ticket
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'date_payment', 'id_ticket'], 'required'],
            [['amount'], 'number'],
            [['date_payment'], 'safe'],
            [['id_ticket'], 'integer'],
            //[['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['id_ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Monto'),
            'date_payment' => Yii::t('app', 'Date Payment'),
            'id_ticket' => Yii::t('app', 'Id Ticket'),
        ];
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery|TicketQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'id_ticket']);
    }

    /**
     * {@inheritdoc}
     * @return PaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }
}
