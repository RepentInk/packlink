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
                                    <b>All Categories</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add Category</b>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div class="form-group float-left">
                                <label>Select :</label>
                                <select class="form-control" v-model="length" @change="getCategory()">
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
                                    <tr v-for="(cat,index) in filteredCategory" :key="cat.id">
                                        <td>{{ index += 1}}</td>
                                        <td>{{ cat.name | upperCase }} </td>
                                        <td>{{ cat.created_at | dateOnly }}</td>
                                        <td colspan="2" class="text-center">
                                            <a href="" class="btnEdit" @click.prevent="showData(cat)"
                                               title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a href="" class="btnDelete" @click.prevent="deleteCategory(cat.id)"
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
                     <!-- navigation -->
                        <nav aria-label="Page navigation example" style="margin-bottom:70px">
                            <ul class="pagination pagination-md justify-content-center">
                                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item">
                                    <a href="#" class="page-link" @click.prevent="getCategory(pagination.prev_page_url)"><b>Previous</b></a>
                                </li>

                                <li class="page-item disabled">
                                    <a class="page-link text-dark" href="#">Page <b>{{ pagination.current_page }}</b> of <b>{{ pagination.last_page }}</b></a>
                                </li>

                                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                                    <a href="#" class="page-link" @click.prevent="getCategory(pagination.next_page_url)"><b>Next</b></a>
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
        <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>REGISTER CATEGORY</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitCategoryForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="category.name" type="text"
                                       placeholder="Enter Category Name" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Save Category
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="editCategoryModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>EDIT CATEGORY</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editCategoryForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                             <div class="form-group">
                                <input class="form-control" v-model="category.name" type="text"
                                       placeholder="Enter Category">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-pen"></i>
                                Edit Category
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
                allCategory:[],
                category : {
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

            async getCategory(page_url){
                this.tableLoading = true;
                page_url = page_url || '/admin/get/category/' + this.length;
                await axios.get(page_url)
                .then((response) => {
                    this.allCategory = response.data.data;
                    this.makePagination(response.data);
                }).catch(() => {
                   Swal.fire('Failed :','Loading all category failed','warning');
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
                $("#addCategoryModel").modal('show');
            },

            openEditModal() {
                $("#editCategoryModel").modal('show');
            },

            async showData(category) {
                this.category.id = category.id;
                this.category.name = category.name;
                this.openEditModal();
            },

            clearForm(){
                this.category.id = '';
                this.category.name = '';
            },

            async submitCategoryForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('name', this.category.name);

                await axios.post('/admin/post/category', form)
                .then(() => {
                    Toast.fire("Success :","Category saved successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#addCategoryModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async editCategoryForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('id', this.category.id);
                form.append('name', this.category.name);

                await axios.post('/admin/update/category', form)
                .then(() => {
                    Toast.fire("Success :","Category updated successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#editCategoryModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async deleteCategory(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "Category will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        axios.delete('/admin/delete/category/' + id)
                        .then(() => {
                            Toast.fire('Deleting Category !','Category has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted category","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

        },

        created () {
            Fire.$on('refresh',() => {
                this.getCategory();
            });
        },

        mounted() {
           this.getCategory();
        },

        computed:{

            filteredCategory(){
                let category = this.allCategory;
                if(this.search){
                    category = category.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    })
                }
                return category;
            },

        },
    }
</script>

