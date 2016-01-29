<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%cm_index}}".
 *
 * @property integer $id
 * @property integer $cm_id
 * @property integer $content_id
 * @property integer $node_id
 * @property integer $parent_id
 * @property integer $user_id
 * @property integer $top
 * @property integer $pink
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $state
 */
class Content extends \yii\db\ActiveRecord
{


    /**
     * content model table name
     */
    public static $_tableName;

    /**
     * content model fields;
     */
    public static $_fields;
    /**
     * content model fields rules
     */
    public static $_rules;

    //public $_options;

    public static $_select_field;

    public static $_title_field;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::$_tableName;
        //return '{{%cm_article}}';
    }
    public function getFields()
    {
        return self::$_fields;
    }
    /**
     * @param $id
     */
    public static function setCm($id)
    {
        $cm    = Cm::findOne($id);
        $table = Cm::getTable($cm->tab_index,$cm->tab);
        self::$_tableName = $table;

        self::$_rules         = self::getRulesFromString($cm->rules,$table);
        self::$_select_field = $cm->select_field;
        self::$_title_field  = $cm->title_field;

        $fields = CmField::find()->where(['cm_id'=>$id])->orderBy(['sort' => SORT_ASC,'id'=>SORT_ASC])->asArray()->all();
        self::$_fields  = self::getOptions($fields);

        return new static;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return self::$_rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cm_id' => Yii::t('app', 'Cm ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'node_id' => Yii::t('app', 'Node ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'top' => Yii::t('app', 'Top'),
            'pink' => Yii::t('app', 'Pink'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'state' => Yii::t('app', 'State'),
        ];
    }

    /**
     * convert the string rules to php array
     * @param $rule
     * @param $table
     * @return array|mixed
     */
    public static function getRulesFromString($rule, $table)
    {
        $rules = [];
        if(!empty($rule)){
            $string = "<?php\nreturn [\n{$rule}\n];\n?>";
            $cacheDir = Yii::getAlias('@runtime/cm');
            if(!is_dir($cacheDir)){
                mkdir($cacheDir);
            }
            $cacheFile = $cacheDir.'/'.$table.'_rules.php';
            file_put_contents($cacheFile,$string);
            $rules = include $cacheFile;
        }

        return $rules;
    }

    /**
     * @param $fields
     * @return mixed
     */
    public static  function getOptions($fields)
    {
        foreach($fields as $k => $field){
           if(empty($field['options']))
               $fields[$k]['options'] =[];
           else
               $fields[$k]['options'] = self::getRulesFromString(trim($field['options'],'[]'),'options');
        }
        return $fields;
    }

    /**
     * @param $string
     * @return array
     */
    public static function getSource($string)
    {
        $string = strtolower($string);
        $options = [];
        if(strpos($string,'select')!==false){
            $query = Yii::$app->db->createCommand($string)->queryAll();
            $fields = null;
            foreach($query as $row)
            {
                if(!isset($fields))
                    $fields = array_keys($row);
                $options[$row[$fields[0]]] = $row[$fields[1]];
            }
        }else{
            $string = trim($string);
            $lines  = preg_split ('/$\R?^/m', $string);
            foreach($lines as $line)
            {
                $array = explode('=>',$line);
                $options[trim($array[0])] = trim($array[1]);
            }
        }
        return $options;
    }
}
