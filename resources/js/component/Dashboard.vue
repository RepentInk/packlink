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
                        <home-component :userinfo="userinfo"></home-component>
                    </div>

                    <div id="profile" class="container tab-pane fade"><br>
                       <user-profile-component :userinfo="userinfo"></user-profile-component>
                    </div>

                    <div id="add_package" class="container tab-pane fade"><br>
                        <user-package-component></user-package-component>
                    </div>

                    <div id="package_user" class="container tab-pane fade"><br>
                        <user-component></user-component>
                    </div>

                </div>


             </div>


        </div>

      </div>

</template>
<script>
export default {
    props:['userinfo'],
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

.nav-item {
    font-size: 13px;
}

</style>

