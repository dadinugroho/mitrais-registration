<?php

namespace app\models;

use Yii;
use borales\extensions\phoneInput\PhoneInputValidator;
use libphonenumber\PhoneNumberType;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $mobileNumber
 * @property string $firstName
 * @property string $lastName
 * @property string $dateOfBirth
 * @property int $gender
 * @property string $email
 * @property string $password
 * @property string $authKey
 */
class User extends \yii\db\ActiveRecord {

    /**
     * Gender values
     */
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    /**
     * Get gender options
     */
    public static function getGenderOptions() {
        return [
            self::GENDER_MALE => Yii::t('app', 'Male'),
            self::GENDER_FEMALE => Yii::t('app', 'Female'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['mobileNumber', 'filter', 'filter' => function ($value) {
                    // normalize mobileNumber input here so that everyone will get international format
                    // otherwise +62888 8888 8888 is different from 0888 8888 8888.
                    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                    return empty($value) ? $value : $phoneUtil->format($phoneUtil->parse($value, 'ID'), \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
                }],
            [['dateOfBirth'], 'filter', 'filter' => function ($value) {
                    $dob = date('Y-m-d', strtotime($value));
                    $dob = ($dob == date('Y-m-d', strtotime('1900-01-01'))) ? null : $dob;  // assume 01-01-1900 is null value since the vue-dropdown-date does not has empty value
                    
                    return $dob;
                }],
            [['mobileNumber', 'firstName', 'lastName', 'email', 'password', 'authKey'], 'trim'],
            [['mobileNumber', 'firstName', 'lastName', 'email'], 'required'],
            [['dateOfBirth'], 'date', 'format' => 'php:Y-m-d', 'message' => Yii::t('app', 'Please enter valid date.')],
            [['gender'], 'integer'],
            [['mobileNumber'], 'string', 'max' => 20],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 50],
            [['password', 'authKey'], 'string', 'max' => 255],
            [['mobileNumber'], 'unique'],
            [['mobileNumber'],
                PhoneInputValidator::className(),
                'region' => 'ID',
                'default_region' => 'ID',
                'type' => PhoneNumberType::MOBILE, 'message' => Yii::t('app', 'Please enter valid Indonesian number.'),
            ],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'mobileNumber' => Yii::t('app', 'Mobile number'),
            'firstName' => Yii::t('app', 'First name'),
            'lastName' => Yii::t('app', 'Last name'),
            'dateOfBirth' => Yii::t('app', 'Date of birth'),
            'gender' => Yii::t('app', 'Gender'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Auth key'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

}
