<template>
   <div>
        <h3>Packages Collections </h3><hr>

        <div class="row">

            <div class="col-xl-12 col-lg-12">
                <form class="form">

                        <div class="form-group">
                        <v-select v-model="pack.cat_id"
                                :options="allCategory"
                                label="name"
                                @input="searchPackage"
                                :reduce="allCategory => allCategory.id"
                                placeholder="Search by package category">
                        </v-select>
                        </div>

                </form>

            </div>

            <div class="col-xl-12 col-lg-12">

            <div>
                <div class="form-group float-left">
                    <select class="form-select" v-model="length" @input="resetPagination()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
                <div class="form-group float-right">
                    <input type="text" class="form-control" v-model="search" @input="resetPagination()"
                        placeholder="Search by package name">
                </div>
            </div>

                <vue-loading :active.sync="tableLoading"
                            :can-cancel="true"
                            :is-full-page="false">
                </vue-loading>

                <div class="table-responsive">

                    <table class="table table-striped" v-if="allPackage">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Command</th>
                                <th class="text-center">Rate</th>
                                <th class="text-center">Raters</th>
                                <th class="text-center">Link</th>
                                <th class="text-center">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="allPackage.length > 0" v-for="(pack,index) in paginated" :key="pack.id">
                                <td>{{ index += 1}}</td>
                                <td>{{ pack.name | upperCase | reduceText(30, '...')}} </td>
                                <td><pre>{{ pack.command | reduceText(25, '...')}}</pre></td>
                                <td class="text-center" style="color:blue">

                                    <span v-if="pack.rate !== null">
                                        <b style="color:blue;">
                                            {{ total = parseFloat((pack.rate / pack.totalraters).toFixed(1)) }}
                                        </b>
                                        <star-rating
                                            :inline="true"
                                            :read-only="true"
                                            :star-size="12"
                                            :max-rating="5.0"
                                            :show-rating="false"
                                            v-model="total"
                                            :increment="0.1"
                                            active-color="#F48024">
                                        </star-rating>
                                    </span>


                                    <span v-else>
                                        <b style="color:blue;">
                                            {{ total = 0 }}
                                        </b>
                                        <star-rating
                                            :inline="true"
                                            :read-only="true"
                                            :star-size="12"
                                            :max-rating="5.0"
                                            :show-rating="false"
                                            v-model="total"
                                            :increment="0.1"
                                            active-color="#F48024">
                                        </star-rating>
                                    </span>

                                </td>
                                <td class="text-center">
                                    <span>
                                        <b style="color:#F6B01E; font-size:12px">
                                            {{  pack.totalraters }}
                                        </b>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a :href="pack.link" target="_blank" class="link">
                                        visit
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="" class="btnEdit" @click.prevent="viewPackDetails(pack)"
                                    title="Click to view">
                                        <i class="fas fa-eye text-success"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr v-show="allPackage.length <= 0">
                                <td colspan="7" class="text-center">
                                    Sorry! No results found
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

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

        <!-- Model view package starts here -->
       <div class="modal fade" id="viewPackageDetails" tabindex="-1" role="dialog"
         data-backdrop="static" data-keyboard="false" aria-hidden="true">

         <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" style="text-align:center">
                        Package Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-striped">

                        <tbody>
                            <tr>
                                <th>Package Name</th>
                                <td>{{ pack.name }}</td>
                            </tr>
                            <tr>
                                <th>Install Command</th>
                                <td><pre>{{ pack.command }}</pre></td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>
                                    <a :href="pack.link" target="_blank" class="link" title="Click to visit website">
                                    {{ pack.link }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ pack.cat_name }}</td>
                            </tr>
                            <tr>
                                <th>Install Medium</th>
                                <td>
                                    <span class="myBtn" v-for="install in allPackInstall" :key="install.id">
                                        {{ install.name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:220px">Programming Language</th>
                                <td>
                                    <span class="myBtn" v-for="lang in allPackLang" :key="lang.id">
                                        {{ lang.name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Rate Status</th>
                                <td>
                                    <span>
                                    <b style="color:blue;font-size:25px">
                                        <sub>{{ totalRating }}</sub>
                                    </b>
                                    <star-rating
                                        :inline="true"
                                        :read-only="true"
                                        :star-size="20"
                                        :max-rating="5.0"
                                        :show-rating="false"
                                        v-model="totalRating"
                                        :increment="0.1"
                                        active-color="#F48024">
                                    </star-rating>
                                    <b style="color:blue;font-size:15px">
                                        <sub> raters : {{ totalUsers }}</sub>
                                    </b>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Rate Package</th>
                                <td>
                                    <star-rating id="rate"
                                        :title="tooltipText"
                                        :increment="1"
                                        :max-rating="5.0"
                                        active-color="#F48024"
                                        :star-size="20"
                                        :show-rating="false"
                                        v-model="rating"
                                        @current-rating="showText"
                                        @rating-selected="setRating">
                                    </star-rating>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>
                                    <p v-html="pack.description"></p>
                                </td>
                            </tr>
                            <tr>
                                <th>Simple Procedure</th>
                                <td>
                                    <p v-html="pack.procedure"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="comment">

                        <a href="" @click.prevent="viewComment()" :class="{ active: viewcomment }">
                            <span class="badge badge-secondary">{{ allPackComment.length }}</span>
                            comments
                        </a>

                        <a href="" @click.prevent="addComment()" :class="{ active: addcomment }">
                            <i class="fas fa-comment"></i>
                            add comment
                        </a>
                    </div>

                    <div class="footer">

                        <div class="viewcomment" v-show="viewcomment">

                            <table class="table" style="font-size:12px">
                                <tbody>
                                    <tr v-show="allPackComment.length > 0" v-for="(com, index) in allPackComment" :key="index">
                                        <td>
                                                <img class="avatar" :src="'/image/user/' + com.profile " alt="profile" width="40px" height="40px">
                                        </td>
                                        <td>
                                            {{ com.comment | upperCase }}
                                            | <a class="commenter">{{  com.nickname | upperCase }}</a>
                                                <span> {{ com.created_at | dateTime }}</span>
                                        </td>
                                    </tr>
                                    <tr v-show="allPackComment.length <= 0">
                                        <td colspan="2" class="text-center">No comments on package</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="viewcomment" v-show="addcomment">

                            <form class="form" @submit.prevent="sendComment()">

                                <div class="form-group" style="padding-top: 10px;">
                                    <label for="comment">
                                        <i class="fas fa-comment"></i>
                                        Comment
                                    </label>
                                    <textarea class="form-control" id="comment" cols="10" rows="3" minlength="10" v-model="comment.comment"
                                    placeholder="Comment on this package" style="resize:none"></textarea>
                                </div>

                                <button class="btn btn-block btn-sm btnaddcomment" type="submit" style="color:white">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Comment
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

             </div>

           </div>
        </div>
        <!-- end view package details -->

   </div>

</template>
<script>
  import VueLoading from "vue-loading-overlay/src/js/Component";
  import 'vue-select/dist/vue-select.css';
  export default {
      components : {
        VueLoading,
      },
      props:['userinfo'],
      data(){
          return {
            allPackage:[],
            allPackLang:[],
            allPackInstall:[],
            allPackComment:[],
            allCategory:[],
            users:[],
            pack: {
                id:'',
                name:'',
                link:'',
                command:'',
                description:'',
                procedure:'',
                cat_id:'',
                cat_name:'',
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
            comment:{
                id:'',
                pack_id:'',
                comment:'',
            },
            search:'',
            length:20,
            tableLoading:false,
            rating:0,
            totalRating:0,
            totalUsers:0,
            tooltipText:'Go',
            viewcomment:false,
            addcomment:true,
            rate_state:'',
          }
      },

      methods: {


        /**
         * Comment functions goes here
        */

        viewComment(){
          this.addcomment = false;
          this.viewcomment = true;
        },

        addComment(){
          this.viewcomment = false;
          this.addcomment = true;
        },

        sendComment(){
            let comment = new FormData();

            comment.append('pack_id', this.pack.id);
            comment.append('comment', this.comment.comment);

            axios.post('/post/comment', comment)
            .then((res) => {
               this.comment.comment = "";
               this.viewComment();
               this.getPackageComments(this.pack.id);
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :", error.response.data.error, "warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            });

        },

        getPackageComments(id){
            this.allPackComment = [];
            axios.get('/get/comment/' + id)
            .then((res) => {
                this.allPackComment = res.data;
            }).catch(() => {
                Swal.fire('Failed :','Getting all pack comment failed','warning');
            });
        },



       /**
        * End comment functions
       */


        /**
         * Rating functions start
        */

        showText(rating) {
            this.tooltipText = "";
            this.rating = rating;
            if(this.rating === 1){
                this.tooltipText = "Did not like it";
            } else if(this.rating === 2){
                this.tooltipText = "It was ok";
            } else if(this.rating === 3){
                this.tooltipText = "Liked it";
            } else if(this.rating === 4){
                this.tooltipText = "Really like it";
            }  else {
                this.tooltipText = "It was amazing";
            }
        },

        setRating(rating) {
            if(this.rate_state === 1){
              Swal.fire('Sorry !', 'You have already rated this package','warning');
            } else {

                this.rating = rating;
                let form = new FormData();

                form.append('pack_id', this.pack.id);
                form.append('rating', this.rating);

                axios.post('/post/rating', form)
                .then((res) => {
                    this.getRating(res.data.pack_id);
                    this.getAuthRating(this.users.id, this.pack.id)
                    this.getPackage();
                }).catch((error) => {
                    Swal.fire("Failed :" + error.response.data.error,'warning');
                }).finally(() => {
                    Toast.fire("Success :","Thanks for rating package","success")
                });

            }
        },

        getRating(id) {
            axios.get('/get/rating/' + id)
            .then((res) => {
                let myData = res.data;
                this.totalUsers = myData.length;
                let sum = 0;

                myData.forEach((rate) => {
                    sum += parseFloat(rate.rating);
                });

                let avg = sum/myData.length;
                if(avg > 0){
                   this.totalRating = parseFloat(avg.toFixed(1));
                } else {
                    this.totalRating = 0;
                }

            }).catch(() => {
                Swal.fire('Failed :','Getting all book failed','warning');
            });
        },

        getAuthRating(user_id, pack_id){
            this.rate_state = '';
            axios.get('/get/auth/rater/' + user_id + '/' + pack_id)
            .then((res) => {
                this.rate_state = res.data;
            }).catch(() => {
                Swal.fire('Failed :','Getting all book failed','warning');
            });
        },

        /**
         * Package function starts here
         * */

        openModal(){
            $("#viewPackageDetails").modal('show');
        },

        viewPackDetails(pack){
            this.isLoading = true;

            this.pack.id = pack.id;
            this.pack.name = pack.name;
            this.pack.link = pack.link;
            this.pack.command = pack.command;
            this.pack.description = pack.description;
            this.pack.procedure = pack.procedure;
            this.pack.cat_name = pack.catname;
            this.getPackLang(pack.id);
            this.getPackInstall(pack.id);
            this.getRating(pack.id);
            this.getPackageComments(pack.id);
            this.getAuthRating(this.users.id, pack.id)
            this.openModal();
        },

        searchPackage(){
           if(this.pack.cat_id) {
              this.getSearchPackage(this.pack.cat_id);
           } else {
              this.getPackage();
           }
        },

        getCategory(){
            axios.get('/get/category')
            .then((response) => {
                this.allCategory = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all category failed','warning');
            });
        },

        getPackLang(id){
            this.allPackLang = [];
            axios.get('/get/pack/lang/' + id)
            .then((res) => {
               this.allPackLang = res.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all package language failed','warning');
            });
        },

        getPackInstall(id){
            this.allPackInstall = [];
            axios.get('/get/pack/install/' + id)
            .then((res) => {
                this.allPackInstall = res.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all package installation failed','warning');
            });
        },

        getSearchPackage(id){
            this.allPackage = [];
            axios.get('/get/pack/search/' + id)
            .then((response) => {
                this.tableLoading = true;
                this.allPackage = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all packages failed','warning');
            }).finally(() => {
                this.tableLoading = false;
            });
        },

        getPackage(){
            const config = {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json;charset=UTF-8'
                },
            };

            axios.get('/get/package', config)
            .then((response) => {
                this.tableLoading = true;
                this.allPackage = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all packages failed','warning');
            }).finally(() => {
                this.tableLoading = false;
            });
        },


        /**
         * Package functions ends here
        */





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
          this.getPackage();
          this.getCategory();
          this.users = JSON.parse(this.userinfo);
      },

      computed:{

        filteredPackage(){
            let thepackage = this.allPackage;
            if(this.search){
                thepackage = thepackage.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                })
            }
            return thepackage;
        },

        paginated(){
            return this.paginate(this.filteredPackage, this.length, this.pagination.currentPage);
        },

      },
  }
</script>

<style lang="scss" scoped>

select {
   color: black !important;
}

.form-select {
    font-size: 1rem;
    height: 50px;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 2px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.link{
  color: #051be2;
}

.myBtn {
    border-radius: 2px;
    padding: 5px;
    margin-left:5px;
    border: 1px solid #969696;
}


.comment .active {
   color: #F48024;
}

.comment a {
    text-decoration: none;
    color: #969696;
    margin-right: 20px;
}

.comment a:hover {
   color: #F48024;
}

.footer {
    margin-top: 10px;
    border-top: 1px solid gray;
}

.btnaddcomment {
    background-color: rgb(180, 177, 177);
    border-radius: 5px;
}

.btnaddcomment:hover {
    background-color:  #F48024;
}

.commenter {
    color: #0089D8;
    background-color: #E1ECF4;
    padding:5px;
    text-decoration: none;
}

.commenter:hover {
    color:blue;
}

.avatar {
  vertical-align: middle;
  border-radius: 50%;
}


</style>
