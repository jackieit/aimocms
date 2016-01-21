<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%node}}".
 *
 * @property integer $id
 * @property integer $site_id
 * @property integer $cm_id
 * @property string $name
 * @property integer $is_real
 * @property string $v_nodes
 * @property integer $parent
 * @property string $slug
 * @property integer $workflow
 * @property string $tpl_index
 * @property string $tpl_detail
 * @property integer $status
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 */
class Node extends ActiveRecord
{
    public $parent_txt;
    public static $list_nodes    =[];
    public static $site_nodes    = [];
    public static $site_children = [];
    /**
     * @return array
     */
    public static function isReal()
    {
        return ['1' => Yii::t('app','Yes'),'2'=>Yii::t('app','No')];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['site_id','cm_id','name','is_real','workflow'],'required'],
            [['site_id', 'cm_id', 'is_real', 'parent', 'workflow', 'status'], 'integer'],
            [['v_nodes'], 'string'],
            [['status'] ,'default','value'=> 0],
            [['name'], 'string', 'max' => 20],
            [['slug', 'tpl_index', 'tpl_detail'], 'string', 'max' => 45],
            [['seo_title'], 'string', 'max' => 80],
            [['seo_keyword'], 'string', 'max' => 240],
            [['seo_description'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'site_id' => Yii::t('app', 'Node Site ID'),
            'cm_id' => Yii::t('app', 'Node Cm ID'),
            'name' => Yii::t('app', 'Node Name'),
            'is_real' => Yii::t('app', 'Node Is Real'),
            'v_nodes' => Yii::t('app', 'Node V Nodes'),
            'parent' => Yii::t('app', 'Node Parent'),
            'parent_txt' => Yii::t('app', 'Node Parent'),
            'slug' => Yii::t('app', 'Node Slug'),
            'workflow' => Yii::t('app', 'Node Workflow'),
            'tpl_index' => Yii::t('app', 'Node Tpl Index'),
            'tpl_detail' => Yii::t('app', 'Node Tpl Detail'),
            'status' => Yii::t('app', 'Node Status'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keyword' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
        ];
    }
    public static function getSiteNodes($site_id)
    {
        self::$site_nodes = self::$site_children = [];
        $result = self::find()->select(['id','parent','name'])->with()->where(['site_id'=>$site_id])
        ->asArray()->all();
        foreach($result as $row)
        {

            self::$site_nodes[$row['id']] = $row['name'];
            self::$site_children[$row['id']][] = $row['parent'];
        }

        self::getOptionList($site_id,0,-1);

        return self::$list_nodes;
    }
    /**
     * @todo
     * @param $site_id
     * @param $root
     * @param $level
     * @return void
     */
    public static function getOptionList($site_id,$root=0, $level=-1)
    {
         //$dependency = new FileDependency(['fileName' => '@runtime/node.txt']);

        if($root !=0){
            self::$list_nodes[] =[ 'data' =>$root, 'value'=>str_repeat(' ', $level).$root.'|'.self::$site_nodes[$root]];
        }
        foreach (self::$site_children[$root] as $child)
            self::getOptionList($site_id,$child, $level+1);

    }
}
