<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
$search_str = filter_input(INPUT_GET, 'search_str');
$pagelimit = 15;

$page = filter_input(INPUT_GET, 'page');
if (!$page) {
    $page = 1;
}
$select = filter_input(INPUT_POST, 'select', FILTER_VALIDATE_INT);
if(isset($_GET['select'])) {
    $select = $_GET['select'];
} 

$db = getDbInstance();


$db->pageLimit = $pagelimit;

// $rows = $db->arraybuilder()->paginate('ai_virtual_cam_tab', $page, $select);

$total_pages = $db->totalPages;


             $link = mysqli_connect('localhost', 'root', 'Qwerty@1234');
        
        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        
        $db_selected = mysqli_select_db( $link,'SENTINELX' );
            
        if (!$db_selected)
        {
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;   
            echo "<script type='text/javascript'>alert('" . mysqli_connect_errno() . "');</script>";
                 
            exit;
        }
?>
<?php
$seq = $_GET['id'];
 $seq1 = array(); 
// $select = $_POST['select'];

 echo $seq;

$sql1 = "SELECT * FROM ai_virtual_cam_tab where Ai_id ='".$seq."'";
$result1=mysqli_query($link,$sql1);
while ($row1 = mysqli_fetch_array($result1, MYSQLI_NUM)){
  $data = $row1[2];
  // echo $data.'-data'.'<br>';
}
  // echo $data;
  $data_array = array();
  $time_grp = array();
  $event_grp = array();
  $data_explode = explode('-', $data);
  // print_r($data_explode);
  for($i=0; $i<sizeof($data_explode)-1; $i++){
    $data_explode1 = explode(',', $data_explode[$i]);
    
    if($data_explode1[3] == 1){
        array_push($data_array, $data_explode1[0]);
        
        
        array_push($time_grp, $data_explode1[1]);
        
        array_push($event_grp, $data_explode1[2]);
       
    }
}
// echo "data array is ";print_r($data_array).'<br>';
// echo "time grp is ";print_r($time_grp).'<br>';
// echo "event grp is ";print_r($event_grp).'<br>';
// print_r($time_grp);
// print_r($event_grp);


// print_r($event_array);

         $event_array = array(); 
         $test_array = array();         

        for($j=0;$j<sizeof($event_grp);$j++)
        {
            $e_grp = $event_grp[$j];

            $sqlu1="";
            $sqlu1 = "SELECT Data FROM eventgroups WHERE SeqNo='$e_grp'";
            $result=mysqli_query($link,$sqlu1);
            // $ix1= 0 ;              
            // $edata[$ix1] = "" ;
               
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            { 
                $edata = $row[0] ;
                // print_r($edata);
                // $ix1++;
            }

            $edata2 = explode(",",$edata);

            for($i=0;$i<sizeof($edata2)-1;$i++)
            {
                $ecomma_split = explode("-",$edata2[$i]);
                $status = $ecomma_split[1];
                if($status == "1")
                {
                   // array_push($event_array, $ecomma_split[0]);
                     array_push($test_array, $ecomma_split[0]."-".$data_array[$j]);

                }
            }
        }
        // echo "event array is ";
        // print_r($test_array).'<br>';




         // $time_event = array();
         // $time_seq = array();
        $time_array = array();

        for($j=0;$j<sizeof($time_grp);$j++)
        {
            $t_grp = $time_grp[$j];
            $sqlu2="";
            $sqlu2 = "SELECT TData FROM time_groups WHERE Seq_no='$t_grp'";
            $result=mysqli_query($link,$sqlu2);
            $ix2= 0 ;
            $tdata[$ix2] = "" ;
               
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            { 
                $tdata[$ix2] = $row[0] ;
                $ix2++;
            }

            $tdata2 = explode(",",$tdata[0]);

            for ($i=0; $i<sizeof($tdata2)-1 ; $i++)
            { 
                $split = explode("-",$tdata2[$i]);
                // print_r($split);
                if($split[0] != "" and $split[1]!="")
                {
                    $start=0;
                    $end=0;
                    $t=0;
                    $start = strtotime($split[0]);
                    $t= time();
                    $end = strtotime($split[1]);
                    
                    if($start<=$t and $t<=$end)
                    {
                        // array_push($time_seq,$data_array[$j]);
                        // array_push($time_event,$event_grp[$j]);
                          array_push($time_array, $data_array[$j]);  
                    }
                } 
            }
}
// echo "time array is ";
// print_r($time_array).'<br>';


        
       


         $sqlu3="";
        $sqlu3 = "SELECT seq_no,channel_id,unixtime,event,Event_id,image FROM dl_event_tab order by seq_no desc limit 50";
        $result=mysqli_query($link,$sqlu3);
        $ix3 = 0 ;

        $seq_no[$ix3] = "" ;
        $channel_id[$ix3] = "" ;
        $unixtime[$ix3] = "" ;
        $event[$ix3] = "" ;
        $eventid[$ix3] = "" ;
        $image[$ix3] = "" ;

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
        { 
            $seq_no[$ix3] = $row[0] ;
            $channel_id[$ix3] = $row[1] ;
            $unixtime[$ix3] = $row[2];
            $event[$ix3] = $row[3];
            $eventid[$ix3] = $row[4];
            $image[$ix3] = $row[5];
            $ix3++;
        }
        // echo "size is ". sizeof($seq_no) ;
?> 
 
 <?php 
        for($i=0;$i<sizeof($channel_id);$i++){
            

                    for($m=0;$m<sizeof($time_array);$m++){
                        if($time_array[$m]==$channel_id[$i]){


                    for($l=0;$l<sizeof($test_array);$l++){
                        $str="";
                        $str=explode("-", $test_array[$l]);
                        if($str[1]==$channel_id[$i] and $str[0]==$eventid[$i]){
                            
                        
                            
                                
                            
                                    array_push($seq1, $seq_no[$i]);
                        }



    }}}}
        print_r($seq1);

        
        ?>

<?php
if(sizeof($seq1) != 0){
if($select <= sizeof($seq1)){
    $select1 = $select;
    echo "select1 is ".$select1;
}
else{
    $select1 = sizeof($seq1);
      echo "select1 is ".$select1;
}}

?>





<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
      <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">AI Virtual Cam View</h1>
        </div>
    </div>
   
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
   
    <!-- <input type="submit" name="submit" value="submit"> -->


    <!-- Filters -->
<?php
if(sizeof($seq1) != 0){
for($i=0; $i<1; $i++){
    for($j=0; $j<sizeof($seq_no); $j++){
    if($seq1[$i] == $seq_no[$j]){
    echo '<img alt="Image" height="150px" width="150px" src="data:image/jpeg;base64,'.base64_encode($image[$j]).'"/>';
}

}}}

?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>Seq_no</th>
            <th>channel id</th>
            <th>event</th>
            <th>event id</th>
            <th>unixtime</th>
            <th>image</th>
         </tr>
    </thead>

    <tbody>
        <?php
            if(sizeof($seq1) != 0){
            for($i=0; $i<$select1; $i++){
                for($j=0; $j<sizeof($seq_no); $j++){
                    if($seq1[$i] == $seq_no[$j]){
                ?>

                <tr>

                          <td><?php echo $seq_no[$j];?></td>
                          <td><?php echo $channel_id[$j]; ?></td>
                          <td><?php echo $unixtime[$j]; ?></td>
                          <td><?php echo $event[$j]; ?></td>
                          <td><?php echo $event[$j]; ?></td>
                          <td><?php echo '<img alt="Image" height="150px" width="150px" src="data:image/jpeg;base64,'.base64_encode($image[$j]).'"/>'; ?></td>

                        </tr>
        


        <?php
            }}}}

         ?>
           
      
        </tbody>
    </table>



    
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
