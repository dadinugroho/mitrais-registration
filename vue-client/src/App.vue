<template>
  <app-form></app-form>
</template>

<script>
import Form from "./components/form/Form.vue";

export default {
  name: "app",
  components: {
    appForm: Form
  }
};
</script>

<style>
.purple {
  background-color: #9c27b0;
  color: #fff;
}

.container-registration {
  width: 450px;
  position: relative;
  margin: 0 auto;
}

.registration-form-main {
  margin-top: 100px;
  padding: 10px 30px;
  background-color: #eee;
}

.registration-form-footer {
  margin-top: 20px;
  background-color: #9c27b0;
  height: 80px;
  line-height: 80px;
  text-align: center;
  color: #fff;
}

.registration-form-footer h3 {
  display: inline-block;
  vertical-align: middle;
  line-height: normal;
  margin: 0px;
  padding: 0px;
}

.login-button-footer {
  margin-top: 20px;
  padding-left: 30px;
  padding-right: 30px;
  background-color: #eee;
  height: 80px;
  line-height: 80px;
  text-align: center;
  color: #fff;
}

.login-button-footer div {
  width: 100%;
  display: inline-block;
  vertical-align: middle;
  line-height: normal;
  margin: 0px;
  padding: 0px;
}

.has-error {
  position: relative;
}

.has-error div.error-tip {
  background-color: #f44336;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 7px 20px;
  position: absolute;
  z-index: 1;
  bottom: 120%;
  right: 0%;
}

.has-error div.error-tip::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 20%;
  margin-left: -15px;
  border-width: 15px;
  border-style: solid;
  border-color: #f44336 transparent transparent transparent;
}

.disabled-form {
  filter: alpha(opacity=30);
  -moz-opacity: 0.3;
  opacity: 0.3;
}
</style>
