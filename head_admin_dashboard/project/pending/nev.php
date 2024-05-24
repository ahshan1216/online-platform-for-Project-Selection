<style>
  #projectSubMenu {
  display: none;
}
  </style>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
<div class="sidenav-header">
<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
<a class="navbar-brand m-0" href="../../" >
<img src="../../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
<span class="ms-1 font-weight-bold">Admin Dashboard</span>
</a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link  " href="../../">
<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">

  <img src="svg/shop_icon.svg" alt="Shop Icon">
</div>
<span>Dashboard</span>
</a>
</li>
<li class="nav-item">
  <a class="nav-link active" href=" " id="projectLink">
    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
      <img src="svg/office.svg" alt="Shop Icon">
    </div>
    <span>Project </span>
  </a>
  <ul class="sub-menu" id="projectSubMenu">
  <li><a class="nav-link" href="../faculty_selection/">faculty_selection</a></li>
  <li><a class="nav-link" href="../pending">Project Manager</a></li>
    <li><a class="nav-link" href="../active/">Project Activity</a></li>
    <li><a class="nav-link" href="../complete/">Complete Project</a></li>
  </ul>
</li>

<li class="nav-item mt-3">
<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
</li>
<li class="nav-item">
<a class="nav-link " href="../../Profile_setting">
<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
  <img src="../../svg/customar.svg" alt="Shop Icon">
</div>
<span class="nav-link-text ms-1">Profile</span>
</a>
</li>
<li class="nav-item">
<a class="nav-link " href="../../../logout.php">
<div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
  <img src="../../svg/doccument.svg" alt="Shop Icon">
</div>
<span class="nav-link-text ms-1">Logout</span>
</a>
</li>

</ul>
</div>

 
</aside>

<script>
// Get the project link and sub-menu
const projectLink = document.getElementById('projectLink');
const projectSubMenu = document.getElementById('projectSubMenu');

// Add click event listener to the project link
projectLink.addEventListener('click', function(event) {
  // Prevent the default link behavior
  event.preventDefault();
  
  // Toggle the display of the sub-menu
  projectSubMenu.style.display = (projectSubMenu.style.display === 'block') ? 'none' : 'block';
});
  </script>