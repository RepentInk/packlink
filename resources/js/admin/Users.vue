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
                                    <b>All Users</b>
                                </h2>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                <p class="card-description">
                                    <a href="#" class="btn btn-outline-primary float-right" @click.prevent="openAddModal()">
                                        <b><i class="mdi mdi-account-plus"></i></b>
                                        <b>Add User</b>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div>
                            <div class="form-group float-left">
                                <label>Select :</label>
                                <select class="form-control" v-model="length" @change="getUsers()">
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
                                    <th>Nickname </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>UserType</th>
                                    <th>Created On</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user,index) in filteredUser" :key="user.id">
                                        <td>{{ index += 1}}</td>
                                        <td>{{ user.nickname | upperCase }} </td>
                                        <td>{{ user.name | reduceText(20, '...') }}</td>
                                        <td>{{ user.email | reduceText(20, '...') }}</td>
                                        <td>{{ user.user_type }}</td>
                                        <td>{{ user.created_at | dateOnly }}</td>
                                        <td colspan="2" class="text-center">

                                            <a href="" class="btnEdit" @click.prevent="showData(user)" title="Click to view and edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>

                                            <a v-if="user.id === JSON.parse(user_id)" class="btnDelete" href="" style="color:#4a4a4a;pointer-events:none">
                                                <i class="mdi mdi-delete"></i>
                                            </a>

                                            <a v-else href="" class="btnDelete" @click.prevent="deleteUser(user.id)" title="Click to delete">
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
                                    <a href="#" class="page-link" @click.prevent="getUsers(pagination.prev_page_url)"><b>Previous</b></a>
                                </li>

                                <li class="page-item disabled">
                                    <a class="page-link text-dark" href="#">Page <b>{{ pagination.current_page }}</b> of <b>{{ pagination.last_page }}</b></a>
                                </li>

                                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                                    <a href="#" class="page-link" @click.prevent="getUsers(pagination.next_page_url)"><b>Next</b></a>
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
        <div class="modal fade" id="addUserModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>REGISTER USER</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitUserForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" v-model="user.nickname" type="text"
                                       placeholder="Enter Nick Name" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.name" type="text"
                                       placeholder="Enter Name" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.email" type="email"
                                       placeholder="Enter Email Address" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.password" type="password"
                                       placeholder="Enter Password" id="passMain" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.confirmPass" type="password"
                                       placeholder="Enter Confirm Password" id="passCon" required>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" @click="showPassword()"> Check to show password
                            </div>


                            <div class="form-group">
                                <label>
                                    <i class="fa fa-picture-o"></i> Select Profile Picture
                                </label>
                                <input type="file" class="form-control" @change="singleFile">
                            </div>

                            <div class="form-group flex-fill">
                                <img v-for="show in showImage" :src="show" alt="Image" :key="show"
                                     class="img img-thumbnail mr-1" style="width:120px; height:120px">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Save User
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End of model -->


        <!-- Model for Editting starts her -->
        <div class="modal fade" id="editUserModel" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>EDIT USER INFO</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editUserForm()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <img :src="user.profile" class="img-thumbnail" style="height: 70px; width: 70px"
                                     alt="image">
                            </div>

                             <div class="form-group">
                                <input class="form-control" v-model="user.title" type="text"
                                       placeholder="Enter Title">
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.nickname" type="text"
                                       placeholder="Enter Nick Name">
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.name" type="text"
                                       placeholder="Enter Name">
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.email" type="email"
                                       placeholder="Enter Email Address">
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.location" type="text"
                                       placeholder="Enter Location">
                            </div>

                            <div class="form-group">
                                <label>Add About You</label>
                                <vue-editor v-model="user.about" id="editor" required
                                            :editorToolbar="maintenance">
                                </vue-editor>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fa fa-picture-o"></i> Select Profile Picture
                                </label>
                                <input type="file" class="form-control" @change="singleFile">
                            </div>

                            <div class="form-group flex-fill">
                                <img v-for="show in showImage" :src="show" alt="Image" :key="show"
                                     class="img img-thumbnail mr-1" style="width:120px; height:120px">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-pen"></i>
                                Edit User Info
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
    import { VueEditor } from "vue2-editor";
    export default {
        components : {
            VueLoading,
            VueEditor,
        },
        props: ['user_id'],
        data(){
            return {
                maintenance: [
                    ["bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    ["image", "code-block"],
                ],
                allUsers:[],
                user : {
                    id:'',
                    nickname:'',
                    name:'',
                    email:'',
                    password:'',
                    profile:'',
                    confirmPass:'',
                    location:'',
                    title:'',
                    about:'',
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

            async getUsers(page_url){
                this.tableLoading = true;
                page_url = page_url || '/admin/get/users/' + this.length;
                await axios.get(page_url)
                .then((response) => {
                    this.allUsers = response.data.data;
                    this.makePagination(response.data);
                }).catch(() => {
                    Swal.fire('Failed :','Loading all users failed','warning');
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

            showPassword(){
                let x = document.getElementById("passMain");
                let y = document.getElementById("passCon");
                if (x.type === "password" || y.type === "password") {
                    x.type = "text";
                    y.type = "text";
                } else {
                    x.type = "password";
                    y.type = "password";
                }
            },

            singleFile(e){
                this.user.profile = '';
                let file = e.target.files[0];
                if(file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/jpg'){

                    if(file.size < 2097152){
                        this.user.profile = file;
                        this.previewImage(file);
                    } else {
                        Swal.fire('Image Size Too Large', 'Image size cannot be more than 2MB','warning')
                    }

                }  else {
                    Swal.fire('File Format not Supported', 'Supported file types are jpg | jpeg | png','warning')
                }
            },

            previewImage(file){
                let reader = new FileReader();
                reader.onload = (e) =>{
                    this.showImage.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },

            openAddModal(){
                this.clearForm();
                $("#addUserModel").modal('show');
            },

            openEditModal() {
                $("#editUserModel").modal('show');
            },

            async showData(user) {
                this.user.id = user.id;
                this.user.nickname = user.nickname;
                this.user.name = user.name;
                this.user.email = user.email;
                this.user.profile = user.profile;
                this.user.title = user.title;
                this.user.location = user.location;
                this.user.about = user.about;

                this.openEditModal();
            },

            clearForm(){
                this.user.id = '';
                this.user.nickname = '';
                this.user.name = '';
                this.user.email = '';
                this.user.profile = '';
                this.user.password = '';
                this.user.confirmPass = '';
                this.showImage = [];
            },

            async submitUserForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('nickname', this.user.nickname);
                form.append('name', this.user.name);
                form.append('email', this.user.email);
                form.append('password', this.user.password);
                form.append('confirm_password', this.user.confirmPass);
                form.append('profile', this.user.profile);

                await axios.post('/admin/post/user', form)
                .then(() => {
                    Toast.fire("Success :","User saved successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#addUserModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async editUserForm(){
                this.isLoading = true;
                let form = new FormData();

                form.append('id', this.user.id);
                form.append('nickname', this.user.nickname);
                form.append('name', this.user.name);
                form.append('email', this.user.email);
                form.append('profile', this.user.profile);
                form.append('title', this.user.title);
                form.append('location', this.user.location);
                form.append('about', this.user.about);

                await axios.post('/admin/update/user', form)
                .then(() => {
                    Toast.fire("Success :","User updated successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.showImage = [];
                    $("#editUserModel").modal('hide');
                    Fire.$emit('refresh');
                    this.isLoading = false;
                });

            },

            async deleteUser(id){
                Swal.fire({
                    title: 'Are you sure ?',
                    text: "User will be deleted",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!'
                }).then((result) => {
                    if (result.value) {

                        axios.delete('/admin/delete/user/' + id)
                        .then(() => {
                            Toast.fire('Deleting User !','User has been deleted','success');
                        }).catch(() => {
                            Swal.fire("Failed","Could not deleted user","warning");
                        }).finally(() => {
                            Fire.$emit('refresh');
                        });

                    }
                });
            },

        },

        created () {
            Fire.$on('refresh',() => {
                this.getUsers();
            });
        },

        mounted() {
            this.getUsers();
        },

        computed:{

            filteredUser(){
                let users = this.allUsers;
                if(this.search){
                    users = users.filter((row) => {
                        return Object.keys(row).some((key) => {
                            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                        })
                    })
                }
                return users;
            },

        },
    }
</script>

