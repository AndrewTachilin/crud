<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_management".
 *
 * @property int $id
 * @property string $status
 * @property string $date_application
 * @property string $name
 * @property string $phone
 * @property string $email
 */
class ApplicationManagement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_management';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['date_application'], 'safe'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
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
            'date_application' => Yii::t('app', 'Date Application'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
        ];
    }
}
