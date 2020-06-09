
<?php

session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once BASE_PATH . '/lib/Costumers/Costumers.php';
$costumers = new Costumers();
$_SESSION['myvalue'] = 3;

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


$db = getDbInstance();

$search_str = filter_input(INPUT_GET, 'search_str');
$_SESSION['search_str'] = $search_str;

$currentTimeinSeconds = time();  
  



?>
<script type="text/javascript">
    function myFunction() { 
                var from =  document.getElementById("from_date").value; 

                var to =  document.getElementById("to_date").value;
                

                
                
                
            } 

    function reset() {
   // Get the first form with the name
   // Hopefully there is only one, but there are more, select the correct index
    document.getElementById("from_date").value = ""; 

    document.getElementById("to_date").value = "";
                
   // from.submit(); // Submit
   // to.submit();
   // from.reset();  // Reset
   // to.reset();
   // return false;
   return false; // Prevent page refresh
}
</script>




 <?php  

        
        $str = "SELECT * from dl_event_tab";
        if(isset($_POST['submit']))

        {   $selected = $_POST['events'];
            // echo $selected;
            $time_selected = $_POST['Time'];
            // echo $time_selected;
            // $timegrp_selected = $_POST['Timegroup'];
            // echo $timegrp_selected;

            $channelgrp_selected = $_POST['channelgroup'];

            $channel_selected = $_POST['channel'];
           // echo $channelgrp_selected;


            $from_result = $_POST['from'];
            echo $from_result;
            $to_result = $_POST['to'];
            echo $to_result;
            $from_unixtime = strtotime($from_result);
            $to_unixtime = strtotime($to_result);


            
              $str13='';
             if($selected != ''){
                if(substr($selected, 0, 10 ) === "EventGroup"){
                  $sqlu8 = "SELECT Data FROM eventgroups WHERE Name='".$selected."'";
                  $result8=mysqli_query($link,$sqlu8);
                  while ($row = mysqli_fetch_array($result8, MYSQLI_NUM)){
                    $eventgrp_data = $row[0];
                  
                    $eventgrp_data1 = explode(',', $eventgrp_data);

                      for($i=0; $i<sizeof($eventgrp_data1)-1 ; $i++) {
                      $eventgrp_data2 = explode ('-',$eventgrp_data1[$i]);
                      
                      $status1 = $eventgrp_data2[1];
                      if($status1 == 1){
                            $str12 = " Event_id = '".$eventgrp_data2[0]."' or ";
                            $str13 .= $str12;

                          }
                      


                      }
                      $str14 = substr($str13, 0, -3);
                      $str1 = $str. " where (".$str14.")";
                      
                }
              }

                else{
                $str1 = $str. " where Event_id='".$selected."'";
                }
             }
             else{
                $str1 = $str. " where 1=1";
             }




             if($time_selected != '' and $from_unixtime == '' and $to_unixtime == ''){


                if($time_selected == 1){
                // code...
                        $lastweek = 24*60*60;
                
                    }

                elseif ($time_selected == 2) {
                 # code...
                        $lastweek = 24*60*60;
                        $currentTimeinSeconds = $currentTimeinSeconds - 24*60*60;

                    }
              
                elseif ($time_selected == 3) {
                 # code...
                        $lastweek = 2*24*60*60;

                    } 

                elseif ($time_selected == 4) {
                 # code...
                        $lastweek = 3*24*60*60;

                    } 


                elseif ($time_selected == 5) {
                 # code...
                        $lastweek = 7*24*60*60;

                    } 



                elseif ($time_selected == 6) {
                 # code...
                        $lastweek = 7*7*24*60*60;

                    } 


                elseif ($time_selected == 7) {
                 # code...
                        $lastweek = 7*7*7*24*60*60;

                    } 


                elseif ($time_selected == 8) {
                 # code...
                        $lastweek = 30*24*60*60;

                    } 
                


                $last1 = $currentTimeinSeconds - $lastweek;
                $from_period = date('Y/m/d h:i', $last1);
                // echo $from;
                $to_period = date('Y/m/d h:i', $currentTimeinSeconds);
                echo $from_period;
                echo $to_period;
                

                $str2 = $str1. " and unixtime BETWEEN '$last1' and '$currentTimeinSeconds'";
                
                    

            }
             else{
                $from_period = $from_result;
                $to_period = $to_result;

                $str2 = $str1. " and 1=1";
             }

             
             // if($timegrp_selected != '' and $from_unixtime == '' and $to_unixtime == ''){
              
             //    $sqlu5 = "SELECT TData from time_groups where Seq_no='".$timegrp_selected."'";
             //    $result5=mysqli_query($link,$sqlu5);
             //    while ($row = mysqli_fetch_array($result5, MYSQLI_NUM)){
                  
             //    $data = $row[0];
                  
             //    $data1 = explode(',', $data);
             
             //    $str5 = '';
             //    for($i=0; $i<sizeof($data1)-1 ; $i++) {
             //      $data2 = explode ('-',$data1[$i]);
             //      print_r($data2);

             //      if ($data2[0]!='' and $data2[1]!=''){
             //        if($time_selected == 1){
             //          $start_time = strtotime($data2[0]);
             //          echo $start_time;
             //          $end_time = strtotime($data2[1]);
             //          $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //          $str5 .= $str4;
             //        }
             //        elseif($time_selected == 2){
             //          $start_time = strtotime($data2[0])-24*60*60;
             //          $end_time = strtotime($data2[1])-24*60*60;
             //          $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //          $str5 .= $str4;
             //        }
             //        elseif($time_selected == 3){
             //          for($j=1; $j<=2; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == 4){
             //          for($j=1; $j<=3; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == 5){
             //          for($j=1; $j<=7; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == 6){
             //          for($j=1; $j<=14; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == 7){
             //          for($j=1; $j<=21; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == 8){
             //          for($j=1; $j<=30; $j++){
                        
             //            $start_time = strtotime($data2[0])-$j*24*60*60;
             //            $end_time = strtotime($data2[1])-$j*24*60*60;
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
                        
             //          }
             //        }
             //        elseif($time_selected == ""){

             //            $start_time = strtotime($data2[0]);
                      
             //            $end_time = strtotime($data2[1]);
             //            $str4 = " unixtime>='".$start_time."' AND unixtime<='".$end_time."' OR";
             //            $str5 .= $str4;
             //        }
                    
             //      }
             //      else{
             //        echo "no time";
             //      }
                  
             //      }
             //      // echo $str5;
             //    $str6 = substr($str5, 0, -2);
                
             //    $str7 = $str2. " and (". $str6. ")";
             //      }
             //  }

             // else{

             //   $str7 = $str2. " and 1=1";

             //  }


            
            $str9 = "";
            $str11 = "";
            if($channelgrp_selected != '' and $channel_selected == ''){
                $sqlu6 = "SELECT Channel_Group_data FROM Channel_Group_tab WHERE Seqno='".$channelgrp_selected."'";
                $result6=mysqli_query($link,$sqlu6);
                while ($row = mysqli_fetch_array($result6, MYSQLI_NUM)){
                  $channel_data = $row[0];
                  
                  $channel_data1 = explode(',', $channel_data);

                  for($i=0; $i<sizeof($channel_data1)-1 ; $i++) {
                  $channel_data2 = explode ('-',$channel_data1[$i]);
                  
                  $status = $channel_data2[1];

                  if($status == 1){
                    $str8 = "channel_id = '".$channel_data2[0]."' or ";
                    $str9 .= $str8;

                  }


                }
                $str10 = substr($str9, 0, -4);
                $str11 = $str2. " and (".$str10.")"; 
                if($status != 1){
                  $str11 = $str2;
                }
                
              }

            }

            
             else{
              // echo "no";

               $str11 = $str2. " and 1=1";
               // echo $str11;

              }




            
        $str15='';
        if($from_unixtime!= '' AND $to_unixtime!=''){

              $str15 = "unixtime>='".$from_unixtime."' AND unixtime<='".$to_unixtime."' ";
              $str16 = $str11. " and (".$str15.")";
            }
             
           
           else{
            $str16 = $str11. " and 1=1";
           }


        if($channel_selected != ''){
            $str17 = $str16. " and channel_id = '".$channel_selected."' ";
           }
           else{
            $str17 = $str16. " and 1=1";
           }

             $sqlu1 = $str17;
             // echo $sqlu1;
            
             }


        else 
        {
           
            $sqlu1 = $str;
            echo $sqlu1;


            
         
        }



        $result=mysqli_query($link,$sqlu1);

                $ix = 0 ;
                $line_seq_no[$ix] = "" ;
                $line_event[$ix] = "" ;

                $line_image[$ix] = "";
                $line_unixtime[$ix] = "";


               while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                 
                 { 
                  
                    $line_seq_no[$ix] = $row[0] ;
                    $line_channel[$ix] = $row[2];
                    $line_unixtime[$ix] = date("F j, Y, g:i a", intval($row[3]));
                     
                    $line_event[$ix] = $row[4] ;
                    $line_image[$ix] = $row[12];
                    

                    $heatmap[$ix]=$row;
                    $ix++;

                 }
                

                 $idlen="";
                 $idlen=count($line_seq_no);
                // echo $idlen;
                 $_SESSION['length']=$idlen;


          if (mysqli_num_rows($result)==0) { 
                    $line_seq_no[$ix] = "" ;
                    $line_channel[$ix] = "";
                    $line_unixtime[$ix] = "";

                    $line_event[$ix] = "" ;
                    $line_image[$ix] = "";
                    

                    $heatmap[$ix]=$row;
                    $ix++;
                    

           }

?>
 


<?php include BASE_PATH . '/includes/header.php'; ?>


<div id="page-wrapper">

    <div class="row">

        <div class="col-lg-6">

            <h1 class="page-header">VIEW</h1>

        </div>

    </div>

     <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
     <form method="POST" action="">
     <select name="events" style="border: ridge;">
      <option value="">All</option>
      <?php
       $sqlu2 = "SELECT Event_id,Event_name FROM Events_tab";

       $result2=mysqli_query($link,$sqlu2);
       while ($row = mysqli_fetch_array($result2, MYSQLI_NUM)) {
        ?>

        <option value="<?php echo $row[0] ?>"
          <?php 
          if(isset($_POST['submit'])){
          if($_POST['events'] == $row[0])
                    echo 'selected';
                }
              ?>
                  >

                    <?php echo $row[1];?>
          
        </option>
    
      <?php }
    ?>
    <?php
       $sqlu7 = "SELECT SeqNo,Name FROM eventgroups";

       $result7=mysqli_query($link,$sqlu7);
       while ($row = mysqli_fetch_array($result7, MYSQLI_NUM)) {
        ?>

        <option value="<?php echo $row[1] ?>" <?php
        if(isset($_POST['submit'])){
         if($_POST['events'] == $row[1])
                    echo 'selected';
              }
              ?>
                  >
                    <?php echo $row[1];?></option>
        
    
      <?php }
    ?>
    
       


         
     </select>
     <select name="Time" style="border: ridge;" id="timeprd">
         <option value="">All</option>
         <option value="1" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 1) ? 'selected="selected"' : ''; ?>>Today</option>
         <option value="2" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 2) ? 'selected="selected"' : ''; ?>>yesterday</option>
         <option value="3" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 3) ? 'selected="selected"' : ''; ?>>two days</option>
         <option value="4" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 4) ? 'selected="selected"' : ''; ?>>three days</option>
         <option value="5" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 5) ? 'selected="selected"' : ''; ?>>one week</option>
         <option value="6" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 6) ? 'selected="selected"' : ''; ?>>2 weeks</option>
         <option value="7" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 7) ? 'selected="selected"' : ''; ?>>3 weeks</option>
         <option value="8" <?php echo (isset($_POST['Time']) && $_POST['Time'] == 8) ? 'selected="selected"' : ''; ?>>one month</option>
         
     </select>
     


      <!-- <select name="Timegroup" style="border: ridge;">
      <option value="" id="timegrp">Timegroup</option>
      <?php
       $sqlu3 = "SELECT TName,Seq_no FROM time_groups";
       $result1=mysqli_query($link,$sqlu3);
       while ($row = mysqli_fetch_array($result1, MYSQLI_NUM)) {
        ?>

        <option value="<?php echo $row[1] ?>"<?php
        if(isset($_POST['submit'])){
         if($_POST['Timegroup'] == $row[1])
                    echo 'selected';
                }
                  ?>

                  >
                    <?php echo $row[0];?></option>
    
      <?php }
    ?>
       </select> -->
     
      <select name="channelgroup" style="border: ridge;">
      <option value="">All</option>
      <?php
       $sqlu4 = "SELECT Channel_group_name,Seqno FROM Channel_Group_tab";
       $result4 = mysqli_query($link,$sqlu4);
       while ($row = mysqli_fetch_array($result4,MYSQLI_NUM)) {
         ?>

         <option value="<?php echo $row[1] ?>"<?php 
         if(isset($_POST['submit'])){
         if($_POST['channelgroup'] == $row[1])
                    echo 'selected';
                }
                  ?>>
                    <?php echo $row[0];?></option>

   <?php }
   ?>

   </select>

    <select name="channel" style="border: ridge;">
      <option value="">All</option>
      <?php
       $sqlu9 = "SELECT Channel_id,Channel_name FROM Channel_tab";
       $result9 = mysqli_query($link,$sqlu9);
       while ($row = mysqli_fetch_array($result9,MYSQLI_NUM)) {
         ?>

         <option value="<?php echo $row[0] ?>"<?php 
         if(isset($_POST['submit'])){
         if($_POST['channel'] == $row[0])
                    echo 'selected';
                }
                  ?>>
                    <?php echo $row[1];?></option>

   <?php }
   ?>

   </select>



   <div style="padding: 10px; margin-left: 30px;">
      <label>From</label>
     <input  id="from_date" name="from" autocomplete="off" value="<?php if(isset($_POST['submit'])){
       
        echo $from_period;
    
     } 


     
     ?>" >
     <label >To</label>
     <input  id="to_date" name="to" autocomplete="off"  value="<?php if(isset($_POST['submit'])){
         
        echo $to_period;
    
     }
    


      ?>">
     <link rel="stylesheet" href="jquery.datetimepicker.min.css">
    <script src="jquery.js"></script>
    <script src="jquery.datetimepicker.full.js" ></script>


    <script type="text/javascript">
        
            $("#from_date").datetimepicker();

            $('#to_date').datetimepicker();
      
      

    </script> 
        
    
    <!-- <input type="button" name="reset" value="Reset" style="background-color: #4CAF50;" onclick="reset();" > -->
    <button onclick="document.getElementById('from_date').value = '';
                    document.getElementById('to_date').value = ''
                    return false;">Reset</button>
    <div>
        <input type="submit" name="submit" value="submit" style="background-color: #4CAF50; margin-left: 200; margin-top: 10;" onclick="myFunction()" >
    </div>
 </div>



     
     </form>

  
   
   <table class="table table-striped table-bordered table-condensed">

       <thead>
            <tr>
                <th>seq_no</th>
                <th>Date</th>
                <th>Channel</th>
                <th>event</th>
                <th>image</th>
                
            </tr>
        </thead>

        <tbody>
          
           
                      <?php 
                       for($i=0;$i<$idlen;$i++)
                       {
                           $_SESSION['value_id']= $i+1;    
                         ?>
                         <tr>

                          <td><?php echo $line_seq_no[$i];?></td>
                          <td><?php echo $line_unixtime[$i]; ?></td>
                          <td><?php echo $line_channel[$i]; ?></td>
                          <td><?php echo $line_event[$i]; ?></td>
                          <td><?php echo '<img alt="Image" height="150px" width="150px" src="data:image/jpeg;base64,'.base64_encode($line_image[$i]).'"/>'; ?></td>

                        </tr>
                        <?php        
                        }  
                    ?> 


        </tbody>
      </table>
    </div>

        
