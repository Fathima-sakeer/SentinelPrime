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


$db = getDbInstance();

$select = array('Ai_id', 'AiName');

if ($search_str) {
    $db->where('AiName', '%' . $search_str . '%', 'like');
}

$db->pageLimit = $pagelimit;

$rows = $db->arraybuilder()->paginate('ai_virtual_cam_tab', $page, $select);
// print_r($rows);
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

<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">AI Virtual Cam View</h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->

    <!-- Table -->
   
    


  <!--  <form method="POST" > -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>AI Virtual Cam</th>
                
            </tr>
        </thead>
        <tbody>

            <?php foreach ($rows as $row): ?>
                
              
            <tr>
               
                <td><?php echo $row['Ai_id']; ?></td>
                <td>
                    <form action="ai_virtual_cam_disp.php?id=<?php echo $row['Ai_id'];?>" method="POST">

                <select name="select" >
                    <!-- <option value="1">1</option> -->
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                    <option value="60">60</option>
                </select>
                 <input type="submit" name="submit" value="<?php echo $row['AiName']; ?> "> 
               
                    

             </form>
         </td>

              
            </tr>

           
            
            <?php endforeach; ?>
        </tbody>
    </table>
<!-- </form> -->
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <!--<?php echo paginationLinks($page, $total_pages, 'customers.php'); ?>
    </div>
     //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
