<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Payment;
use app\models\Ticket;
use app\models\TicketDetail;
use app\models\Product;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use kartik\mpdf\Pdf;

/**
 * CustomerController implements the CRUD actions for Customer payment.
 */
class SaleController extends Controller
{

    public $json;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer payments.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }


    /**
     * View item
     * @return mixed
     */
    public function actionView($id)
    {
        $ticket = Ticket::findOne($id);

        $query = new \yii\db\Query();
        $query->from(['d' => 'ticket_detail'])
        ->select(['COUNT(*) AS count','p.name', 'd.amount', 'SUM(d.amount) as total'])
        ->innerJoin(['p'=>'products'],'d.id_product = p.id')
        ->andWhere(['d.id_ticket' => $ticket->id])
        ->groupBy(['p.name', 'd.amount'])
        ->all();

        $ticketDetails = $query->all();

        $payments = Payment::find()->where(['id_ticket' => $ticket->id])->all();
        $totalAmount = 0;

        if (sizeof($payments)==0) {

            $char = [['PAGO PENDIENTE', 100]];
            $payment_summary = [];
            
        }else{

            $count = 0;
            $total = $ticket->total;
            $total_payments = 0;
            $char = [
            ];
            $payment_summary = [
            ];

            foreach ($payments as $key => $value) {
                $count = $count + 1;
                $total_payments = $total_payments + (int)$value->amount;
                $percentage = (int)$value->amount * 100 / $total;
                $addPiece = [(string)"PAGO ". $count." - $". $value->amount, $percentage];
                $addPayment = [(string)"". $count, substr($value->date_payment, 0,10) , (string)"$". $value->amount];
                
                $totalAmount = $totalAmount + (int)$value->amount;
                array_push($char, $addPiece);
                array_push($payment_summary, $addPayment);
            }
      
            $remaining_percentage = 100 - $total_payments * 100 / $total;
        }

        return $this->render('view', [
            'ticket' => $ticket,
            'ticketDetails' => $ticketDetails,
            'payments' => $payments,
            'char' => $char,
            'payment_summary' => $payment_summary,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function actionCreate()
    {
        $payment = new Payment();
        $ticket = new Ticket();
        $products = ArrayHelper::map(Product::find()->select(['id','name'])->all(),'id','name');
        $request = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        $newdate = date("Y-m-d");

        if ($request) {
            try  {
                //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $ticket->total = (float)$request['total'];
                $ticket->date_ticket = $newdate;
                if($ticket->total > 0){
                    if($ticket->save(false)){
                   
                        $product_id_1 = ((int)$request['select_product_id_1'] > 0) ? (int)$request['select_product_id_1'] : null;
                        $product_id_2 = ((int)$request['select_product_id_2'] > 0) ? (int)$request['select_product_id_2'] : null;
                        $product_id_3 = ((int)$request['select_product_id_3'] > 0) ? (int)$request['select_product_id_3'] : null;
                        $product_id_4 = ((int)$request['select_product_id_4'] > 0) ? (int)$request['select_product_id_4'] : null;
                        $product_id_5 = ((int)$request['select_product_id_5'] > 0) ? (int)$request['select_product_id_5'] : null;
    
                        if($product_id_1){
                            $quantity_1 = (int)$request['input_quantity_1'];
                            
                            for ($i=0; $i < $quantity_1 ; $i++) {
                                $product = Product::findOne($product_id_1);
                                $ticketDetails = new TicketDetail();
                                $ticketDetails->amount = $product->price;
                                $ticketDetails->date_ticket = $newdate;
                                $ticketDetails->id_ticket = $ticket->id;
                                $ticketDetails->id_product =  $product->id;
                                $ticketDetails->save();
                            }
                        }
                        
                        if($product_id_2){
                            $quantity_2 = (int)$request['input_quantity_2'];
    
                            for ($i=0; $i < $quantity_2 ; $i++) {
                                $product = Product::findOne($product_id_2);
                                $ticketDetails = new TicketDetail();
                                $ticketDetails->amount = $product->price;
                                $ticketDetails->date_ticket = $newdate;
                                $ticketDetails->id_ticket = $ticket->id;
                                $ticketDetails->id_product = $product->id;
                                $ticketDetails->save();
                            }
                        }
                        
                        if($product_id_3){
                            $quantity_3 = (int)$request['input_quantity_3'];
    
                            for ($i=0; $i < $quantity_3 ; $i++) {
                                $product = Product::findOne($product_id_3);
                                $ticketDetails = new TicketDetail();
                                $ticketDetails->amount = $product->price;
                                $ticketDetails->date_ticket = $newdate;
                                $ticketDetails->id_ticket = $ticket->id;
                                $ticketDetails->id_product = $product->id;
                                $ticketDetails->save();
                            }
                        }
    
                        if($product_id_4){
                            $quantity_4 = (int)$request['input_quantity_4'];
                            
                            for ($i=0; $i < $quantity_4 ; $i++) {
                                $product = Product::findOne($product_id_4);
                                $ticketDetails = new TicketDetail();
                                $ticketDetails->amount = $product->price;
                                $ticketDetails->date_ticket = $newdate;
                                $ticketDetails->id_ticket = $ticket->id;
                                $ticketDetails->id_product =  $product->id;
                                $ticketDetails->save();
                            }
                        }
    
                        if($product_id_5){
                            $quantity_5 = (int)$request['input_quantity_5'];
    
                            for ($i=0; $i < $quantity_5 ; $i++) {
                                $product = Product::findOne($product_id_5);
                                $ticketDetails = new TicketDetail();
                                $ticketDetails->amount = $product->price;
                                $ticketDetails->date_ticket = $newdate;
                                $ticketDetails->id_ticket = $ticket->id;
                                $ticketDetails->id_product = $product->id;
                                $ticketDetails->save();
                            }
                        }
                        
                        $payment->amount = (float)$request['total_payment'];
                        $payment->date_payment = $newdate;
                        $payment->id_ticket = $ticket->id;
                        $payment->save();
                        
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $ticket->id]);
                    }else{
                        $transaction->rollBack();
                    }
                }else{
                    $transaction->rollBack();
                }
         
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        //return 'webos ';

        return $this->render('create', [
            'products' => $products,
        ]);
    }

    public function actionItem(){
        $data = Yii::$app->request->post('str');
        $product = Product::find()->where(['id' => $data])->one();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $product;
    }

    public function actionTicket($id) {
        $ticket = Ticket::findOne($id);
        $query = new \yii\db\Query();
        $query->from(['d' => 'ticket_detail'])
        ->select(['COUNT(*) AS count','p.name', 'd.amount', 'SUM(d.amount) as total'])
        ->innerJoin(['p'=>'products'],'d.id_product = p.id')
        ->andWhere(['d.id_ticket' => $ticket->id])
        ->groupBy(['p.name', 'd.amount'])
        ->all();
        $ticketDetails = $query->all();

        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return $ticketDetails;
        $payments = Payment::find()->where(['id_ticket' => $ticket->id])->all();
        $total_payments = 0;
        foreach ($payments as $key => $value) {
            $total_payments = $total_payments + (int)$value->amount;
        }

        if($total_payments == $ticket->total){
            $paidOut = "Completa";
        }else{
            $difference = $ticket->total - $total_payments;
            $paidOut = "Parcial (Restante $" . $difference.")";
        }

        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $date_ticket = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        $body = "<div class='container' >
                    <div class='page-header'>
                    <div class='panel panel-default'>
                    <div class='panel-heading'>
                    <h1>&nbsp;&nbsp;&nbsp;<img src='https://i.ibb.co/tLFdjnk/logo.png' height='50'/>&nbsp;&nbsp; FotoLife <small>Recordar es volver a vivir</small>&nbsp;&nbsp;&nbsp; <img src='https://i.ibb.co/tLFdjnk/logo.png' height='50'/></h1>
                    </div>
                    </div>
                    </div>
                    <div class='container'>
                        <div class='row'>
                            <div class='col-xs-12'>
                                <div class='text-center'>
                                    <i class='fa fa-search-plus pull-left icon'></i>
                                    <h2>Nota de compra #0000".$ticket->id."</h2>
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class='col-xs-12'>
                                        <div class='panel panel-default height'>
                                            <div class='panel-heading'><strong>Datos del cliente</strong></div>
                                            <div class='panel-body'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'><strong>Resumen de pago</strong>
                                    </div>
                                    <div class='panel-body'>
                                        <div class='table-bordered'>
                                        <table class='table table-condensed table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Cantidad</th>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                                foreach ($ticketDetails as $key => $value) {
                                                    $body = $body.'<tr>';
                                                    $counter = 0;
                                                        foreach ($value as $item) {
                                                            $counter ++;
                                                            $body = $body. '<td>';
                                                            $value = ($counter == 3 || $counter == 4) ? '$': '';
                                                            $body = $body.$value;
                                                            $body = $body. $item;
                                                            $body = $body. '</td>';
                                                        }
                                                    $body = $body.'</tr>';
                                                }
                                            $body = $body. "</tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>Total</b></td>
                                                    <td>$ $ticket->total </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-xs-12'>
                                <div class='panel panel-default height'>
                                        <div class='panel-heading'><strong>Información de pago</strong></div>
                                        <div class='panel-body'>
                                            <strong>Tipo de pago:</strong> Efectivo<br>
                                            <strong>Liquidación: </strong>".$paidOut ."<br>
                                        </div>
                                </div>
                            </div>

                            <br><br><br><br><br><br>
                            <br><br><br><br><br>
                            &nbsp;
                            <br>
                        </div>
                    </div>
        </div>";

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $body,
            'format' => Pdf::FORMAT_A4, 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
            ],
            'methods' => [
                'SetTitle' => 'FotoLife',
                'SetSubject' => 'Generado por DevProjects.com.mx',
                'SetHeader' => ['FotoLife|| a ' . $date_ticket],
                'SetFooter' => ['|Página {PAGENO}|'],
                'SetAuthor' => 'Foto Life',
                'SetCreator' => 'Foto Life',
                'SetKeywords' => 'Ticker, FotoLife',
            ]
        ]);
        return $pdf->render();
    }

}