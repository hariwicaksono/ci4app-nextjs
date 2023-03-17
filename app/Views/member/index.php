<?php $this->extend("layouts/app-member"); ?>
<?php $this->section("content"); ?>
<v-row>
    <v-col lg="12" cols="sm" class="pb-2">
        <v-card link href="<?= base_url('member/order-list'); ?>" min-height="130px">
            <div class="pa-5">
                <h2 class="text-h5 font-weight-medium mb-2"><?= lang('App.order'); ?>
                    <v-icon x-large class="blue--text text--lighten-1 float-right">mdi-cart</v-icon>
                </h2>
                <h1 class="text-h3"><?= $jmlOrder; ?></h1>
            </div>
        </v-card>

    </v-col>
</v-row>
<?php $this->endSection("content") ?>

<?php $this->section("js") ?>
<script>
    const token = JSON.parse(localStorage.getItem('access_token'));
    const options = {
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    };

    dataVue = {
        ...dataVue,
    }

    createdVue = function() {

    }

    methodsVue = {
        ...methodsVue,

    }
</script>
<?php $this->endSection("js") ?>