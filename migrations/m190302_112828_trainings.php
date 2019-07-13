<?php

use yii\db\Migration;

/**
 * Class m190302_112828_trainings
 */
class m190302_112828_trainings extends Migration
{

    private $table = 'trainings';
    public function safeUp()
    {
        $this->createTable($this->table,[
            'id' => $this->primaryKey(),
            'training_photo' => $this->string(255),
            'name'   => $this->string(255),
            'date'   => $this->date(),
            'address'    => $this->string(255),
            'price' => $this->float(),
            'text_before'   => $this->text(),
            'text_after'   => $this->text(),
            'text'   => $this->text(),
            'speaker'  => $this->integer(),
            'feedback_video' => $this->string(),
            'status'    => "ENUM('disable', 'enable', 'held')",
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable($this->table);
    }
}
