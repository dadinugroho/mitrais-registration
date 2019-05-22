# mitrais-registration

[Go to development story page](https://github.com/dadinugroho/mitrais-registration/blob/master/DEVELOPMENT.md)

This is simple registration page using following technologies:

**UI Technologies**
1. HTML 5
2. CSS (CSS3)
3. Vue
4. AJAX
5. Unit testing

**Web Technologies**
1. RESTful (Implemented in Yii! framework 2.0)

**Server Technologies**
1. PHP (Implemented in Yii! framework 2.0)

**Database**
1. MySQL


### Requirements
*User data model*
* Mobile number is required.
* Mobile number should be unique.
* Mobile number should validate valid Indonesian phone number. (Assume the mobile number pattern is [+62][0]
* First name is required
* Last name is required
* Date of Birth is optional
* Gender is optional
* Email is required
* Email should be unique

*Functional requirements*
* When clicked on ‘Register’ button,
1. Disable (Gray out) Register form as shown in the next slide
2. If the data saved properly, display login button as shown in the next slide
3. If there is any error, enable the form and display the error message on top of the form (Register label)

* When clicked on the login button, the page should be redirected to login page


*Layout*

![registration page](https://github.com/dadinugroho/mitrais-registration/blob/master/registration01.png "Registration page")


![registration_success page](https://github.com/dadinugroho/mitrais-registration/blob/master/registration02.png "Registration success page")
