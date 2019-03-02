<?php

/* Create Form */

?>

<!-- ***** Validating Form Fields ***** -->

<script>

    function validate() {

	    var uname = document.register.username;
		var uemail = document.register.email;
		
		if(name_validation(uname,3,30))
		{
			if(email_validation(uemail))
			    return true;
		}
		return false;
	}

    function name_validation(uname,mx,my)
	{
	    var letters = /^[A-Za-z]+$/;
		var letterss= /^[A-Za-z][A-Za-z ]+$/;
		var uname_len = uname.value.length;
		if(uname.value.match(letters) || uname.value.match(letterss) )
		{
		    if(uname_len == 0 || uname_len > my || uname_len < mx)
			{
				alert("Length of Name should be between "+mx+" to "+my);
				uname.focus();
				uname.style.borderColor="red";
				return false;
			}
			
            uname.style.borderColor="lightgrey";
			return true;
		}
		else
		{
			alert('Name must have alphabet characters only');
			uname.focus();
			uname.style.borderColor="red";
			return false;
		}
	}

	function email_validation(uemail)
	{
	    var mailformat= /^[A-Za-z]{1}([A-za-z0-9_\-\.])+\@([A-Za-z_\-\.])+\.([A-Za-z]{2,4})$/;
		if(uemail.value.match(mailformat))
		{
			uemail.style.borderColor="lightgrey";
			return true;
		}
		else
		{
			alert("You have entered an invalid email address!");
			uemail.focus();
			uemail.style.borderColor="red";
			return false;
		}
	}


</script>

<div class="row"> 
    <form method="post" name="register" onSubmit="return validate();">
        <h1>Simple Form</h1>
        <div class="row">   
            <div class="col span-1-of-3">
                <label for="username" class="lb_name">Name</label>
            </div>
            <div class="col span-2-of-3">
                <input type="text" name="username" id="username" placeholder="Your Name..." required><br />
            </div>
        </div>
        <br/>
        <div class="row">   
            <div class="col span-1-of-3">
                <label for="email" class="lb_email">Email</label>
            </div>
            <div class="col span-2-of-3">
                <input type="email" name="email" id="email" placeholder="Your Email..." required><br />
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col span-1-of-3">
                <label>&nbsp;</label>
            </div>
            <div class="col span-2-of-3">
                <button type="submit" name="submit">Submit</button>
            </div>
        </div>  
        <br/>        
    </form>
</div>

<?php 

/* Insert Form Data in Database Table */

    function DB_insert_data()
    {

        global $wpdb;
        $DB_tb_name = $wpdb->prefix . 'form_details';

        $username = $_POST['username'];
        $email = $_POST['email'];

        if (isset($_POST['submit'])) {
            $wpdb->insert(
                $DB_tb_name,
                array(
                    'username' => $username,
                    'email' => $email
                ),

                array(
                    '%s',
                    '%s'
                )

            );
        }
    }
    DB_insert_data();
?>

<?php

    global $wpdb;

    $DB_tb_name = $wpdb->prefix . 'form_details';

    $DB_results = $wpdb->get_results("SELECT * FROM $DB_tb_name");

?>

<br/>
<h1>List Of Entries</h1>

<table cellspacing="15px" > 

    <tr>
        <th>SNo.</th>
        <th>Name</th>
        <th>Email</th>
    </tr>

    <?php foreach ($DB_results as $DB_row) {
        $id = $DB_row->id;
        $username = $DB_row->username;
        $email = $DB_row->email;

    ?>

    <tr>
        <td>
            <?php echo $id; ?>
        </td>
        <td>
            <?php echo $username; ?>
        </td>
        <td>
            <?php echo $email; ?>
        </td>
    </tr>

    <?php } ?>
</table> 


<!-- *****Using Ajax For Auto update the list when new elements are added***** -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("button").click(function() {
            $("table").load("MyFirstTask_form.php");
        });
    });
</script>