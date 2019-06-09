<?php

namespace app\api\modules\v1_1\controllers;

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

        $headers = Yii::$app->request->headers;

        $model->mobileNumber = $headers->get('mobileNumber');
        $model->firstName = $headers->get('firstName');
        $model->lastName = $headers->get('lastName');
        $model->dateOfBirth = $headers->get('dateOfBirth');
        $model->gender = $headers->get('gender');
        $model->email = $headers->get('email');

        $cid = $headers->has('cid') ? $headers->get('cid') : null;
        $string = $model->mobileNumber . $model->firstName . $model->lastName . $model->dateOfBirth . $model->gender . $model->email . Yii::$app->params['client_id'];
        $signature = hash_hmac('sha512', $string, Yii::$app->params['client_secret']);

        if ($cid == Yii::$app->params['client_id'] && $signature == $headers->get('signature')) {
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
        } else {
            return [
                'success' => false,
                'errors' => [
                    'mobileNumber' => Yii::t('app', 'Registration data has been tempered!')  // Put the alert on mobile number field
                ],
            ];
        }
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
