<template>
    <div>

        <section>

            <div class="container py-5">

                <div class="row">

                    <div class="col-xl-8 col-lg-8 col-mb-8 col-sm-12 hidden-sm">

                        <div style="margin-top:200px">

                             <p style="font-size:30px">Join the PackLink Community</p>

                             <p style="font-size:18px">
                                <i class="fab fa-google" style="color:blue"></i>
                                Bring all packages to one platform
                             </p>

                              <p style="font-size:18px">
                                 <i class="fab fa-google" style="color:blue"></i>
                                 Bring all packages to one platform
                              </p>

                        </div>

                    </div>

                    <div class="col-xl-4 col-lg-4 col-mb-4 col-sm-12">

                        <div style="color:white; margin-bottom:20px">

                            <a class="btn btn-block btn-danger btn-sm" :href="'/sign-in/google'">
                               <i class="fab fa-google"></i>
                              Signup with Google
                            </a>

                            <a class="btn btn-block btn-dark btn-sm" :href="'/sign-in/github'">
                                <i class="fab fa-github"></i>
                                Signup with Github
                            </a>

                        </div>

                        <div class="shadow-lg box">
                            <div class="p-4 border bg-white mt3">

                               <form @submit.prevent="submitForm()" class="myForm">

                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-user fa-fw"></i>
                                        Display Name
                                    </label>
                                    <input class="form-control" type="text" id="name" v-model="user.name"
                                            placeholder="Enter Display Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope fa-fw"></i>
                                        Email
                                    </label>
                                    <input class="form-control" type="email" id="email" v-model="user.email"
                                            placeholder="Enter Email Address" required>
                                </div>

                                <div class="form-group">
                                    <label for="cren">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        Password
                                    </label>
                                    <input class="form-control" type="password" v-model="user.password"
                                            placeholder="Enter Password" id="cren" required/>
                                </div>

                                 <div class="form-group">
                                    <label id="passwordConfirm">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        Confirm Password
                                    </label>
                                    <input class="form-control" type="password" v-model="user.confirm_password"
                                            placeholder="Enter Confirm Password" id="passwordConfirm" required/>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" @click="visiblePassword()"> Check to show password
                                </div>

                                <button class="btn btn-block btn-primary" type="submit" style="color:white">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login
                                </button>

                                <p class="small" style="margin-top:20px">
                                    By clicking “Sign up”, you agree to our terms of service, privacy policy and cookie policy
                                </p>

                              </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </div>
</template>

<script>
    export default {
        data () {
            return {
               user:{
                   id:'',
                   name:'',
                   email:'',
                   password:'',
                   confirm_password:'',
               }
            }
        },

        methods: {

             visiblePassword(){
                 let x = document.getElementById("cren");
                 let y = document.getElementById("passwordConfirm");
                if (x.type === "password" || y.type === "password") {
                    x.type = "text";
                    y.type = "text";
                } else {
                    x.type = "password";
                    y.type = "password";
                }
            },


            clearField() {
                this.user.name = "";
                this.user.email = "";
                this.user.password = "";
                this.user.confirm_password = "";
            },


            submitForm(){
                const form = new FormData();

                form.append("name", this.user.name);
                form.append("email", this.user.email);
                form.append("password", this.user.password)
                form.append("confirm_password", this.user.confirm_password);

                axios.post('/signup', form)
                .then((res) => {

                    Toast.fire("Success :"," Account Verified Successfully","success");

                    if(res.data === "user"){
                        setTimeout(()=>{
                            window.location.href = '/dashboard';
                        }, 1000);
                    }

                 }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :", error.response.data.error, "warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                });
            }

        },

        created() {
           this.clearField();
        }
    }
</script>

<style scoped lang="scss">


</style>
