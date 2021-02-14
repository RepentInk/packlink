<template>
    <div class="content-wrapper">

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                                <h2 class="card-title float-left">
                                    <i class="mdi mdi-account"></i>
                                    <b>All Tutorials</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add Tutorial</b>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div class="form-group float-left">
                                <label>Select :</label>
                                <select class="form-control" v-model="number" @change="getTutorial()">
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
                                            <a href="" class="btnEdit" @click.prevent="showData(tito)" title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a href="" class="btnDelete" @click.prevent="deleteLanguage(tito.id)" title="Click to delete">
                                                <i class="mdi mdi-delete"></i>
                                            </a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                    </div>
            </div>
        </div>

         <div class="modal fade" id="addTutorialModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
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

                    <form @submit.prevent="submitTutorialForm()" class="myForm">
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
                                <v-select v-model="tutorial.lang_name" required
                                    :options="allLanguage"
                                    label="name"
                                    :reduce="allLanguage => allLanguage.id"
                                    placeholder="Select Programming Languages">
                                </v-select>
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

    </div>
</template>
<script>
import VueLoading from "vue-loading-overlay/src/js/Component";
import 'vue-select/dist/vue-select.css';
import { VueEditor } from "vue2-editor";
export default {
    components: {
        VueLoading,
    },
    data() {
        return {
            maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
            ],
            number:10,
            allTutorials:[],
            allLanguage:[],
            search:'',
            isLoading:false,
            tableLoading:false,
            pagination:{},
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

        openAddModal(){
          $("#addTutorialModel").modal('show');
        },

        async getTutorial(page_url) {
            this.isLoading = true;
            page_url = page_url || '/admin/get/tutorial/' + this.number;
            await axios.get(page_url)
            .then(res => {
                this.allTutorials = res.data.data;
                this.makePagination(res);
                this.isLoading = false;
            }).catch(() => {
                Swal.fire("Failed","getting all user tutorials","warning")
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

        submitTutorialForm(){

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

        showData(tito) {

        },

        deleteLanguage(id) {

        },

    },

    created() {
        this.getTutorial();
        this.getLanguage();
    },

    computed: {

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
