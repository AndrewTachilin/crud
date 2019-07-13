<?php

namespace app\controllers;

use Yii;
use app\models\Trainings;
use app\models\TrainingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * TrainingsController implements the CRUD actions for Trainings model.
 */
class TrainingsController extends Controller
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
     * Lists all Trainings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trainings model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Trainings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Trainings();
        if ($model->load(Yii::$app->request->post()) && $model->upload($model) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;
        $model->id = $id;
        $photo = $model->training_photo;
        $video = $model->feedback_video;
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            $files = $model->upload($model);
            if (is_array($files)) {
                if (!empty($files['photo'])) {
                    $model->feedback_video = $video;
                    $model->training_photo = $files['photo'];
                }
                if (!empty($files['video'])) {
                    $model->feedback_video = $files['video'];
                    $model->training_photo = $photo;
                }

                $model->name = Yii::$app->request->post('Trainings')['name'];
                $model->date = Yii::$app->request->post('Trainings')['date'];
                $model->address = Yii::$app->request->post('Trainings')['address'];
                $model->price = Yii::$app->request->post('Trainings')['price'];
                $model->text_before = Yii::$app->request->post('Trainings')['text_before'];
                $model->text_after = Yii::$app->request->post('Trainings')['text_after'];
                $model->text = Yii::$app->request->post('Trainings')['text'];
                $model->speaker = Yii::$app->request->post('Trainings')['speaker'];
                $model->status = Yii::$app->request->post('Trainings')['status'];

                $model->update();
                return $this->redirect(['view', 'id' => $model->id]);
            }



        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Trainings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trainings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trainings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
