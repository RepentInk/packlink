<template>
    <div>

       <!-- Model for Adding starts her -->
        <div class="modal fade" id="addLangModelTito" role="dialog">
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
import VueLoading from "vue-loading-overlay/src/js/Component";
import Con from "../service/PackageController";
export default {
    components:{
       VueLoading,
    },
    data() {
        return {
            langLoading:false,
            language : {
                id:'',
                name:'',
            },
        }
    },

    methods: {

        submitLanguageForm() {
            this.langLoading = true;
            Con.saveLanguage(this.language.name)
            .then(() => {
                Toast.fire("Success :","Language saved successfully","success");
                this.language.name = '';
                $("#addLangModelTito").modal('hide');
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

    },
}
</script>
