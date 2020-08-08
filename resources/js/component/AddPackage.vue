<template>
    <div class="container pt-4" style="margin-bottom:70px">

        <div class="row">
           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <a href="#" class="btn btnaddcomment text-white float-right" @click.prevent="openPackModal()">
                  Add New Package
              </a>
           </div>
        </div>

        <div class="row pt-4">

            <div class="col-xl-12 col-lg-12">
                <div class="form-group float-left">
                    <select class="form-select" v-model="length" @change="getPackageUser()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
                <div class="form-group float-right">
                    <input type="text" class="form-control" v-model="search" placeholder="Search by package name">
                </div>
            </div>

            <div class="table-responsive">

                <vue-loading :active.sync="userPackLoading"
                            :can-cancel="true"
                            :is-full-page="false">
                </vue-loading>

                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Command</th>
                            <th>Link</th>
                            <th>Created On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in filteredPack" :key="user.id" scope="row">
                            <td>{{ index += 1}}</td>
                            <td>{{ user.name | upperCase | reduceText(50, '...') }} </td>
                            <td><pre>{{ user.command | reduceText(30, '...') }}</pre></td>
                            <td class="text-center">
                                <a :href="user.link" style="color:blue" target="_blank">link</a>
                            </td>
                            <td>{{ user.created_at | dateOnly }}</td>
                            <td class="text-center">
                                <a href="" class="btn-sm" @click.prevent="editPackModal(user)" title="Click to view and edit">
                                    <i class="fas fa-eye text-success"></i>
                                </a>

                                <a href="" class="btn-sm" @click.prevent="deleteUserPackage(user.id)" title="Click to delete">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- navigation -->
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-md justify-content-center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item">
                    <a href="#" class="page-link" @click.prevent="getPackageUser(pagination.prev_page_url)"><b>Previous</b></a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page <b>{{ pagination.current_page }}</b> of <b>{{ pagination.last_page }}</b></a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                    <a href="#" class="page-link" @click.prevent="getPackageUser(pagination.next_page_url)"><b>Next</b></a>
                </li>

                <li class="page-item disabled sm-hidden xs-hidden">
                    <a class="page-link text-dark" href="#"> From <b>{{ pagination.from_page }}</b> to <b>{{ pagination.to_page }}</b> out of <b>{{ pagination.total_page }}</b></a>
                </li>
            </ul>
        </nav>

        <pack-component :pack="packUser" ref="pack"></pack-component>

    </div>
</template>
<script>
    import PackComponent from '../modals/PackModel';
    import 'vue-select/dist/vue-select.css';
    import VueLoading from "vue-loading-overlay/src/js/Component";
    import Con from '../service/PackageController';
    export default {
       components : {
          VueLoading,
          PackComponent,
       },
       data() {
           return {
                allPackageUser:[],
                packUser:[],
                userPackLoading:false,
                pagination:{},
                search:'',
                length:10,
           }
       },

       methods: {

        openPackModal(){
            this.$refs.pack.addoredit = false;
            this.$refs.pack.clearPackForm();
            this.getPackageUser();
            $("#addPackModel").modal('show');
        },

        editPackModal(user){
            this.packUser = user;
            this.$refs.pack.openPackModal();
        },

        async getPackageUser(page_url){
            this.userPackLoading = true;
            page_url = page_url || '/get/user/package/' + this.length;
            axios.get(page_url)
            .then((res) => {
                this.allPackageUser = res.data.data;
                this.makePagination(res.data);
                this.userPackLoading = false;
            }).catch(() => {
                Swal.fire('Failed :','Loading all user packages failed','warning');
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

        async deleteUserPackage(id){
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

                    Con.deletePack(id)
                    .then(() => {
                        Toast.fire('Deleting Package!','Tutorial has been deleted','success');
                    }).catch(() => {
                        Swal.fire("Failed","Could not deleted package","warning");
                    }).finally(() => {
                        Fire.$emit('refresh');
                    });

                }
            });
        },


       },

       created() {
           Fire.$on('refresh',() => {
                this.getPackageUser();
           });
       },

       mounted () {
          this.getPackageUser();
       },

      computed:{

        filteredPack(){
            let thepackage = this.allPackageUser;
            if(this.search){
                thepackage = thepackage.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                })
            }
            return thepackage;
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
