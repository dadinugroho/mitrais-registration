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
* gender is optional
* email STRING NOT NULL UNIQUE
* password STRING NOT NULL UNIQUE
* status int NOT NULL
