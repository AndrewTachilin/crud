<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "trainings".
 *
 * @property int $id
 * @property string $training_photo
 * @property string $name
 * @property string $date
 * @property string $address
 * @property double $price
 * @property string $text_before
 * @property string $text_after
 * @property string $text
 * @property int $speaker
 * @property string $feedback_video
 * @property string $status
 */
class Trainings extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
//    const SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trainings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg','png']],
            [['feedback_video'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg','png']],
            [['date'], 'date', 'format'=>'Y-m-d'],
            [['price'], 'number'],
            [['text_before', 'speaker','text_after', 'text', 'status'], 'string'],
            [['name','address'], 'string', 'max' => 255],
            [['date','price','text_before','text_after','text','status','name','address'], 'required', 'on' => self::SCENARIO_UPDATE],
//            [['date','price','text_before','text_after','text','status','name','address'], 'required', 'on' => self::SCENARIO_CREATE],
//            [['training_photo','feedback_video'], 'file', 'skipOnEmpty' => false, 'extensions' => ['jpg','png'],'on' => self::SCENARIO_CREATE],
            [['training_photo','feedback_video'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg','png'],'on' => self::SCENARIO_UPDATE],



        ];
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'training_photo' => Yii::t('app', 'Training Photo'),
            'name' => Yii::t('app', 'Name'),
            'date' => Yii::t('app', 'Date'),
            'address' => Yii::t('app', 'Address'),
            'price' => Yii::t('app', 'Price'),
            'text_before' => Yii::t('app', 'Text Before'),
            'text_after' => Yii::t('app', 'Text After'),
            'text' => Yii::t('app', 'Text'),
            'speaker' => Yii::t('app', 'Speaker'),
            'feedback_video' => Yii::t('app', 'Feedback Video'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    public function upload($model)
    {

        if ($this->validate()) {
            if (!empty($_FILES['Trainings']['name']['feedback_video'])) {
                $model->feedback_video = UploadedFile::getInstance($model, 'feedback_video');
                $video = Yii::$app->security->generateRandomString(10) . '.' . $this->feedback_video->extension;
                $model->feedback_video->saveAs('uploads/' . $video, false);
                $arr['video'] = $video;
            }
            if (!empty($_FILES['Trainings']['name']['training_photo'])){
                $model->training_photo = UploadedFile::getInstance($model, 'training_photo');
                $photo = Yii::$app->security->generateRandomString(10) . '.' . $this->training_photo->extension;
                $model->training_photo->saveAs('uploads/' . $photo, false);
                $arr['photo'] = $photo;
            }
        } else {
            return false;
        }
        return $arr;
    }
}
