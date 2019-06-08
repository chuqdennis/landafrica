<?php
        include_once ("session.php");
        include_once ("admin.php");
        
        $site = new admin;
        $searchWord = htmlentities(trim($_POST["searchWord"]));
        $searchResult = $site->searchLands($searchWord,'All');
      
        if (count($searchResult) < 1) {
           echo '<div class="col-md-12 col-sm-12 col-lg-12">
                     <center style="opacity: 0.3">
                         <i class="fa fa-search fa-3x"></i><br><br>
                         <h5>No result found</h5>
                     </center>
                 </div>'; 
        }else{
            foreach ($searchResult as $key => $all) {
            ?>
                <div class="row tada hover-shadow-2">
                  <div class="col-2" style="padding-top: 4%">
                    <a href="#" onclick="changeMap(<?php echo $all->id ?>)" data-toggle="tooltip" title="View on map"><i class="fa fa-map fa-2x text-primary"></i></a>
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
                    <a href="<?php echo $all->txnLink ?>" target="_blank" data-toggle="tooltip" title="View on Blockchain">
                      <i class="fa fa-check-square fa-2x"></i>
                    </a>
                  </div>
                </div>
            <?php 
            }
        }
        ?>