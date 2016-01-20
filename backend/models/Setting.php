<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $var
 * @property string $val
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var'], 'required'],
            [['var'], 'string', 'max' => 45],
            [['val'], 'string', 'max' => 255],
            [['var'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'var' => Yii::t('app', 'Setting Var'),
            'val' => Yii::t('app', 'Setting Val'),
        ];
    }
}
