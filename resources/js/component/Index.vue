<template>
    <div>

        <section>
            <div class="container py-5">

                <div class="row mb-5">

                    <div class="col-xl-4 col-lg-4 col-mb-4 col-sm-12">
                        <div class="mybox">

                            <div class="header">
                                <span class="fas fa-people-carry"></span>
                                <h4> Packages Collection </h4>
                            </div>

                            <div class="body">
                               <p>
                                  Brings together all packages that speed up developers work on one platform to reduce the stress developers goes through in search for packages.
                               </p>
                            </div>

                            <div class="footer">
                                  <a :href="'/search/package'">Browse Packages</a>
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-mb-4 col-sm-12">
                        <div class="mybox">

                            <div class="header">
                                <span class="fas fa-people-carry"></span>
                                <h4> Tutorial Collection </h4>
                            </div>

                            <div class="body">
                               <p>
                                  Brings together all packages that speed up developers work on one platform to reduce the stress developers goes through in search for packages.
                               </p>
                            </div>

                            <div class="footer">
                                  <a :href="'/search/package'">Browse Packages</a>
                            </div>

                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-4 col-mb-4 col-sm-12">
                        <div class="mybox">

                            <div class="header">
                                <span class="fas fa-people-carry"></span>
                                <h4> Reading Materials </h4>
                            </div>

                            <div class="body">
                               <p>
                                  Brings together all packages that speed up developers work on one platform to reduce the stress developers goes through in search for packages.
                               </p>
                            </div>

                            <div class="footer">
                                  <a :href="'/search/package'">Browse Packages</a>
                            </div>

                        </div>
                    </div>



                </div>

            </div>
        </section>

    </div>
</template>

<script>
    export default {
        data () {
            return {

            }
        },

        methods: {


        },

    }
</script>

<style scoped lang="scss">
    .mybox {
       height: 400px;
       border-radius: 10px;
       text-align: center;
       padding: 32px;
       box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.075) !important;
    }

    .mybox:hover {
       box-shadow: 0 0.1rem 0.234rem black !important;
    }

    .header span {
       font-size: 50px;
       margin-bottom: 20px;
    }

    .header h4 {
       font-family: serif;
       font-weight: 400;
       margin-bottom: 20px;
    }

    .body{
        margin-bottom: 20px;
    }

    .footer {
        padding-top: 20px;
    }

    .footer a {
        text-decoration: none;
        border-radius: 5px;
        padding: 15px;
        color: #ffffff;
        background-color: #271d5e;
    }

</style>
