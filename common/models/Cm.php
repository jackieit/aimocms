<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cm}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $tab
 * @property integer $is_inner
 * @property integer $site_id
 * @property integer $tab_index
 *
 * @property CmField[] $cmFields
 */
class Cm extends \yii\db\ActiveRecord
{
    public static $TAB_INDEX = ['1' => 'cm_index','2'=>'user'];
    /**
     * @inheritdoc
     */
    public static function IS_INNER()
    {
        return ['1' => Yii::t('app','Yes'),'2'=>Yii::t('app','No')];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cm}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','tab','is_inner','tab_index'],'required','on'=>['create','update']],
            [['is_inner', 'site_id', 'tab_index'], 'integer'],
            [['name', 'tab'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Cm Name'),
            'tab'  => Yii::t('app', 'Table name'),
            'is_inner'  => Yii::t('app', 'Is Inner'),
            'site_id'   => Yii::t('app', 'Site ID'),
            'tab_index' => Yii::t('app', 'Tab Index'),
            'site.name' => Yii::t('app','Site name')

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmFields()
    {
        return $this->hasMany(CmField::className(), ['cm_id' => 'id']);
    }
    public function getSite()
    {
        return $this->hasOne(Site::className(),['site_id' => 'id']);
    }
}
