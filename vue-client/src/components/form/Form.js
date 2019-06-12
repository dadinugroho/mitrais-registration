import { required, email } from 'vuelidate/lib/validators';
import axios from 'axios';
import DateDropdown from 'vue-date-dropdown'

        export default {
            name: 'app-form',
            components: {
                DateDropdown
            },
            data() {
                return {
                    isSubmitted: false,
                    isError: false,
                    errorHeader: 'error.invalidFields',
                    errors: [],
                    submitting: false,
                    form: {
                        mobileNumber: '',
                        firstName: '',
                        lastName: '',
                        dateOfBirth: '',
                        gender: '',
                        email: '',
                        cid: '',
                        signature: '',
                    }
                }
            },
            methods: {
                submit() {
                    this.$v.$touch();
                    if (!this.$v.$error) {
                        this.form.cid = process.env.VUE_APP_CID;
                        this.form.signature = CryptoJS.HmacSHA256((this.form.mobileNumber.trim() + this.form.firstName.trim() + this.form.lastName.trim() + this.form.email.trim() + process.env.VUE_APP_CID.trim()), process.env.VUE_APP_CSECRET).toString(CryptoJS.enc.Base64);
                        this.sendFormData();
                    } else {
                        this.validationError();
                    }
                },
                enableSubmitLoader() {
                    this.submitting = true;
                },
                disableSubmitLoader() {
                    this.submitting = false;
                },
                sendFormData() {
                    this.enableSubmitLoader();
                    axios.post(process.env.VUE_APP_REGSERVER, {}, {'headers': this.form}).then(response => {
                        this.submitSuccess(response);
                        this.disableSubmitLoader();
                    }).catch(error => {
                        this.submitError(error);
                        this.disableSubmitLoader();
                    });
                },
                submitSuccess(response) {
                    if (response.data.success) {
                        this.isSubmitted = true;
                        this.isError = false;
                    } else {
                        this.errorHeader = 'error.invalidFields';
                        this.errors = response.data.errors;
                        this.isError = true;
                    }
                },
                submitError(error) {
                    console.log(error);
                    this.errorHeader = 'error.general';
                    this.errors = [{'field': null, 'message': 'error.generalMessage'}];
                    this.isError = true;
                },
                validationError() {
                    this.errorHeader = 'error.invalidFields';
                    this.errors = this.getErrors();
                    this.isError = true;
                },
                isErrorField(field) {
                    try {
                        if (this.getValidationField(field).$error) {
                            return true;
                        }
                    } catch (error) {
                        console.log(error);
                    }

                    return this.errors.some(el => el.field === field);
                },
                getErrors() {
                    let errors = [];
                    for (const field of Object.keys(this.form)) {
                        try {
                            if (this.getValidationField(field).$error) {
                                errors.push({'field': field, 'message': null});
                            }
                        } catch (error) {
                            console.log(error);
                        }
                    }
                    return errors;
                },
                getValidationField(field) {
                    if (this.$v.form[field]) {
                        return this.$v.form[field];
                    }
                    throw Error('No validation for field ' + field);
                },
                onFieldBlur(field) {
                    try {
                        this.getValidationField(field).$touch();
                        if (this.getValidationField(field).$error) {
                            if (!this.errors.some(el => el.field === field)) {
                                this.errors.push({'field': field, 'message': null});
                            }
                        } else {
                            this.errors = this.errors.filter(el => el.field !== field);
                        }
                    } catch (error) {
                        console.log(error);
                    }
                },
                reload() {
                    window.location = '';
                }
            },
            validations: {
                form: {
                    mobileNumber: {required},
                    firstName: {required},
                    lastName: {required},
                    email: {required, email},
                }
            },
            watch: {
                errors() {
                    this.isError = this.errors.length > 0 ? true : false;
                }
            }
        }