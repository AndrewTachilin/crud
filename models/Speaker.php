<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "speaker".
 *
 * @property int $id
 * @property string $user_photo
 * @property string $name
 * @property string $last_name
 * @property string $about
 */
class Speaker extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speaker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_photo'], 'file', 'skipOnEmpty' => false, 'extensions' => ['jpg','png']],
            [['about'], 'string'],
            [['name', 'last_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_photo' => Yii::t('app', 'User Photo'),
            'name' => Yii::t('app', 'Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'about' => Yii::t('app', 'About'),
        ];
    }

    public function upload($model)
    {

        $model->user_photo = UploadedFile::getInstance($model, 'user_photo');
        if ($this->validate()) {
            if (!empty($_FILES['Speaker']['name']['user_photo'])) {
                $img_name = Yii::$app->security->generateRandomString(10) . '.' . $this->user_photo->extension;
                if($model->user_photo->saveAs('uploads/' . $img_name, false)){
                }
                return ['img'   => $model->user_photo];
            }else{
                return false;
            }
        } else {
            return false;
        }

    }
}
