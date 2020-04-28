<template>
    <div>
        <h3>All Users</h3>

        <div class="row">
            <table class="table" style="font-size:12px">
                <tbody>
                    <tr v-show="allUsers.length > 0" v-for="(user, index) in paginated" :key="index">
                        <td width="60px">
                            <img class="avatar" :src="user.profile" alt="Profile" width="40px" height="40px">
                        </td>
                        <td>
                            <a href="" class="commenter" @click.prevent="showMyUser(user)">
                                {{  user.nickname | upperCase }}
                            </a> <br>
                            <span> {{ user.title }}</span>
                        </td>
                    </tr>
                    <tr v-show="allUsers.length <= 0">
                        <td colspan="2" class="text-center">No Users Yet</td>
                    </tr>
                </tbody>
            </table>

            <nav class="myNav text-center" aria-label="Page navigation">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prevPage }]" class="active">
                        <a href="#" class="page-link" @click.prevent="substraction()">
                            <b>Previous</b>
                        </a>
                    </li>

                    <li class="page-item disabled">
                        <a class="page-link " href="#" style="color: black">
                            Page
                            <b>{{ pagination.currentPage }}</b>
                            of
                            <b>{{ pagination.page }}</b>
                        </a>
                    </li>

                    <li v-bind:class="[{disabled: !pagination.nextPage }]" class="active">
                        <a href="#" class="page-link" @click.prevent="addition()">
                            <b>Next</b>
                        </a>
                    </li>

                    <li class="page-item disabled">
                        <a class="page-link" href="#" style="color: black"> From
                            <b>{{ pagination.from}}</b> to
                            <b>{{ pagination.to}}</b> out of
                            <b>{{ pagination.total }}</b>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

         <!-- Model for Adding starts her -->
        <div class="modal fade" id="viewDetailModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align:center">
                            <b>PROFILE DETAILS</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                               <img :src="authuser.profile" class="img img-thumbnail" style="height:170px; width:150px" alt="profile">
                            </div>

                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7">

                               <table class="table table-striped">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ authuser.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nickname</th>
                                        <td>{{ authuser.nickname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ authuser.title }}</td>
                                    </tr>
                                </table>

                            </div>

                        </div>

                        <div class="row" style="margin-top:20px">
                             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <p v-html="authuser.about"></p>
                             </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!-- End of model -->

    </div>
</template>
<script>
export default {
    data(){
        return {
           allUsers:[],
           authuser:{
                id:'',
                nickname:'',
                name:'',
                email:'',
                profile:'',
                title:'',
                location:'',
                about:'',
           },
           pagination:{
                currentPage:1,
                nextPage:'',
                prevPage:'',
                total:'',
                from:'',
                to:'',
                page:'',
           },
           length:20,
        }
    },

    methods: {

        /**
         * Users
        */
        getAllUsers(){
            axios.get('/get/users')
            .then((response) => {
                this.allUsers = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all users failed','warning');
            });
        },

        showMySelected(){
            $("#viewDetailModel").modal('show');
        },

        showMyUser(user){
           this.authuser.id = user.id;
           this.authuser.name = user.name;
           this.authuser.email = user.email;
           this.authuser.nickname = user.nickname;
           this.authuser.title = user.title;
           this.authuser.location = user.location;
           this.authuser.about = user.about;
           this.authuser.profile = user.profile;

           this.showMySelected();
        },

        /**
        * Pagination starts
        */

        substraction(){
            if(this.pagination.currentPage <=  1){
                Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
            } else {
                --this.pagination.currentPage;
            }
        },

        addition(){
            if(this.pagination.currentPage == this.pagination.page){
                Toast.fire('Page Limit :', 'Sorry cant go further', 'warning');
            } else {
                ++this.pagination.currentPage;
            }
        },

        paginate(array, length, pageNumber){
            this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
            this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
            this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
            this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
            this.pagination.page = Math.ceil(array.length / length);
            this.pagination.total = array.length;

            return array.slice((pageNumber - 1) * length, pageNumber * length);
        },

        resetPagination(){
            this.pagination.currentPage  = 1;
            this.pagination.prevPage = '';
            this.pagination.nextPage = '';
        },

    },

    mounted(){
        this.getAllUsers();
    },

    computed: {

        filteredUser() {
            let user = this.allUsers;
            if(this.search){
                user = user.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                })
            }
            return user;
        },

        paginated(){
            return this.paginate(this.filteredUser, this.length, this.pagination.currentPage);
        },

    },

}
</script>

<style lang="scss" scoped>

.avatar{
    border-radius: 50%;
}

.commenter {
    color: #0089D8;
    background-color: #E1ECF4;
    padding:5px;
    text-decoration: none;
}

</style>
