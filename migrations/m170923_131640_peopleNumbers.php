<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m170923_131640_peopleNumbers
 */
class m170923_131640_peopleNumbers extends Migration
{
   
    public function up()
    {
         $tableOptions = null;
          if ($this->db->driverName === 'mysql') {
              $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
          }
 
          $this->createTable('{{%person}}', [
              'id' => Schema::TYPE_PK,
              'first_name' => Schema::TYPE_STRING,
              'last_name' => Schema::TYPE_STRING,
              'phone_number_count' => Schema::TYPE_INTEGER,
              'created_at' => Schema::TYPE_DATETIME,
              'updated_at' => Schema::TYPE_DATETIME,
          ], $tableOptions);

          $this->createTable('{{%phoneNumber}}', [
              'id' => Schema::TYPE_PK,
              'person_id' => Schema::TYPE_INTEGER,
              'number' => Schema::TYPE_STRING,
              'type' => Schema::TYPE_STRING,
              'created_at' => Schema::TYPE_DATETIME,
          ], $tableOptions);

          $this->addForeignKey(
            'fk-phoneNumber-person_id',
            'phoneNumber',
            'person_id',
            'person',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('');
        
    }
}
