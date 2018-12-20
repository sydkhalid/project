<?php 
include("plugins/connect.php");
if(isset($_POST['command'])){
$command=$_POST['command'];
date_default_timezone_set('Asia/Kolkata');
$c_date=date('d/m/Y');
if($command=='add_customer')
{
    $uname       = $_POST['uname'];
    $fname       = $_POST['fname'];
    $lname       = $_POST['lname'];
    $password    = $_POST['password'];
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $dob         = $_POST['dob'];
    $describtion = $_POST['describtion'];
$sql_u       = "SELECT * FROM tbl_customer WHERE uname='$uname' and email='$email'and phone='$phone'";
$res_u       = mysqli_query($conn, $sql_u);
if (mysqli_num_rows($res_u) > 0) {
    echo "0";
} else {
    $sql1 = "insert into tbl_customer(fname,lname,uname,password,email,phone,describtion,dob,status) 
    values('" . $_POST['fname'] . "','" . $_POST['lname'] . "','" . $_POST['uname'] . "','" . md5($_POST['password']) . "','" . $_POST['email'] . "','" . $_POST['phone'] . "','" . $_POST['describtion'] . "','" . $_POST['dob'] . "','1')";
    mysqli_query($conn,$sql1);
?><table id="example" class="table table-bordered table-striped">
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
<?php
}
}



if($command=='edit_customer')
{

$id=$_POST['id'];

				$sql="SELECT * from tbl_customer where  id='".$id."' order by id asc";
				$customer=mysqli_query($conn,$sql);
				$cus_details=mysqli_fetch_array($customer)
				
?>
<h3 class="btn btn-warning" style="font-size: 18px; width: 100%; font-weight:bold;">Update Customer</h3>
<input type="hidden" name="id1" value="<?php echo $cus_details['id'];?>" id="id1">
			<div class="col-md-6">
			<label for="usename">Username:</label>
			<input type="text" name="uname1" value="<?php echo $cus_details['uname'];?>" class="form-control checkusername" id="uname1"><span id="name_status"></span>
			</div>
			<div class="col-md-6">
			<label for="fname">First Name:</label>
			<input type="text"  name="fname1" value="<?php echo $cus_details['fname'];?>" class="form-control" id="fname1" oninput="validateAlpha();" >
			</div>
			<div class="col-md-6">
			<label for="lname">Last Name:</label>
			<input type="text" name="lname1" value="<?php echo $cus_details['lname'];?>" class="form-control" id="lname1" oninput="validateAlpha1();">
			</div>
			<div class="col-md-6">
			<label for="email">E Mail:</label>
			<input type="text" name="email1" value="<?php echo $cus_details['email'];?>" class="form-control checkemail" id="email1" onChange="validateEmail(this);">
			</div>
			<div class="col-md-6">
			<label for="phone">Phone:</label>
			<input type="text" name="phone1" value="<?php echo $cus_details['phone'];?>" class="form-control checkphone" min="10" max="15" id="phone1" oninput="isNumberKey();">
			</div>
			<div class="col-md-6">
			<label for="dob">Dob:</label>
			<input type="text" name="dob1" value="<?php echo $cus_details['dob'];?>" class="form-control" id="dob1">
			</div>
			<div class="col-md-12">
			<label for="describtion">Describtion:</label>
			<textarea name="describtion1" id="describtion1" class="form-control"><?php echo $cus_details['describtion'];?></textarea>
			</div> 
            <center><input type="submit" class="btn btn-success btn-rounded" value="Update" onclick="change2(<?php echo $cus_details['id'];?>);"></center>
		
                    
<?php
}

if($command=='update_customer')
{
    $id          = $_POST['id1']; 
    $uname       = $_POST['uname1'];
    $fname       = $_POST['fname1'];
    $lname       = $_POST['lname1'];
    $email       = $_POST['email1'];
    $phone       = $_POST['phone1'];
    $dob         = $_POST['dob1'];
    $describtion = $_POST['describtion1'];
    $sql="update tbl_customer set uname='".$_POST['uname1']."',fname='".$_POST['fname1']."', lname='".$_POST['lname1']."',email='".$_POST['email1']."',phone='".$_POST['phone1']."',dob='".$_POST['dob1']."',describtion='".$_POST['describtion1']."'  where id='$id'";
    mysqli_query($conn,$sql);
?>

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
<?php
}


if($command=='delete_customer')
{
$id          = $_POST['id']; 
$sql="update tbl_customer set status='0' where id='$id'";
mysqli_query($conn,$sql);
?>
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
<?php
}
if($command=='username_check')
{
 $uname=$_POST['uname'];
 $checkdata=" SELECT uname from tbl_customer WHERE uname='$uname' ";
 $query=mysqli_query($conn,$checkdata);
 if(mysqli_num_rows($query)>0)
 {
  echo "0";
 }
 else
 {
  echo "1";
 }
}
if($command=='email_check')
{
 $email=$_POST['email'];
 $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
  $checkdata=" SELECT email from tbl_customer WHERE email='$email' ";
 $query=mysqli_query($conn,$checkdata);
 $num =mysqli_num_rows($query);
 if($num>0 )
 {
	 echo "0";
	}
 else if (!preg_match($regex, $email))
 {
  echo "2";
 } 
 else
 {
	 echo "1";
 }
}
if($command=='phone_check')
{
 $phone=$_POST['phone'];
 $checkdata=" SELECT phone from tbl_customer WHERE phone='$phone' ";
 $query=mysqli_query($conn,$checkdata);
 if(mysqli_num_rows($query)>0)
 {
  echo "0";
 }else if(strlen($phone)<10)
 {
	 echo "2";
	}else
	{
		echo "1";}
}


if($command=='password_check')
{
$password=$_POST['password'];
if (strlen($password) < 8)
{
echo "0";
}
 else if (!preg_match('/^(?=[^\d]*\d)(?=[A-Z\d ]*[^A-Z\d ]).{8,}$/i', $password))
{
echo "1";
}
else{
	echo "2";
}
}


}
?>