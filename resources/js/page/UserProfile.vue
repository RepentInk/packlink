<template>
  <div>
        <h3>Profile Details</h3> <hr>
        <div class="row mb-5">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12"></div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                <form @submit.prevent="submitFormProfile()" class="form">

                        <vue-loading :active.sync="profileLoading"
                                    :can-cancel="true"
                                    :is-full-page="false">
                        </vue-loading>

                        <div class="form-group">
                            <img :src="user.profile" alt="" class="img avatar" width="60px" height="60px">
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
                            <label>About You</label>
                            <vue-editor v-model="user.about"
                                        id="editor" required
                                        :editorToolbar="maintenance"
                                        placeholder="Add about yourself">
                            </vue-editor>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-image"></i>
                                Select Profile Picture
                            </label>
                            <input type="file" class="form-control" @change="singleFile">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                <i class="fas fa-save"></i>
                                Update Profile
                            </button>
                        </div>

                        <div class="form-group flex-fill">
                            <img v-for="show in showImage" :src="show" alt="Image" :key="show"
                                class="img img-thumbnail mr-1" style="width:120px; height:120px">
                        </div>


                </form>

            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12"></div>
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
           maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
           ],
           profileLoading:false,
           showImage:[],
       }
   },

   methods: {

        /**
         * User Profile update goes here
        */

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

        submitFormProfile(){
            this.profileLoading = true;
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
                this.showImage = [];
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.profileLoading = false;
            });
        },

        /**
         * Profile ends
        */

   },

   mounted() {
      this.user = JSON.parse(this.userinfo);
   },
}  
</script>

<style lang="scss" scoped>

.btnaddcomment {
    background-color: rgb(180, 177, 177);
    border-radius: 5px;
}

.btnaddcomment:hover {
    background-color:  #F48024;
}

.avatar {
    border-radius:50%;
}

</style>