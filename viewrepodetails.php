<?php
require("database.php");

$id = $_GET['id'];

$datbase = new database();
$result = $datbase-> searchFromDBById($id);

include('header.php');
?>
<div class="container">


    <div class="row">
        <div class="col-md-12">
           <?php
            if($result['status']=='200'){
                $data = $result['message'][0];
                ?>
                <h1> Repository Details </h1>
                <p>ID : <?php echo $data[0];?> </p>
                <p>Name : <?php echo $data[1];?> </p>
                <p>URL : <?php echo $data[2];?> </p>
                <p>Create Date : <?php echo $data[3];?> </p>
                <p>Last Push Date : <?php echo $data[4];?> </p>
                <p>Description : <?php echo $data[5];?> </p>
                <p>Stars : <?php echo $data[6];?> </p>
                <?php
            } else {
                ?>
                <h1>Sorry no data found</h1>
            <?php
            }
           ?>

        </div>
    </div>
</div>

<?php
include('footer.php');
?>
