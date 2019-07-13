<?php

namespace app\modules\admin\controllers;

use app\models\StaticPageContent;
use Yii;
use app\models\Countries;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Countries model.
 */
class DefaultController extends Controller
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
     * Lists all Countries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Countries::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Countries model.
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
     * Creates a new Countries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Countries();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->country_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Countries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Countries::findOne(['country_id' => $id]);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->updateCountry(Yii::$app->request->post('Countries'));
            if(Yii::$app->request->post('Countries')['is_active'] == 'true'){
                $model->is_active = 'true';
                $model->update();
                $existStaticPage = StaticPageContent::findOne(['country_code' => Yii::$app->request->post('Countries')['code']]);

                if(is_null($existStaticPage)){
                    $staticPageContent = new StaticPageContent();
                    $activeCountries = Countries::find()->where(['is_active' => true])->with(['languageCode','languageRelation'])->all();
                    foreach ($activeCountries as $country){
                        $staticPageContent->country_code = Yii::$app->request->post('Countries')['code'];
                        $staticPageContent->language = isset($country->languageCode->language_id) ? $country->languageCode->language_id: '';
                        $staticPageContent->save();
                    }
//                    $staticPageContent->country_code = Yii::$app->request->post('Countries')['code'];
//                    $staticPageContent->language = $country->languageCode->language_id;
//                    $staticPageContent->page_name = Yii::$app->params['C51-A28-editable'];
//                    $staticPageContent->save();
                }

            }else{
                $model->is_active = 'false';
                $model->update();
                StaticPageContent::deleteAll(['country_code' =>  Yii::$app->request->post('Countries')['code']]);
            }
            return $this->redirect(['view', 'id' => $model->country_id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Countries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Countries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('indexPage', 'The requested page does not exist.'));
    }
}
