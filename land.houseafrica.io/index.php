<!DOCTYPE html>
<?php 
    include_once 'includes/admin.php';
    $site = new admin;
    $landNo = $site->allLandRows();
    $allLands = $site->getLands('All',0,20);
    $vacant = $site->getLands('Vacant',0,20);
    $allocated = $site->getLands('Allocated',0,20);
    $mapo = json_encode($site->getLandsForMap());

  ?> 
<html lang="en">
  <head>
    <title>LandAfrica — Land Registry on the Blockchain</title>
    <?php include_once 'includes/meta.php'; ?>
    <style type="text/css">
      #map_canvas {
        height: 100%;  /* The height is 400 pixels */
        width: 103%;  /* The width is the width of the web page */
       }
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: lightblue; 
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888; 
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: lightblue; 
        }
        /*@media only screen and (min-height:  880px) {
              #lefty {
                overflow-x: hidden;
                overflow-y: scroll;
                max-height: 400px
          }
        }*/
    </style>
  </head>
  <!-- Modal - Default -->
  <div class="modal fade" id="modal-long" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body" id="detail-map">
          
        </div>
      </div>
    </div>
  </div>
  <body onload="initialize()">
    <main class="main-content">
      <div class="section bg-gray p-0">
        <div class="p-5 mh-fullscreen">
          <div class="row">
            <div class="col-md-5 col-xl-4 pl-0 pr-0">
              <div class="sidebar px-4 py-md-0">
                <?php include_once 'includes/header.php'; ?>
                <hr>

                <form class="form-group input-group input-round" style="border:none!Important;">
                  <input type="text" class="form-control" name="s" placeholder="Search" id="land-search">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="ti-search"></i></span>
                  </div>
                </form>

                <ul class="nav nav-tabs-minimal">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-home-1">All</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-profile-1">Allocated</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-contact-1">Vacant</a>
                  </li>
                </ul>

                <div class="tab-content p-4" id="lefty" style="overflow-x: hidden;overflow-y: auto;  height:calc(100vh - 40px);">
                  <div class="tab-pane fade show active" id="tab-home-1">
                    <?php 
                        if (count($allLands) < 1) {
                           echo '<div class="col-md-12 col-sm-12 col-lg-12">
                                     <center style="opacity: 0.3">
                                         <i class="fa fa-search fa-3x"></i><br><br>
                                         <h5>No result found</h5>
                                     </center>
                                 </div>'; 
                        }else{
                            foreach ($allLands as $key => $all) {
                              $txt = $site->landStatus($all->status);
                            ?>
                                <div class="row tada hover-shadow-2">
                                  <div class="col-2" style="padding-top: 4%">
                                    <?php  
                                      if ($all->land_type == 'Estate') {
                                      ?>
                                        <a href="#" onclick="changeEstateMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-<?php echo $txt; ?>"></i></a>
                                      <?php 
                                      }else{
                                      ?>
                                        <a href="#" onclick="changeMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-<?php echo $txt; ?>"></i></a>
                                      <?php 
                                      }
                                    ?>
                                    <input type="hidden" id="lato-<?php echo $all->id ?>" value="<?php echo $all->lat ?>">
                                    <input type="hidden" id="longo-<?php echo $all->id ?>" value="<?php echo $all->lng ?>">
                                  </div>
                                  <div class="col-8">
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <h5><b><?php echo $all->landId ?></b></h5>
                                    </a>
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <small><?php echo $all->address ?></small>
                                    </a>
                                  </div>
                                  <div class="col-2 text-right" style="padding-top: 4%">
                                    <a href="<?php echo $all->txnLink ?>" target="_blank" data-toggle="tooltip" title="View on Blockchain" class="text-<?php echo $txt; ?> iconbox">
                                      <i class="fa fa-file-o"></i>
                                    </a>
                                  </div>
                                </div>
                            <?php 
                            }
                        }
                     ?>
                  </div>
                  <div class="tab-pane fade" id="tab-profile-1">
                    <?php 
                        if (count($allocated) < 1) {
                           echo '<div class="col-md-12 col-sm-12 col-lg-12">
                                     <center style="opacity: 0.3">
                                         <i class="fa fa-search fa-3x"></i><br><br>
                                         <h5>No result found</h5>
                                     </center>
                                 </div>'; 
                        }else{
                            foreach ($allocated as $key => $all) {
                            ?>
                                <div class="row tada hover-shadow-2">
                                  <div class="col-2" style="padding-top: 4%">
                                    <?php  
                                      if ($all->land_type == 'Estate') {
                                      ?>
                                        <a href="#" onclick="changeEstateMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-<?php echo $txt; ?>"></i></a>
                                      <?php 
                                      }else{
                                      ?>
                                        <a href="#" onclick="changeMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-<?php echo $txt; ?>"></i></a>
                                      <?php 
                                      }
                                    ?>
                                    <input type="hidden" id="lato-<?php echo $all->id ?>" value="<?php echo $all->lat ?>">
                                    <input type="hidden" id="longo-<?php echo $all->id ?>" value="<?php echo $all->lng ?>">
                                  </div>
                                  <div class="col-8">
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <h5><b><?php echo $all->landId ?></b></h5>
                                    </a>
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <small><?php echo $all->address ?></small>
                                    </a>
                                  </div>
                                  <div class="col-2 text-right" style="padding-top: 4%">
                                    <a href="<?php echo $all->txnLink ?>" target="_blank" data-toggle="tooltip" title="View on Blockchain" class="text-info iconbox">
                                      <i class="fa fa-file-o"></i>
                                    </a>
                                  </div>
                                </div>
                            <?php 
                            }
                        }
                     ?>
                  </div>
                  <div class="tab-pane fade" id="tab-contact-1">
                    <?php 
                        if (count($vacant) < 1) {
                           echo '<div class="col-md-12 col-sm-12 col-lg-12">
                                     <center style="opacity: 0.3">
                                         <i class="fa fa-search fa-3x"></i><br><br>
                                         <h5>No result found</h5>
                                     </center>
                                 </div>'; 
                        }else{
                            foreach ($vacant as $key => $all) {
                            ?>
                                <div class="row tada hover-shadow-2">
                                  <div class="col-2" style="padding-top: 4%">
                                    <?php  
                                      if ($all->land_type == 'Estate') {
                                      ?>
                                        <a href="#" onclick="changeEstateMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-warning"></i></a>
                                      <?php 
                                      }else{
                                      ?>
                                        <a href="#" onclick="changeMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map-o fa-2x text-warning"></i></a>
                                      <?php 
                                      }
                                    ?>
                                    <input type="hidden" id="lato-<?php echo $all->id ?>" value="<?php echo $all->lat ?>">
                                    <input type="hidden" id="longo-<?php echo $all->id ?>" value="<?php echo $all->lng ?>">
                                  </div>
                                  <div class="col-8">
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <h5><b><?php echo $all->landId ?></b></h5>
                                    </a>
                                    <a class="media text-default align-items-center" href="#" data-toggle="offcanvas" data-target="#offcanvas-left" onclick="viewInfo(<?php echo $all->id ?>)">
                                      <small><?php echo $all->address ?></small>
                                    </a>
                                  </div>
                                  <div class="col-2 text-right" style="padding-top: 4%">
                                    <a href="<?php echo $all->txnLink ?>" target="_blank" data-toggle="tooltip" title="View on Blockchain" class="text-warning iconbox">
                                      <i class="fa fa-file-o"></i>
                                    </a>
                                  </div>
                                </div>
                            <?php 
                            }
                        }
                     ?>
                  </div>
                </div>

                <hr class="mt-2">

              </div>
            </div>
            <div class="col-md-7 col-xl-8 sticky" style="margin: -9px -9px;">
              <div class="gap-y" id="map_canvas">
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>

    <div id="offcanvas-left" class="offcanvas w-500" data-animation="slide-right" style="overflow-x: hidden;overflow-y: auto;  height:100vh;">
      <button type="button" class="close position-static px-0" data-dismiss="offcanvas" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>

      <nav class="nav nav-lead flex-column my-3" id="land-area">
        
      </nav>
    </div>

    <!-- Scripts -->
    <script src="assets/js/page.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        var map;
        var myStyle = [
                {
                    "featureType": "all",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
            ];

        function initialize() {
          var mapOptions = {
            center: new google.maps.LatLng(9.098243150184958, 7.471330934743946),
            zoom: 14,
            mapTypeId: 'roadmap'
          };
          map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
          map.set('styles',myStyle);
          var json1 = <?php echo $mapo ?>;
          //console.log(json1)
          $.each(json1, function(key, data) {
                var bermudaTriangle = new google.maps.Polygon({
                  paths: data.cords,
                  strokeColor: data.color,
                  strokeOpacity: 0.9,
                  strokeWeight: 1,
                  fillColor: data.color,
                  fillOpacity: data.fill,
                });
                google.maps.event.addListener(bermudaTriangle,'click',function() {
                  map.setZoom(16);
                  map.setCenter(bermudaTriangle.getPath());
                  $('#modal-long').modal('show');
                  viewInfoMap(data.id);
                });
                bermudaTriangle.setMap(map);
          });
        }

        function changeMap(id){
            event.preventDefault();
          $.ajax({
              url:"includes/changeMapData",
              method:"POST",
              data:{id:id},
              success:function(data){
                var myData = JSON.parse(data);
                var mapOptions = {
                    center: new google.maps.LatLng(myData.lat, myData.lng),
                    zoom: 17,
                    mapTypeId: 'roadmap'
                  };
                  map = new google.maps.Map(document.getElementById("map_canvas"),
                    mapOptions);
                  map.set('styles',myStyle);
                var bermudaTriangle = new google.maps.Polygon({
                  paths: myData.cords,
                  strokeColor: myData.color,
                  strokeOpacity: 0.8,
                  strokeWeight: 2,
                  fillColor: myData.color,
                  fillOpacity: 0.5,
                });
                google.maps.event.addListener(bermudaTriangle,'click',function() {
                  $('#modal-long').modal('show');
                  viewInfoMap(myData.id);
                });
                 bermudaTriangle.setMap(map);             
             },error : function(e){
                    console.log(e);
               }
          });
        }

        function changeEstateMap(id){
            event.preventDefault();
            var mylat = $("#lato-"+id).val();
            var mylng = $("#longo-"+id).val();
          $.ajax({
              url:"includes/changeEstateMapData",
              method:"POST",
              data:{id:id},
              success:function(data){
                var estateData = JSON.parse(data);
                var mapOptions = {
                    center: new google.maps.LatLng(mylat, mylng),
                    zoom: 16,
                    mapTypeId: 'roadmap'
                  };
                  map = new google.maps.Map(document.getElementById("map_canvas"),
                    mapOptions);
                  map.set('styles',myStyle);
                  $.each(estateData, function(key, data) {
                      var bermudaTriangle = new google.maps.Polygon({
                        paths: data.cords,
                        strokeColor: data.color,
                        strokeOpacity: 0.9,
                        strokeWeight: 1,
                        fillColor: data.color,
                        fillOpacity: data.fill,
                      });
                      google.maps.event.addListener(bermudaTriangle,'click',function() {
                        map.setZoom(16);
                        map.setCenter(bermudaTriangle.getPath());
                        $('#modal-long').modal('show');
                        viewInfoMap(data.id);
                      });
                      bermudaTriangle.setMap(map);
                });            
             },error : function(e){
                    console.log(e);
               }
          });
        }
    </script>
    <script type="text/javascript">
            $("#klose").on('click', function(e){
                $(".vipform").slideUp();
            });
            function viewInfo(id) {
                event.preventDefault();
                $("#land-area").html('<center><i class="fa fa-spinner fa-spin fa-3x"></i></center>');
                $.ajax({
                  url:"includes/fetchDetail",
                  method:"POST",
                  data:{id:id},
                  success:function(data){
                    $("#land-area").html(data);             
                 },error : function(e){
                        console.log(e);
                    }
              });
            }

            function viewInfoMap(id) {
                event.preventDefault();
                $("#detail-map").html('<center><i class="fa fa-spinner fa-spin fa-3x"></i></center>');
                $.ajax({
                  url:"includes/fetchDetail",
                  method:"POST",
                  data:{id:id},
                  success:function(data){
                    $("#detail-map").html(data);             
                 },error : function(e){
                        console.log(e);
                    }
              });
            }

            $("#land-search").on('input',function(e){
                var searchWord = $("#land-search").val();
                $.ajax({
                  url:"includes/searchAll",
                  method:"POST",
                  data:{searchWord:searchWord},
                  success:function(data){
                    $("#tab-home-1").html(data);             
                 },error : function(e){
                        console.log(e);
                    }
              });
              $.ajax({
                  url:"includes/searchVacant",
                  method:"POST",
                  data:{searchWord:searchWord},
                  success:function(data){
                    $("#tab-contact-1").html(data);             
                    $("#pagin").slideUp();             
                 },error : function(e){
                        console.log(e);
                    }
              });
              $.ajax({
                  url:"includes/searchAllocated",
                  method:"POST",
                  data:{searchWord:searchWord},
                  success:function(data){
                    $("#tab-profile-1").html(data);             
                 },error : function(e){
                        console.log(e);
                    }
              });
            });
            $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip(); 
            });
        </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhEgGRLiCyeeXLFDP6C5bp4UxmbZ1JKSs"></script>
  </body>
</html>
