# Development story

This page will be about the development story of the development of registration system. It will be developed in two iterations. The first iteration is the registration system developed in yii framewok v2.0 and second iteration is the REST and VUE client.

### First iteration
0. System preparation and database design

The Yii2 project will be using extensions from :
* [kartik practical b](http://demos.krajee.com/app-practical-b)
* [Indonesia mobile number validator](https://github.com/Borales/yii2-phone-input)

The database design for user table is as follow:
* ID int PK
* mobileNumber STRING UNIQUE NOT NULL (Mobile number should validate valid Indonesian phone number in the PHP level not MySQL level)
* firstName STRING NOT NULL
* lastName STRING NOT NULL
* dateOfBirth DATE NULL
* gender TINYINT NULL
* email STRING NOT NULL UNIQUE
* password STRING NOT NULL  <-- not specified on the requirement but added for login purpose
* authKey STRING NOT NULL   <-- not specified on the requirement but added for login purpose


##### Unit tests
Use cases for unit tests to test the requirement:

1. Mobile number is REQUIRED, display error if Mobile number is empty.
2. Mobile number is UNIQUE, display error if there is existing Mobile number already used in the system.
3. Mobile number is not valid Indonesian phone number, display error if Mobile number is not a valid Indonesian phone number.
4. First name is REQUIRED, display error if First name is empty.
5. Last name is REQUIRED, display error if Last name is empty.
6. Date of Birth can be NULL, should not raise any error.
7. Gender can be NULL, should not raise any error.
8. Email is REQUIRED, display error message if Email is empty
9. Email is UNIQUE, display error if there is existing Email already in the system.


##### Functional tests
1. Registration succes, show **Login** button upon successful registration and the registration form is grayed out.
2. Registration failed, show error(s) on the offending field(s) when there is/are validation error(s) 

