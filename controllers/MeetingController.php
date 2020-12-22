<?php

namespace app\controllers;

use Yii;
use app\models\Meeting;
use app\models\MeetingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;
use yii\helpers\BaseJson;
use app\models\Customer;
use app\models\Service;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use app\models\Ticket;
use app\models\TicketDetail;
use app\models\Payment;
use yii\db\Query;

/**
 * MeetingController implements the CRUD actions for Meeting model.
 */
class MeetingController extends Controller
{
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
     * Lists all Meeting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MeetingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = new Query;
        $query->select(["id, title, CONCAT(start, ' ', time_init) AS start, 
                        CONCAT('info') AS backgroundColor, 
                        CONCAT('info') AS borderColor,
                        CONCAT('white') AS textColor"])
                ->where('status>0')
                ->from('meeting');
        $rows = $query->all();
        $command = $query->createCommand();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $command->queryAll(),
        ]); 
    }

    /**
     * Displays a single Meeting model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $ticket = Ticket::find()->where(['id_meeting' => $model->id])->one();
        $modelcustomer = Customer::findOne($ticket->id_customer);
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return $ticket;

        $ticketDetails = TicketDetail::find()->where(['id_ticket' => $ticket->id])->all();
        $payments = Payment::find()->where(['id_ticket' => $ticket->id])->all();
        $service = Service::find()->where(['id' => $model->id_service])->one();
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

            if($total_payments < $service->price){
                array_push($char, ['PAGO PENDIENTE', $remaining_percentage]);
            }

        }
        
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       // return $payment_summary;

        return $this->render('view', [
            'model' => $model,
            'modelcustomer' => $modelcustomer,
            'char' => $char,
            'payment_summary' => $payment_summary,
            'service' => $service,
            'totalAmount' => $totalAmount,
            'ticket' => $ticket
        ]);
    }

    /**
     * Creates a new Meeting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Meeting();
        $modelticket = new Ticket();
        $modelcustomer = new Customer();
        $modelticketdetails = new TicketDetail();
        $listData=ArrayHelper::map(Service::find()->select(['id','title'])->all(),'id','title');
        $listDataCustomer=ArrayHelper::map(Customer::find()->select(['id','name'])->all(),'id','name');
        
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load(Yii::$app->request->post()) && $modelcustomer->load(Yii::$app->request->post())) {
            try  {

                if($modelcustomer->id == 0){
                    $modelcustomer->save();

                    if($modelcustomer->id == 0){
                        $transaction->rollBack();
                    }
                }

                $modelticket->id_customer = $modelcustomer->id;
                $serviceData = Service::find()->where(['id' => $model->id_service])->one();

                if ($model->save()) {
                    $modelticket->total = $serviceData->price;
                    $modelticket->date_ticket = date("Y-m-d");
                    $modelticket->id_meeting = $model->id;
                    $modelticket->save(false);

                    $modelticketdetails->amount = $serviceData->price;
                    $modelticketdetails->date_ticket = date("Y-m-d");
                    $modelticketdetails->id_ticket =  $modelticket->id;
                    $modelticketdetails->save();
                        
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
                
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'modelcustomer' => $modelcustomer,
                'dataservice' => $listData,
                'datacustomer' => $listDataCustomer
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelcustomer' => $modelcustomer,
                'dataservice' => $listData,
                'datacustomer' => $listDataCustomer
            ]);
        }

    }
 
    public function actionTicket($id) {
        
        $model = $this->findModel($id);
        $modelcustomer = Customer::findOne($model->id_customer);
        $modelservice = Service::findOne($model->id_service);
        $ticket = Ticket::find()->where(['id_meeting' => $id])->one();
        $ticketDetails = TicketDetail::find()->where(['id_ticket' => $id])->one();
        $payments = Payment::find()->where(['id_ticket' => $ticket->id])->all();
        
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return $ticket;
        
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

        $body = "
        <div class='container' >
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
                                    <h2>Nota de compra #0000".$model->id."</h2>
                                </div>
                                <hr>
                                <div class='row'>
                                    <div class='col-xs-12'>
                                        <div class='panel panel-default height'>
                                            <div class='panel-heading'><strong>Datos del cliente</strong></div>
                                            <div class='panel-body'>
                                                <strong>".$modelcustomer->name."</strong><br>
                                                ".$modelcustomer->email."<br>
                                                ".$modelcustomer->phone."<br>
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
                                            <table class='table table-condensed'>
                                                <thead>
                                                    <tr>
                                                        <td class='text-left'><strong>Nombre de servicio</strong></td>
                                                        <td class='text-left'><strong>Detalle</strong></td>
                                                        <td class='text-right'><strong>Precio</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>".$modelservice->title."</td>
                                                        <td class='text-left'>".$modelservice->description." con una duración de ".$modelservice->working_time." horas.</td>
                                                        <td class='text-right'>$".$modelservice->price."</td>
                                                    </tr>
                                                    <tr>
                                                        <td class='emptyrow'></td>
                                                        <td class='emptyrow text-left'><strong>Total</strong></td>
                                                        <td class='emptyrow text-right'>$".$modelservice->price."</td>
                                                    </tr>
                                                </tbody>
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

                            <div class='col-xs-12'>
                            <div class='panel panel-default'>
                            <div class='panel-body'><strong>
                            <h4>TÉRMINOS DEL CONTRATO</h4>
                            <p style='font-size:70%;'>Este  contrato  contiene  todos  los  aspectos  de  entendimiento  entre FotoLife y  el Cliente. Este reemplaza cualquier contrato anterior entre las partes. La única manera de adicionar o cambiar este acuerdo es por escrito y firmado por las partes.</p>
                            <p style='font-size:70%;'>RESERVA: La firma del contrato y anticipo es requerido para reservar el evento especificado.</p>
                            <p style='font-size:70%;'>CONSULTA  PREVIA:  Las  partes  acuerdan  reunirse  con  anticipación  al  evento  para  tratar algunos temas sobre la logística de las fotografías.</p>
                            <p style='font-size:70%;'>COOPERACIÓN:  Las  partes  acuerdan  disponer  de  toda  la  cooperación  y  comunicación para  lograr  el  mejor  resultado  de  este  trabajo.  Tanto  la  Novia  como  el  Novio  estarán dispuestos  a  aceptar  sugerencias  de  los  Fotógrafos  para  alguna  tomaen  particular  las cuales lucirán el estilo propio del Fotógrafo.</p>
                            <p style='font-size:70%;'>TIEMPO  DEDICADO:  El  Fotógrafo  se  comprometen  a  asistir  en  la  fecha  y  horas  indicadas donde  se  cubrirá  la  esencia  del  evento,  durante  la  reunión  o  recepción  se  avisará  a  los novios sobre el trabajo realizado y se acordará si  son necesarias más tomas para proceder con ellas o retirarse del evento.</p>
                            <p style='font-size:70%;'>REGLAS DE EVENTO: El Fotógrafo estarán limitados a las reglas del evento, La Iglesia o el lugar de  recepción  por  lo  tanto  el  cliente  acepta  los  resultados  técnicos  de  las  imposiciones  o limitaciones  que  tengan  estos.  La  participación  de  otros  fotógrafos  profesionales  no  es aceptada por los fotógrafos, por lo tanto,el cliente se responsabiliza de que esto no ocurra especialmente en la Iglesia donde comúnmente aparecen fotógrafos que interfieren en las tomas, como también, si los invitados que pueden llevar sus cámaras fotográficas, al hacer las tomas no interrumpan o incomoden al trabajo del fotógrafo</p>
                            <p style='font-size:70%;'>DERECHOS DE AUTOR: Todas las fotografías que se hagan durante los eventos antes descritos son  propiedad  de FotoLife. Las Fotografías  compradas  por  el  cliente  (Copia) podrán ser reproducidas y exhibidas,exclusivamente para uso personal. </p>
                            <p style='font-size:70%;'>LIMITE  DE  RESPONSABILIDAD  Y  GARANTÍA  DE  SATISFACCIÓN:  Si  por  alguna  circunstancia  de fuerza  mayor,  accidente,  incapacidad,  o  robo,  los  fotógrafos  no  pudieran  cumplir  este compromiso, El Fotógrafo hará todo el esfuerzo posible por buscar reemplazos profesionales que cubran el evento y se comprometen a avisar lo más pronto posible sobre la situación y devolverá el valor del anticipo en el caso de no resolver dicha circunstancia. Se respaldará en todo momento la entera satisfacción del cliente al servicio contratado.</p>
                            <p style='font-size:70%;'>POLÍTICA  DE  CANCELACIÓN: En  caso  de  cancelación  de  evento  el  anticipo  no  será devuelto,  sin embargo,en  caso  de  cambio  de  fecha,  el  fotógrafo acudirá  siemprey cuando la disponibilidad lo permita y sea avisado con anticipación.</p>
                            <p style='font-size:70%;'>PLAZOS  DE  ENTREGA  DEL  MATERIAL  FOTOGRÁFICO. El  fotógrafo  se  compromete  a  realizar  la entrega de las fotos como fecha límite 30 días después del evento.</p>
                            <p style='font-size:70%;'>FORMA DE PAGO: Según acuerden las partes, la forma de pago será por ingreso bancario o entrega en mano.</p>
                            <p style='font-size:70%;'>PLAZOS DE PAGO: Con la firma de este contrato se realiza una reserva de 30%.</p>
                            <br><br>
                            <p style='font-size:70%;'>He leído y entendido los términos de este contrato y estoy de acuerdo con el mismo.</p>
                            <p style='font-size:70%;'>En ___________________________a ___________ de ______________de 20____ .</p>
                            <br><br><br> <br><br><br> <br><br><br> <br><br>
                            <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ______________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ______________________________
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FOTO LIFE
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ". $modelcustomer->name."</p>
                            </div></div></div></div>
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

    public function actionAjax()
        {
            $data = Yii::$app->request->post('str');
            
            $client = new Client([
            'baseUrl' => 'https://geocoder.ls.hereapi.com/search/6.2/geocode.json?',
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ]]);
            
            $response = $client->get([
            'languages' => 'es-MX', 
            'maxresults' => '10', 
            'searchtext' => $data, 
            'apiKey' => 'POODzP5bCT1UlFq0aEvMHWAs1PX0QHE539FeGjkTs8k'])
            ->addHeaders(['content-type' => 'application/json'])
            ->send();

            return $response;
        }
        

        public function actionService(){
            $data = Yii::$app->request->post('str');
            
            $response = Service::find()
            ->where(['id' => $data])
            ->one();

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $response;
        }

    /**
     * Updates an existing Meeting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Meeting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Meeting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Meeting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Meeting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
