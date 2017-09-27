<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $phone_number_count
 * @property string $created_at
 * @property string $updated_at
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    

    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_number_count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number_count' => 'Phone Number Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
