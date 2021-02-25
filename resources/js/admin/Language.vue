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
                                    <b>All Languages</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add Language</b>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div class="form-group float-left">
                                <label>Select :</label>
                                <select class="form-control" v-model="length" @change="getLanguage()">
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
                                <input type="text" class="form-control" v-model="search" placeholder="Enter to search">
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
                                    <tr v-for="(lang,index) in filteredLanguage" :key="lang.id">
                                        <td>{{ index += 1}}</td>
                                        <td>{{ lang.name | upperCase }} </td>
                                        <td>{{ lang.created_at | dateOnly }}</td>
                                        <td colspan="2" class="text-center">
                                            <a href="" class="btnEdit" @click.prevent="showData(lang)"
                                               title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a href="" class="btnDelete" @click.prevent="deleteLanguage(lang.id)"
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
                        <nav aria-label="Page navigation example" style="margin-bottom:70px">
                            <ul class="pagination pagination-md justify-content-center">
                                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item">
                                    <a href="#" class="page-link" @click.prevent="getLanguage(pagination.prev_page_url)"><b>Previous</b></a>
                                </li>

                                <li class="page-item disabled">
                                    <a class="page-link text-dark" href="#">Page <b>{{ pagination.current_page }}</b> of <b>{{ pagination.last_page }}</b></a>
                                </li>

                                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                                    <a href="#" class="page-link" @click.prevent="getLanguage(pagination.next_page_url)"><b>Next</b></a>
                                </li>

                                <li class="page-item disabled sm-hidden xs-hidden">
                                    <a class="page-link text-dark" href="#"> From <b>{{ pagination.from_page }}</b> to <b>{{ pagination.to_page }}</b> out of <b>{{ pagination.total_page }}</b></a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>

        </div>
        <!-- End of row -->


        <!-- Model for Adding starts her -->
        <div class="modal fade" id="addLanguageModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>REGISTER LANGUAGE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitLanguageForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="language.name" type="text"
                                       placeholder="Enter Language Name" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Save Language
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="editLanguageModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>EDIT LANGUAGE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editLanguageForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                             <div class="form-group">
                                <input class="form-control" v-model="language.name" type="text"
                                       placeholder="Enter Language">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-pen"></i>
                                Edit Language
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
                allLanguage:[],
                language : {
                    id:'',
                    name:'',
                },
                pagination:{},
                search:'',
                length:10,
                showImage:[],
                isLoading: false,
                tableLoading:false,
            }
        },

        methods: {

            async getLanguage(page_url){
                this.tableLoading = true;
                page_url = page_url || '/admin/get/language/' + this.length;
                await axios.get(page_url)
                .then((response) => {
                    this.allLanguage = response.data.data;
                    this.makePagination(response.data);
                }).catch(() => {
                   Swal.fire('Failed :','Loading all language failed','warning');
                }).finally(() => {
                    this.tableLoading = false;
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

            openAddModal(){
                this.clearForm();
                $("#addLanguageModel").modal('show');
            },

            openEditModal() {
                $("#editLanguageModel").modal('show');
            },

            async showData(language) {
                this.language.id = language.id;
                this.language.name = language.name;
                this.openEditModal();
            },

            clearForm(){
                this.language.id = '';
                this.language.name = '';
            },

            async submitLanguageForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('name', this.language.name);

                await axios.post('/admin/post/language', form)
                .then(() => {
                    Toast.fire("Success :","Language saved successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#addLanguageModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async editLanguageForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('id', this.language.id);
                form.append('name', this.language.name);

                await axios.post('/admin/update/language', form)
                .then(() => {
                    Toast.fire("Success :","Language updated successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#editLanguageModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async deleteLanguage(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Language will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        axios.delete('/admin/delete/language/' + id)
                        .then(() => {
                            Toast.fire('Deleting Language !','Language has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted language","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

        },

        created () {
            Fire.$on('refresh',() => {
                this.getLanguage();
            });
        },

        mounted() {
            this.getLanguage();
        },

        computed:{

            filteredLanguage(){
                let language = this.allLanguage;
                if(this.search){
                    language = language.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    })
                }
                return language;
            },

        },
    }
</script>

