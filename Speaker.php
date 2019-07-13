<?php
namespace app\models\Speaker;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019-03-03
 * Time: 12:11
 */

class Speaker extends \yii\db\ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'speaker';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_photo'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png','jpg'],
                [
                    ['name','last_name','about'],'required'],
                [
                    ['name','last_name','about'],'string'],
                [
                    ['id'],
                    'safe'
                ]
            ]
        ];
    }

}