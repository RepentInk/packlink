<template>
    <div class="container">

        <div id="profileUser" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>UPDATE PROFILE</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="submitFormProfile()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <img :src="user.profile" alt="" class="img img-fluid" style="width:50px; height:50px; vertical-align: middle;border-radius: 50%;">
                            </div>

                             <div class="form-group">
                                <input class="form-control" v-model="user.title" type="text"
                                       placeholder="Enter Title" required>
                            </div>

                            <div class="form-group">
                                <input class="form-control" v-model="user.nickname" type="text"
                                       placeholder="Enter Nickname" required>
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
                               <i class="mdi mdi-plus-circle"></i>
                               Update Profile
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div id="changeUserPass" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>CHANGE PASSWORD</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="passwordChange()" class="myForm">
                        <div class="modal-body">

                            <vue-loading :active.sync="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="false">
                            </vue-loading>

                            <div class="form-group">
                                <input class="form-control" type="email" v-model="user.email"
                                       placeholder="Enter Program Title" disabled>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Enter New Password"
                                          v-model="admin.password" required id="myUserPass"/>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm New Password"
                                       v-model="admin.confirm_password" required id="myUserConfirm"/>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" @click="viewPass()"> Show Password
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-block btn-outline-primary" type="submit">
                                <i class="mdi mdi-plus-circle"></i>
                                Change Password
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
    import { VueEditor } from "vue2-editor";
    export default {
        components : {
            VueLoading,
            VueEditor,
        },
        props:['userinfo'],
        data() {
            return {
                maintenance: [
                    ["bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    ["image", "code-block"],
                ],
                user:{
                    id:'',
                    nickname:'',
                    name:'',
                    email:'',
                    profile:'',
                    title:'',
                    location:'',
                    about:'',
                },
                admin:{
                    password:'',
                    confirm_password:'',
                },
                showImage:[],
                progress:false,
                holdme:0,
                isLoading: false,
            }
        },

        methods: {

            viewPass() {
                let x = document.getElementById("myUserPass");
                let y = document.getElementById("myUserConfirm");
                if (x.type === "password" || y.type === "password") {
                    x.type = "text";
                    y.type = "text";
                } else {
                    x.type = "password";
                    y.type = "password";
                }
            },

            singleFile(e){
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

            modalCloseProfile(){
                $('#profileUser').modal('hide');
            },

            modalClosePassword(){
                $('#changeUserPass').modal('hide');
            },

            submitFormProfile(){
                this.isLoading = true;
                let formdata = new FormData();

                formdata.append('id', this.user.id);
                formdata.append('nickname', this.user.nickname);
                formdata.append('name', this.user.name);
                formdata.append('email', this.user.email);
                formdata.append('title', this.user.title);
                formdata.append('profile', this.user.profile);
                formdata.append('location', this.user.location);
                formdata.append('about', this.user.about);

                axios.post('/update/profile', formdata)
                .then(() => {
                    Toast.fire("Success :","Profile updated successfully","success");
                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.modalCloseProfile();
                    this.isLoading = false;
                });

            },

            passwordChange(){
                this.isLoading = true;

                let formdata = new FormData();
                formdata.append('id', this.user.id);
                formdata.append('password', this.admin.password);
                formdata.append('confirm_password', this.admin.confirm_password);

                axios.post('/change/password', formdata)
                .then(() => {
                    Toast.fire("Success :","Password updated successfully","success");
                 }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed",error.response.data.error,"warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                }).finally(() => {
                    this.modalClosePassword();
                    this.isLoading = false;
                });

            },
        },

        mounted() {
            this.user = JSON.parse(this.userinfo);
        },

    }
</script>
