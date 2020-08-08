<template>
    <div>

        <!-- Add tutorial -->
        <div class="modal fade" id="addTitoModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>CREATE NEW TUTORIAL</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitTitoForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                :can-cancel="true"
                                :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="tutorial.title" type="text"
                                    placeholder="Enter Title" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="tutorial.url" type="url"
                                    placeholder="Enter Package Link or Website eg. https://example.com" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="tutorial.name" type="text"
                                    placeholder="Enter Author Name" required>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                        <v-select v-model="tutorial.lang_name" required
                                            :options="allLanguage"
                                            label="name"
                                            :reduce="allLanguage => allLanguage.id"
                                            placeholder="Select Programming Languages">
                                        </v-select>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                        <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                            title="Click to add new programming language"
                                            @click.prevent="openLangModal()">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <vue-editor v-model="tutorial.description" id="editor" required
                                            :editorToolbar="maintenance" placeholder="Enter brief description">
                                </vue-editor>
                            </div>

                            <div class="form-group">
                                <label style="margin-right:20px">Select tutorial type</label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="rad" v-model="tutorial.type" class="form-check-input" value="video"> Video
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="rad" v-model="tutorial.type"  class="form-check-input" value="read"> Read
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                <span v-if="addoredit">Update</span> <span v-else>Save</span> Tutorial
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end tutorial here -->

        <my-modal-component ref="com"></my-modal-component>

    </div>
</template>
<script>
import 'vue-select/dist/vue-select.css';
import { VueEditor } from "vue2-editor";
import VueLoading from "vue-loading-overlay/src/js/Component";
import Con from "../service/PackageController";
import MyModalComponent from '../modals/LangModal';
export default {
    props:['tito'],
    components:{
        VueLoading,
        VueEditor,
        MyModalComponent,
    },
    data() {
        return {
            maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
            ],
            allLanguage:[],
            isLoading:false,
            addoredit:false,
            tutorial:{
                id:'',
                name:'',
                title:'',
                url:'',
                type:'',
                lang_id:'',
                lang_name:'',
                description:'',
            },
        }
    },

    methods: {

        closeModal(){
           $("#addTitoModel").modal('hide');
        },

        openLangModal(){
            this.closeModal();
            $("#addLangModelTito").modal('show');
        },

        openModalTito(){
            this.addoredit = true;
            setTimeout(() => {
                this.tutorial = this.tito;
                $("#addTitoModel").modal('show');
            }, 500);
        },

        submitTitoForm() {
               this.isLoading = true;

               if(typeof(this.tutorial.lang_name) === 'string'){
                  this.tutorial.lang_name = this.tutorial.lang_id;
               }

               let id = this.tutorial.id;
               let title = this.tutorial.title;
               let name = this.tutorial.name;
               let url = this.tutorial.url;
               let lang = this.tutorial.lang_name;
               let type = this.tutorial.type;
               let des = this.tutorial.description;

               Con.saveTutorial(id, title, name, url, lang, type, des)
               .then((res) => {
                  Toast.fire("Success :","Tutorial saved successfully","success");
                  this.clearForm();
                  this.closeModal();
               }).catch((error) => {
                   if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }
               }).finally(() => {
                   this.isLoading = false;
                   this.$parent.fetchUserTito();
               });
        },

        clearForm(){
            this.tutorial.id = '';
            this.tutorial.title = '';
            this.tutorial.name = '';
            this.tutorial.url = '';
            this.tutorial.lang_name = '';
            this.tutorial.type = '';
            this.tutorial.description = '';
        },

        // get data
        getLanguage(){
            Con.getLanguage().then((res) => {
                this.allLanguage = res.data;
            }).catch((error) => {
                Swal.fire('Failed :','Loading all language failed','warning');
            });
        },

    },

    mounted() {
        this.getLanguage();
    },
}
</script>
