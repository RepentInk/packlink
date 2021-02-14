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
                                    <b>All Packages</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add Package</b>
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
                                    <th>Link</th>
                                    <th>Command</th>
                                    <th>Created On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(pack,index) in filteredPackage" :key="pack.id">
                                        <td>{{ index += 1}}</td>
                                        <td>{{ pack.name | upperCase | reduceText(20, '...') }} </td>
                                        <td>{{ pack.link | reduceText(20, '...')}}</td>
                                        <td>{{ pack.command | reduceText(20, '...') }}</td>
                                        <td>{{ pack.created_at | dateOnly }}</td>
                                        <td colspan="2" class="text-center">
                                            <a href="" class="btnEdit" @click.prevent="showData(pack)"
                                               title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a href="" class="btnDelete" @click.prevent="deletePackage(pack.id)"
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
        <div class="modal fade" id="addPackageModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>REGISTER PACKAGE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitPackageForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="pack.name" type="text"
                                       placeholder="Enter Package Name" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="pack.link" type="url"
                                       placeholder="Enter Package Link or Website eg. https://example.com" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="pack.command" type="text"
                                       placeholder="Enter Installation Command eg. npm istall example" required>
                            </div>

                             <div class="form-group">
                                <v-select v-model="pack.cat_name"
                                    :options="allCategory"
                                    label="name"
                                    :reduce="allCategory => allCategory.id"
                                    placeholder="Select Package Category" required>
                                </v-select>
                             </div>


                            <div class="form-group">
                                <v-select multiple
                                    v-model="pack.install_name"
                                    :options="allInstallation"
                                    label="name"
                                    :reduce="allInstallation => allInstallation.id"
                                    placeholder="Select Package Installation Mediums" required>
                                </v-select>
                            </div>

                            <div class="form-group">
                                <v-select multiple
                                    v-model="pack.lang_name"
                                    :options="allLanguage"
                                    label="name"
                                    :reduce="allLanguage => allLanguage.id"
                                    placeholder="Select Programming Languages">
                                </v-select>
                            </div>

                            <div class="form-group">
                                <vue-editor v-model="pack.description" id="editor" required
                                            :editorToolbar="maintenance" placeholder="Enter package descriptions">
                                </vue-editor>
                            </div>

                             <div class="form-group">
                                <vue-editor v-model="pack.procedure" id="editor" required
                                            :editorToolbar="maintenance" placeholder="Enter package installation procedure">
                                </vue-editor>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Save Package
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="editPackageModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>EDIT PACKAGE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editPackageForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                              <div class="form-group">
                                <input class="form-control" v-model="pack.name" type="text"
                                       placeholder="Enter Package Name" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="pack.link" type="url"
                                       placeholder="Enter Package Link or Website eg. https://example.com" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="pack.command" type="text"
                                       placeholder="Enter Installation Command eg. npm istall example" required>
                            </div>

                             <div class="form-group">
                                <v-select v-model="pack.cat_id"
                                    :options="allCategory"
                                    label="name"
                                    :reduce="allCategory => allCategory.id"
                                    placeholder="Select Package Category" required>
                                </v-select>
                             </div>


                            <div class="form-group">
                                <v-select multiple
                                    v-model="pack.install_id"
                                    :options="allInstallation"
                                    label="name"
                                    :reduce="allInstallation => allInstallation.id"
                                    placeholder="Select Package Installation Mediums" required
                                    @input="showInstall">
                                </v-select>
                            </div>

                            <div class="form-group">
                                <v-select multiple
                                    v-model="pack.lang_id"
                                    :options="allLanguage"
                                    label="name"
                                    :reduce="allLanguage => allLanguage.id"
                                    placeholder="Select Programming Languages"
                                    @input="showLang">
                                </v-select>
                            </div>

                            <div class="form-group">
                                <vue-editor v-model="pack.description" id="editor" required
                                            :editorToolbar="maintenance" placeholder="Enter package descriptions">
                                </vue-editor>
                            </div>

                             <div class="form-group">
                                <vue-editor v-model="pack.procedure" id="editor" required
                                            :editorToolbar="maintenance" placeholder="Enter package installation procedure">
                                </vue-editor>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-pen"></i>
                                Edit Package
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
    import 'vue-select/dist/vue-select.css';
    import { VueEditor } from "vue2-editor";
    export default {
        components : {
            VueLoading,
            VueEditor,
        },
        data(){
            return {
                 maintenance: [
                    ["bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    ["image", "code-block"],
                ],
                allPackage:[],
                allCategory:[],
                allInstallation:[],
                allLanguage:[],
                allPackLang:[],
                allPackInstall:[],
                pack : {
                    id:'',
                    name:'',
                    link:'',
                    command:'',
                    description:'',
                    procedure:'',
                    lang_id:[],
                    install_id:[],
                    cat_id:'',
                    cat_name:'',
                    lang_name:[],
                    install_name:[],
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

            async showInstall(value){
                let diff = this.getDifference(this.pack.install_name, value);
                let id = 0;
                diff.forEach(v =>{
                    id = v;
                });
                this.pack.install_name = [];
                this.pack.install_name = value;
                axios.delete('/admin/delete/pack/install/' + id)
            },

            async showLang(value){
                let diff = this.getDifference(this.pack.lang_name, value);
                let id = 0;
                diff.forEach(v =>{
                    id = v;
                });
                this.pack.lang_name = [];
                this.pack.lang_name = value;
                axios.delete('/admin/delete/pack/lang/' + id)
            },


            getDifference(arr1, arr2){
                let difference = arr1.filter(x => !arr2.includes(x));
                return difference;
            },

            async getPackage(page_url){
                this.tableLoading = true;
                page_url = page_url || '/admin/get/package/' + this.length;
                await axios.get(page_url)
                .then((response) => {
                    this.allPackage = response.data.data;
                    this.makePagination(response.data);
                }).catch(() => {
                   Swal.fire('Failed :','Loading all packages failed','warning');
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

            async getCategory(){
                await axios.get('/admin/get/category/' + 2000)
                .then((response) => {
                    this.allCategory = response.data.data;
                }).catch(() => {
                    Swal.fire('Failed :','Loading all category failed','warning');
                });
            },

            async getLanguage(){
                await axios.get('/admin/get/language/' + 2000)
                .then((response) => {
                    this.allLanguage = response.data.data;
                }).catch(() => {
                   Swal.fire('Failed :','Loading all language failed','warning');
                });
            },

            async getInstallation(){
                await axios.get('/admin/get/installation/' + 2000)
                .then((response) => {
                    this.allInstallation = response.data.data;
                }).catch(() => {
                    Swal.fire('Failed :','Loading all installation failed','warning');
                });
            },

            async getPackLang(id){
                this.allPackLang = [];
                this.pack.lang_id = [];
                this.pack.lang_name = [];
                await axios.get('/admin/get/pack/lang/' + id)
                .then((res) => {

                    this.allPackLang = res.data;
                    this.allPackLang.forEach((value) => {
                        this.pack.lang_id.push(value.id);
                        this.pack.lang_name.push(value.id);
                    });

                }).catch(() => {
                    Swal.fire('Failed :','Loading all package language failed','warning');
                });
            },

            async getPackInstall(id){
                this.allPackInstall = [];
                this.pack.install_id = [];
                this.pack.install_name = [];
                await axios.get('/admin/get/pack/install/' + id)
                .then((res) => {

                    this.allPackInstall = res.data;
                    this.allPackInstall.forEach((value) => {
                        this.pack.install_id.push(value.id);
                        this.pack.install_name.push(value.id);
                    });

                }).catch(() => {
                    Swal.fire('Failed :','Loading all package installation failed','warning');
                });
            },

            openAddModal(){
                this.clearForm();
                $("#addPackageModel").modal('show');
            },

            openEditModal() {
                $("#editPackageModel").modal('show');
            },

            async showData(pack) {
                this.isLoading = true;
                this.pack.id = pack.id;
                this.pack.name = pack.name;
                this.pack.link = pack.link;
                this.pack.command = pack.command;
                this.pack.description = pack.description;
                this.pack.procedure = pack.procedure;
                this.pack.cat_id = pack.catid;
                this.pack.cat_name = pack.catname;
                this.getPackLang(pack.id);
                this.getPackInstall(pack.id);
                this.openEditModal();
                this.isLoading = false;
            },

            clearForm(){
                this.pack.id = '';
                this.pack.name = '';
                this.pack.link = '';
                this.pack.command = '';
                this.pack.procedure = '';
                this.pack.description = '';
                this.pack.cat_id = '';
                this.pack.install_id = [];
                this.pack.lang_id = [];
                this.pack.cat_name = '';
                this.pack.lang_name = [];
                this.pack.install_name = [];
            },

            async submitPackageForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('name', this.pack.name);
                form.append('link', this.pack.link);
                form.append('command', this.pack.command);
                form.append('description', this.pack.description);
                form.append('procedure', this.pack.procedure);
                form.append('cat_id', this.pack.cat_name);

                this.pack.install_name.forEach(element => {
                    form.append('install_id[]', element);
                });

                this.pack.lang_name.forEach(element => {
                  form.append('lang_id[]', element);
                });

                await axios.post('/admin/post/package', form)
                .then(() => {
                    $("#addPackageModel").modal('hide');
                    Toast.fire("Success :","Package saved successfully","success");
                    this.clearForm();
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            getCheck(a){
                for ( let i=0; i < a.length; i++ ) {
                    if (typeof a[i] != "string")
                        return false;
                }
                return true;
            },

            async editPackageForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('id', this.pack.id);
                form.append('name', this.pack.name);
                form.append('link', this.pack.link);
                form.append('command', this.pack.command);
                form.append('description', this.pack.description);
                form.append('procedure', this.pack.procedure);
                form.append('cat_id', this.pack.cat_id);

                this.pack.install_id.forEach(element => {
                    form.append('install_id[]', element);
                });

                this.pack.lang_id.forEach(element => {
                  form.append('lang_id[]', element);
                });


                await axios.post('/admin/update/package', form)
                .then(() => {
                    $("#editPackageModel").modal('hide');
                    Toast.fire("Success :","Package updated successfully", "success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async deletePackage(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Package will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        axios.delete('/admin/delete/package/' + id)
                        .then(() => {
                            Toast.fire('Deleting Package!','Package has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted package","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

        },

        created () {
            Fire.$on('refresh',() => {
                this.getPackage();
            });
        },

        mounted() {
            this.getPackage();
            this.getCategory();
            this.getLanguage();
            this.getInstallation();
        },

        computed:{

            filteredPackage(){
                let thepackage = this.allPackage;
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


