<template>
    <div>

        <section class="bg-light">
            <div class="container py-5">
                <div class="row">

                    <div class="col-lg-4 mb-4">
                        <div class="shadow-lg box">
                            <div class="p-4 border bg-white">
                                <h3 class="h5">
                                    <a class="reset-anchor">Title</a>
                                </h3>
                                <hr>
                                <p class="text-small myBody text-muted">Content</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-4">
                        <div class="shadow-lg box">
                            <div class="p-4 border bg-white">
                                <h3 class="h5">
                                    <a class="reset-anchor">Title</a>
                                </h3>
                                <hr>
                                <p class="text-small myBody text-muted">Content</p>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-4 mb-4">
                        <div class="shadow-lg box">
                            <div class="p-4 border bg-white">
                                <h3 class="h5">
                                    <a class="reset-anchor">Title</a>
                                </h3>
                                <hr>
                                <p class="text-small myBody text-muted">Content</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- <div class="row text-center" v-if="allAbout.length > length">
                    <nav class="myNav" aria-label="Page navigation">
                        <ul class="pagination">
                            <li v-bind:class="[{disabled: !pagination.prevPage }]" class="active">
                                <a href="#" class="page-link" @click.prevent="substraction()">
                                    <b>Previous</b>
                                </a>
                            </li>

                            <li class="page-item disabled">
                                <a class="page-link " href="#" style="color: black">
                                    Page
                                    <b>{{ pagination.currentPage }}</b>
                                    of
                                    <b>{{ pagination.page }}</b>
                                </a>
                            </li>

                            <li v-bind:class="[{disabled: !pagination.nextPage }]" class="active">
                                <a href="#" class="page-link" @click.prevent="addition()">
                                    <b>Next</b>
                                </a>
                            </li>

                            <li class="page-item disabled">
                                <a class="page-link" href="#" style="color: black"> From
                                    <b>{{ pagination.from}}</b> to
                                    <b>{{ pagination.to}}</b> out of
                                    <b>{{ pagination.total }}</b>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div> -->

            </div>
        </section>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                // allAbout:[],
                // pagination:{
                //     currentPage:1,
                //     nextPage:'',
                //     prevPage:'',
                //     total:'',
                //     from:'',
                //     to:'',
                //     page:'',
                // },
                // length:9,
            }
        },

        methods: {
            //  getAboutUs(){
            //      axios.get('/all/about')
            //      .then((res) => {
            //          this.allAbout = res.data;
            //      }).catch(() => {
            //          Swal.fire('Failed :','Getting all about failed','warning');
            //      });
            //  },

            // substraction(){
            //     if(this.pagination.currentPage <=  1){
            //         Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
            //     } else {
            //         --this.pagination.currentPage;
            //     }
            // },

            // addition(){
            //     if(this.pagination.currentPage == this.pagination.page){
            //         Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
            //     } else {
            //         ++this.pagination.currentPage;
            //     }
            // },

            // paginate(array, length, pageNumber){
            //     this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
            //     this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
            //     this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
            //     this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
            //     this.pagination.page = Math.ceil(array.length / length);
            //     this.pagination.total = array.length;

            //     return array.slice((pageNumber - 1) * length, pageNumber * length);
            // },

        },

        mounted() {
            // this.getAboutUs();
        },

        computed:{

            // filteredAbout(){
            //     return this.allAbout;
            // },

            // paginated(){
            //     return this.paginate(this.filteredAbout, this.length, this.pagination.currentPage);
            // },

        },
    }
</script>

<style scoped lang="scss">
      .myBody {
          height: 300px;
          overflow: auto;
      }
</style>
