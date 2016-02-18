<?php

namespace backend\models;

use Yii;
use yii\db\Migration;
use common\models\Site;
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
    public static $TAB_PREFIX = ['1' => 'cm_','2'=>'user_'];

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
            [['name','tab','tab_index'],'required','on'=>['create','update']],
            [['is_inner', 'site_id', 'tab_index'], 'integer'],
            ['tab', 'unique', 'targetClass' => '\backend\models\Cm', 'message' => Yii::t('app','This table has already been taken.'),'on'=>'create'],
            [['rules','title_field','select_field','adv_field'],'string'],
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
            'site.name' => Yii::t('app','Site name'),
            'rules' => Yii::t('app', 'Field Rules'),
            'title_field' => Yii::t('app', 'title Field Rules'),
            'select_field' => Yii::t('app', 'select Field Rules'),
            'adv_field' => Yii::t('app', 'Input advanced fields'),

        ];
    }
    public function hints()
    {
        return [
            'rules' => 'rules'
        ];
    }
    /**
     * @return array
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['update'] = ['name','title_field','select_field','rules'];
        return $scenario;
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->is_inner = 2;
            if(empty($this->site_id)){
                $this->site_id = 0;
            }
            if(!isset($this->rules)){
                $this->rules = '';
            }
            if(!isset($this->title_field)){
                $this->title_field = '';
            }
            if(!isset($this->select_field)){
                $this->select_field = '';
            }

            /*
            else{
                    $oldTableName = self::$TAB_PREFIX[$this->tab_index].$this->getOldAttribute('tab');

                    $table = self::$TAB_PREFIX[$this->tab_index].$this->tab;
                    if($oldTableName !== $this->tab){
                        $migrate->renameTable('{{%'.$oldTableName.'}}','{{%'.$table.'}}');
                    }
            }*/
            return true;
        }else{
            return false;

        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert,$changedAttributes){
        parent::afterSave($insert,$changedAttributes);

        if($insert){
            $migrate = new Migration();
            $tableOptions = '';
            if ($migrate->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $table = self::getTable($this->tab_index,$this->tab);
            $tableOptions = $tableOptions." COMMENT '".Yii::t('app','Comment prefix').$this->name."'";
            $migrate->createTable($table,[
                'id' => $migrate->primaryKey(),
                 
            ],$tableOptions);
            return true;
        }

    }

    /**
     * @param $prefix
     * @param $tab
     * @return string
     */
    public static function getTable($prefix,$tab)
    {
        $table = self::$TAB_PREFIX[$prefix].$tab;
        return '{{%'.$table.'}}';
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $migrate = new Migration();
        $table = self::getTable($this->tab_index,$this->tab);
        $migrate->dropTable($table );
        //return true;
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
        return $this->hasOne(Site::className(),['id' => 'site_id']);
    }
}
