<?php

use yii\db\Migration;

/**
 * Class m190302_112941_blog
 */
class m190302_112941_blog extends Migration
{
    private $table = 'blog';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table,[
            'id'    => $this->primaryKey(),
            'status'    => "ENUM('disable', 'enable', 'held')",
            'text'  => $this->text(),
            'main_img'   => $this->string(255),
            'header' =>    $this->string(255),
            'date'  => $this->date(),
            'body'  => $this->string(255),
            'img'   => $this->string(255)

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       return $this->dropTable($this->table);
    }

}
