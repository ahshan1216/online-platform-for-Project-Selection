<?php

$student_id = $_SESSION['master_admin'];
$queryi = "SELECT * FROM users WHERE student_id = '$student_id'";
$resulti = mysqli_query($connection, $queryi);

if ($resulti && mysqli_num_rows($resulti) > 0) {
    $row = mysqli_fetch_assoc($resulti);
   
    $name = $row['name'];
    $session = $row['session'];
    $profile_photo= $row['profile_picture'];

   
}
?>


<style>
.thumbnail-circle {
    width: 40px; /* Adjust as needed */
    height: 40px; /* Adjust as needed */
    border-radius: 50%; /* Make it circular */
    overflow: hidden; /* Hide overflow */
}

.thumbnail-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Maintain aspect ratio and fill */
    
}

.ml-2 {
    margin-left: 0.5rem !important; /* Adjust as needed */
}

</style>

<li class="nav-item d-flex align-items-center">
<a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
<!--i class="fa fa-user me-sm-1"></i-->
<div class="d-flex align-items-center">
    <div class="thumbnail-circle">
        <img src="/uploads/students/<?php echo $profile_photo ?>?<?php echo time(); ?>" alt="Profile Photo">
    </div>
    <span class="ml-2"> <?php echo $name ?> </span>
</div>
<?php
if($user_group_number)
{

?>
<span class="ml-2">Group Number:  <?php echo $user_group_number ?> </span>
<?php
}
?>
</a>
</li>