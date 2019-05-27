<?php

namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController {

    // We are using the regular web app modules:
    public $modelClass = 'app\models\User';

    /**
     * @inheritdoc
     */
    public function actions() {
        $defaultActions = parent::actions();
        unset($defaultActions['create']);

        return $defaultActions;
    }

    /**
     * Modify the action done in actionCreate
     * 
     * @return Response
     */
    public function actionCreate() {
        /* @var $model \yii\db\ActiveRecord */
        $model = new \app\models\User;

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return [
                'success' => true,
                'errors' => [],
            ];
        } else if (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        $errors = [];
        foreach ($model->getErrors() as $idx => $err) {
            $errors[] = [
                'field' => $idx,
                'message' => $err,
            ];
        }

        return [
            'success' => false,
            'errors' => $errors,
        ];
    }

    /**
     * Add CORS filter
     * 
     * @return string[] behaviours
     */
    public function behaviors() {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }

}
