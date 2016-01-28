<?php

namespace backend\controllers;

use backend\models\Workflow;
use backend\models\WorkflowStep;
use backend\models\WorkflowState;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * WorkflowController implements the CRUD actions for Workflow model.
 */
class WorkflowController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Workflow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Workflow::find(),
        ]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => WorkflowState::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList($wf_id)
    {
        $wf = $this->findModel($wf_id);
        $query = WorkflowStep::find()->where(['wf_id'=>$wf_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>false,
            'pagination'=>[
                'pageSize'=>0,
            ]
        ]);
        return $this->render('list',[
           'wf'    => $wf,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $wf_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStepCreate($wf_id)
    {
        $wf = $this->findModel($wf_id);
        $model = new WorkflowStep();
        $model->wf_id = $wf->id;
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['list','wf_id'=> $wf_id ]);
        }else {
            return $this->render('step-create', [
                'wf' => $wf,
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStepDelete($id)
    {
        $model = null;
        if (($model = WorkflowStep::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            $model->delete();
        }
        $wf_id = $model->wf_id;
        $model->delete();

        return $this->redirect(['list','wf_id'=>$wf_id]);
    }
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStepUpdate ($id)
    {
        $model = WorkflowStep::findOne($id);
        $wf_id = $model->wf_id;
        $wf = $this->findModel($wf_id);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['list','wf_id'=> $wf_id ]);
        }else{
            return $this->render('step-update',[
                'wf'    => $wf,
                'model' => $model,
            ]);
        }

    }
    /**
     * Creates a new WorkflowState model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionStateCreate()
    {
        $model = new WorkflowState();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('state-create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkflowState model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStateUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing WorkflowState model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStateDelete($id)
    {
        $model = null;
        if (($model = WorkflowState::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            $model->delete();
        }
        return $this->redirect(['index']);
    }


    /**
     * Creates a new Workflow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workflow();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Workflow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Workflow model.
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
     * Finds the Workflow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workflow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workflow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
