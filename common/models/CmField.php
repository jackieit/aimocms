<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cm_field}}".
 *
 * @property integer $id
 * @property integer $cm_id
 * @property string $name
 * @property string $label
 * @property string $hint
 * @property string $data_type
 * @property integer $length
 * @property string $input
 * @property string $source
 * @property string $rules
 * @property integer $is_inner
 *
 * @property Cm $cm
 */
class CmField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function IS_INNER()
    {
        return ['1' => Yii::t('app','Yes'),'2'=>Yii::t('app','No')];
    }
    public static function dataType()
    {
        return [
           // 'primaryKey' => Yii::t('app', 'primaryKey'),
            'integer'    => Yii::t('app', 'integer'),
            'string'     => Yii::t('app', 'string'),
            'boolean'    => Yii::t('app', 'boolean'),
            'text'       => Yii::t('app', 'text'),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cm_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cm_id', 'length', 'is_inner'], 'integer'],
            [['source', 'rules'], 'string'],
            [['name', 'label', 'hint', 'data_type', 'input'], 'string', 'max' => 45],
            [['cm_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cm::className(), 'targetAttribute' => ['cm_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cm_id' => Yii::t('app', 'Cm ID'),
            'name' => Yii::t('app', 'Field Name'),
            'label' => Yii::t('app', 'Field Label'),
            'hint' => Yii::t('app', 'Field Hint'),
            'data_type' => Yii::t('app', 'Field Data Type'),
            'length' => Yii::t('app', 'Field Data Length'),
            'input' => Yii::t('app', 'Field Input Form'),
            'source' => Yii::t('app', 'Field Source'),
            'rules' => Yii::t('app', 'Field Rules'),
            'is_inner' => Yii::t('app', 'Is Inner'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCm()
    {
        return $this->hasOne(Cm::className(), ['id' => 'cm_id']);
    }
}
