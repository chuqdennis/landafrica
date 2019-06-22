<?php
        include_once ("session.php");
        include_once ("admin.php");
        
        $site = new admin;
        $id = htmlentities(trim($_POST["id"]));
        $info = $site->getLandInfo($id);
        
?>
    <table>
      <tr>
        <td class="pd-3"><img src="assets/img/favicon.png" style="width: 40px"></td>
        <td class="text-left"><h4><b><?php echo $info->landId ?></b></h4></td>
      </tr>
      <tr>
        <td class="pd-3">Title</td>
        <td><?php echo $info->landTitle ?></td>
      </tr>
      <tr>
        <td class="pd-3">Area</td>
        <td><?php echo $info->area ?>sqm</td>
      </tr>
      <tr>
        <td class="pd-3">Address</td>
        <td><?php echo $info->address ?></td>
      </tr>
      <tr>
        <td class="pd-3">Owner</td>
        <td><?php echo $info->currentOwner ?></td>
      </tr>
      <tr>
        <td class="pd-3" colspan="2" style="word-break: break-all;"><small>{<?php echo $info->coords ?>}</small></td>
      </tr>
      <tr>
          <td colspan="2" class="text-right">
              <a href="<?php echo $info->txnLink ?>" class="text-primary" target="_blank"><b>View on blockchain</b></a>
          </td>
      </tr>
  </table>