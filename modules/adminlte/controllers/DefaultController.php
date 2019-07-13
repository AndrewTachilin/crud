<?php

namespace app\modules\adminlte\controllers;

use app\models\Mail;
use app\models\UserProfile;
use mdm\admin\models\searchs\User as UserSearch;
use app\core\controllers\CoreController;
use app\models\Countries;
use app\models\Language;
use app\models\StartPages;
use app\models\StaticPageContent;
use app\models\UrlLocalization;
use app\models\User;
use Mpdf\Tag\U;
use services\httpclient\JsonParser;
use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Countries model.
 */
class DefaultController extends CoreController
{
    public $layout ='/header-admin';
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $get = Yii::$app->request->get();
        if(!empty($get['id'])){
            $user = User::findOne(['id' => $get['id']]);
            if(!empty($user)){
                $user->delete();
            }
            return $this->redirect('/lte/users');
        }
        return $this->redirect('/lte');


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

    public function actionTest()
    {
        return $this->render('test', [
        ]);
    }

    public function actionStatistics()
    {
        $countries = Countries::find()->where(['is_active' => 'true'])->with('userCount', 'profit')->all();
        return $this->render('statistics', [
            'countries' => $countries
        ]);
    }

    public function actionUserPhoto()
    {
        if(empty(Yii::$app->request->get('offset'))){
            $offset = 0;
        }else{
            $offset = Yii::$app->request->get('offset');
        }
        $users = User::getAllUser(20,$offset);
        $countUsers = count(User::find()->where('id'>0)->all());
        return $this->render('user-photo', [
            'users' => $users,
            'count' => $countUsers
        ]);
    }

    public function actionTranslations()
    {
        return $this->render('translations', [
        ]);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdateAvailable()
    {
        $post = Yii::$app->request->post();
        if(!empty($post['id']) && isset($post['status'])){

            $updateStatus = User::findOne(['id' => $post['id']]);
            $updateStatus->photo_reject = intval($post['status']);

            if(!boolval($post['status'])){
                $mail_reject_status = Mail::photoRejected(Yii::$app->params['user']);
            }else{
                $mail_reject_status = true;
            }


            if($mail_reject_status && $updateStatus->save()){
                $this->asJson(['status' => true,'id'=> $post['id'],'reject' => boolval($post['status'])]);
            }else{
                $this->asJson(['status' => false,'id'=> $post['id'],'reject' => boolval($post['status'])]);
            }

        }
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionContent()
    {
        $request = Yii::$app->request;
        $model = new StartPages();
        $languages = Language::find()->where(['status' => 1])->all();

        $countries = Countries::find()->where(['is_active' => 'true'])->all();
        $countryFlag = Countries::findOne(['code' =>
            Language::findOne(['language_id' => Yii::$app->params['currentLang'] ? Yii::$app->params['currentLang'] : Yii::$app->params['defaultLang']])]);
        if(Yii::$app->request->get('id')) {

            $country  = Yii::$app->request->get('id');

            $startPage = StartPages::findOne(['id' => $country]);
            if (!empty($startPage) && $startPage->load(Yii::$app->request->post()) && $startPage->validate()) {
                $startPage->update();
            }elseif ($model->load(Yii::$app->request->post()) && $model->validate()){

                $model->save();
                $urlLocalization = new UrlLocalization();
                $urlLocalization->is_active = true;
                $urlLocalization->save();
            }

            return $this->render('content',[
                'identifier'    => $startPage->identifier,
                'lang_name' => $startPage->language_name,
                'country_name'  => $startPage->country_name,
                'model' => $model,
                'data' => $startPage,
                'languages' => $languages,
                'countries' => $countries,
                'visable_form'      => true
            ]);
        }elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $model->save();

        }elseif(Yii::$app->request->isAjax && !empty(Yii::$app->request->post('country_name')) && Yii::$app->request->post('flag') == 2){
          if(!empty(Yii::$app->request->post('language_name'))){
              $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'language_name' => Yii::$app->request->post('language_name')]);
          }else{
              $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name')]);
          }
            return $this->asJson([
                'country' => $request->post('country_name'),
                'pages' => $start
            ]);
        }elseif(!empty($request->get('country_ajax'))){
            $country_name = Yii::$app->request->get('country_ajax');
            $counter = StartPages::find()->where(['country_name' => $country_name,'real_action' => 'site/index'])->count() + 1;
            $language_name = Yii::$app->request->get('language_ajax');
            $mix = explode('-',$language_name);
            $data = StartPages::findOne(['country_name' => $country_name,'real_action' => 'site/index','language_name'  => $language_name]);
            $language_name = Yii::$app->request->get('language_ajax');
            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            return $this->render('content',[
                'identifier'    => $identifier,
                'data'              => $data,
                'model' => $model,
                'languages' => $languages,
                'countries' => $countries,
                'lang_name' => $language_name,
                'country_name'  => $country_name,
                'visable_form'      => true
            ]);
        }
        $start = StartPages::findAll(['country_name'    => $countries['0'],'real_action' => 'site/index']);

        return $this->render('content', [
            'languages' => $languages,
            'countries' => $countries,
            'countryFlag' => $countryFlag,
            'pages' => $start,
            'model' => $model,
            'visable_form'  => false,
        ]);
    }
    public function actionStart()
    {

        $request = Yii::$app->request;
        $model = new StartPages();
        $languages = Language::find()->where(['status' => 1])->all();
        $countries = Countries::find()->where(['is_active' => 'true'])->all();
        $countryFlag = Countries::findOne(['code' =>
            Language::findOne(['language_id' => Yii::$app->params['currentLang'] ? Yii::$app->params['currentLang'] : Yii::$app->params['defaultLang']])]);
        if(Yii::$app->request->get('id')) {

            $country  = Yii::$app->request->get('id');

            $startPage = StartPages::findOne(['id' => $country]);
            if (!empty($startPage) && $startPage->load(Yii::$app->request->post()) && $startPage->validate()) {
                $startPage->update();
            }elseif ($model->load(Yii::$app->request->post()) && $model->validate()){

                $model->save();
                $urlLocalization = new UrlLocalization();
                $urlLocalization->is_active = true;
                $urlLocalization->save();
            }

            return $this->render('start',[
                'identifier'    => $startPage->identifier,
                'lang_name' => $startPage->language_name,
                'country_name'  => $startPage->country_name,
                'model' => $model,
                'data' => $startPage,
                'languages' => $languages,
                'countries' => $countries,
                'visable_form'      => true
            ]);
        }elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();

        }elseif(Yii::$app->request->isAjax && !empty(Yii::$app->request->post('country_name')) && Yii::$app->request->post('flag') == 2){
            if(!empty(Yii::$app->request->post('language_name'))){
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'language_name' => Yii::$app->request->post('language_name'),'real_action' => Yii::$app->request->post('real_action')]);
            }else{
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'real_action' => Yii::$app->request->post('real_action')]);
            }
            return $this->asJson([
                'country' => $request->post('country_name'),
                'pages' => $start
            ]);
        }elseif(!empty($request->get('country_ajax'))){
            $country_name = Yii::$app->request->get('country_ajax');
            $counter = StartPages::find()->where(['country_name' => $country_name,'real_action' => 'site/all-about'])->count() + 1;
            $language_name = Yii::$app->request->get('language_ajax');
            $mix = explode('-',$language_name);
            $data = StartPages::findOne(['country_name' => $country_name,'real_action' => 'site/all-about','language_name'  => $language_name]);
            $language_name = Yii::$app->request->get('language_ajax');

            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            return $this->render('start',[
                'identifier'    => $identifier,
                'data'              => $data,
                'model' => $model,
                'languages' => $languages,
                'countries' => $countries,
                'lang_name' => $language_name,
                'country_name'  => $country_name,
                'visable_form'      => true
            ]);
        }
        $start = StartPages::findAll(['country_name'    => $countries['0'],'real_action' => 'site/all-about']);

        return $this->render('start', [
            'languages' => $languages,
            'countries' => $countries,
            'countryFlag' => $countryFlag,
            'pages' => $start,
            'model' => $model,
            'visable_form'  => false,
        ]);
    }
    public function actionLanding()
    {
        $request = Yii::$app->request;
        $model = new StartPages();
        $languages = Language::find()->where(['status' => 1])->all();
        $countries = Countries::find()->where(['is_active' => 'true'])->all();
        $countryFlag = Countries::findOne(['code' =>
            Language::findOne(['language_id' => Yii::$app->params['currentLang'] ? Yii::$app->params['currentLang'] : Yii::$app->params['defaultLang']])]);
        if(Yii::$app->request->get('id')) {
            $country  = Yii::$app->request->get('id');
            $startPage = StartPages::findOne(['id' => $country]);
            if (!empty($startPage) && $startPage->load(Yii::$app->request->post()) && $startPage->validate()) {
                $startPage->update();
            }elseif ($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->save();
                $urlLocalization = new UrlLocalization();
                $urlLocalization->is_active = true;
                $urlLocalization->save();
            }

            return $this->render('landingpage',[
                'identifier'    => $startPage->identifier,
                'lang_name' => $startPage->language_name,
                'country_name'  => $startPage->country_name,
                'model' => $model,
                'data' => $startPage,
                'languages' => $languages,
                'countries' => $countries,
                'visable_form'      => true
            ]);
        }elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();

        }elseif(Yii::$app->request->isAjax && !empty(Yii::$app->request->post('country_name')) && Yii::$app->request->post('flag') == 2){
            if(!empty(Yii::$app->request->post('language_name'))){
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'language_name' => Yii::$app->request->post('language_name'),'real_action' => Yii::$app->request->post('real_action')]);
            }else{
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'real_action' => Yii::$app->request->post('real_action')]);
            }
            return $this->asJson([
                'country' => $request->post('country_name'),
                'pages' => $start
            ]);
        }elseif(!empty($request->get('country_ajax'))){
            $country_name = Yii::$app->request->get('country_ajax');
            $language_name = Yii::$app->request->get('language_ajax');
            $counter = StartPages::find()->where(['country_name' => $country_name, 'language_name' => $language_name])->count() + 1;
            $mix = explode('-',$language_name);
            $data = StartPages::findOne(['country_name' => $country_name,'real_action' => 'site/custom','language_name'  => $language_name]);

            $language_name = Yii::$app->request->get('language_ajax');

            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            return $this->render('landingpage',[
                'identifier'    => $data['identifier'],
                'data'              => $data,
                'model' => $model,
                'languages' => $languages,
                'countries' => $countries,
                'lang_name' => $language_name,
                'country_name'  => $country_name,
                'visable_form'      => true
            ]);
        }
        $start = StartPages::findAll(['country_name'    => $countries['0'],'real_action' => 'site/custom']);

        return $this->render('landingpage', [
            'languages' => $languages,
            'countries' => $countries,
            'countryFlag' => $countryFlag,
            'pages' => $start,
            'model' => $model,
            'visable_form'  => false,
        ]);
    }
    public function actionLegal()
    {
        $request = Yii::$app->request;
        $model = new StartPages();
        $languages = Language::find()->where(['status' => 1])->all();
        $countries = Countries::find()->where(['is_active' => 'true'])->all();
        $countryFlag = Countries::findOne(['code' =>
            Language::findOne(['language_id' => Yii::$app->params['currentLang'] ? Yii::$app->params['currentLang'] : Yii::$app->params['defaultLang']])]);
        if(Yii::$app->request->get('id')) {

            $country  = Yii::$app->request->get('id');

            $startPage = StartPages::findOne(['id' => $country]);
            if (!empty($startPage) && $startPage->load(Yii::$app->request->post()) && $startPage->validate()) {
                $startPage->update();
            }elseif ($model->load(Yii::$app->request->post()) && $model->validate()){

                $model->save();
                $urlLocalization = new UrlLocalization();
                $urlLocalization->is_active = true;
                $urlLocalization->save();
            }

            return $this->render('legal',[
                'identifier'    => $startPage->identifier,
                'lang_name' => $startPage->language_name,
                'country_name'  => $startPage->country_name,
                'model' => $model,
                'data' => $startPage,
                'languages' => $languages,
                'countries' => $countries,
                'visable_form'      => true
            ]);
        }elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->save();

        }elseif(Yii::$app->request->isAjax && !empty(Yii::$app->request->post('country_name')) && Yii::$app->request->post('flag') == 2){
            if(!empty(Yii::$app->request->post('language_name'))){
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name'),'language_name' => Yii::$app->request->post('language_name')]);
            }else{
                $start = StartPages::findAll(['country_name'    => Yii::$app->request->post('country_name')]);
            }
            return $this->asJson([
                'country' => $request->post('country_name'),
                'pages' => $start
            ]);
        }elseif(!empty($request->get('country_ajax'))){
            $country_name = Yii::$app->request->get('country_ajax');
            $counter = StartPages::find()->where(['country_name' => $country_name])->count() + 1;
            $language_name = Yii::$app->request->get('language_ajax');
            $mix = explode('-',$language_name);
            $data = StartPages::findOne(['country_name' => $country_name,'language_name'  => $language_name]);
            $language_name = Yii::$app->request->get('language_ajax');
            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            return $this->render('legal',[
                'identifier'    => $identifier,
                'data'              => $data,
                'model' => $model,
                'languages' => $languages,
                'countries' => $countries,
                'lang_name' => $language_name,
                'country_name'  => $country_name,
                'visable_form'      => true
            ]);
        }
        $start = StartPages::findAll(['country_name'    => $countries['0']]);

        return $this->render('legal', [
            'languages' => $languages,
            'countries' => $countries,
            'countryFlag' => $countryFlag,
            'pages' => $start,
            'model' => $model,
            'visable_form'  => false,
        ]);
    }

    public function actionGetPageDetails()
    {
        if (Yii::$app->request->isAjax && !empty(Yii::$app->request->post('language_name')) && !empty(Yii::$app->request->post('country_name'))){
            $language_name = Yii::$app->request->post('language_name');
            $country_name = Yii::$app->request->post('country_name');
            $page_name = Yii::$app->request->post('real_action');
            $startPage = StartPages::findOne(['country_name' => $country_name, 'language_name' => $language_name,'page_name' => $page_name]);
            $mix = explode('-',$language_name);
            $counter = StartPages::find()->where(['country_name' => $country_name,'real_action' => Yii::$app->request->post('page_name')])->count() + 1;
            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            $startPage = StartPages::findOne(['country_name' => $country_name, 'language_name' =>Yii::$app->request->post('language_name'),'real_action' => Yii::$app->request->post('real_action')]);

            return $this->asJson(['result' => $startPage,'counter' => $counter,'request_lang'   => $language_name,'country_name'    => $country_name,'real_action'=> $page_name, 'identifier'  => $unique_identifier]);
        }
    }


    public function actionGetPageLegal()
    {
        if (Yii::$app->request->isAjax && !empty(Yii::$app->request->post('language_name')) && !empty(Yii::$app->request->post('country_name'))){
            $language_name = Yii::$app->request->post('language_name');
            $country_name = Yii::$app->request->post('country_name');
            $startPage = StartPages::findOne(['country_name' => $country_name, 'language_name' => $language_name]);
            $mix = explode('-',$language_name);
            $counter = StartPages::find()->where(['country_name' => $country_name])->count() + 1;
            $identifier = $country_name.'-'.$mix[1].'-0000'.$counter;
            $unique_identifier = $this->existIdentifier($identifier,$mix[1],$country_name,$counter);
            $data['country_name'] = $country_name;
            $data['language_name'] = $language_name;
            $data['identifier'] = $unique_identifier;
            $startPage = StartPages::findOne(['country_name' => $country_name, 'language_name' =>Yii::$app->request->post('language_name')]);

            return $this->asJson(['result' => $startPage,'counter' => $counter,'request_lang'   => $language_name,'country_name'    => $country_name, 'identifier'  => $unique_identifier]);
        }
    }



    public function actionUsers()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit()
    {
        $model = new User(['scenario' => User::SCENARIO_CREATE_BY_ADMIN]);
        $profile = new UserProfile();
        $get = Yii::$app->request->get();
        $post = Yii::$app->request->post();

        if($model->load($post) && $model->validate() && $profile->load($post) && $profile->validate()){
            UserProfile::updateProfile($post['User']['id'],$post['UserProfile']);


           User::updateUserData($post['User']);
        }

        if(!empty($get['id'])) {
            $user = User::findIdentity($get['id']);
            if(!empty($user)) {
                return $this->render('edit', [
                    'user' => $user,
                    'model' => $model,
                    'user_profile' => $profile
                ]);
            }else{
                return $this->redirect('/lte/users');
            }
        }
    }

    public function actionAjaxBlockUser(){
        $post = Yii::$app->request->post();
        if(!empty($post['id'] && Yii::$app->request->isAjax)){
            $user = User::findIdentity($post['id']);
            $user->user_status = false;
            $user->update();
        }
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionAjaxDeleteUser()
    {

        $post = Yii::$app->request->post();
        if(!empty($post['id'] && Yii::$app->request->isAjax)){
            $user = User::findIdentity($post['id']);
            $user->delete();
        }

    }

    public function actionDeletePage()
    {
        $post = Yii::$app->request->post('StartPages');
        if(!empty($post['id'])){

            $deletePage = StartPages::findOne(['id' => $post['id']]);
            if(!empty($deletePage)){
                $deletePage->delete();
            }
            return $this->redirect('/lte/content');
        }

    }

    private function existIdentifier($identifier,$language,$country,$counter,$old_identifier = null){
        $identifier = $country.'-'.$language.'-0000'.$counter;
        $exist = StartPages::findOne(['identifier'  => $identifier]);

        if(!empty($exist)){
           return $this->existIdentifier($identifier,$language,$country,$counter+1,$exist);
        }else{
            return $identifier;
        }
    }


}















