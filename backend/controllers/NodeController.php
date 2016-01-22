<?php

namespace backend\controllers;

use common\models\Site;
use Yii;
use backend\models\Node;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NodeController implements the CRUD actions for Node model.
 */
class NodeController extends Controller
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
     * Lists all Node models.
     * @return mixed
     */
    public function actionIndex($site_id='1')
    {
        $site = Site::findOne($site_id);

        $dataProvider = new ActiveDataProvider([
            'query' => Node::find()->where(['site_id'=>$site_id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
             'site'  => $site,
          ]);
    }

    /**
     * Displays a single Node model.
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
     * Creates a new Node model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($site_id)
    {
        $model = new Node();
        $site = Site::findOne($site_id);
        $model->site_id = $site->id;
        $hasRoot = Node::find()->where(["site_id"=>$site->id])->count();
        $siteRoot = null;
        $model->is_real = 1;
        if($hasRoot == 0 && empty($model->parent)){
            $siteRoot = new Node([
                'site_id' => $site->id,
                'name'    => $site->name,
                'cm_id'   => 1,
                'is_real' => 1,
                'workflow' => 1,
            ]);
            $siteRoot->makeRoot();

        }else{
            $siteRoot = Node::find()->where(["site_id"=>$site->id])->roots()->one();

        }

        $model->parent = $siteRoot->id;
        //$model->parent_txt = $siteRoot->id.'|'.$siteRoot->name;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if(empty($model->parent)){
                    $root = Node::find()->where(["site_id"=>$site->id])->roots()->one();

                } else{
                    $root = Node::findOne($model->parent);
                }
                $nodeinfo = $model->getAttributes();
                $node = new Node($nodeinfo);
               if( $node->appendTo($root))
                   return $this->redirect(['view', 'id' => $model->id]);
                else
                    return;
        } else {
            return $this->render('create', [
                'model' => $model,
                'site' => $site,

            ]);
        }
    }

    /**
     * Updates an existing Node model.
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
     * Deletes an existing Node model.
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
     * Finds the Node model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Node the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Node::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
