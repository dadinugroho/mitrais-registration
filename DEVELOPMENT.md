# Development story

This page will be about the development story of the development of registration system.
0. System preparation and database design
Since I am familiar with Yii 2.0 framework, I will first develop in Yii 2.0 as if the registration is processed by backend php (yii2). I will then unit test the data validation before implementing REST.

After that, start developing the frontend using VUE and try to connect to the yii 2.0 backend server using REST technology.

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


### Unit testing
We need some use cases for unit testing to test the requirement:

1. If Mobile number is not entered, display error if Mobile number is empty.
2. If duplicate Mobile number is entered, display error if there is existing Mobile number already in the system.
3. If Mobile number is not valid Indonesian phone number, display error if Mobile number is not a valid Indonesian phone number.
4. If First name is not entered, display error if First name is empty.
5. If Last name is not entered, display error if Last name is empty.
6. If Date of Birth is not entered, should not raise any error.
7. If Gender is not entered, should not raise any error
8. If Email is not entered, produce error message
9. If duplicate Email is entered, display error if there is existing email addres already in the system.
