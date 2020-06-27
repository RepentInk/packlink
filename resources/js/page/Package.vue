<template>
   <div>

       <div class="container">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#package">
                    Packages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tutorial">
                    Tutorials (Video / Reading)
                </a>
            </li>
          </ul>
          <div class="col-lg-12 col-md-12">
            <div class="tab-content">
                <div id="package" class="tab-pane active">
                   <add-package-component></add-package-component>
                </div>
                <div id="tutorial" class="tab-pane fade" style="width:100%">
                   <add-tutorial-component></add-tutorial-component>
                </div>
            </div>
           </div>
       </div>

   </div>
</template>
<script>
  import AddPackageComponent from '../component/AddPackage';
  import AddTutorialComponent from '../component/AddTutorial';
  export default {
    components: {
        AddPackageComponent,
        AddTutorialComponent,
    }
  }
</script>

