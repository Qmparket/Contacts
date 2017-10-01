<?php

namespace app\controllers;

use Yii;
use app\models\Person;
use app\models\PhoneNumber;
use app\models\PersonSearch;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
       
        $model = new Person();
        $modelsPhoneNumber = [new PhoneNumber];
        $br=0;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelsPhoneNumber = Model::createMultiple(PhoneNumber::classname());
            Model::loadMultiple($modelsPhoneNumber, Yii::$app->request->post());
            date_default_timezone_set('Europe/Sofia');
            $model->created_at = date('Y-m-d H:i:s');
           

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPhoneNumber) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPhoneNumber as $modelPhoneNumber) {
                            $modelPhoneNumber->person_id = $model->id;
                            $modelPhoneNumber->created_at = date('Y-m-d H:i:s');
                            $br++;
                            $model->phone_number_count = $br;
                            $model->save();
                            if (! ($flag = $modelPhoneNumber->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
        return $this->render('create', [
            'model' => $model,
            'modelsPhoneNumber' => (empty($modelsPhoneNumber)) ? [new PhoneNumber] : $modelsPhoneNumber,
        ]);
    }
        
    }
    

    

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPhoneNumber = $model->id;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsPhoneNumber, 'id', 'id');
            $modelsPhoneNumber = Model::createMultiple(PhoneNumber::classname(), $modelsPhoneNumber);
            Model::loadMultiple($modelsPhoneNumber, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPhoneNumber, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPhoneNumber) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPhoneNumber as $modelPhoneNumber) {
                            $modelPhoneNumber->customer_id = $model->id;
                            if (! ($flag = $modelPhoneNumber->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else{

        return $this->render('update', [
            'model' => $model,
            'modelsPhoneNumber' => (empty($modelsPhoneNumber)) ? [new PhoneNumber] : $modelsPhoneNumber,
        ]);
    }
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
