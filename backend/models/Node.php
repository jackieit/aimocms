<?php

namespace backend\models;

use Yii;

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
class Node extends \yii\db\ActiveRecord
{
    public $parent_txt;
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

    /**
     * @todo
     * @param $site_id
     * @param $parent
     * @return array
     */
    public static function getOptionList($site_id,$parent)
    {
        static $list = [];
        $result = self::getDb()->cache(function($db){
            return self::find()->asArray()->all();
        });
        foreach($result as $nodeinfo)
        {
            if($nodeinfo['parent'] == $parent){
                $list[] =[ 'data' =>$nodeinfo['id'], 'value'=>$nodeinfo['id'].'|'.$nodeinfo['name']];
            }else{
                $parent_id = $nodeinfo['parent'];
                $tmpList = self::getOptionList($parent_id);
                $list = array_merge($tmpList,$list);
            }
        }

        return $list;
    }
}
