<?php $this->extend("layouts/app-front"); ?>
<?php $this->section("content"); ?>
<template>
<v-container class="indigo mt-n10" fill-height fluid>
    <v-layout flex align-center justify-center>
        <v-flex xs12 sm6 md6>
            <v-card elevation="2" outlined>
                <v-card-text class="pa-10">
                    <v-img class="mx-auto mb-5" lazy-src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-light.svg" max-width="30" src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-light.svg"></v-img>
                    <h1 class="font-weight-normal text-center mb-8"><?= lang('App.forgotPass') ?></h1>
                    <v-alert v-if="notifType != ''" dense :type="notifType">{{notifMessage}}</v-alert>
                    <v-form v-model="valid" ref="form">
                        <v-text-field label="<?= lang('App.labelEmail') ?>" v-model="email" :rules="[rules.required, rules.email]" outlined :disabled="submitted"></v-text-field>
                        <v-layout justify-space-between>
                            <a href="<?= base_url('login') ?>">Login</a>
                            <v-btn @click="submit" color="primary" :loading="loading" :disabled="submitted">Reset Password</v-btn>
                        </v-layout>
                        <a href="<?= base_url('register') ?>"><?= lang('App.register') ?></a>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    computedVue = {
        ...computedVue,
    }
    dataVue = {
        ...dataVue,
        show1: false,
        submitted: false,
        email: '',
    }
    methodsVue = {
        ...methodsVue,
        submit() {
            this.loading = true;
            axios.post(`<?= base_url()?>auth/resetPassword`, {
                    email: this.email
                })
                .then(res => {
                    // handle success
                    this.loading = false
                    var data = res.data;
                    if (data.status == true) {
                        this.submitted = true;
                        this.notifType = "success";
                        this.notifMessage = data.message;
                        this.$refs.form.resetValidation();
                        //setTimeout(() => window.location.reload(), 1000);
                    } else {
                        this.snackbar = true;
                        this.snackbarType = "error";
                        this.snackbarMessage = data.message.email || data.message.password;
                        this.$refs.form.validate();
                    }
                })
                .catch(err => {
                    // handle error
                    console.log(err.response);
                    this.loading = false
                })
        },
        clear() {
            this.$refs.form.reset()
        }
    }
</script>

<?php $this->endSection("js") ?>