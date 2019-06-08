<!DOCTYPE html>
<html lang="en">
<head>

    <title>LandAfrica|Add Land</title>
    <?php include_once 'includes/meta.php'; ?>
  </head>

  <body class="layout-centered bg-img" style="background-image: url(assets/img/12.jpg);">


    <!-- Main Content -->
    <main class="main-content">

      <div class="bg-white rounded shadow-7 w-500 mw-100 p-7">
        <h5 class="mb-7">Add new land</h5>

        <form role="form" id="land-form" method="POST">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input placeholder="Title" type="text" class="form-control" name="title" required="">
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                               <div class="form-group">
                                    <label>Address <span id="latitude" class="label label-default"></span> <span id="longitude" class="label label-default"></span></label>
                                    <input class="form-control" type="text" oninput="geolocate()" id="searchInput" placeholder="Enter a Location" name="address">
                                </div> 
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Area</label>
                                    <div class="input-group">
                                        <input placeholder="Area" class="form-control" type="text" name="area">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="clearfix"></div>
                                    <select class="form-control" name="status" style="width: 100%">
                                        <option>Vacant</option>
                                        <option>Allocated</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Owner</label>
                                    <div class="clearfix"></div>
                                    <select class="form-control" name="owner" style="width: 100%">
                                        <option>N/A</option>
                                        <option>Okoye Emmanuel</option>
                                        <option>Nathaniel Oswald</option>
                                        <option>Ayebatonye Joshua</option>
                                        <option>Bethram Harry</option>
                                    </select>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" id="administrative_area_level_1" name="state" />
                            <input class="form-control" type="hidden" id="postal_code" name="postal_code" />
                            <input class="form-control" type="hidden" id="locality" name="city" />

                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="border-bottom: 1px solid lightgrey">
                                        <br>
                                        <center><label>Coordinates</label></center>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group"><br>
                                            <label>Latitude</label>
                                                <input type="text" placeholder="Latitude" class="form-control" name="cord1" id="cord1">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group"><br>
                                            <label>Longitude</label>
                                            <div class="clearfix"></div>
                                            <input type="text" placeholder="Longitude" class="form-control" name="cord2" id="cord2">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <br><br>
                                        <button class="btn btn-primary" style="margin-top: 5%" id="addLat">add</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" name="cords" id="cords" class="form-control" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"><br>
                                    <button id="previewBtn" class="btn btn-primary btn-block">Add</button>
                                </div>
                            </div>

                        </div>
                    </form>
      </div>

    </main><!-- /.main-content -->


    <!-- Scripts -->
    <script src="assets/js/page.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhEgGRLiCyeeXLFDP6C5bp4UxmbZ1JKSs&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script type="text/javascript">
            var placeSearch, autocomplete;

            var componentForm = {
              administrative_area_level_1: 'long_name',
              locality: 'long_name',
              postal_code: 'short_name'
            };

            function initAutocomplete() {
              // Create the autocomplete object, restricting the search predictions to
              // geographical location types.
              autocomplete = new google.maps.places.Autocomplete(
                  document.getElementById('searchInput'));

              // Avoid paying for data that you don't need by restricting the set of
              // place fields that are returned to just the address components.
              autocomplete.setFields(['address_component']);

              // When the user selects an address from the drop-down, populate the
              // address fields in the form.
              autocomplete.addListener('place_changed', fillInAddress);
            }

            function fillInAddress() {
              // Get the place details from the autocomplete object.
              var place = autocomplete.getPlace();

              for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
              }

              // Get each component of the address from the place details,
              // and then fill-in the corresponding field on the form.
              for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                  var val = place.address_components[i][componentForm[addressType]];
                  document.getElementById(addressType).value = val;
                }
              }
            }

            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
              if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                  };
                  var circle = new google.maps.Circle(
                      {center: geolocation, radius: position.coords.accuracy});
                  autocomplete.setBounds(circle.getBounds());
                });
              }
            }
        var cords = [];
        $("#addLat").on('click',function(e){
            e.preventDefault();
             var lat = $("#cord1").val();
             var lng = $("#cord2").val();
             var cordy = lat+':'+lng;
             cords.push(cordy);
             $("#cord1").val('');
             $("#cord2").val('');
             $("#cords").val(cords.toString());
        });
        $("#land-form").on('submit',(function(e) {
                e.preventDefault();
                $("#previewBtn").attr('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> processing");
                var datas = new FormData(this);
                $.ajax({
                    url: "includes/doSaveLand", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: datas, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data){   // A function to be called if request succeeds
                        if(data.trim() == "done"){
                          $("#previewBtn").attr('disabled',false).html("Add");
                          toastr.success('Land added successfuly');
                          $('#land-form')[0].reset();
                        }else{
                            toastr.warning(data);
                            $("#previewBtn").attr('disabled',false).html("Add");
                        }
                    },
                    error : function(e){
                        console.log(e);
                    }
                });
            }));
    </script>

  </body>

<!-- Mirrored from thetheme.io/thesaas/page/user-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 May 2019 10:16:09 GMT -->
</html>
