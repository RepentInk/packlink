<template>
    <div>

        <!-- Model for Adding category starts here -->
        <div class="modal fade" id="addCatModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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

         <!-- Model for Adding starts her -->
        <div class="modal fade" id="addLangModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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

        <!-- Model for Editting starts her -->
        <div class="modal fade" id="addInstallModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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

    </div>
</template>
<script>
    import VueLoading from "vue-loading-overlay/src/js/Component";
    import Con from "../service/PackageController";
    export default {
       components:{
           VueLoading,
       },
       data() {
           return {
                catLoading:false,
                langLoading:false,
                installLoading:false,

                category : {
                    id:'',
                    name:'',
                },
                language : {
                    id:'',
                    name:'',
                },
                installation : {
                    id:'',
                    name:'',
                },
           }
       },

       methods: {

            openLanguageModal(){
                $("#addLangModel").modal('show');
            },

            submitCategoryForm(){
                this.catLoading = true;
                Con.saveCategory(this.category.name)
                .then((res) => {
                    Toast.fire("Success :","Category saved successfully","success");
                    this.category.name = '';
                    $("#addCatModel").modal('hide');
                }).catch((error) => {
                   if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }
                }).finally(() => {
                    this.catLoading = false;
                    this.$parent.getCategory();
                });
            },

            submitLanguageForm(){
                this.langLoading = true;
                Con.saveLanguage(this.language.name)
                .then(() => {
                    Toast.fire("Success :","Language saved successfully","success");
                    this.language.name = '';
                    $("#addLangModel").modal('hide');
                }).catch(() => {
                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }
                }).finally(() => {
                    this.langLoading = false;
                    this.$parent.getLanguage();
                });
            },

            submitInstallationForm(){
                this.installLoading = true;
                Con.saveInstallation( this.installation.name)
                .then(() => {
                    Toast.fire("Success :","Installation saved successfully","success");
                    this.installation.name = '';
                    $("#addInstallModel").modal('hide');
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.installLoading = false;
                    this.$parent.getInstallation();
                });

            },

       },

    }
</script>

<style>

.btnaddcomment {
    background-color: rgb(180, 177, 177);
    border-radius: 5px;
}

.btnaddcomment:hover {
    background-color:  #F48024;
}

</style>
