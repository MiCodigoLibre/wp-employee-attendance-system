<?php
function wpeas_attendance_panel() {
 
	get_option('timezone_string');
	$date = date("Y-m-d");
	$ThisDate = date("d-m-Y", strtotime($date));

	
  ?>

  <h1>Today is : <?php echo $ThisDate; ?></h1>

  <?php


  // <!-- Checking if attendance is taken for today -->
  global $wpdb;
  $table_name2 = $wpdb->prefix . 'employee_details';
  $count_query = "select count(*) from $table_name2";
  $num = $wpdb->get_var($count_query);
  // echo $num;
  





	// insert attendance starts here 

	if(isset($_POST['submit-attendance'])) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'attendance_taken';

		for($i=0;$i<$num;$i++) { // for loop starts 

		    $att_id=sanitize_text_field($_POST['eid'][$i]);
        $att_emp_name=sanitize_text_field($_POST['name'][$i]);
        $att_date=sanitize_text_field($_POST['date'][$i]);
        $att_value=sanitize_text_field($_POST['attendance'][$i]);
        

        $wpdb->insert(
            $table_name,
            array(
                'eid' => $att_id,
                'name' => $att_emp_name,
                'date' => $att_date,
                'attendance'=>$att_value
            )
        );
        echo "attendance inserted";

    } // for loop close
        
        ?>
      <meta http-equiv="refresh" content="1; url=<?=get_site_url()?>/wp-admin/admin.php?page=View_Todays_Attendance" />
        <?php
        exit;

	}

	// insert attendance starts here 


	?>
	<table width="100%" class="table table-striped table-lightfont">
    <thead>
      <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th class="present_color">Present</th>
        <th>Absent</th>
      </tr>
    </thead>
    <tbody>
	
	<form action="" method="post">
	<?php

  global $wpdb;
	$table_name = $wpdb->prefix . 'employee_details'; 
	$att_taken = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($att_taken as $suhas) {

		?>

	
   <input type="hidden" value="<?php echo esc_html($suhas->id);?>" name="eid[]" />
   <input type="hidden" value="<?php echo esc_html($suhas->name);?>" name="name[]" />
      <tr>
        <td><?php echo esc_html($suhas->id); ?></td>
        <td><?php echo esc_html($suhas->name); ?></td>
        <td><label><input type="checkbox" name="attendance[]" value="Present">Present</label></td>
        <td><label><input type="checkbox" name="attendance[]" value="Absent">Absent</label></td>
      </tr>

		<?php
             get_option('timezone_string');
	           $date = date("Y-m-d");
             $ThisDate = date("d-m-Y", strtotime($date));

               ?>

               <input type="hidden" value="<?php echo esc_html($ThisDate);?>" name="date[]" />

               <?php
	}
	?>

	 </tbody>
    </table>
    </br>
   
    <button type="submit" name="submit-attendance" value="submit" class="all-button-classes">Submit Todays Attendance</button>
  
 </form> 

	<?php




    
}

?>