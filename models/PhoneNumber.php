<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phonenumber".
 *
 * @property int $id
 * @property int $person_id
 * @property string $number
 * @property string $type
 */
class PhoneNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phonenumber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'],'required'],
            [['number'],'integer'],
            [['person_id'], 'integer'],
            [['number', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'number' => 'Number',
            'type' => 'Type',
        ];
    }
}



