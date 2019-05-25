<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $regFormShow integer 0 is grayed out and 1 is normal */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kovalenkojuls\date\CombodateWidget;

$this->title = Yii::t('app', 'Registration');
?>
<div class="site-index">
    <div class="container-registration">
        <div class="registration-form-main <?= (0 == $regFormShow ? 'disabled-form' : '') ?>">
            <h3><?= Yii::t('app', 'Registration') ?></h3>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{error}\n{input}",
                        ],
                    ])
            ?>
            <?= $form->field($model, 'mobileNumber', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->textInput(['disabled' => 0 == $regFormShow, 'placeholder' => $model->getAttributeLabel('mobileNumber')])->label(false)->hint(false) ?>

            <?= $form->field($model, 'firstName', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->textInput(['disabled' => 0 == $regFormShow, 'placeholder' => $model->getAttributeLabel('firstName')])->label(false)->hint(false) ?>

            <?= $form->field($model, 'lastName', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->textInput(['disabled' => 0 == $regFormShow, 'placeholder' => $model->getAttributeLabel('lastName')])->label(false)->hint(false) ?>

            <?=
            $form->field($model, 'dateOfBirth', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->widget(CombodateWidget::className(), [
                'value' => $model->dateOfBirth ? $model->dateOfBirth : '',
                'options' => [
                    'language' => 'id',
                    'data-format' => 'YYYY-MM-DD',
                    'data-template' => 'MMMM D YYYY',
                    'customClass' => 'form-control',
                    'errorClass' => 'has-error',
                    'minYear' => 1900,
                    'maxYear' => date('Y'),
                    'smartDays' => true,
                ]
            ])
            ?>

            <?= $form->field($model, 'gender', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->inline()->radioList(app\models\User::getGenderOptions(), ['disabled' => 0 == $regFormShow])->label(false)->hint(false) ?>

            <?= $form->field($model, 'email', ['errorOptions' => ['tag' => 'div', 'class' => 'error-tip']])->textInput(['disabled' => 0 == $regFormShow, 'placeholder' => $model->getAttributeLabel('email')])->label(false)->hint(false) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Register'), ['disabled' => 0 == $regFormShow, 'class' => 'btn btn-default btn-block purple']) ?>
            </div>

            <?php ActiveForm::end() ?>

        </div>

        <?php if (1 == $regFormShow) { ?>
            <div class="registration-form-footer">
                <h3>Footer</h3>
            </div>
        <?php } else { ?>
            <div class="login-button-footer">
                <div><?= Html::a(Yii::t('app', 'Login'), '#', ['class' => 'btn btn-default btn-block purple']) ?></div>
            </div>
        <?php } ?>
    </div>
</div>
