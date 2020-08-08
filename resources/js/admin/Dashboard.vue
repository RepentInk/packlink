<template>
    <div class="content-wrapper">

        <!-- Start of the row -->
        <div class="row">

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <a href="#" title="Click to view all users">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-account text-dark icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right">Total Users</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">123</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <a href="#" title="Click to view all carousels">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-codepen text-warning icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right">Total Carousels</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">
                                            23
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <a href="#" title="Click to view all programs">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi mdi-package text-success icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right">Total Programs</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">343</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <a href="#" title="Click to view all partners">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="mdi  mdi-account-switch text-primary icon-lg"></i>
                                </div>
                                <div class="float-right">
                                    <p class="mb-0 text-right">Total Partners</p>
                                    <div class="fluid-container">
                                        <h3 class="font-weight-medium text-right mb-0">
                                            533
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <!-- End of row -->

    </div>
</template>

<script>
    export default {
        data(){
            return {
                totalUser:0,
                totalCarousel:0,
                totalPrograms:0,
                totalSponsor:0,
            }
        },

        methods: {


        },

        mounted() {

        }
    }
</script>

<style scoped>
    .card a{
        text-decoration: none;
        text-underline: none;
        color:#212529;
    }

    .card a:hover{
        color:#F2B310;
    }
</style>
