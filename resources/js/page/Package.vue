<template>
   <div>

        <div class="row">
            <div class="comment">

                <a href="" @click.prevent="addPackage()" :class="{ active: addpackage }">
                    <i class="fas fa-plus"></i>
                    <b>Add Package</b>
                </a>

                <a href="" @click.prevent="viewPackage()" :class="{ active: viewpackage }">
                    <i class="fas fa-eye"></i>
                    <b>View Your Package</b>
                </a>

            </div>
        </div>

        <hr>

        <div class="row mb-5" v-show="addpackage">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                <form @submit.prevent="submitPackageForm()" class="myForm">

                        <vue-loading :active.sync="packageLoading"
                                    :can-cancel="true"
                                    :is-full-page="false">
                        </vue-loading>

                        <div class="form-group">
                            <input class="form-control" v-model="userpack.name" type="text"
                                placeholder="Enter Package Name" required>
                        </div>

                        <div class="form-group">
                            <input class="form-control" v-model="userpack.link" type="url"
                                placeholder="Enter Package Link or Website eg. https://example.com" required>
                        </div>

                        <div class="form-group">
                            <input class="form-control" v-model="userpack.command" type="text"
                                placeholder="Enter Installation Command eg. npm istall example" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                    <v-select v-model="userpack.cat_name"
                                        :options="allCategory"
                                        label="name"
                                        :reduce="allCategory => allCategory.id"
                                        placeholder="Select Package Category" required>
                                    </v-select>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                    <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                    title="Click to add new package category" @click.prevent="openCategoryModal()">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                        <v-select multiple
                                        v-model="userpack.install_name"
                                        :options="allInstallation"
                                        label="name"
                                        :reduce="allInstallation => allInstallation.id"
                                        placeholder="Select Package Installation Mediums"
                                        @input="showInstall"
                                        required>
                                    </v-select>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                    <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                    title="Click to add new package installation medium" @click.prevent="openInstallationModal()">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                        <v-select multiple
                                        v-model="userpack.lang_name"
                                        :options="allLanguage"
                                        label="name"
                                        :reduce="allLanguage => allLanguage.id"
                                        placeholder="Select Programming Languages"
                                        @input="showLang">
                                    </v-select>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                    <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                    title="Click to add new programming language" @click.prevent="openLanguageModal()">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <vue-editor v-model="userpack.description" id="editor" required
                                        :editorToolbar="maintenance" placeholder="Enter package descriptions">
                            </vue-editor>
                        </div>

                        <div class="form-group">
                            <vue-editor v-model="userpack.procedure" id="editor" required
                                        :editorToolbar="maintenance" placeholder="Enter package installation procedure">
                            </vue-editor>
                        </div>

                        <div class="form-group" v-if="addoredit">
                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                Save Package
                            </button>
                        </div>

                        <div class="form-group" v-else>
                            <a class="btn btn-block btnaddcomment" href="" @click.prevent="editUserPackageForm()" style="color:white">
                                <i class="fas fa-edit"></i>
                                Edit Package
                            </a>
                        </div>

                </form>

            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
        </div>

        <div class="row mb-5" v-show="viewpackage">

            <div class="col-xl-12 col-lg-12">
                <div class="form-group float-left">
                    <select class="form-select" v-model="length" @input="resetPagination()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
                <div class="form-group float-right">
                    <input type="text" class="form-control" v-model="search" @input="resetPagination()"
                        placeholder="Search by package name">
                </div>
            </div>

            <div class="table-responsive">

                <vue-loading :active.sync="userPackLoading"
                            :can-cancel="true"
                            :is-full-page="false">
                </vue-loading>

                <table class="table table-striped">
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
                        <tr v-for="(user, index) in paginated" :key="user.id">
                            <td>{{ index += 1}}</td>
                            <td>{{ user.name | upperCase | reduceText(50, '...') }} </td>
                            <td><pre>{{ user.command | reduceText(30, '...') }}</pre></td>
                            <td class="text-center">
                                <a :href="user.link" style="color:blue" target="_blank">link</a>
                            </td>
                            <td>{{ user.created_at | dateOnly }}</td>
                            <td colspan="2" class="text-center">

                                <a href="" class="btnEdit" @click.prevent="showUserPackage(user)"
                                title="Click to view and edit">
                                    <i class="fas fa-eye text-success"></i>
                                </a>

                                <a href="" class="btnDelete" @click.prevent="deleteUserPackage(user.id)"
                                title="Click to delete">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <nav class="myNav text-center" aria-label="Page navigation">
            <ul class="pagination">

                <li :class="[{disabled: !pagination.prevPage }]">
                    <a href="#" class="page-link" @click.prevent="substraction()">
                        <b>Previous</b>
                    </a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link" href="#" style="color: black">
                        Page
                        <b>{{ pagination.currentPage }}</b>
                        of
                        <b>{{ pagination.page }}</b>
                    </a>
                </li>

                <li :class="[{disabled: !pagination.nextPage }]">
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


        <!-- Model for Adding starts here -->
        <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog"
            data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align:center">
                                <b>CREATE NEW CATEGORY</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="submitCategoryForm()" class="myForm">
                            <div class="modal-body">

                                <vue-loading :active.sync="catLoading"
                                            :can-cancel="true"
                                            :is-full-page="false">
                                </vue-loading>

                                <div class="form-group">
                                    <input class="form-control" v-model="category.name" type="text"
                                        placeholder="Enter Category Name" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                    <i class="fas fa-save"></i>
                                    Save Category
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="addInstallationModel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>CREATE INSTALLATION MEDIUM</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitInstallationForm()" class="myForm">

                        <div class="modal-body">

                            <vue-loading :active.sync="installLoading"
                                        :can-cancel="true"
                                        :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="installation.name" type="text"
                                    placeholder="Enter Installation Medium">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                Save Installation
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->

        <!-- Model for Adding starts her -->
        <div class="modal fade" id="addLanguageModel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>CREATE LANGUAGE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitLanguageForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="langLoading"
                                        :can-cancel="true"
                                        :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="language.name" type="text"
                                    placeholder="Enter New Programming Language Name" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                Save Language
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
  import 'vue-select/dist/vue-select.css';
  import VueLoading from "vue-loading-overlay/src/js/Component";
  import { VueEditor } from "vue2-editor";
  export default {
    components : {
        VueLoading,
        VueEditor,
    },
    data() {
        return {
            maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
            ],
            allCategory:[],
            allInstallation:[],
            allLanguage:[],
            allPackageUser:[],
            allPackUserLang:[],
            allPackUserInstall:[],
            userpack : {
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
            category : {
                id:'',
                name:'',
            },
            installation : {
                id:'',
                name:'',
            },
            language : {
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
            isLoading:false,
            packageLoading:false,
            catLoading:false,
            installLoading:false,
            langLoading:false,
            userPackLoading:false,
            addpackage:true,
            viewpackage:false,
            addoredit:true,
            search:'',
            length:20,
        }
    },

    methods: {

        /**
         * Package adding by user
        */
        addPackage(){
           this.addpackage = true;
           this.viewpackage = false;
        },

        viewPackage(){
           this.viewpackage = true;
           this.addpackage = false;
           this.addoredit = true;
           this.clearForm();
        },

        getCategory(){
            axios.get('/get/category')
            .then((response) => {
                this.allCategory = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all category failed','warning');
            });
        },

        getLanguage(){
            axios.get('/get/language')
            .then((response) => {
                this.allLanguage = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all language failed','warning');
            });
        },

        getInstallation(){
            axios.get('/get/installation')
            .then((response) => {
                this.allInstallation = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all installation failed','warning');
            });
        },

        openCategoryModal(){
            $("#addCategoryModel").modal('show');
        },

        submitCategoryForm(){
            this.catLoading = true;
            let form = new FormData();

            form.append('name', this.category.name);

            axios.post('/post/category', form)
            .then(() => {
                Toast.fire("Success :","Category saved successfully","success");
                $("#addCategoryModel").modal('hide');
                this.getCategory();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.catLoading = false;
            });

        },

        openInstallationModal(){
            $("#addInstallationModel").modal('show');
        },

        submitInstallationForm(){
            this.installLoading = true;
            let form = new FormData();

            form.append('name', this.installation.name);

            axios.post('/post/installation', form)
            .then(() => {
                Toast.fire("Success :","Installation saved successfully","success");
                $("#addInstallationModel").modal('hide');
                this.getInstallation();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.installLoading = false;
            });

        },

        openLanguageModal(){
            $("#addLanguageModel").modal('show');
        },

        submitLanguageForm(){
            this.langLoading = true;
            let form = new FormData();

            form.append('name', this.language.name);

            axios.post('/post/language', form)
            .then(() => {
                Toast.fire("Success :","Language saved successfully","success");
                $("#addLanguageModel").modal('hide');
                this.getLanguage();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.langLoading = false;
            });

        },

        submitPackageForm(){
            this.isLoading = true;
            let form = new FormData();

            form.append('name', this.userpack.name);
            form.append('link', this.userpack.link);
            form.append('command', this.userpack.command);
            form.append('description', this.userpack.description);
            form.append('procedure', this.userpack.procedure);
            form.append('cat_id', this.userpack.cat_name);

            this.userpack.install_name.forEach(element => {
                form.append('install_id[]', element);
            });

            this.userpack.lang_name.forEach(element => {
                form.append('lang_id[]', element);
            });

            axios.post('/post/package', form)
            .then(() => {
                Toast.fire("Success :","Package saved successfully","success");
                this.clearForm();
                this.viewPackage();
                this.getPackageUser();
                this.getPackage();
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

        editUserPackageForm(){
            let form = new FormData();

            form.append('id', this.userpack.id);
            form.append('name', this.userpack.name);
            form.append('link', this.userpack.link);
            form.append('command', this.userpack.command);
            form.append('description', this.userpack.description);
            form.append('procedure', this.userpack.procedure);
            form.append('cat_id', this.userpack.cat_id);

            this.userpack.install_name.forEach(element => {
                form.append('install_id[]', element);
            });

            this.userpack.lang_name.forEach(element => {
                form.append('lang_id[]', element);
            });


            axios.post('/update/package', form)
            .then(() => {
                Toast.fire("Success :","Package updated successfully", "success");
                this.viewPackage();
                this.getPackageUser();
                this.getPackage();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            });

        },

        getPackageUser(){
            this.userPackLoading = true;
            axios.get('/get/user/package')
            .then((response) => {
                this.allPackageUser = response.data;
                this.userPackLoading = false;
            }).catch(() => {
                Swal.fire('Failed :','Loading all user packages failed','warning');
            });
        },

        clearForm(){
            this.userpack.id = '';
            this.userpack.name = '';
            this.userpack.link = '';
            this.userpack.command = '';
            this.userpack.procedure = '';
            this.userpack.description = '';
            this.userpack.cat_id = '';
            this.userpack.install_id = [];
            this.userpack.lang_id = [];
            this.userpack.cat_name = '';
            this.userpack.lang_name = [];
            this.userpack.install_name = [];
        },

        deleteUserPackage(id) {
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

                    axios.delete('/delete/package/' + id)
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

        showUserPackage(user){
            this.userPackLoading = true;
            this.userpack.id = user.id;
            this.userpack.name = user.name;
            this.userpack.link = user.link;
            this.userpack.command = user.command;
            this.userpack.description = user.description;
            this.userpack.procedure = user.procedure;
            this.userpack.cat_id = user.catid;
            this.userpack.cat_name = user.catname;
            this.getPackUserLang(user.id);
            this.getPackUserInstall(user.id);
            this.addPackage();
            this.userPackLoading = false;
            this.addoredit = false;
        },

        getPackUserLang(id){
            this.allPackLang = [];
            this.userpack.lang_id = [];
            this.userpack.lang_name = [];
            axios.get('/get/pack/lang/' + id)
            .then((res) => {

                this.allPackUserLang = res.data;
                this.allPackUserLang.forEach((value) => {
                    this.userpack.lang_id.push(value.id);
                    this.userpack.lang_name.push(value.id);
                });

            }).catch(() => {
                Swal.fire('Failed :','Loading all package language failed','warning');
            });
        },

        getPackUserInstall(id){
            this.allPackUserInstall = [];
            this.userpack.install_id = [];
            this.userpack.install_name = [];
            axios.get('/get/pack/install/' + id)
            .then((res) => {

                this.allPackUserInstall = res.data;
                this.allPackUserInstall.forEach((value) => {
                    this.userpack.install_id.push(value.id);
                    this.userpack.install_name.push(value.id);
                });

            }).catch(() => {
                Swal.fire('Failed :','Loading all package installation failed','warning');
            });
        },

        showInstall(value){
            let diff = this.getDifference(this.userpack.install_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.install_id = [];
            this.userpack.install_id = value;
            axios.delete('/delete/pack/install/' + id)
        },

        showLang(value){
            let diff = this.getDifference(this.userpack.lang_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.lang_id = [];
            this.userpack.lang_id = value;
            axios.delete('/delete/pack/lang/' + id)
        },

        getDifference(arr1, arr2){
            let difference = arr1.filter(x => !arr2.includes(x));
            return difference;
        },

        /**
        * Pagination starts
       */

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

    mounted() {
        this.getCategory();
        this.getLanguage();
        this.getInstallation();
        this.getPackageUser();
    },

     computed:{

        filteredPackageUser(){
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

        paginated(){
            return this.paginate(this.filteredPackageUser, this.length, this.pagination.currentPage);
        },

      },
  }
</script>

<style lang="scss" scoped>

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

.link{
  color: #051be2;
}

.myBtn {
    border-radius: 2px;
    padding: 5px;
    margin-left:5px;
    border: 1px solid #969696;
}


.comment .active {
   color: #F48024;
}

.comment a {
    text-decoration: none;
    color: #969696;
    margin-right: 20px;
}

.comment a:hover {
   color: #F48024;
}

.footer {
    margin-top: 10px;
    border-top: 1px solid gray;
}

.btnaddcomment {
    background-color: rgb(180, 177, 177);
    border-radius: 5px;
}

.btnaddcomment:hover {
    background-color:  #F48024;
}

.commenter {
    color: #0089D8;
    background-color: #E1ECF4;
    padding:5px;
    text-decoration: none;
}

.commenter:hover {
    color:blue;
}

</style>
