<?php

use app\models\User;

class RegistrationFormCest {

    /**
     * Go to the correct page
     * 
     * @param \FunctionalTester $I
     */
    public function _before(\FunctionalTester $I) {
        $I->amOnPage(['/site/index']);
    }

    /**
     * 0. The correct page main feature is to have Registration title and Footer text in h3 tags.
     * 
     * @param \FunctionalTester $I
     */
    public function openRegistrationPage(\FunctionalTester $I) {
        $I->see('Registration', 'h3');
        $I->see('Footer', 'h3');
    }

    /**
     * 1. Registration failed test by sending empty form
     * 
     * @param \FunctionalTester $I
     */
    public function submitEmptyRegistration(\FunctionalTester $I) {
        $I->submitForm('#registration-form', []);
        $I->expectTo('see validations errors');
        $I->see('Registration', 'h3');
        $I->see('Footer', 'h3');
        $I->see('Mobile number cannot be blank.');
        $I->see('First name cannot be blank.');
        $I->see('Last name cannot be blank.');
        $I->see('Email cannot be blank.');
    }

    /**
     * 2. Registration failed test by registering duplicate mobile number
     * 
     * @param \FunctionalTester $I
     */
    public function submitDuplicateMobileNumberRegistration(\FunctionalTester $I) {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $mobileNumber = $phoneUtil->format($phoneUtil->parse('08155557777', 'ID'), \libphonenumber\PhoneNumberFormat::INTERNATIONAL);

        // Add existing record
        $andy = new User;
        $andy->mobileNumber = $mobileNumber;
        $andy->firstName = 'Andy';
        $andy->lastName = 'Budiman';
        $andy->email = 'andy@budiman.org';
        $andy->save();

        // Try register same 
        $I->submitForm('#registration-form', [
            'User[mobileNumber]' => $mobileNumber,
            'User[firstName]' => 'Andy',
            'User[lastName]' => 'Widjaja',
            'User[email]' => 'andy@widjaja.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Registration', 'h3');
        $I->see('Footer', 'h3');
        $I->see('Mobile number "' + $mobileNumber + '" has already been taken.');

        // Clean up, delete registered user
        $andy->delete();
    }

    /**
     * 3. Registration failed test by registering not Indonesian format mobile number
     * 
     * @param \FunctionalTester $I
     */
    public function submitNonIndonesianMobileNumberRegistration(\FunctionalTester $I) {
        $I->submitForm('#registration-form', [
            'User[mobileNumber]' => '0277464762', // Indonesian format mobile number is 08xx xxxx xxxx or +628xx xxxx xxxx.
            'User[firstName]' => 'Andy',
            'User[lastName]' => 'Widjaja',
            'User[email]' => 'andy@widjaja.com',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Registration', 'h3');
        $I->see('Footer', 'h3');
        $I->see('Please enter valid Indonesian number.');
    }

    /**
     * 4. Registration failed test by sending duplicate email
     * 
     * @param \FunctionalTester $I
     */
    public function submitDuplicateEmailRegistration(\FunctionalTester $I) {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $mobileNumber = $phoneUtil->format($phoneUtil->parse('08155557777', 'ID'), \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        $email = 'andy@gmail.com';

        // Add existing record
        $andy = new User;
        $andy->mobileNumber = '0888888888';
        $andy->firstName = 'Andy';
        $andy->lastName = 'Budiman';
        $andy->email = $email;
        $andy->save();

        // Try register same 
        $I->submitForm('#registration-form', [
            'User[mobileNumber]' => $mobileNumber,
            'User[firstName]' => 'Andy',
            'User[lastName]' => 'Widjaja',
            'User[email]' => $email,
        ]);
        $I->expectTo('see validations errors');
        $I->see('Registration', 'h3');
        $I->see('Footer', 'h3');
        $I->see('Email "' + $email + '" has already been taken.');

        // Clean up, delete registered user
        $andy->delete();
    }

    /**
     * 5. Registration success by sending only required fields
     * 
     * @param \FunctionalTester $I
     */
    public function submitRequiredOnlyRegistrationSuccessfully(\FunctionalTester $I) {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $mobileNumber = $phoneUtil->format($phoneUtil->parse('08155557777', 'ID'), \libphonenumber\PhoneNumberFormat::INTERNATIONAL);

        $I->submitForm('#registration-form', [
            'User[mobileNumber]' => $mobileNumber,
            'User[firstName]' => 'Andy',
            'User[lastName]' => 'Widjaja',
            'User[email]' => 'andy@widjaja.com',
        ]);
        $I->dontSeeInSource('<h3>Footer</h3>');
        $I->seeLink('Login');
        $I->seeInSource('<div class="registration-form-main disabled-form">');

        // Clean up, delete registered user
        User::deleteAll(['mobileNumber' => $mobileNumber]);
    }

    /**
     * 6. Registration success by sending all fields
     * 
     * @param \FunctionalTester $I
     */
    public function submitAllFieldsRegistrationSuccessfully(\FunctionalTester $I) {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $mobileNumber = $phoneUtil->format($phoneUtil->parse('08155557777', 'ID'), \libphonenumber\PhoneNumberFormat::INTERNATIONAL);

        $I->submitForm('#registration-form', [
            'User[mobileNumber]' => $mobileNumber,
            'User[firstName]' => 'Andy',
            'User[lastName]' => 'Widjaja',
            'User[birthOfDate]' => '1970-01-02',
            'User[gender]' => 1,
            'User[email]' => 'andy@widjaja.com',
        ]);
        $I->dontSeeInSource('<h3>Footer</h3>');
        $I->seeLink('Login');
        $I->seeInSource('<div class="registration-form-main disabled-form">');

        // Clean up, delete registered user
        User::deleteAll(['mobileNumber' => $mobileNumber]);
    }

}
