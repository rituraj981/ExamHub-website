<?php

//Home_Panel.php

include('Admin_panel.php');

?>
<style>
 
    .slctlnguage_box {
        float: right;
        width: 15%;
        margin-right: 45px;
        
    }
    
    span.txt-slctlnge {
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        line-height: 14px;
    }

    select.selectbox-language {
        height: 35px;
        display: block;
        width: 200px;
        background: #fff;
        font-size: 17px;
        border: 1px solid #000;
        outline: none;
        margin: 5px 10px;
    }
    .container {
        margin: 55px 100px;
        /* text-align: center; */
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        color: #333;
    }
    #exam-container {
        display: none;
        margin-top: 20px;
    }
    #timer {
        margin-top: 10px;
        font-weight: bold;
        text-align: right;
    }
    #options {
        margin-top: 20px;
    
    }
    #options label {
        display: block;
        margin-bottom: 10px;
    }
    #options input[type="radio"] {
        margin-right: 5px;
    }
    #result {
        display: none;
        margin-top: 20px;
    }
    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 10px;
    }
    .btn-danger {
        background-color: #f44336;  
    }
    .check_button{
        text-align: center;
        font-size: 21px;
    }
    .check_button .check_btn{
        width: 180px;
        height: 37px;
        font-size: 19px;
        background: #5cb85c;
        border-radius: 12px;
        color: white;
        font-weight: bold;
        /* text-transform: uppercase; */
        margin-right: 15px;
        cursor: pointer;
            
    }
</style>
</head>

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Update Question Paper Instructions</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
                <li class="breadcrumb-item">Online Examination</li>
                <li class="breadcrumb-item active">Instructions</li>
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
              <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                <h3 style="text-align: center; margin: 10px">Please Read the Instructions carefully</h3>
                <hr size="2" width="100%" color="black">

                 <h3 style="text-decoration: underline;">General Instructions:</h3>
                <Ol>
                    <!-- <li>Total duration of DUET - DU JAT BMS BBA N BA Business Economics 02 - DUET 2018 is 120 min.</li> -->
                    <li>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the ex When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.</li>
                    <li>The Questions Palette displayed on the right side of screen will show the status of each question using one of the following symbols:</li>
                    <ul>
                        <li><img src="..\Student\Images\Not_Visited.png" alt="Not Visited"> You have not visited the question yet.</li>
                        <li><img src="..\Student\Images\Not_Answered.png" alt="Not Answered"> You have not answered the question.</li>
                        <li><img src="..\Student\Images\Answered.png" alt="Answered"> You have answered the question.</li>
                        <li><img src="..\Student\Images\Marked_for_Review.png" alt="Marked for Review"> You have NOT answered the question, but have marked the question for review.</li>
                        <li><img src="..\Student\Images\Review_save.png" alt="Marked for Review">The question(s) "Answered and Marked for Review" will be considered for evalution.</li>
                    </ul>

                    
                    <li>You can click on the ">" arrow which apperes to the left of question palette to collapse the question palette thereby maximizing the question window. To vie question palette again, you can click on "<" which appears on the right side of question window.</li>
                    <li>You can click on your "Profile" image on top right corner of your screen to change the language during the exam for entire question paper. On clicking of you will get a drop-down to change the question content to the desired language.</li>
                    <li>You can click on to navigate to the bottom and to navigate to top of the question are, without scrolling.</li>
                </Ol>

            <h3 style="text-decoration: underline;">Navigating to a Quetion:</h3>
                <Ul>
                    <li>To answer a question do the following.</li>
                    <ol>
                        <li>Click on the question number in the question palette at the night of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question</li>
                        <li>Click on Save & Next to save your answer for the current question and then go to the next question</li>
                        <li>Click on Mark for Review & Next to save your answer for the current question, mark it for review, and then go to the next question</li>
                    </ol>
                </Ul>

            <h3 style="text-decoration: underline;">Answering a Question</h3>
                <ol>
                <li>Procedure for anering a multiple choice type question.</li>
                <ol>
                    <li>To select your answer, click on the button of one of the question </li>
                    <li>To deselect your chosen answer, click on the button of the chosen option again or click on the Clear Response button</li>
                    <li>To change your chosen answer, click on the button of another option</li>
                    <li>To save your answer, you MUST click on the Save & Next button</li>
                    <li>To mark the question for review, click on the Mark for Review & Next button</li>
                </ol>
                <li>To change your answer to a question that has already been answered, first select that question for answering and then follow the procedure for answer that question</li>
                </ol>
            <h3 style="text-decoration: underline;">Answering a Question</h3>
                <ol>
                    <li>Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by click on the section name. the section you are currently viewing is highlighted.</li>
                    <li>After click the Save ^ Next button on the last question for a section, you will automatically be taken to the first question of the next section</li>
                    <li>You can shuffle between sections and questions anything during the examination as per your convenience only during the time stipulated.</li>
                    <li>Candidate can view the corresponding section summary as part of the legend that appears in every section above the question palette.</li>
                </ol>
            </div>
        </div>
    </div>
</section>
</main>
<?php

//footer.php

include('footer.php');

?>
