<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%auth_role}}".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $name
 * @property string $description
 * @property string $controllers
 * @property string $actions
 */
class AuthRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id'], 'integer'],
            [['cat_id','name','description'],'required'],
            [['controllers', 'actions'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['rules'], 'string', 'max' => 80],
            [['description'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_id' => Yii::t('app', 'Cat ID'),
            'name' => Yii::t('app', 'Name'),
            'rules' => Yii::t('app','Rules'),
            'description' => Yii::t('app', 'Description'),
            'controllers' => Yii::t('app', 'controllers'),
            'actions' => Yii::t('app', 'actions'),
        ];
    }
}
