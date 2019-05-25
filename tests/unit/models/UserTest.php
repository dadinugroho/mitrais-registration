<?php

namespace tests\models;

use \app\models\User;

class UserTest extends \Codeception\Test\Unit {

    /**
     * 1. Mobile number is REQUIRED, display error if Mobile number is empty.
     */
    public function testValidateMobileNumberRequired() {
        $user = new User;
        $user->mobileNumber = '';
        $this->assertFalse($user->validate(array('mobileNumber')));

        $user->mobileNumber = '0815777999';
        $this->assertTrue($user->validate(array('mobileNumber')));
    }

    /**
     * 2. Mobile number is UNIQUE, display error if there is existing Mobile number already used in the system.
     */
    public function testValidateMobileNumberUnique() {
        // Add existing record
        $andy = new User;
        $andy->mobileNumber = '0888 8888 8888';
        $andy->firstName = 'Andy';
        $andy->lastName = 'Widjaja';
        $andy->email = 'andy@widjaja.com';
        $andy->save();

        // Try to add another record with the same mobile number
        $andi = new User;
        $andi->mobileNumber = '0888 8888 8888';
        $andi->firstName = 'Andi';
        $andi->lastName = 'Budiman';
        $andi->email = 'andi@budiman.com';

        // Check for duplicate mobile number
        $this->assertFalse($andi->save());

        // Clean up
        $andy->delete();
    }

    /**
     * 3. Mobile number is not valid Indonesian phone number, display error if Mobile number is not a valid Indonesian phone number.
     */
    public function testValidateMobileNumberIndonesianMobile() {
        $user = new User;

        // Full format +62 8xx xxx xxx
        $user->mobileNumber = '+62 815 777 999';
        $this->assertTrue($user->validate(array('mobileNumber')));

        // Full format no space +628xxxxxxxx
        $user->mobileNumber = '+6281577779999';
        $this->assertTrue($user->validate(array('mobileNumber')));

        // No country code with space 08xx xx xx xxx
        $user->mobileNumber = '0815 77 77 999';
        $this->assertTrue($user->validate(array('mobileNumber')));

        // No country code no space 08xxxxxxxx
        $user->mobileNumber = '081577779999';
        $this->assertTrue($user->validate(array('mobileNumber')));

        // Wrong country code
        $user->mobileNumber = '06581577779999';
        $this->assertFalse($user->validate(array('mobileNumber')));

        // Wrong first number (8) for mobile number
        $user->mobileNumber = '515 7777 9999';
        $this->assertFalse($user->validate(array('mobileNumber')));
    }

    /**
     * 4. First name is REQUIRED, display error if First name is empty.
     */
    public function testValidateFirstNameRequired() {
        $user = new User;
        $user->firstName = '';
        $this->assertFalse($user->validate(array('firstName')));

        $user->firstName = 'Daniel';
        $this->assertTrue($user->validate(array('firstName')));
    }

    /**
     * 5. Last name is REQUIRED, display error if Last name is empty.
     */
    public function testValidateLastNameNotNull() {
        $user = new User;
        $user->lastName = '';
        $this->assertFalse($user->validate(array('lastName')));

        $user->lastName = 'Adinugroho';
        $this->assertTrue($user->validate(array('lastName')));
    }

    /**
     * 6. Date of Birth can be NULL, should not raise any error.
     */
    public function testValidateDateOfBirthNull() {
        $user = new User;
        $this->assertTrue($user->validate(array('dateOfBirth')));

        $user->dateOfBirth = date('Y-m-d', strtotime('1970-01-01'));
        $this->assertTrue($user->validate(array('dateOfBirth')));
    }

    /**
     * 7. Gender can be NULL, should not raise any error.
     */
    public function testValidateGenderNull() {
        $user = new User;
        $this->assertTrue($user->validate(array('gender')));

        // Test male
        $user->gender = User::GENDER_MALE;
        $this->assertTrue($user->validate(array('gender')));

        // Test female
        $user->gender = User::GENDER_FEMALE;
        $this->assertTrue($user->validate(array('gender')));
    }

    /**
     * 8. Email is REQUIRED, display error message if Email is empty also validate for wrong email format
     */
    public function testValidateEmailRequired() {
        $user = new User;
        $user->email = '';
        $this->assertFalse($user->validate(array('email')));

        // Correct email format
        $user->email = 'adinugro@gmail.com';
        $this->assertTrue($user->validate(array('email')));

        // Correct email format
        $user->email = 'www.google.com';
        $this->assertFalse($user->validate(array('email')));
    }

    /**
     * 9. Email is UNIQUE, display error if there is existing Email already in the system.
     */
    public function testValidateEmailUnique() {
        // Add existing record
        $andy = new User;
        $andy->mobileNumber = '0858 858 585';
        $andy->firstName = 'Andy';
        $andy->lastName = 'Widjaja';
        $andy->email = 'andy@gmail.com';
        $andy->save();

        // Try to add another record with the same email
        $andi = new User;
        $andi->mobileNumber = '0888 8888 8888';
        $andi->firstName = 'Andi';
        $andi->lastName = 'Budiman';
        $andi->email = 'andy@gmail.com';

        // Check for duplicate email
        $this->assertFalse($andi->save());

        // Clean up
        $andy->delete();
    }

}
