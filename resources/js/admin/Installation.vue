<template>

    <div class="content-wrapper">

        <!-- Start of the row -->
        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                <h2 class="card-title float-left">
                                    <i class="mdi mdi-account"></i>
                                    <b>All Installation</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add Installation</b>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div class="form-group float-left">
                                <label>Select :</label>
                                <select class="form-control" v-model="length" @input="resetPagination()">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>
                            <div class="form-group float-right">
                                <label>Search :</label>
                                <input type="text" class="form-control" v-model="search" @input="resetPagination()"
                                       placeholder="Enter to search">
                            </div>
                        </div>

                        <div class="table-responsive">

                            <vue-loading :active.sync="tableLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Created On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(install,index) in paginated" :key="install.id">
                                        <td>{{ index += 1}}</td>
                                        <td>{{ install.name | upperCase }} </td>
                                        <td>{{ install.created_at | dateOnly }}</td>
                                        <td colspan="2" class="text-center">
                                            <a href="" class="btnEdit" @click.prevent="showData(install)"
                                               title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a href="" class="btnDelete" @click.prevent="deleteInstallation(install.id)"
                                               title="Click to delete">
                                                <i class="mdi mdi-delete"></i>
                                            </a>

                                        </td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="card-footer text-center">
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
                    </div>

                </div>
            </div>

        </div>
        <!-- End of row -->


        <!-- Model for Adding starts her -->
        <div class="modal fade" id="addInstallationModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>REGISTER INSTALLATION</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitInstallationForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="installation.name" type="text"
                                       placeholder="Enter Installation Name" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Save Installation
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="editInstallationModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>EDIT INSTALLATION</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editInstallationForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                             <div class="form-group">
                                <input class="form-control" v-model="installation.name" type="text"
                                       placeholder="Enter Language">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-pen"></i>
                                Edit Installation
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->

    </div>

</template>

<script>
    import VueLoading from "vue-loading-overlay/src/js/Component";
    export default {
        components : {
            VueLoading,
        },
        data(){
            return {
                allInstallation:[],
                installation : {
                    id:'',
                    name:'',
                },
                pagination:{
                    currentPage:1,
                    nextPage:'',
                    prevPage:'',
                    total:'',
                    from:'',
                    to:'',
                    page:'',
                },
                search:'',
                length:10,
                showImage:[],
                isLoading: false,
                tableLoading:false,
            }
        },

        methods: {

            getInstallation(){

                const config = {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json;charset=UTF-8'
                    },
                };

                axios.get('/admin/get/installation', config)
                .then((response) => {
                    this.tableLoading = true;
                    this.allInstallation = response.data;
                }).catch(() => {
                   Swal.fire('Failed :','Loading all installation failed','warning');
                }).finally(() => {
                    this.tableLoading = false;
                });

            },

            openAddModal(){
                this.clearForm();
                $("#addInstallationModel").modal('show');
            },

            openEditModal() {
                $("#editInstallationModel").modal('show');
            },

            showData(installation) {
                this.installation.id = installation.id;
                this.installation.name = installation.name;
                this.openEditModal();
            },

            clearForm(){
                this.installation.id = '';
                this.installation.name = '';
            },

            submitInstallationForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('name', this.installation.name);

                axios.post('/admin/post/installation', form)
                .then(() => {
                    Toast.fire("Success :","Installation saved successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#addInstallationModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            editInstallationForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('id', this.installation.id);
                form.append('name', this.installation.name);

                axios.post('/admin/update/installation', form)
                .then(() => {
                    Toast.fire("Success :","Installation updated successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#editInstallationModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            deleteInstallation(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Installation will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        axios.delete('/admin/delete/installation/' + id)
                        .then(() => {
                            Toast.fire('Deleting Installation !','Installation has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted installation","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

            substraction(){
                if(this.pagination.currentPage <=  1){
                    Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
                } else {
                    --this.pagination.currentPage;
                }
            },

            addition(){
                if(this.pagination.currentPage == this.pagination.page){
                    Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
                } else {
                    ++this.pagination.currentPage;
                }
            },

            paginate(array, length, pageNumber){
                this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
                this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
                this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
                this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
                this.pagination.page = Math.ceil(array.length / length);
                this.pagination.total = array.length;

                return array.slice((pageNumber - 1) * length, pageNumber * length);
            },

            resetPagination(){
                this.pagination.currentPage  = 1;
                this.pagination.prevPage = '';
                this.pagination.nextPage = '';
            },

        },

        created () {
            Fire.$on('refresh',() => {
                this.getInstallation();
            });
        },

        mounted() {
            this.getInstallation();
        },

        computed:{

            filteredInstallation(){
                let installation = this.allInstallation;
                if(this.search){
                    installation = installation.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    })
                }
                return installation;
            },

            paginated(){
                return this.paginate(this.filteredInstallation, this.length, this.pagination.currentPage);
            },

        },
    }
</script>

