<template>
     <div class="container pt-4" style="margin-bottom:70px">

        <div class="row">
           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <a href="#" class="btn btnaddcomment text-white float-right" @click.prevent="openModal()">
                  Add New Tutorial
              </a>
           </div>
        </div>

        <div class="row pt-4">
            <div class="col-xl-12 col-lg-12">
                <div class="form-group float-left">
                    <select v-model="number" v-on:change="fetchUserTito()" class="form-select">
                        <option :value="10" selected>10</option>
                        <option :value="20">20</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                        <option :value="150">150</option>
                        <option :value="200">200</option>
                    </select>
                </div>
                <div class="form-group float-right">
                    <input class="form-control" type="text" placeholder="Enter to search..." v-model="searching" id="search">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">

                <vue-loading :active.sync="isLoading"
                            :can-cancel="true"
                            :is-full-page="false">
                </vue-loading>

                <table class="table table-sm table-striped">
                   <thead>
                       <tr>
                           <th scope="col">#</th>
                           <th scope="col">Title</th>
                           <th scope="col">By</th>
                           <th scope="col">Url</th>
                           <th scope="col">Date</th>
                           <th scope="col" class="text-center">Action</th>
                       </tr>
                   </thead>
                   <tbody>
                        <tr v-for="(tito, index) in filterTito" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ tito.title | reduceText(40, '...') }}</td>
                            <td>{{ tito.name |  reduceText(20, '...') }}</td>
                            <td class="text-center">
                                <a :href="tito.url" style="color:blue" target="_blank">link</a>
                            </td>
                            <td>{{ tito.created_at | dateOnly }}</td>
                            <td colspan="2" class="text-center">
                                <a href="#" class="btnEdit btn-sm" title="Click to view and edit" @click.prevent="openEditModal(tito)">
                                    <i class="fas fa-eye text-success"></i>
                                </a>
                                <a href="#" class="btnDelete btn-sm" title="Click to delete" @click.prevent="deleteTito(tito.id)">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                   </tbody>
                </table>
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-md justify-content-center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item">
                    <a href="#" class="page-link" @click.prevent="fetchUserTito(pagination.prev_page_url)"><b>Previous</b></a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page <b>{{ pagination.current_page }}</b> of <b>{{ pagination.last_page }}</b></a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                    <a href="#" class="page-link" @click.prevent="fetchUserTito(pagination.next_page_url)"><b>Next</b></a>
                </li>

                <li class="page-item disabled sm-hidden xs-hidden">
                    <a class="page-link text-dark" href="#"> From <b>{{ pagination.from_page }}</b> to <b>{{ pagination.to_page }}</b> out of <b>{{ pagination.total_page }}</b></a>
                </li>
            </ul>
        </nav>

        <modal-component :tito="titorial" ref="tuto"></modal-component>

     </div>
</template>
<script>
    import VueLoading from "vue-loading-overlay/src/js/Component";
    import Con from '../service/PackageController';
    import ModalComponent from '../modals/TitoModel';
    export default {
        components : {
          VueLoading,
          ModalComponent,
        },
        data() {
           return {
              number:10,
              allTutorials:[],
              searching:'',
              isLoading:false,
              pagination:{},
              titorial:[],
           }
       },

       methods: {

            openModal() {
                this.titorial = [],
                this.$refs.tuto.addoredit = false;
                this.fetchUserTito();
                this.$refs.tuto.clearForm();
                $("#addTitoModel").modal('show');
            },

            openEditModal(tito){
               this.titorial = tito;
               this.$refs.tuto.openModalTito();
            },

            async fetchUserTito(page_url){
                this.isLoading = true;
                page_url = page_url || '/get/tutorial/' + this.number;
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.allTutorials = res.data;
                        this.makePagination(res);
                        this.isLoading = false;
                    }).catch(() => {
                    Swal.fire("Failed","getting all user tutorials","warning")
                });
            },

            async deleteTito(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Tutorial will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        Con.deleteTito(id)
                        .then(() => {
                            Toast.fire('Deleting Tutorial!','Tutorial has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted tutorial","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

            makePagination(res){
                let pagination = {
                    current_page : res.current_page,
                    last_page : res.last_page,
                    next_page_url : res.next_page_url,
                    prev_page_url : res.prev_page_url,
                    from_page : res.from,
                    to_page : res.to,
                    total_page : res.total
                };
                this.pagination = pagination;
            },

       },

       created() {
           Fire.$on('refresh',() => {
                this.fetchUserTito();
           });
       },

       mounted() {
          this.fetchUserTito();
       },

       computed:{
            filterTito(){
                let tito = this.allTutorials;
                if(this.searching){
                    tito = tito.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.searching.toLowerCase()) > -1;
                        })
                    })
                }
                return tito;
            },
       },
    }
</script>

<style scoped>

select {
   color: black !important;
}

.form-select {
    font-size: 1rem;
    height: 50px;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 2px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btnaddcomment {
    background-color: rgb(180, 177, 177);
    border-radius: 5px;
}

.btnaddcomment:hover {
    background-color:  #F48024;
}

thead th {
    font-size: 13px;
}

tbody td {
    font-size: 13px;
}

</style>
