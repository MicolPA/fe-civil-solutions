<?php

namespace frontend\controllers;

use Yii;
use app\models\Answers;
use app\models\Questions;
use frontend\models\AnswersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnswersController implements the CRUD actions for Answers model.
 */
class AnswersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Answers models.
     * @return mixed
     */
    public function actionIndex($IdQuestion)
    {
        $this->layout = '@app/views/layouts/main-admin';
        $searchModel = new AnswersSearch();
        $dataProvider = $searchModel->search($IdQuestion);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'IdQuestion' => $IdQuestion,

        ]);
    }

    /**
     * Displays a single Answers model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/views/layouts/main-admin';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Answers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($IdQuestion)
    {
        $this->layout = '@app/views/layouts/main-admin';
        $model = new Answers();
        $question = Questions::findOne($IdQuestion);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->IdQuestion = $IdQuestion;
                $model->CorrectAnswer = '1';
                $model->save();
                return $this->redirect(['index', 'IdQuestion' => $IdQuestion]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'question' => $question,

        ]);
    }

    /**
     * Updates an existing Answers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $IdQuestion)
    {
        $this->layout = '@app/views/layouts/main-admin';
        $model = $this->findModel($id);
        $question = Questions::findOne($IdQuestion);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success1', "Answer updated successfully");
            return $this->redirect(['index', 'IdQuestion' => $model->IdQuestion]);
        }

        return $this->render('update', [
            'model' => $model,
            'question' => $question,
        ]);
    }

    /**
     * Deletes an existing Answers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = '@app/views/layouts/main-admin';
        $model = $this->findModel($id);
        $ques = $model->IdQuestion;
        $model->delete();

        return $this->redirect(['index', 'IdQuestion' => $ques]);
    }

    /**
     * Finds the Answers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
