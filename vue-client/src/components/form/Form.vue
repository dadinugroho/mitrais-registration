<template>
  <div class="container-registration">
    <div class="registration-form-main" v-bind:class="{ 'disabled-form' : isSubmitted}">
      <h3>{{$t("form.registration")}}</h3>
      <form id="registration-form" @submit.prevent="submit" novalidate>
        <div
          class="form-group field-user-mobilenumber required"
          v-bind:class="{ 'has-error': isErrorField('mobileNumber') }"
        >
          <div
            v-if="isErrorField('mobileNumber')"
            class="error-tip"
          >{{ form.mobileNumber.length == 0 ? $t('error.fieldRequired', { field: $t('form.mobileNumber') }) : errors.filter(el => el.field === 'mobileNumber').map(el => el.message).join() }}</div>
          <input
            type="text"
            id="mobileNumber"
            class="form-control"
            name="User[mobileNumber]"
            v-bind:placeholder="$t('form.mobileNumber')"
            aria-required="true"
            v-model.lazy.trim="form.mobileNumber"
            @blur="onFieldBlur('mobileNumber')"
            :disabled="isSubmitted"
          >
        </div>
        <div
          class="form-group field-user-firstname required"
          v-bind:class="{ 'has-error': isErrorField('firstName') }"
        >
          <div
            v-if="isErrorField('firstName')"
            class="error-tip"
          >{{ $t('error.fieldRequired', { field: $t('form.firstName') }) }}</div>
          <input
            type="text"
            id="firstName"
            class="form-control"
            name="User[firstName]"
            v-bind:placeholder="$t('form.firstName')"
            aria-required="true"
            v-model.lazy.trim="form.firstName"
            @blur="onFieldBlur('firstName')"
            :disabled="isSubmitted"
          >
        </div>
        <div
          class="form-group field-user-lastname required"
          v-bind:class="{ 'has-error': isErrorField('lastName') }"
        >
          <div
            v-if="isErrorField('lastName')"
            class="error-tip"
          >{{ $t('error.fieldRequired', { field: $t('form.lastName') }) }}</div>
          <input
            type="text"
            id="lastName"
            class="form-control"
            name="User[lastName]"
            v-bind:placeholder="$t('form.lastName')"
            aria-required="true"
            v-model.lazy.trim="form.lastName"
            @blur="onFieldBlur('lastName')"
            :disabled="isSubmitted"
          >
        </div>
        <div class="form-group field-user-dateofbirth">
          <label class="control-label" for="dateOfBirth">{{ $t('form.dateOfBirth') }}</label>
          <div
            v-if="isErrorField('dateOfBirth')"
            class="error-tip"
          >{{ errors.filter(el => el.field === 'dateOfBirth').map(el => el.message).join() }}</div>
          <date-dropdown default min="1900" max="2019" value v-model="form.dateOfBirth"/>
        </div>
        <div class="form-group field-user-gender">
          <div
            v-if="isErrorField('gender')"
            class="error-tip"
          >{{ errors.filter(el => el.field === 'gender').map(el => el.message).join() }}</div>
          <div>
            <input type="hidden" name="User[gender]" value>
            <div id="user-gender" role="radiogroup">
              <label class="radio-inline">
                <input
                  type="radio"
                  name="User[gender]"
                  value="1"
                  :disabled="isSubmitted"
                  v-model="form.gender"
                > Male
              </label>
              <label class="radio-inline">
                <input
                  type="radio"
                  name="User[gender]"
                  value="0"
                  :disabled="isSubmitted"
                  v-model="form.gender"
                > Female
              </label>
            </div>
            <div class="error-tip"></div>
          </div>
        </div>
        <div
          class="form-group field-user-email required"
          v-bind:class="{ 'has-error': isErrorField('email') }"
        >
          <div
            v-if="isErrorField('email')"
            class="error-tip"
          >{{ form.email.length == 0 ? $t('error.fieldRequired', { field: $t('form.email') }) : errors.filter(el => el.field === 'email').map(el => el.message).join() }}</div>
          <input
            type="text"
            id="email"
            class="form-control"
            name="User[email]"
            v-bind:placeholder="$t('form.email')"
            aria-required="true"
            v-model.lazy.trim="form.email"
            @blur="onFieldBlur('email')"
            :disabled="isSubmitted"
          >
        </div>
        <div class="form-group">
          <button
            type="submit"
            class="btn btn-default btn-block purple"
            :disabled="submitting || isSubmitted"
          >
            <span v-if="submitting">
              {{ $t('form.submitting' ) }}
              <img src="../../assets/loader.svg">
            </span>
            <span v-else>{{ $t('form.submit' ) }}</span>
          </button>
        </div>
      </form>
    </div>
    <div v-if="!isSubmitted" class="registration-form-footer">
      <h3>Footer</h3>
    </div>
    <div v-if="isSubmitted" class="login-button-footer">
      <div>
        <a class="btn btn-default btn-block purple" href="#">Login</a>
      </div>
    </div>
  </div>
</template>

<script src="./Form.js"></script>
