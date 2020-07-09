<template>
    <div>

        <!-- Add package -->
        <div class="modal fade" id="addPackModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>CREATE NEW PACKAGE</b>
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
                                        title="Click to add new package category" @click.prevent="openCatModal()">
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
                                        title="Click to add new package installation medium" @click.prevent="openInstallModal()">
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
                                        title="Click to add new programming language" @click.prevent="openLangModal()">
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

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                <span v-if="addoredit">Update</span> <span v-else>Save</span> Package
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end package here -->

        <my-modal ref="mo"></my-modal>

    </div>
</template>
<script>
import 'vue-select/dist/vue-select.css';
import { VueEditor } from "vue2-editor";
import VueLoading from "vue-loading-overlay/src/js/Component";
import Con from "../service/PackageController";
import MyModal from '../modals/myModals';
export default {
    props:['pack'],
    components:{
        VueLoading,
        VueEditor,
        MyModal,
    },
    data() {
        return {
            maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
            ],
            isLoading:false,
            addoredit:false,

            allPackUserLang:[],
            allPackUserInstall:[],
            allCategory:[],
            allLanguage:[],
            allInstallation:[],

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
        }
    },

    methods: {

        closePackModal(){
            $("#addPackModel").modal('hide');
        },

        openCatModal(){
            this.closePackModal();
            $("#addCatModel").modal('show');
        },

        openLangModal(){
            this.closePackModal();
            this.$refs.mo.openLanguageModal();
        },

        openInstallModal(){
            this.closePackModal();
            $("#addInstallModel").modal('show');
        },

        openPackModal(){
            this.addoredit = true;
            setTimeout(() => {
                this.isLoading = true;
                this.userpack.id = this.pack.id;
                this.userpack.name = this.pack.name;
                this.userpack.link = this.pack.link;
                this.userpack.command = this.pack.command;
                this.userpack.description = this.pack.description;
                this.userpack.procedure = this.pack.procedure;
                this.userpack.cat_id = this.pack.catid;
                this.userpack.cat_name = this.pack.catname;
                this.getPackUserLang(this.pack.id);
                this.getPackUserInstall(this.pack.id);
                this.isLoading = false;
                $("#addPackModel").modal('show');
            }, 500);
        },

        submitPackageForm(){
            this.isLoading = true;

            if(typeof(this.userpack.cat_name) === 'string'){
                this.userpack.cat_name = this.userpack.cat_id;
            }

            let id = this.userpack.id;
            let name = this.userpack.name;
            let link = this.userpack.link;
            let command = this.userpack.command;
            let description = this.userpack.description;
            let procedure = this.userpack.procedure;
            let cat_name = this.userpack.cat_name;
            let install_name = this.userpack.install_name;
            let lang_name = this.userpack.lang_name;


            Con.savePackage(id, name, link, command, description, procedure, cat_name, install_name, lang_name)
            .then(() => {
                Toast.fire("Success :","Package saved successfully","success");
                this.clearPackForm();
                this.closePackModal();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.isLoading = false;
                this.$parent.getPackageUser();
            });

        },

        clearPackForm(){
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


        /**
         * Get Data
        */
        getCategory(){
            Con.getCategory().then((res) => {
                this.allCategory = res.data;
            }).catch((error) => {
                Swal.fire('Failed :','Loading all category failed','warning');
            });
        },

        getLanguage(){
            Con.getLanguage().then((res) => {
                this.allLanguage = res.data;
            }).catch((error) => {
                Swal.fire('Failed :','Loading all language failed','warning');
            });
        },

        getInstallation(){
            Con.getInstallation().then((res) => {
                this.allInstallation = res.data;
            }).catch((error) => {
                Swal.fire('Failed :','Loading all installation failed','warning');
            });
        },



        /**
         * Perfroming actions
         * */
        showInstall(value){
            let diff = Con.getDifference(this.userpack.install_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.install_id = [];
            this.userpack.install_id = value;
            Con.deleteInstall(id);
        },

        showLang(value){
            let diff = Con.getDifference(this.userpack.lang_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.lang_id = [];
            this.userpack.lang_id = value;
            Con.deleteLanguage(id);
        },

        getPackUserLang(id){
            this.allPackLang = [];
            this.userpack.lang_id = [];
            this.userpack.lang_name = [];
            Con.getPackLanguage(id)
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

            Con.getPackInstallation(id)
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

    },

    mounted() {
        this.getCategory();
        this.getLanguage();
        this.getInstallation();
    },
}
</script>
