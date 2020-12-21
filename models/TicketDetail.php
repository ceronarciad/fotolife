<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket_detail".
 *
 * @property int $id
 * @property float $amount
 * @property string $date_ticket
 * @property int $id_ticket
 *
 * @property Ticket $ticket
 */
class TicketDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'date_ticket', 'id_ticket'], 'required'],
            [['amount'], 'number'],
            [['date_ticket'], 'safe'],
            [['id_ticket'], 'integer'],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['id_ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Amount'),
            'date_ticket' => Yii::t('app', 'Date Ticket'),
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
     * @return TicketDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketDetailQuery(get_called_class());
    }
}
