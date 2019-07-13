<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019-03-03
 * Time: 12:11
 */
namespace app\models\Trainings;
class Trainings extends \yii\db\ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'trainings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['certificate'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png','jpg'],
                [
                    ['name','address','price','text','description','text','speaker','feedback_video','status'],
                    'required'
                ],
                [
                    ['name','address','text','description','text','speaker','feedback_video','status'],
                    'string'
                ],
                    ['price', 'double'],
                [
                    ['id'],
                    'safe'
                ]
            ]
        ];
    }

}