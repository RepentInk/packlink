<template>
     <div>
         <div class="modal fade" id="loginModel" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
             <div class="modal-dialog modal-dialog-scrollable" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" style="text-align:center">
                             PackLink
                         </h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>

                        <div class="modal-body">

                          <form @submit.prevent="submitLogin()" class="myForm">

                             <div class="form-group">
                                 <label>
                                     <i class="fas fa-envelope fa-fw"></i>
                                     Email
                                 </label>
                                 <input class="form-control" type="email" v-model="user.userEmail"
                                        placeholder="Enter Email Address" required>
                             </div>

                             <div class="form-group">
                                 <label>
                                     <i class="fa fa-lock" aria-hidden="true"></i>
                                     Password
                                 </label>
                                 <input class="form-control" type="password" v-model="user.userPassword"
                                        placeholder="Enter Password" id="pass" required>
                             </div>

                             <div class="form-group">
                                <input type="checkbox" @click="visiblePass()"> Check to show password
                             </div>

                             <button class="btn btn-block btn-primary" type="submit" style="color:white">
                                 <i class="fas fa-sign-in-alt"></i>
                                 Login
                             </button>

                          </form>

                        </div>

                         <div class="modal-footer" style="color:white">

                            <a class="btn btn-block btn-danger btn-sm" :href="'/sign-in/google'">
                                <i class="fab fa-google"></i>
                                Login with Google
                            </a> <br>

                            <a class="btn btn-block btn-dark btn-sm" :href="'/sign-in/github'">
                               <i class="fab fa-github"></i>
                                Login with Github
                            </a>

                         </div>

                 </div>
             </div>
         </div>


     </div>
</template>

<script>
    export default {
        data() {
            return{
                user:{
                    userEmail:'',
                    userPassword:'',
                }
            }
        },

        methods : {

            visiblePass(){
                let x = document.getElementById("pass");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            },

            clearFields(){
                this.user.userEmail = '';
                this.user.userPassword = '';
            },

            submitLogin(){
                let formdata = new FormData();

                formdata.append('email', this.user.userEmail);
                formdata.append('password', this.user.userPassword);

                axios.post('/login', formdata)
                .then((res) => {

                    Toast.fire("Success :","Account Verified Successfully","success");

                    if(res.data === "user"){
                        setTimeout(()=>{
                            window.location.href = '/dashboard';
                        },1000);
                    } else if(res.data === "admin") {
                        setTimeout(()=>{
                            window.location.href = '/admin/index';
                        },1000);
                    }

                }).catch((error) => {
                    Swal.fire("Failed :",error.response.data.error,"warning");
                });

            },

        },

        mounted() {
            this.clearFields();
        }
    }
</script>

