<template>
      <div class="container">

          <div class="row">

             <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3">
                 <ul class="nav nav-tabs flex-column" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#home">
                         <i class="fas fa-home"></i>
                          Home
                      </a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#profile">
                          <i class="fas fa-user"></i>
                           Profile
                        </a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#add_package">
                          <i class="fas fa-plus"></i>
                           Add
                       </a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" data-toggle="tab" href="#package_user">
                         <i class="fas fa-users"></i>
                           Users
                       </a>
                    </li>
                </ul>

             </div>

             <div class="col-xl-10 col-lg-10 col-md-10 col-sm-9">

                 <!-- Tab panes -->
                <div class="tab-content">

                    <div id="home" class="container tab-pane active mb-5"><br>

                        <h3>Packages Collections</h3><hr>

                        <div class="ro">

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
                                            <th class="text-center">Website</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="allPackage.length > 0" v-for="(pack,index) in paginated" :key="pack.id">
                                                <td>{{ index += 1}}</td>
                                                <td>{{ pack.name | upperCase }} </td>
                                                <td><pre>{{ pack.command }}</pre></td>
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



                    </div>


                    <div id="profile" class="container tab-pane fade"><br>
                        <h3>Profile</h3> <hr>
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


                    <div id="add_package" class="container tab-pane fade"><br>
                        <h3>Package</h3><hr>

                        <div class="row">
                           <div class="comment">

                                <a href="" @click.prevent="addPackage()" :class="{ active: addpackage }">
                                   <i class="fas fa-plus"></i>
                                   Add Package
                                </a>

                                <a href="" @click.prevent="viewPackage()" :class="{ active: viewpackage }">
                                    <i class="fas fa-eye"></i>
                                     View Your Package
                                </a>

                           </div>
                        </div> <hr>

                        <div class="row mb-5" v-show="addpackage">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12"></div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">

                                <form @submit.prevent="submitPackageForm()" class="myForm">

                                        <vue-loading :active.sync="packageLoading"
                                                    :can-cancel="true"
                                                    :is-full-page="false">
                                        </vue-loading>

                                        <div class="form-group">
                                            <input class="form-control" v-model="userpack.name" type="text"
                                                placeholder="Enter Package Name" required>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control" v-model="userpack.link" type="url"
                                                placeholder="Enter Package Link or Website eg. https://example.com" required>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control" v-model="userpack.command" type="text"
                                                placeholder="Enter Installation Command eg. npm istall example" required>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                                    <v-select v-model="userpack.cat_name"
                                                        :options="allCategory"
                                                        label="name"
                                                        :reduce="allCategory => allCategory.id"
                                                        placeholder="Select Package Category" required>
                                                    </v-select>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                                   <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                                   title="Click to add new package category" @click.prevent="openCategoryModal()">
                                                       <i class="fas fa-plus"></i>
                                                   </a>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                                     <v-select multiple
                                                        v-model="userpack.install_name"
                                                        :options="allInstallation"
                                                        label="name"
                                                        :reduce="allInstallation => allInstallation.id"
                                                        placeholder="Select Package Installation Mediums"
                                                        @input="showInstall"
                                                        required>
                                                    </v-select>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                                   <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                                   title="Click to add new package installation medium" @click.prevent="openInstallationModal()">
                                                       <i class="fas fa-plus"></i>
                                                   </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                                                     <v-select multiple
                                                        v-model="userpack.lang_name"
                                                        :options="allLanguage"
                                                        label="name"
                                                        :reduce="allLanguage => allLanguage.id"
                                                        placeholder="Select Programming Languages"
                                                        @input="showLang">
                                                    </v-select>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 text-right">
                                                   <a href="" class="btn btn-sm btnaddcomment" style="height:35px;"
                                                   title="Click to add new programming language" @click.prevent="openLanguageModal()">
                                                       <i class="fas fa-plus"></i>
                                                   </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <vue-editor v-model="userpack.description" id="editor" required
                                                        :editorToolbar="maintenance" placeholder="Enter package descriptions">
                                            </vue-editor>
                                        </div>

                                        <div class="form-group">
                                            <vue-editor v-model="userpack.procedure" id="editor" required
                                                        :editorToolbar="maintenance" placeholder="Enter package installation procedure">
                                            </vue-editor>
                                        </div>

                                        <div class="form-group" v-if="addoredit">
                                            <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                                <i class="fas fa-save"></i>
                                                Save Package
                                            </button>
                                        </div>

                                        <div class="form-group" v-else>
                                            <a class="btn btn-block btnaddcomment" href="" @click.prevent="editUserPackageForm()" style="color:white">
                                                <i class="fas fa-edit"></i>
                                                Edit Package
                                            </a>
                                        </div>

                                </form>

                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12"></div>
                        </div>

                        <div class="row mb-5" v-show="viewpackage">

                            <div class="table-responsive">

                                <vue-loading :active.sync="userPackLoading"
                                            :can-cancel="true"
                                            :is-full-page="false">
                                </vue-loading>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Command</th>
                                        <th>Website</th>
                                        <th>Created On</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in allPackageUser" :key="user.id">
                                            <td>{{ index += 1}}</td>
                                            <td>{{ user.name | upperCase }} </td>
                                            <td><pre>{{ user.command }}</pre></td>
                                            <td class="text-center">
                                              <a :href="user.link" style="color:blue" target="_blank">link</a>
                                            </td>
                                            <td>{{ user.created_at | dateOnly }}</td>
                                            <td colspan="2" class="text-center">

                                               <a href="" class="btnEdit" @click.prevent="showUserPackage(user)"
                                                title="Click to view and edit">
                                                   <i class="fas fa-eye text-success"></i>
                                                </a>

                                               <a href="" class="btnDelete" @click.prevent="deleteUserPackage(user.id)"
                                                title="Click to delete">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>

                                            </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                     </div>

                    <div id="package_user" class="container tab-pane fade"><br>
                        <h3>All Users</h3>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                    </div>

                </div>


             </div>



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
                                      <a :href="pack.link" class="link" title="Click to visit website">
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
                                           | <a href="" class="commenter">{{  com.nickname | upperCase }}</a>
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

            <!-- Model for Adding starts her -->
            <div class="modal fade" id="addCategoryModel" tabindex="-1" role="dialog"
                data-backdrop="static" data-keyboard="false" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="text-align:center">
                                    <b>CREATE NEW CATEGORY</b>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="submitCategoryForm()" class="myForm">
                                <div class="modal-body">

                                    <vue-loading :active.sync="catLoading"
                                                :can-cancel="true"
                                                :is-full-page="false">
                                    </vue-loading>

                                    <div class="form-group">
                                        <input class="form-control" v-model="category.name" type="text"
                                            placeholder="Enter Category Name" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                        <i class="fas fa-save"></i>
                                        Save Category
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
            </div>
            <!-- End of model -->


            <!-- Model for Editting starts her -->
            <div class="modal fade" id="addInstallationModel" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align:center">
                                <b>CREATE INSTALLATION MEDIUM</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="submitInstallationForm()" class="myForm">

                            <div class="modal-body">

                                <vue-loading :active.sync="installLoading"
                                            :can-cancel="true"
                                            :is-full-page="false">
                                </vue-loading>

                                <div class="form-group">
                                    <input class="form-control" v-model="installation.name" type="text"
                                        placeholder="Enter Installation Medium">
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                    <i class="fas fa-save"></i>
                                    Save Installation
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of model -->

            <!-- Model for Adding starts her -->
            <div class="modal fade" id="addLanguageModel" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align:center">
                                <b>CREATE LANGUAGE</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="submitLanguageForm()" class="myForm">
                            <div class="modal-body">

                                <vue-loading :active.sync="langLoading"
                                            :can-cancel="true"
                                            :is-full-page="false">
                                </vue-loading>

                                <div class="form-group">
                                    <input class="form-control" v-model="language.name" type="text"
                                        placeholder="Enter New Programming Language Name" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-block btnaddcomment" type="submit" style="color:white">
                                    <i class="fas fa-save"></i>
                                    Save Language
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <!-- End of model -->

        </div>

      </div>

</template>
<script>
import 'vue-select/dist/vue-select.css';
import VueLoading from "vue-loading-overlay/src/js/Component";
import { VueEditor } from "vue2-editor";
export default {
    components : {
        VueLoading,
        VueEditor,
    },
    props:['userinfo'],
    data(){
       return {
           maintenance: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block"],
           ],
           allCategory:[],
           allPackage:[],
           allPackLang:[],
           allPackInstall:[],
           allPackComment:[],
           allCategory:[],
           allInstallation:[],
           allLanguage:[],
           allPackageUser:[],
           allPackUserLang:[],
           allPackUserInstall:[],
           pack:{
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
            userpack : {
                id:'',
                name:'',
                link:'',
                command:'',
                description:'',
                procedure:'',
                lang_id:[],
                install_id:[],
                cat_id:'',
                cat_name:'',
                lang_name:[],
                install_name:[],
            },
            category : {
                id:'',
                name:'',
            },
            installation : {
                id:'',
                name:'',
            },
            language : {
                id:'',
                name:'',
            },
            search:'',
            length:10,
            tableLoading:false,
            isLoading:false,
            profileLoading:false,
            packageLoading:false,
            catLoading:false,
            installLoading:false,
            langLoading:false,
            userPackLoading:false,
            rating:0,
            totalRating:0,
            totalUsers:0,
            tooltipText:'Go',
            viewcomment:false,
            addcomment:true,
            showImage:[],
            addpackage:true,
            viewpackage:false,
            addoredit:true,
       }
    },

    methods: {

        /**
         * Package adding by user
        */
        addPackage(){
           this.addpackage = true;
           this.viewpackage = false;
        },

        viewPackage(){
           this.viewpackage = true;
           this.addpackage = false;
           this.addoredit = true;
           this.clearForm();
        },

        getCategory(){
            axios.get('/get/category')
            .then((response) => {
                this.allCategory = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all category failed','warning');
            });
        },

        getLanguage(){
            axios.get('/get/language')
            .then((response) => {
                this.allLanguage = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all language failed','warning');
            });
        },

        getInstallation(){
            axios.get('/get/installation')
            .then((response) => {
                this.allInstallation = response.data;
            }).catch(() => {
                Swal.fire('Failed :','Loading all installation failed','warning');
            });
        },

        openCategoryModal(){
            $("#addCategoryModel").modal('show');
        },

        submitCategoryForm(){
            this.catLoading = true;
            let form = new FormData();

            form.append('name', this.category.name);

            axios.post('/post/category', form)
            .then(() => {
                Toast.fire("Success :","Category saved successfully","success");
                $("#addCategoryModel").modal('hide');
                this.getCategory();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.catLoading = false;
            });

        },

        openInstallationModal(){
            $("#addInstallationModel").modal('show');
        },

        submitInstallationForm(){
            this.installLoading = true;
            let form = new FormData();

            form.append('name', this.installation.name);

            axios.post('/post/installation', form)
            .then(() => {
                Toast.fire("Success :","Installation saved successfully","success");
                $("#addInstallationModel").modal('hide');
                this.getInstallation();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.installLoading = false;
            });

        },

        openLanguageModal(){
            $("#addLanguageModel").modal('show');
        },

        submitLanguageForm(){
            this.langLoading = true;
            let form = new FormData();

            form.append('name', this.language.name);

            axios.post('/post/language', form)
            .then(() => {
                Toast.fire("Success :","Language saved successfully","success");
                $("#addLanguageModel").modal('hide');
                this.getLanguage();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                this.langLoading = false;
            });

        },

        submitPackageForm(){
            this.isLoading = true;
            let form = new FormData();

            form.append('name', this.userpack.name);
            form.append('link', this.userpack.link);
            form.append('command', this.userpack.command);
            form.append('description', this.userpack.description);
            form.append('procedure', this.userpack.procedure);
            form.append('cat_id', this.userpack.cat_name);

            this.userpack.install_name.forEach(element => {
                form.append('install_id[]', element);
            });

            this.userpack.lang_name.forEach(element => {
                form.append('lang_id[]', element);
            });

            axios.post('/post/package', form)
            .then(() => {
                Toast.fire("Success :","Package saved successfully","success");
                this.clearForm();
                this.viewPackage();
                this.getPackageUser();
                this.getPackage();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            }).finally(() => {
                Fire.$emit('refresh');
                this.isLoading = false;
            });

        },

        editUserPackageForm(){
            let form = new FormData();

            form.append('id', this.userpack.id);
            form.append('name', this.userpack.name);
            form.append('link', this.userpack.link);
            form.append('command', this.userpack.command);
            form.append('description', this.userpack.description);
            form.append('procedure', this.userpack.procedure);
            form.append('cat_id', this.userpack.cat_id);

            this.userpack.install_name.forEach(element => {
                form.append('install_id[]', element);
            });

            this.userpack.lang_name.forEach(element => {
                form.append('lang_id[]', element);
            });


            axios.post('/update/package', form)
            .then(() => {
                Toast.fire("Success :","Package updated successfully", "success");
                this.viewPackage();
                this.getPackageUser();
                this.getPackage();
            }).catch((error) => {

                if(error.response.status === 402){
                    Swal.fire("Failed :",error.response.data.error,"warning");
                } else {
                    let keys = Object.keys(error.response.data.error);
                    Swal.fire("Failed",error.response.data.error[keys[0]][0],"warning");
                }

            });

        },


        getPackageUser(){
            this.userPackLoading = true;
            axios.get('/get/user/package')
            .then((response) => {
                this.allPackageUser = response.data;
                this.userPackLoading = false;
            }).catch(() => {
                Swal.fire('Failed :','Loading all user packages failed','warning');
            });
        },


        clearForm(){
            this.userpack.id = '';
            this.userpack.name = '';
            this.userpack.link = '';
            this.userpack.command = '';
            this.userpack.procedure = '';
            this.userpack.description = '';
            this.userpack.cat_id = '';
            this.userpack.install_id = [];
            this.userpack.lang_id = [];
            this.userpack.cat_name = '';
            this.userpack.lang_name = [];
            this.userpack.install_name = [];
        },

        deleteUserPackage(id) {
           Swal.fire({
                title: 'Are you sure ?',
                text: "Package will be deleted",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.value) {

                    axios.delete('/delete/package/' + id)
                    .then(() => {
                        Toast.fire('Deleting Package!','Package has been deleted','success');
                    }).catch(() => {
                        Swal.fire("Failed","Could not deleted package","warning");
                    }).finally(() => {
                        Fire.$emit('refresh');
                    });

                }
            });
        },

        showUserPackage(user){
            this.userPackLoading = true;
            this.userpack.id = user.id;
            this.userpack.name = user.name;
            this.userpack.link = user.link;
            this.userpack.command = user.command;
            this.userpack.description = user.description;
            this.userpack.procedure = user.procedure;
            this.userpack.cat_id = user.catid;
            this.userpack.cat_name = user.catname;
            this.getPackUserLang(user.id);
            this.getPackUserInstall(user.id);
            this.addPackage();
            this.userPackLoading = false;
            this.addoredit = false;
        },

        getPackUserLang(id){
            this.allPackLang = [];
            this.userpack.lang_id = [];
            this.userpack.lang_name = [];
            axios.get('/get/pack/lang/' + id)
            .then((res) => {

                this.allPackUserLang = res.data;
                this.allPackUserLang.forEach((value) => {
                    this.userpack.lang_id.push(value.id);
                    this.userpack.lang_name.push(value.id);
                });

            }).catch(() => {
                Swal.fire('Failed :','Loading all package language failed','warning');
            });
        },

        getPackUserInstall(id){
            this.allPackUserInstall = [];
            this.userpack.install_id = [];
            this.userpack.install_name = [];
            axios.get('/get/pack/install/' + id)
            .then((res) => {

                this.allPackUserInstall = res.data;
                this.allPackUserInstall.forEach((value) => {
                    this.userpack.install_id.push(value.id);
                    this.userpack.install_name.push(value.id);
                });

            }).catch(() => {
                Swal.fire('Failed :','Loading all package installation failed','warning');
            });
        },

        showInstall(value){
            let diff = this.getDifference(this.userpack.install_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.install_id = [];
            this.userpack.install_id = value;
            axios.delete('/delete/pack/install/' + id)
        },

        showLang(value){
            let diff = this.getDifference(this.userpack.lang_id, value);
            let id = 0;
            diff.forEach(v =>{
                id = v;
            });
            this.userpack.lang_id = [];
            this.userpack.lang_id = value;
            axios.delete('/delete/pack/lang/' + id)
        },


        getDifference(arr1, arr2){
            let difference = arr1.filter(x => !arr2.includes(x));
            return difference;
        },



       /***
        * Package adding by user end
        * /

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
            this.rating = rating;
            let form = new FormData();

            form.append('pack_id', this.pack.id);
            form.append('rating', this.rating);

            axios.post('/post/rating', form)
            .then((res) => {
                this.getRating(res.data.pack_id);
                this.getPackage();
            }).catch((error) => {
                Swal.fire("Failed :" + error.response.error,'warning');
            }).finally(() => {
                Toast.fire("Success :","Thanks for rating package","success")
            });
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

        /**
         * End of rating
        */


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

    created () {

    },

    mounted() {
        this.getCategory();
        this.getPackage();
        this.getCategory();
        this.getLanguage();
        this.getInstallation();
        this.getPackageUser();
        this.user = JSON.parse(this.userinfo);
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

        ratingPack(id){
          let totalrating = 0;
          axios.get('/get/rating/' + id)
            .then((res) => {
                let myData = res.data;
                let sum = 0;
                myData.forEach((rate) => {
                    sum += parseFloat(rate.rating);
                });
                let avg = sum/myData.length;
                if(avg > 0){
                   totalrating = parseFloat(avg.toFixed(1));
                } else {
                   totalrating = 0;
                }
            }).catch(() => {
                Swal.fire('Failed :','Getting all book failed','warning');
            });

            return totalrating
        }

    },


}
</script>

<style lang="scss" scoped>

.flex-column{
  border-right: 1px solid #D6D9DC;
}

.nav-tabs li a:hover {
   background-color: #EFF0F1;
   border-right: 3px solid #F48024;
}

.nav-item .active {
    color: #F48024;
    border-right: 3px solid #F48024;
}

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

