<template>
    <b-row class="h-100">
        <b-colxx xxs="12" md="10" class="mx-auto my-auto">
            <b-card class="auth-card" no-body>
                <div class="position-relative image-side">
                    <p class="text-white h2">
                        {{ $t("dashboards.magic-is-in-the-details") }}
                    </p>
                    <p class="white mb-0">
                        Please use your e-mail to reset your password.
                        <br />If you are not a member, please
                        <router-link to="/user/register" class="white"
                            >register</router-link
                        >.
                    </p>
                </div>
                <div class="form-side">
                    <router-link to="/">
                        <span class="logo-single" />
                    </router-link>
                    <h6 class="mb-4">{{ $t("user.forgot-password") }}</h6>
                    <b-form
                        @submit.prevent="formSubmit"
                        class="av-tooltip tooltip-label-bottom"
                        @closed="v$.$reset()" >


                        <b-form-group
                            :label="$t('user.email')"
                            class="has-float-label mb-4"   >
                            <b-form-input
                                type="text"
                                v-model="v$.form.email.$model"
                                :state="!v$.form.email.$error"
                            />

                            

                            <b-form-invalid-feedback
                                v-if="v$.form.$error && v$.form.$errors[0].$validator=='required'"
                                >Please enter your email
                                address</b-form-invalid-feedback
                            >


                            <b-form-invalid-feedback
                                v-else-if="v$.form.$error && v$.form.$errors[0].$validator=='email'"
                                >Please enter a valid email
                                address</b-form-invalid-feedback
                            >
                            <b-form-invalid-feedback
                            v-else-if="v$.form.$error && v$.form.$errors[0].$validator=='minLength'"

                                >Your email must be minimum 4
                                characters</b-form-invalid-feedback
                            >

                        </b-form-group>
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <router-link to="/user/forgot-password">{{
                                $t("user.forgot-password-question")
                            }}</router-link>
                            <b-button
                                type="submit"
                                variant="primary"
                                size="lg"
                                :disabled="processing"
                                :class="{
                                    'btn-multiple-state btn-shadow': true,
                                    'show-spinner': processing,
                                    'show-success':
                                        !processing && loginError === false,
                                    'show-fail': !processing && loginError,
                                }"
                            >
                                <span class="spinner d-inline-block">
                                    <span class="bounce1"></span>
                                    <span class="bounce2"></span>
                                    <span class="bounce3"></span>
                                </span>
                                <span class="icon success">
                                    <i class="simple-icon-check"></i>
                                </span>
                                <span class="icon fail">
                                    <i class="simple-icon-exclamation"></i>
                                </span>
                                <span class="label">{{
                                    $t("user.reset-password-button")
                                }}</span>
                            </b-button>
                        </div>
                    </b-form>
                </div>
            </b-card>
        </b-colxx>
    </b-row>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import useVuelidate from "@vuelidate/core";
import { required, email, maxLength, minLength } from "@vuelidate/validators";

export default {

    data() {
        return {
            form: {
                email: "",
            },
        };
    },
    compatConfig: { MODE: 3 },
    validations() {
        return {
            form: {
                email: {
                    required,
                    email,
                    minLength: minLength(4),
                },
            },
        };
    },
    setup:()=>( {v$: useVuelidate() }),
    validationConfig: {
    $lazy: true,
  },

    computed: {
        ...mapGetters(["processing", "loginError", "forgotMailSuccess"]),
    },
    methods: {
        ...mapActions(["forgotPassword"]),
        formSubmit() {
            this.v$.form.$touch();
            console.log( this.v$.form.$errors)
            if (!this.v$.form.$error) {
                this.forgotPassword({
                    email: this.form.email,
                });
            }
        },
    },
    watch: {
        loginError(val) {
            if (val != null) {
                this.$notify(
                    {
                        type:"error",
                        text:   ` ${val}`  ,
                        duration: 3000,
                        });
            }
        },
        forgotMailSuccess(val) {

            if (val) {
                this.$notify({
                     type:"success",
                     text: "Forgot Password Success Please check your email.",
                     duration: 3000,

                });
            }
        },
    },
};
</script>
