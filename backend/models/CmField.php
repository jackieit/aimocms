<?php

namespace backend\models;

use Yii;
use yii\db\Migration;

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
    public $old_name;
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

            'integer'    => Yii::t('app', 'field datatype integer'),
            'smallInteger' => Yii::t('app','field datatype smallInteger'),
            'string'     => Yii::t('app', 'field datatype string'),
            'boolean'    => Yii::t('app', 'field datatype boolean'),
            'text'       => Yii::t('app', 'field datatype text'),
            'decimal'    => Yii::t('app', 'field datatype decimal'),
            'float'      => Yii::t('app', 'field datatype float'),
            'double'      => Yii::t('app', 'field datatype double'),
            'date'       => Yii::t('app', 'field datatype date'),
            'datetime'   => Yii::t('app', 'field datatype datetime'),

        ];
    }

    /**
     * @return array
     */
    public static function inputType()
    {
        return [
            'textInput'     => Yii::t('app','field input type textInput'),
            'hiddenInput'   => Yii::t('app','field input type hiddenInput'),
            'passwordInput' => Yii::t('app','field input type passwordInput'),
            'fileInput'     => Yii::t('app','field input type fileInput'),
            'textarea'      => Yii::t('app','field input type textarea'),
            'radio'         => Yii::t('app','field input type radio'),
            'checkbox'      => Yii::t('app','field input type checkbox'),
            'dropDownList'  => Yii::t('app','field input type dropDownList'),
            'checkboxList'  => Yii::t('app','field input type checkboxList'),
            'radioList'     => Yii::t('app','field input type radioList'),
            'richEditor'    => Yii::t('app','field input type richEditor'),
            'datePicker'    => Yii::t('app','field input type datePicker'),
            'datetimePicker'=> Yii::t('app','field input type datetimePicker'),

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
            [['name','label','data_type','input'],'required','on'=>['update','create']],
            [['cm_id', 'is_inner'], 'integer'],
            [['source','length','old_name','options'], 'string'],
            [['length'],'required','when'=>function(){
                return $this->data_type=='string' || $this->data_type=='decimal';
            },'whenClient'=>"function(attribute,value){
                return $('#cmfield-data_type').val()=='string' || $('#cmfield-data_type').val()=='decimal';
            }",'on'=>['update','create']],
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
            'sort' => Yii::t('app', 'Field sort'),
            'data_type' => Yii::t('app', 'Field Data Type'),
            'length' => Yii::t('app', 'Field Data Length'),
            'input' => Yii::t('app', 'Field Input Form'),
            'source' => Yii::t('app', 'Field Source'),
            'options' => Yii::t('app', 'Field options'),
            'is_inner' => Yii::t('app', 'Is Inner'),
        ];
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if(!isset($this->length))
                $this->length='';
            return true;
        }
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['sort'] = ['sort'];
        return $scenarios;
    }
    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert,$changedAttributes)
    {
       parent::afterSave($insert,$changedAttributes);
        if(!in_array($this->scenario,['update','create'])){
            return true;
        }
        $cm = $this->cm;
        $mg = new Migration();

        $table = Cm::$TAB_PREFIX[$cm->tab_index].$cm->tab;
        $column = null;
        $type = $this->data_type;

        switch ($type){
            case 'integer':
            case 'smallInteger':
            case 'boolean':
            case 'float':
            case 'double':
                $column = $mg->{$type}()->notNull()->defaultValue(0);
                break;
            case 'string':
                $column = $mg->{$type}($this->length)->notNull()->defaultValue('');
                break;
            case 'decimal':
                $column = $mg->{$type}($this->length)->notNull()->defaultValue(0);
                break;

            default:
                $column = $mg->{$type}()->defaultValue(null);
                break;
        }
        $column .=" COMMENT '".$this->label."'";
        if($insert){
            $mg->addColumn('{{%'.$table.'}}',$this->name,$column);

        }else{
            $oldName = $this->old_name;

            $newname = $this->name;
            if($oldName !==$newname)
                $mg->renameColumn('{{%'.$table.'}}',$oldName,$newname);
            $mg->alterColumn('{{%'.$table.'}}',$newname,$column);
        }
        return true;


    }

    /**
     * @throws \yii\base\NotSupportedException
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $cm = $this->cm;
        $mg = new Migration();

        $table = Cm::$TAB_PREFIX[$cm->tab_index].$cm->tab;
        $tableSchema = $mg->db->getSchema()->getTableSchema('{{%'.$table.'}}');
        if($tableSchema===null){
            return;
        }
        $columns = $tableSchema->getColumnNames();

        if(in_array($this->name,$columns)){
            $mg->dropColumn('{{%'.$table.'}}',$this->name);
        }

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCm()
    {
        return $this->hasOne(Cm::className(), ['id' => 'cm_id']);
    }
}
