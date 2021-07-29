<?php

namespace frontend\controllers;

use app\models\Questions;
use app\models\Answers;
use app\models\Category;
use app\models\QuestionsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends Controller
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
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate($IdCategory)
    {
        #$this->questionLimit($IdCategory);
        $model = new Questions();
        $model2 = new Answers();
        
        if ($this->request->isPost) {
            print_r($_POST);
                        exit();
            if ($model->load($this->request->post())) {

                $model->IdCategory = $IdCategory; 
                
               
                $model->save();
                $this->newAnswer($model);
                #$this->subirFoto($model2);

                return $this->redirect(['create',
                    'IdCategory' => $IdCategory,
                ]); 
            }
        } else {
            $model->loadDefaultValues();
            $model2->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
            'IdCategory' => $IdCategory,

        ]);
    }

    
    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->IdQuestion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList($IdCategory)
    {
        return $this->render('list', [
            'IdCategory' => $IdCategory,
        ]);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function subirFoto(Answers $model2) 
    {

            $model2->archivo = UploadedFile::getInstance($model2, 'archivo');

                if($model2->archivo){
                    $imageRute = 'images/' .time()."_".$model2->archivo->baseName.".".$model2->archivo->extension;
                    if( $model2->archivo->saveAs($imageRute)){
                        $model2->Image = $imageRute;
                    }
                }
    }

    protected function questionLimit($IdCategory){

        $limit = Category::find()->where(['IdCategory' => $IdCategory])->one();
        
        if($limit->Count == $limit->Limit){
            Yii::$app->session->setFlash('limitReached', "Limit Reached.");
        }else{
           
        }

    }

    protected function newAnswer($model){

        for ($i=1; $i < count($_POST["CorrectAnswer"]); $i++) { 
            $model2 = new Answers();
            $CorrectAnswer = $this->request->post(['CorrectAnswer'][$i]);

            $model2->IdQuestion = $model->IdQuestion;
            $model2->Answer = $CorrectAnswer[$i];
            $model2->CorrectAnswer = $CorrectAnswer[$i];
                                    
            $model2->save(false);
        
}

    }
}

