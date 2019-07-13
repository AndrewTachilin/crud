<?php
namespace app\models\Blog;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019-03-03
 * Time: 12:11
 */

class Blog extends \yii\db\ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['main_ing','img'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png','jpg'],
                [
                    ['status','text','header','date','body'],
                    'required'
                ],
                [
                    ['status','text','header','date','body'],
                    'string'
                ],
                [
                    ['id'],
                    'safe'
                ]
            ]
        ];
    }

}