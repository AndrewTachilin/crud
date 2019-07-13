<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $status
 * @property string $text
 * @property string $main_img
 * @property string $header
 * @property string $date
 * @property string $body
 * @property string $img
 */
class Blog extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img'], 'file', 'skipOnEmpty' => false, 'extensions' => ['jpg','png']],
            [['main_img'], 'file', 'skipOnEmpty' => false, 'extensions' => ['jpg','png']],
            [['status', 'text'], 'string'],
            [['date'], 'safe'],
            [['header', 'body'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'text' => Yii::t('app', 'Text'),
            'main_img' => Yii::t('app', 'Main Img'),
            'header' => Yii::t('app', 'Header'),
            'date' => Yii::t('app', 'Date'),
            'body' => Yii::t('app', 'Body'),
            'img' => Yii::t('app', 'Img'),
        ];
    }

    public function upload($model)
    {
        $model->img = UploadedFile::getInstance($model, 'img');
        $model->main_img = UploadedFile::getInstance($model, 'main_img');
        if ($this->validate()) {
            if (!empty($_FILES['Blog']['name']['main_img'])) {

                $video = Yii::$app->security->generateRandomString(10) . '.' . $this->main_img->extension;
                $model->main_img->saveAs('uploads/' . $video, false);
                $arr['video'] = $video;
            }
            if (!empty($_FILES['Trainings']['name']['img'])){
                $photo = Yii::$app->security->generateRandomString(10) . '.' . $this->img->extension;
                $model->img->saveAs('uploads/' . $photo, false);
                $arr['photo'] = $photo;
            }
        } else {
            return false;
        }
        return $arr;

    }
}
