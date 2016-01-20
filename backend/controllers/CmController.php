<?php

namespace backend\controllers;

use backend\models\CmField;
use Yii;
use backend\models\Cm;
use yii\data\ActiveDataProvider;
use yii\db\Schema;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmController implements the CRUD actions for Cm model.
 */
class CmController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'field-delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Cm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cm::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Cm models fields.
     * @return mixed
     */
    public function actionField($id)
    {
        $cm  = Cm::findOne($id);

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            $act   = ArrayHelper::getValue($post,'act');

            $fids  = ArrayHelper::getValue($post,'fid');
            $sort  = ArrayHelper::getValue($post,'sort');
            foreach($fids as $k => $fid){
                $fm = $this->findFieldModel($fid);
                $fm->scenario = 'sort';
                $fm->sort = (int)$sort[$k];
                $fm->save();
            }

        }
        $dataProvider = new ActiveDataProvider([
            'query' => CmField::find()->where(['cm_id'=>$id])->orderBy(['sort' => SORT_ASC,'id'=>SORT_ASC]),
            'pagination'=>[
                'pageSize' => 100
            ]
        ]);

        return $this->render('field', [
            'dataProvider' => $dataProvider,
            'cm' => $cm,
        ]);
    }
    public function actionRule($id)
    {
        $cm  = Cm::findOne($id);
        $table_name = Cm::getTable($cm->tab_index,$cm->tab);

        $table = Yii::$app->db->getTableSchema($table_name);
        $types = [];
        $lengths = [];
        foreach ($table->columns as $column) {
            if ($column->autoIncrement) {
                continue;
            }
            if (!$column->allowNull && $column->defaultValue === null) {
                $types['required'][] = $column->name;
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case 'double': // Schema::TYPE_DOUBLE, which is available since Yii 2.0.3
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $types['safe'][] = $column->name;
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }
        $rules = [];
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }
        $response  = Yii::$app->response;
        $response->format = $response::FORMAT_RAW;

        return  implode(",\n",$rules);
    }
    /**
     * create models fields.
     * @return mixed
     */
    public function actionFieldCreate($cm_id)
    {
        $model = new CmField();
        $model->scenario = 'create';
        $model->cm_id = $cm_id;
        $cm  = Cm::findOne($cm_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['field','id'=>$cm_id]);
        }

        return $this->render('field-create', [
            'model' => $model,
            'cm'    => $cm
        ]);
    }
    /**
     * create models fields.
     * @return mixed
     */
    public function actionFieldUpdate($id)
    {
        $model = $this->findFieldModel($id);
        $model->scenario = 'update';
        $cm  = Cm::findOne($model->cm_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['field','id'=>$model->cm_id]);
        }

        return $this->render('field-create', [
            'model' => $model,
            'cm'    => $cm
        ]);
    }
    /**
     * Deletes an existing Cm model field.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionFieldDelete($id,$cm_id)
    {
        $this->findFieldModel($id)->delete();

        return $this->redirect(['field','id'=>$cm_id]);
    }
    /**
     * Displays a single Cm model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cm();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //var_dump($model->getErrors());
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Finds the Cm field model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findFieldModel($id)
    {
        if (($model = CmField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
