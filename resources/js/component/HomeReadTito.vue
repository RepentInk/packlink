<template>
    <div>

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <form class="form">
                    <div class="form-group">
                        <v-select v-model="tutorial.lang_id"
                        :options="allLanguage"
                        label="name"
                        @input="searchTutorial"
                        :reduce="allLanguage => allLanguage.id"
                        placeholder="Search by programming language"></v-select>
                    </div>
                </form>
            </div>

             <div class="col-xl-12 col-lg-12">
                <div>
                    <div class="form-group float-left">
                        <select class="form-select" v-model="length" @change="getReadTutorials()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                        </select>
                    </div>
                    <div class="form-group float-right">
                        <input type="text" class="form-control" v-model="search" placeholder="Search..." />
                    </div>
                </div>

                <div class="table-responsive">

                <vue-loading :active.sync="tableLoading" :can-cancel="true" :is-full-page="false"></vue-loading>

                <table class="table table-striped">
                    <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Written By</th>
                    <th class="text-center">Rate</th>
                    <th class="text-center">Raters</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">View</th>
                    </thead>
                    <tbody>
                    <tr v-for="(read, index) in filteredReadTito" :key="index">
                        <td>{{ index += 1 }}</td>
                        <td>{{ read.title | upperCase | reduceText(30, '...')}}</td>
                        <td>{{ read.name }}</td>
                        <td class="text-center" style="color:blue">
                            <span v-if="read.rate !== null">
                                <b style="color:blue;">{{ total = parseFloat((read.rate / read.totalraters).toFixed(1)) }}</b>
                                <star-rating
                                :inline="true"
                                :read-only="true"
                                :star-size="12"
                                :max-rating="5.0"
                                :show-rating="false"
                                v-model="total"
                                :increment="0.1"
                                active-color="#F48024"></star-rating>
                            </span>

                            <span v-else>
                                <b style="color:blue;">{{ totalRate = 0 }}</b>
                                <star-rating
                                :inline="true"
                                :read-only="true"
                                :star-size="12"
                                :max-rating="5.0"
                                :show-rating="false"
                                v-model="totalRate"
                                :increment="0.1"
                                active-color="#F48024"></star-rating>
                            </span>
                        </td>
                        <td class="text-center">
                        <span>
                            <b style="color:#F6B01E; font-size:12px">{{ read.totalraters }}</b>
                        </span>
                        </td>
                        <td class="text-center">
                           <a :href="read.url" target="_blank" class="link">visit</a>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btnEdit btn-sm" @click.prevent="viewDetails(read)" title="Click to view">
                                <i class="fas fa-eye text-success"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!-- navigation -->
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-md justify-content-center">
                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item">
                <a
                    href="#"
                    class="page-link"
                    @click.prevent="getVideoTutorials(pagination.prev_page_url)"
                >
                    <b>Previous</b>
                </a>
                </li>

                <li class="page-item disabled">
                <a class="page-link text-dark" href="#">
                    Page
                    <b>{{ pagination.current_page }}</b> of
                    <b>{{ pagination.last_page }}</b>
                </a>
                </li>

                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                <a href="#" class="page-link"
                    @click.prevent="getVideoTutorials(pagination.next_page_url)">
                    <b>Next</b>
                </a>
                </li>

                <li class="page-item disabled sm-hidden xs-hidden">
                <a class="page-link text-dark" href="#">
                    From
                    <b>{{ pagination.from_page }}</b> to
                    <b>{{ pagination.to_page }}</b> out of
                    <b>{{ pagination.total_page }}</b>
                </a>
                </li>
            </ul>
        </nav>

        <div class="modal fade" id="viewReadDetails" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" style="text-align:center">Tutorial Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                   <vue-loading :active.sync="viewLoading"
                        :can-cancel="true"
                        :is-full-page="false">
                   </vue-loading>

                   <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody class="viewDetails">
                            <tr>
                                <th>Title</th>
                                <td>{{ tutorial.title }}</td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td>{{ tutorial.name }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>
                                <a :href="tutorial.url"
                                    target="_blank"
                                    class="link"
                                    title="Click to visit website">{{ tutorial.url }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:220px">Programming Language</th>
                                <td>{{ tutorial.lang_name }}</td>
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
                                        active-color="#F48024"></star-rating>
                                    <b style="color:blue;font-size:15px">
                                       <sub>raters : {{ totalUsers }}</sub>
                                    </b>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Rate Tutorial</th>
                                <td>
                                <star-rating
                                    id="rate"
                                    :title="tooltipText"
                                    :increment="1"
                                    :max-rating="5.0"
                                    active-color="#F48024"
                                    :star-size="20"
                                    :show-rating="false"
                                    v-model="rating"
                                    @current-rating="showText"
                                    @rating-selected="setRating"></star-rating>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>
                                   <p v-html="tutorial.description"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   </div>

                   <div class="comment">
                        <a href @click.prevent="viewComment()" :class="{ active: viewcomment }">
                            <span class="badge badge-secondary">{{ allTitoComment.length }}</span>
                            comments
                        </a>

                        <a href @click.prevent="addReadComment()" :class="{ active: addcomment }">
                            <i class="fas fa-comment"></i>
                            add comment
                        </a>
                   </div>


                  <div class="footer">
                    <div class="viewcomment" v-show="viewcomment">
                        <table class="table" style="font-size:12px">
                        <tbody>
                            <tr v-show="allTitoComment.length > 0" v-for="(com, index) in allTitoComment" :key="index">
                                <td width="35px">
                                    <img class="avatar" :src="'/image/user/' + com.profile " alt="profile" width="30px" height="30px"/>
                                </td>
                                <td>
                                    {{ com.comment | upperCase }} | <a class="commenter">{{ com.nickname | upperCase }}</a>
                                    <span>{{ com.created_at | dateTime }}</span>
                                </td>
                            </tr>
                            <tr v-show="allTitoComment.length <= 0">
                            <td colspan="2" class="text-center">No comments on tutorial</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>

                    <div class="viewcomment" v-show="addcomment">
                        <form class="form" @submit.prevent="sendComment()">
                        <div class="form-group" style="padding-top: 10px;">
                            <label for="comment">
                              <i class="fas fa-comment"></i> Comment
                            </label>
                            <textarea
                            class="form-control"
                            id="comment"
                            cols="10"
                            rows="3"
                            minlength="10"
                            v-model="comment.comment"
                            placeholder="Comment on this package"
                            style="resize:none"
                            ></textarea>
                        </div>

                        <button
                            class="btn btn-block btn-sm btnaddcomment"
                            type="submit"
                            style="color:white">
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

    </div>
</template>

<script>
import VueLoading from "vue-loading-overlay/src/js/Component";
import "vue-select/dist/vue-select.css";
import Con from "../service/PackageController";
export default {
   components: {
     VueLoading,
   },
   props: ["auth"],
   data() {
       return {
            allLanguage: [],
            allReadTito: [],
            allTitoComment: [],
            user: {},

            tutorial: {
                id: '',
                lang_id: '',
                type: 'read',
                name: '',
                title: '',
                description: '',
                url: '',
                lang_name: '',
            },

            comment: {
                id: '',
                tito_id: '',
                comment: '',
                type: 'r',
            },

            tableLoading: false,
            viewLoading: false,
            pagination: {},

            viewcomment: false,
            addcomment: true,

            search: '',
            length: 10,
            totalRate: 0,
            rating: 0,
            totalRating: 0,
            totalUsers: 0,
            tooltipText: 'Go',
       }
   },

    methods: {
            // Comment functions goes here
            viewComment(){
                this.addcomment = false;
                this.viewcomment = true;
            },

            addReadComment(){
                this.viewcomment = false;
                this.addcomment = true;
            },

            async sendComment(){
                Con.saveComments(this.tutorial.id, this.comment.comment, this.comment.type)
                .then((res) => {

                    this.comment.comment = "";
                    this.viewComment();
                    this.getTitoComments(this.tutorial.id, this.comment.type);

                }).catch((error) => {

                    if(error.response.status === 402){
                        Swal.fire("Failed :", error.response.data.error, "warning");
                    } else {
                        let keys = Object.keys(error.response.data.error);
                        Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                    }

                });

            },

            async getTitoComments(id, type){
                this.allTitoComment = [];
                Con.getComments(id, type)
                .then((res) => {
                    this.allTitoComment = res.data;
                }).catch(() => {
                    Swal.fire('Failed :','Getting all pack comment failed','warning');
                });
            },

            // rating functions
            showText(rating) {
                this.tooltipText = "";
                this.rating = rating;
                if (this.rating === 1) {
                    this.tooltipText = "Did not like it";
                } else if (this.rating === 2) {
                    this.tooltipText = "It was ok";
                } else if (this.rating === 3) {
                    this.tooltipText = "Liked it";
                } else if (this.rating === 4) {
                    this.tooltipText = "Really like it";
                } else {
                    this.tooltipText = "It was amazing";
                }
            },

            async setRating(rating) {
                if (this.rate_state === 1) {
                    Swal.fire("Sorry !", "You have already rated this tutorial", "warning");
                } else {
                    this.rating = rating;
                    Con.saveTitoRatings(this.tutorial.id, this.rating, this.comment.type)
                    .then((res) => {
                        this.getRating(res.data.tito_id, res.data.type);
                        this.getAuthTitoRating(this.users.id, this.tutorial.id,this.comment.type);
                        this.getReadTuto();
                    })
                    .catch((error) => {
                        Swal.fire("Failed :" + error.response.data.error, "warning");
                    })
                    .finally(() => {
                        Toast.fire("Success :", "Thanks for rating tutorial", "success");
                    });
                }
            },

            async getRating(id, type) {
                Con.getTitoRatings(id, type)
                    .then((res) => {
                    let myData = res.data;
                    this.totalUsers = myData.length;
                    let sum = 0;

                    myData.forEach((rate) => {
                        sum += parseFloat(rate.rating);
                    });

                    let avg = sum / myData.length;
                    if (avg > 0) {
                        this.totalRating = parseFloat(avg.toFixed(1));
                    } else {
                        this.totalRating = 0;
                    }
                }).catch(() => {
                   Swal.fire("Failed :", "Getting all rating failed", "warning");
                });
            },

            async getAuthTitoRating(user_id, tito_id, type) {
                this.rate_state = "";
                Con.getAuthUserTitoRate(user_id, tito_id, type)
                .then((res) => {
                    this.rate_state = res.data;
                }).catch(() => {
                    Swal.fire("Failed :", "Getting all auth rating failed", "warning");
                });
            },

            // Getting read tutorial details
            async getALang() {
                Con.getLanguage()
                .then((res) => {
                    this.allLanguage = res.data;
                }).catch(() => {
                    Swal.fire("Failed :", "Getting all language failed", "warning");
                });
            },

            async getReadTuto(page_url) {
                // this.tableLoading = true;
                page_url = page_url || '/get/all/tutorial/' + this.length + '/' + this.tutorial.type;
                axios.get(page_url)
                .then(res => {
                    this.allReadTito = res.data.data;
                    this.makePagination(res.data);
                }).catch((error) => {
                    Swal.fire("Failed :", "Getting all video tutorial failed", "warning");
                }).finally(() => {
                    this.tableLoading = false;
                });
            },

            async searchReadTuto(id) {
                this.tableLoading = true;
                axios.get('/get/search/tito/' + id + '/' + this.length + '/' + this.tutorial.type)
                .then((res) => {
                    this.allReadTito = res.data.data;
                    this.makePagination(res.data);
                }).catch((err) => {
                    Swal.fire("Failed :", "Getting search tutorial failed", "warning");
                }).finally(() => {
                    this.tableLoading = false;
                });
            },

            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url,
                    from_page: res.from,
                    to_page: res.to,
                    total_page: res.total,
                };
                this.pagination = pagination;
            },

            async searchTutorial() {
                if (this.tutorial.lang_id) {
                    this.searchReadTuto(this.tutorial.lang_id);
                } else {
                    this.getReadTuto();
                }
            },

            openTitoModal() {
               $("#viewReadDetails").modal("show");
            },

            async viewDetails(tito) {
                this.viewLoading = true;
                this.tutorial.id = tito.id;
                this.tutorial.name = tito.name;
                this.tutorial.title = tito.title;
                this.tutorial.description = tito.description;
                this.tutorial.url = tito.url;
                this.tutorial.lang_name = tito.langname;
                this.getRating(tito.id, this.comment.type);
                this.getTitoComments(tito.id, this.comment.type);
                this.getAuthTitoRating(this.users.id, tito.id,this.comment.type);
                this.openTitoModal();
                this.viewLoading = false;
            },

    },

    mounted() {
        this.getReadTuto();
        this.getALang();
        this.users = JSON.parse(this.auth);
    },

    computed: {
        filteredReadTito() {
            let titoRead = this.allReadTito;
            if (this.search) {
                titoRead = titoRead.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return (String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1);
                    });
                })
            }
            return titoRead;
        },
    },

}
</script>

<style scoped>

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

thead th {
    font-size: 13px;
}

tbody td {
    font-size: 13px;
}

.viewDetails tr th {
    font-size: 13px;
}

</style>

