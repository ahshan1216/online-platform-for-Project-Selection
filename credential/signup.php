
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="  assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="  assets/img/favicon.png">
  <title>
    Signup
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="  assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="  assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="  assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
      <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href=" ">
        Project Selection
      </a>
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
          
         
          <li class="nav-item">
            <a class="nav-link me-2" href="../">
              <i class="fas fa-user-circle opacity-6  me-1"></i>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="  pages/sign-in.html">
              <i class="fas fa-key opacity-6  me-1"></i>
              Ranking
            </a>
          </li>
        </ul>
      
        <ul class="navbar-nav d-lg-block d-none">
          <li class="nav-item">
            <a href="signin.php" class="btn btn-sm btn-round mb-0 me-1 bg-gradient-light">Sign In</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('  assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Welcome!</h1>
              <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
              <div class="card-header text-center pt-4">
                <h5>Registration</h5>
              </div>
              
              <div class="card-body">
    <form role="form text-left" id="signupForm" method="post" action="submit.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Name" required>
        </div>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email" required>
        </div>
        <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" required>
        </div>
        <div class="mb-3">
            <label for="role">Role:</label>
            <select id="role" name="role" class="form-select" onchange="showForm()" required>
                <option value="">Select Option</option>
                <option value="student">Student</option>
                <option value="faculty">Teacher</option>
            </select>
        </div>
        <div id="studentForm" style="display: none;">
            <div class="mb-3">
                <label for="student_id">Student ID:</label>
                <input type="text" class="form-control" name="student_id" id="student_id" placeholder="Student ID" aria-label="Student ID" required>
            </div>
            <div class="mb-3">
                <label for="student_id_photo">ID Photo:</label>
                <input type="file" class="form-control" name="student_id_photo" id="student_id_photo" placeholder="ID Photo" aria-label="ID Photo" required>
            </div>
            <div class="mb-3">
                <label for="student_profile_picture">Profile Picture:</label>
                <input type="file" class="form-control" name="student_profile_picture" id="student_profile_picture" placeholder="Profile Picture" aria-label="Profile Picture" required>
            </div>
            <div class="mb-3">
                <label for="session1">session:</label>
                <input type="text" class="form-control" name="session1" id="session" placeholder="session" aria-label="sess" required>
            </div>
            <div class="mb-3">
                <label for="semester">Semester:</label>
                <input type="text" class="form-control" name="semester" id="semester" placeholder="Semester" aria-label="Semester" required>
            </div>
        </div>
        <div id="teacherForm" style="display: none;">
            <div class="mb-3">
                <label for="teacher_id">Teacher's ID:</label>
                <input type="text" class="form-control" name="teacher_id" id="teacher_id" placeholder="Teacher's ID" aria-label="Teacher's ID" required>
            </div>
            <div class="mb-3">
                <label for="teacher_id_photo">ID Photo:</label>
                <input type="file" class="form-control" name="teacher_id_photo" id="teacher_id_photo" placeholder="ID Photo" aria-label="ID Photo" required>
            </div>
            <div class="mb-3">
                <label for="teacher_profile_picture">Profile Picture:</label>
                <input type="file" class="form-control" name="teacher_profile_picture" id="teacher_profile_picture" placeholder="Profile Picture" aria-label="Profile Picture" required>
            </div>
            <div class="mb-3">
                <label for="session12">session:</label>
                <input type="text" class="form-control" name="session12" id="session" placeholder="session" aria-label="sess" required>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
        </div>
        <p class="text-sm mt-3 mb-0">Already have an account? <a href="signin.php" class="text-dark font-weight-bolder">Sign in</a></p>
    </form>
</div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
     <?php
include 'footer.php';
     ?>
    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  </main>
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
 
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="  assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>

  <script>
       function showForm() {
    var role = document.getElementById('role').value;
    var studentForm = document.getElementById('studentForm');
    var teacherForm = document.getElementById('teacherForm');

    // Reset required attribute for all fields
    var allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.removeAttribute('required');
    });

    if (role === 'student') {
        studentForm.style.display = 'block';
        teacherForm.style.display = 'none';

        // Set required attribute for student fields
        var studentInputs = studentForm.querySelectorAll('input, select');
        studentInputs.forEach(input => {
            input.setAttribute('required', true);
        });
    } else if (role === 'faculty') {
        studentForm.style.display = 'none';
        teacherForm.style.display = 'block';

        // Set required attribute for teacher fields
        var teacherInputs = teacherForm.querySelectorAll('input, select');
        teacherInputs.forEach(input => {
            input.setAttribute('required', true);
        });
    }
}

    </script>


    <script>
        document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    var formData = new FormData(this); // Create FormData object from form

    // Make a POST request to submit.php with form data
    fetch(this.action, {
        method: 'POST',
        body: formData // Include form data in the request body
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok'); // Throw error if response is not ok
        }
        return response.text(); // Read response body as text
    })
    .then(data => {
      if(data == 'New_record_created_successfully')
      {
        var websiteUrl = 'signin.php';
    // Redirect to the specified website
    window.location.href = websiteUrl;
      }
      else{
        alert('Email or ID already exists');
      }
        console.log('hi',data); // Log response body
        // Handle response data (if needed)
    })
    .catch(error => {
        console.error('Error:', error); // Log and handle errors
    });
});

    </script>





</body>

</html>