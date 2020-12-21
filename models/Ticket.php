<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property float $total
 * @property string $date_ticket
 * @property int|null $id_meeting
 *
 * @property Payment[] $payments
 * @property Meeting $meeting
 * @property TicketDetail[] $ticketDetails
 */
class Ticket extends \yii\db\ActiveRecord
{
    public $product_list;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'date_ticket','product_list'], 'required'],
            [['total'], 'number'],
            [['date_ticket', 'product_list'], 'safe'],
            [['id_meeting'], 'integer'],
            ['id_meeting', 'default', 'value' => null],
            [['id_meeting'], 'exist',  'skipOnError' => true, 'targetClass' => Meeting::className(), 'targetAttribute' => ['id_meeting' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'total' => Yii::t('app', 'Total'),
            'date_ticket' => Yii::t('app', 'Date Ticket'),
            'id_meeting' => Yii::t('app', 'Id Meeting'),
            'product_list' => Yii::t('app', 'Lista de productos'),
        ];
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery|PaymentQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['id_ticket' => 'id']);
    }

    // /**
    //  * Gets query for [[Meeting]].
    //  *
    //  * @return \yii\db\ActiveQuery|MeetingQuery
    //  */
    // public function getMeeting()
    // {
    //     return $this->hasOne(Meeting::className(), ['id' => 'id_meeting']);
    // }

    /**
     * Gets query for [[TicketDetails]].
     *
     * @return \yii\db\ActiveQuery|TicketDetailQuery
     */
    public function getTicketDetails()
    {
        return $this->hasMany(TicketDetail::className(), ['id_ticket' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TicketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketQuery(get_called_class());
    }
}
