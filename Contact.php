<?php

namespace app\models\Contact;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2019-03-03
 * Time: 12:11
 */
class Contact extends \yii\db\ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['phone', 'email'],'required'],
            'email' => 'email'
        ];
    }

}