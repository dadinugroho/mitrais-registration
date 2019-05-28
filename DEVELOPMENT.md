# Development story

This page will be about the development story of the development of registration system. It will be developed in two iterations. The first iteration is the registration system developed in yii framewok v2.0 and second iteration is the REST and VUE client.

## First iteration
### 0. System preparation and database design

The Yii2 project will be using extensions from :
* [kartik practical b](http://demos.krajee.com/app-practical-b)
* [Indonesia mobile number validator](https://github.com/Borales/yii2-phone-input)
* [combo date](https://github.com/kovalenkojuls/yii2-widget-combodate)

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
3. Mobile number is not valid Indonesian phone number, display error if Mobile number is not a valid Indonesian phone number. *Note: We will only consider valid Indonesian mobile number for GSM number with format 08xx.... CDMA number that are no longer exists will not validate.*
4. First name is REQUIRED, display error if First name is empty.
5. Last name is REQUIRED, display error if Last name is empty.
6. Date of Birth can be NULL, should not raise any error.
7. Gender can be NULL, should not raise any error.
8. Email is REQUIRED, display error message if Email is empty
9. Email is UNIQUE, display error if there is existing Email already in the system.


### 1. Registration in PHP code (yii framework 2.0)
The registration is developed in yii framework as the basis to check that it works before moved to REST solution.

##### Functional tests
1. Registration succes, show **Login** button upon successful registration and the registration form is grayed out.
2. Registration failed, show error(s) on the offending field(s) when there is/are validation error(s) 


## Second iteration
### 2. Setup the REST in yii framework
Yii has built in support for REST, so it would be used in here. 
[Testing results are atatched to the ticket](https://github.com/dadinugroho/mitrais-registration/issues/4)


### 3. Client side using VUE 
The requirement asked to use one of the Javascript framework and VUE is chosen. The problem is that my development server cannot be deployed the VUE app. Instead I deployed the VUE to firebase hosting in less than 10 minutes.
Another problem is that the firebase cannot call REST API from http. The development server did not have https setup. Hence, https was implemented in development server using lets encryot certificate. Everything is work by now.

