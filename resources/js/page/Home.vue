<template>
   <div>

       <div class="container">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#homePack">
                    Packages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#homeTito">
                    Video Tutorials
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#homeDoc">
                    Reading Documents
                </a>
            </li>
          </ul>
          <div class="col-lg-12 col-md-12">
            <div class="tab-content">
                <div id="homePack" class="pt-4 tab-pane active">
                    <home-pack-component :authuser="userinfo"></home-pack-component>
                </div>
                <div id="homeTito" class="pt-4 tab-pane fade" style="width:100%">
                    <home-video-component :authuser="userinfo"></home-video-component>
                </div>
                <div id="homeDoc" class="pt-4 tab-pane fade" style="width:100%">
                    <home-read-component :auth="userinfo"></home-read-component>
                </div>
            </div>
           </div>
       </div>

   </div>
</template>
<script>
  import HomePackComponent from '../component/HomePackage';
  import HomeVideoComponent from '../component/HomeVideoTito';
  import HomeReadComponent from '../component/HomeReadTito';
  export default {
    props:['userinfo'],
    components: {
        HomePackComponent,
        HomeVideoComponent,
        HomeReadComponent
    }
  }
</script>

