<?php

//Dashboard_Panel.php

include('Admin_panel.php');

?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Editors</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
          <li class="breadcrumb-item">Forms</li>
          <li class="breadcrumb-item active">Editors</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
      <div class="row">
          <div class="col-lg-12">
            <div class="sidebar-nav">
                <button class="btn">
                  <a class="nav-link collapsed" href="Online_exam_panel.php">
                    <img src="image\back_button.png" alt="Student Panel" width="25" height="25" class="me-2">
                    <span>Back</span>
                  </a> 
                </button>
            </div>
          </div>
        </div>
      <div class="row">
      <div class="card">
      
        <!-- <div class="col-lg-6"> -->
 
            <div class="card-body">
              <!-- <h5 class="card-title">Editor</h5> -->
                
              <!-- TinyMCE Editor -->
              <textarea class="tinymce-editor">
               
              </textarea>
              <!-- End TinyMCE Editor -->
            </div>
      
          <div class="" style="float: right">
                  <div class="sidebar-nav" style="float: right">                 
                      <button class="file" id="">
                          <span>Update Instructions</span>
                        </a> 
                      </button>
                    </div>
                    <div class="sidebar-nav" style="float: right">
                      <button class="submit" id="">
                          <span>Submit</span>
                        </a> 
                      </button>
                    </div>
                  </div>
                  </div>
        </div>
        
      </div>
    </section>
  </main>
  <!-- End #main -->
<?php

  //footer.php
  
  include('footer.php');
  
?>