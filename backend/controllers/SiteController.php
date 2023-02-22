<?php

namespace backend\controllers;

use backend\models\forms\AppleForm;
use backend\models\Apple;
use common\models\LoginForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'apple-generate', 'fall', 'eat-quarter', 'eat-half'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if($post = Yii::$app->request->post()) {
            if(isset($post['AppleForm'])) {

                if(!empty(trim($post['AppleForm']['color']))) {
                    $appleModel = new Apple($post['AppleForm']['color']);
                } else {
                    $appleModel = new Apple();
                }
                $appleModel->save();
            }

        }

        // создание провайдера данных с конфигурацией для сортировки и постраничной разбивки
        $query = Apple::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $appleFormModel = new AppleForm();
        return $this->render('index', ['appleFormModel' => $appleFormModel, 'dataProvider' => $dataProvider]);
    }


    public function actionAppleGenerate()
    {
        for($i=0; $i < rand(0,10); $i++) {

            $appleModel = new Apple();
            $appleModel->size = 1;
            $appleModel->save();
        }

        return $this->redirect('/');
    }

    public function actionFall($id)
    {

        $appleModel = Apple::findOne($id);
        if(!$appleModel->fall_date) {
            $appleModel->fall_date = date('Y-m-d H:i:s');
            $appleModel->save();
        }

        return $this->redirect('/');
    }

    public function actionEatQuarter($id)
    {

        $this->eat($id, 0.25);
    }

    public function actionEatHalf($id)
    {
        $this->eat($id, 0.5);
    }

    public function eat($id, $percent)
    {
        $appleModel = Apple::findOne($id);

        $appleModel->eat($percent);
        if ($appleModel->size <= 0) {
            $appleModel->delete();
        } else {
            $appleModel->appearance_date = date('Y-m-d H:i:s');
            $appleModel->save();
        }
        return $this->redirect('/');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
