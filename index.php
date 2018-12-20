<?php include("plugins/connect.php"); ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Curd Operation</title>
      <link rel="stylesheet" href="plugins/bootstrap.min.css">
      <link rel="stylesheet" href="plugins/font-awesome.min.css">
      <style>
		textarea {
		resize: none;
		}
	</style>
   </head>
   <body style="background-color:#222d32;margin-top:15px";>
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" id="edittab"></div>
            </div>
         </div>
      </div>
      
      <div class="container">
         <div class="row">
            <div class="col-md-5">
               <!-- input mask -->
               <div class="panel">
                  <div class="panel-body">
                     <h3 class="btn btn-warning" style="font-size: 18px; width: 100%; font-weight:bold;">Add customer</h3>
                     <div id="insert_error" style="color:red;display:none"></p>Please Check All Fields</p></div>
                     <div class="col-md-6">
                        <label for="usename">Username:</label>
                        <input type="text" name="uname" class="form-control" id="uname" Onchange="username();"><span id="name_status" style="color:red;display:none"></p>username already exist</p></span>
                     </div>
                     <div class="col-md-6">
                        <label for="fname">First Name:</label>
                        <input type="text"  name="fname" class="form-control" id="fname" oninput="validateAlpha();" required>
                     </div>
                     <div class="col-md-6">
                        <label for="lname">Last Name:</label>
                        <input type="text" name="lname" class="form-control" id="lname" oninput="validateAlpha1();" required>
                     </div>
                     <div class="col-md-6" name="frmCheckPassword" id="frmCheckPassword">
                        <label for="pwd">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" Onchange="checkpassword();" /><span id="password_status" style="color:red;display:none"><p>password should 8 digits</p></span><span id="password_status1" style="color:red;display:none"><p>Please Enter 1 alphabet 1number 1 special charater</p></span>
                     </div>
                     <div class="col-md-6">
                        <label for="email">E Mail:</label>
                        <input type="text" name="email" class="form-control" id="email" Onchange="email(this);" required><span id="email_status" style="color:red;display:none"><p>Email already exist</p></span><span id="email_status1" style="color:red;display:none"><p>Invalid Email</p></span>
                     </div>
                     <div class="col-md-6">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" class="form-control" min="10" max="15" id="phone"  Onchange="phone(this);" oninput="isNumberKey();" required><span id="phone_status" style="color:red;display:none"><p>Phone Number already exist</p></span><span id="phone_status1" style="color:red;display:none"><p>Minimum 10 digits</p></span>
                     </div>
                     <div class="col-md-6">
                        <label for="dob">Dob:</label>
                        <input type="text" name="dob" class="form-control" id="dob">
                     </div>
                     <div class="col-md-6">
                        <label for="describtion">Describtion:</label>
                        <textarea name="describtion" id="describtion" class="form-control"></textarea>
                     </div>
                     <center><input type="submit" id="submit" class="btn btn-success  btn-rounded" value="Submit" onclick="change();"></center>
                     </center>
                  </div>
               </div>
            </div>
            <div class="col-md-7">
               <div class="panel">
                  <h3 class="btn btn-warning" style="font-size: 18px; width: 100%; font-weight:bold;margin-top:3%;">Customer List</h3>
                  <div class="panel-body">
                     <div id="tab">
                        <table id="example" class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th>S.no</th>
                                 <th>Username</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $sql="SELECT * from tbl_customer where status='1' order by id asc";
                                 $customer=mysqli_query($conn,$sql);
                                 $i=1;
                                 $num=mysqli_num_rows($customer);
                                 if ($num =='0')
                                     {
                                         Echo "No Record Found";
                                     }
                                 
                                 while($cus_details=mysqli_fetch_array($customer))
                                 {
                                     
                                 ?> 
                              <tr>
                                 <td><?php echo $i; ?></td>
                                 <td><?php echo $cus_details['fname']; ?> <?php echo $cus_details['lname']; ?></td>
                                 <td><?php echo $cus_details['email']; ?></td>
                                 <td><?php echo $cus_details['phone']; ?></td>
                                 <td>
                                    <a href="#" onclick="changeedit(<?php echo $cus_details['id'];?>)"> <button class="btn-success">Edit</button></a>
                                    <a href="#" onclick="changedel(<?php echo $cus_details['id'];?>)"><button class="btn-danger">Delete</button></a>
                                 </td>
                              </tr>
                              <?php
                                 $i++;
                                 } 
                                 ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <p><a href="syed.zip">Download file</a></p>
      </div>
      <!-- /.content -->
      </div>
      </div>
      </div>
      <script src="plugins/jquery-3.1.1.min.js"></script>
      <script src="plugins/bootstrap.js"></script>
      <script src="plugins/jquery.dataTables.min.js"></script>
      <script src="plugins/dataTables.bootstrap.min.js"></script>
      <script src="plugins/dataTables.buttons.min.js"></script>
      <script src="plugins/datatables.js"></script>
     
      <script type="text/javascript">
      //username validation
        function username(){
            $.post("save.php",{uname: $('#uname').val(),command:"username_check"},function(response){
               if(response==1)
               {
                  $("#uname").css("border","1px solid #ccc");
                  $("#name_status").hide();
                  $("#submit").attr("disabled", false);
                  
               }
               else
               {
                $("#uname").focus().css("border","1px solid red");
                $("#name_status").show();
                $("#submit").attr("disabled", true);
               }
               });
          }
          //email validation  
          function email(){
            $.post("save.php",{email: $('#email').val(),command:"email_check"},function(response){
     
               if(response==1)
               {
                  $("#email").css("border","1px solid #ccc");
                  $("#email_status").hide();
                  $("#email_status1").hide();
                  $("#submit").attr("disabled", false);
               }
               else if(response==0)
               {
                $("#email").focus().css("border","1px solid red");
                $("#email_status").show();                
                $("#email_status1").hide();
                $("#submit").attr("disabled", true);
               }
               else if(response=2)
               {
                $("#email").focus().css("border","1px solid red");
                $("#email_status1").show();
                $("#email_status").hide(); 
                $("#submit").attr("disabled", true);
               }
               else
               {
                  $("#email").css("border","1px solid #ccc");
                  $("#email_status").hide();
                  $("#email_status1").hide();
                  $("#submit").attr("disabled", false);
               }
               });
          }
          //phone number validation
         function phone(){
            $.post("save.php",{phone: $('#phone').val(),command:"phone_check"},function(response){
              
               if(response==1)
               {
                  $("#phone").css("border","1px solid #ccc");
                  $("#phone_status").hide();
                  $("#phone_status1").hide();
                  $("#submit").attr("disabled", false);
               }
               else if(response==0)
               {
                $("#phone").focus().css("border","1px solid red");
                $("#phone_status").show();                
                $("#phone_status1").hide();
                $("#submit").attr("disabled", true);
               }
               else if(response=2)
               {
                $("#phone").focus().css("border","1px solid red");
                $("#phone_status1").show();
                $("#submit").attr("disabled", true);
               }
               else
               {
                  $("#phone").css("border","1px solid #ccc");
                  $("#phone_status").hide();
                  $("#phone_status1").hide();
                  $("#submit").attr("disabled", false);
               }
               });
          }

         //password check
         function checkpassword() {
            $.post("save.php",{password: $('#password').val(),command:"password_check"},function(response){
               alert(response);
               if(response==0)
               {
               $("#password").focus().css("border","1px solid red");
               $("#password_status").show();                
               $("#password_status1").hide();
               $("#submit").attr("disabled", true);
               }
               else if(response==1)
               {
                  $("#password").focus().css("border","1px solid red");
                  $("#password_status1").show();                
               $("#password_status").hide();
                $("#submit").attr("disabled", true);
               }
               else if(response==2){
              
                $("#password").css("border","1px solid #ccc");
                  $("#password_status").hide();
                  $("#password_status1").hide();
                  $("#submit").attr("disabled", false);
               }
               else {
              
              $("#password").css("border","1px solid #ccc");
                $("#password_status").hide();
                $("#password_status1").hide();
                $("#submit").attr("disabled", false);
             }
            });
            }


         
        //validate only alphabet input
         function validateAlpha(){
         var textInput = document.getElementById("fname").value;
         textInput = textInput.replace(/[^A-Za-z]/g, "");
         document.getElementById("fname").value = textInput;
         }
         //validate only alphabet input
         function validateAlpha1(){
         var textInput = document.getElementById("lname").value;
         textInput = textInput.replace(/[^A-Za-z]/g, "");
         document.getElementById("lname").value = textInput;
         }
         //validate only number input
         function isNumberKey(){
         var textInput = document.getElementById("phone").value;
         textInput = textInput.replace(/[^0-9]/g, "");
         document.getElementById("phone").value = textInput;
         }
         //Inserting customer data
         function change(){
          
         				if($("#uname").val()=='')
         				{
         				alert('Please Type User Name');
                     $("#uname").focus();
         				  return false;
         				}
         				if($("#email_id").val()=='')
         				{
         				alert('Please Type EmailId');
                     $("#email_id").focus();
         				  return false;
         				}
                     if($("#phone").val()=='')
         				{
         				alert('Please Type Phone Number');
                     $("#phone").focus();
         				  return false;
         				}
         	
         $.post("save.php",{uname: $('#uname').val(),fname: $('#fname').val(),lname: $('#lname').val(),password: $('#password').val(),email: $('#email').val(),phone: $('#phone').val(),describtion: $('#describtion').val(),dob: $('#dob').val(),command:"add_customer"},function(data){
            alert(data);
            if(data==0)
            {
               $("#insert_error").show(); 
            }
            else
            {
            $('#tab').html(data);
            $('input[type="text"], textarea,input[type="password"]').val('');
            }
             });
         
         }
         //edit key press
         function changeedit(id){
         $.post("save.php",{id: id,command:"edit_customer"},function(data){
            $('#myModal').modal('show');    
            $('#edittab').html(data);
            
             });
         
         }
         //update customer data
         function change2(id){
                  if($("#uname1").val()=='')
                  {
                  alert('Please Type User Name');
                  $("#uname1").focus();
                     return false;
                  }
                  if($("#email_id1").val()=='')
                  {
                  alert('Please Type EmailId');
                  $("#email_id1").focus();
                     return false;
                  }
                  if($("#phone1").val()=='')
                  {
                  alert('Please Type Phone Number');
                  $("#phone1").focus();
                     return false;
                  }
         $.post("save.php",{id1: $('#id1').val(),uname1: $('#uname1').val(),fname1: $('#fname1').val(),lname1: $('#lname1').val(),email1: $('#email1').val(),phone1: $('#phone1').val(),describtion1: $('#describtion1').val(),dob1: $('#dob1').val(),command:"update_customer"},function(data){
                $('#myModal').modal('hide'); 
                $('#tab').html(data);
                 });
             
             }
             //delete customer data
         function changedel(id){
         if(confirm("Are you sure you want to delete this customer?"))
         {
         $.post("save.php",{id: id,command:"delete_customer"},function(data){
         //alert(data);
         $('#tab').html(data);
         });
         
         }
         }
      </script>
   </body>
</html>