<?php

namespace frontend\controllers;

use frontend\models\UserProfile;
use Yii;
use frontend\models\Profile;
use frontend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
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
     * update lembar kehidupan
     * @return mixed
     */
    public function actionLk()
    {
        if (!Yii::$app->user->isGuest) {
//            $id = Yii::$app->user->id;
//            $UserProfileModel = UserProfile::find()->andWhere(['userId' => $id])->One();
//            $model = $UserProfileModel->profile;
//            if (null == $UserProfileModel) {
//                $model = new Profile;
//                $model->save();
//                $UserProfileModel = new UserProfile();
//                $UserProfileModel->userId = $id;
//                $UserProfileModel->profileId = $model->id;
//                $UserProfileModel->save();
//            }
//
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                //  return $this->redirect(['view', 'id' => $model->id]);
//                Yii::$app->session->setFlash('success', 'Profile is saved');
//            }

            return $this->render('lk', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }

    }
    /**
     * Update self profile
     * @return mixed
     */
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->id;
            $UserProfileModel = UserProfile::find()->andWhere(['userId' => $id])->One();
            $model = $UserProfileModel->profile;
            if (null == $UserProfileModel) {
                $model = new Profile;
                $model->save();
                $UserProfileModel = new UserProfile();
                $UserProfileModel->userId = $id;
                $UserProfileModel->profileId = $model->id;
                $UserProfileModel->save();
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //  return $this->redirect(['view', 'id' => $model->id]);
                Yii::$app->session->setFlash('success', 'Profile is saved');
            }

            return $this->render('self', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }

    }


    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profile model.
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

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
