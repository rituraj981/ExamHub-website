<?php

//index.php

include('../Admin/Examination.php');

$exam = new Examination;

include('header.php');

?>
   
</head>
<body>
<div class="containter">
		<?php
		if(isset($_SESSION["user_id"]))
		{
		?>

    <div class="header_language">
        <h3>GENERAL INSTRUCTIONS
        <div class="language_box">
            <span>Choose Your Default Language</span>
            <select class="selectbox-language" onchange="changeLanguage()">
            <option value="English">English</option>
            <option value="Hindi">हिंदी</option>
            </select>
        </div>
    </div>

<div class="containers" id="English">
    
    <h3 style="text-align: center;">Please Read the Instructions carefully</h3>
    <hr size="2" width="100%" color="black">

<h3 style="text-decoration: underline;">General Instructions:</h3>
    <Ol>
        <!-- <li>Total duration of DUET - DU JAT BMS BBA N BA Business Economics 02 - DUET 2018 is 120 min.</li> -->
        <li>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the ex When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.</li>
        <li>The Questions Palette displayed on the right side of screen will show the status of each question using one of the following symbols:</li>
        <ul>
            <li><img src="Images\Not_Visited.png" alt="Not Visited"> You have not visited the question yet.</li>
            <li><img src="Images\Not_Answered.png" alt="Not Answered"> You have not answered the question.</li>
            <li><img src="Images\Answered.png" alt="Answered"> You have answered the question.</li>
            <li><img src="Images\Marked_for_Review.png" alt="Marked for Review"> You have NOT answered the question, but have marked the question for review.</li>
            <li><img src="Images\Review_save.png" alt="Marked for Review">The question(s) "Answered and Marked for Review" will be considered for evalution.</li>
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

<!-- Checkbox with Label -->
<div class="check_button">
    <label for="agree">
    <input type="checkbox" id="agree" name="agree" value="agree" onchange="toggleProceedButton(this)">
    <span class="checkbox-label"> I agree to the terms and conditions</span>
    </label>
    <br>

    <!-- Proceed Button -->
    <button class="btn btn-success" id="proceed" onclick="proceedIfCheckeds()">Proceed</button>

    <script>
        function toggleProceedButton(checkbox) {
            var proceedButton = document.getElementById("proceed");
            proceedButton.disabled = !checkbox.checked;
        }

        function proceedIfCheckeds() {
            var agreeCheckbox = document.getElementById("agree");
            if (agreeCheckbox.checked) {
            location.href = 'enroll_exam.php';
            } else {
            alert("Please agree to the terms and conditions.");
            }
        }
    </script>
</div>
</div>

<div class="containers" id="Hindi">
  <h3 style="text-align: center;">कृपया निर्देशों को ध्यानपूर्वक पढ़ें</h3>
  <hr size="2" width="100%" color="black">

<h3 style="text-decoration: underline;">सामान्य निर्देश:</h3>
    <Ol>
        <!-- <li>Total duration of DUET - DU JAT BMS BBA N BA Business Economics 02 - DUET 2018 is 120 min.</li> -->
        <li>घड़ी सर्वर पर सेट की जाएगी. स्क्रीन के ऊपरी दाएं कोने में उलटी गिनती टाइमर आपके लिए परीक्षा पूरी करने के लिए उपलब्ध शेष समय प्रदर्शित करेगा। जब टाइमर शून्य पर पहुंच जाएगा, तो परीक्षा अपने आप समाप्त हो जाएगी। आपको अपनी परीक्षा समाप्त करने या जमा करने की आवश्यकता नहीं होगी।</li>
        <li>स्क्रीन के दाईं ओर प्रदर्शित प्रश्न पैलेट निम्नलिखित प्रतीकों में से किसी एक का उपयोग करके प्रत्येक प्रश्न की स्थिति दिखाएगा:</li>
        <ul>
            <li><img src="Images\Not_Visited.png" alt="Not Visited">आपने अभी तक प्रश्न का अवलोकन नहीं किया है. </li>
            <li><img src="Images\Not_Answered.png" alt="Not Answered"> आपने प्रश्न का उत्तर नहीं दिया है.</li>
            <li><img src="Images\Answered.png" alt="Answered">आपने प्रश्न का उत्तर दे दिया है. </li>
            <li><img src="Images\Marked_for_Review.png" alt="Marked for Review">आपने प्रश्न का उत्तर नहीं दिया है, लेकिन प्रश्न को समीक्षा के लिए चिह्नित किया है। </li>
            <li><img src="Images\Review_save.png" alt="Marked for Review">"उत्तर दिए गए और समीक्षा के लिए चिह्नित" प्रश्नों पर मूल्यांकन के लिए विचार किया जाएगा।</li>
        </ul>

        
        <li>आप प्रश्न पैलेट को संक्षिप्त करने के लिए प्रश्न पैलेट के बाईं ओर दिखाई देने वाले ">" तीर पर क्लिक कर सकते हैं, जिससे प्रश्न विंडो अधिकतम हो जाएगी। प्रश्न पैलेट को दोबारा देखने के लिए, आप "<" पर क्लिक कर सकते हैं जो प्रश्न विंडो के दाईं ओर दिखाई देता है।</li>
        <li>आप संपूर्ण प्रश्नपत्र की परीक्षा के दौरान भाषा बदलने के लिए अपनी स्क्रीन के ऊपरी दाएं कोने पर अपनी "प्रोफ़ाइल" छवि पर क्लिक कर सकते हैं। क्लिक करने पर आपको प्रश्न सामग्री को वांछित भाषा में बदलने के लिए एक ड्रॉप-डाउन मिलेगा।</li>
        <li>आप नीचे की ओर नेविगेट करने के लिए क्लिक कर सकते हैं और स्क्रॉल किए बिना, प्रश्न के शीर्ष पर नेविगेट करने के लिए क्लिक कर सकते हैं।</li>
    </Ol>

<h3 style="text-decoration: underline;">किसी प्रश्न पर नेविगेट करना:</h3>
  <ul>
    <li>किसी प्रश्न का उत्तर देने के लिए निम्नलिखित कार्य करें।</li>
    <ol>
      <li>उस क्रमांकित प्रश्न पर सीधे जाने के लिए रात में अपनी स्क्रीन के प्रश्न पैलेट में प्रश्न संख्या पर क्लिक करें। ध्यान दें कि इस विकल्प का उपयोग करने से वर्तमान प्रश्न का आपका उत्तर सहेजा नहीं जाता है।</li>
      <li>वर्तमान प्रश्न के लिए अपना उत्तर सहेजने के लिए Save & Next पर क्लिक करें और फिर अगले प्रश्न पर जाएँ।</li>
      <li>वर्तमान प्रश्न के लिए अपना उत्तर सहेजने के लिए मार्क फॉर रिव्यू एंड नेक्स्ट पर क्लिक करें, इसे समीक्षा के लिए चिह्नित करें और फिर अगले प्रश्न पर जाएं।</li>
    </ol>
  </ul>

<h3 style="text-decoration: underline;">एक प्रश्न का उत्तर देना</h3>
    <ol>
    <li>बहुविकल्पीय प्रकार के प्रश्नों को हल करने की प्रक्रिया।</li>
    <ol>
        <li>अपना उत्तर चुनने के लिए किसी एक प्रश्न के बटन पर क्लिक करें।</li>
        <li>अपने चुने गए उत्तर को अचयनित करने के लिए, चुने गए विकल्प के बटन पर दोबारा क्लिक करें या क्लियर रिस्पॉन्स बटन पर क्लिक करें।</li>
        <li>अपने चुने हुए उत्तर को बदलने के लिए दूसरे विकल्प के बटन पर क्लिक करें।</li>
        <li>अपना उत्तर सहेजने के लिए आपको Save & Next बटन पर क्लिक करना होगा।</li>
        <li>प्रश्न को समीक्षा के लिए चिह्नित करने के लिए, मार्क फॉर रिव्यू एंड नेक्स्ट बटन पर क्लिक करें।</li>
    </ol>
    <li>किसी ऐसे प्रश्न का उत्तर बदलने के लिए जिसका उत्तर पहले ही दिया जा चुका है, पहले उत्तर देने के लिए उस प्रश्न का चयन करें और फिर उस प्रश्न का उत्तर देने के लिए प्रक्रिया का पालन करें।</li>
    </ol>
<h3 style="text-decoration: underline;">एक प्रश्न का उत्तर देना.</h3>
    <ol>
        <li>इस प्रश्न पत्र के अनुभाग स्क्रीन के शीर्ष पट्टी पर प्रदर्शित होते हैं। किसी अनुभाग के प्रश्नों को अनुभाग के नाम पर क्लिक करके देखा जा सकता है। जो अनुभाग आप वर्तमान में देख रहे हैं वह हाइलाइट किया गया है।</li>
        <li>किसी अनुभाग के अंतिम प्रश्न पर सहेजें ^ अगला बटन पर क्लिक करने के बाद, आपको स्वचालित रूप से अगले अनुभाग के पहले प्रश्न पर ले जाया जाएगा।</li>
        <li>आप परीक्षा के दौरान अपनी सुविधा के अनुसार केवल निर्धारित समय के दौरान अनुभागों और प्रश्नों के बीच किसी भी चीज़ में फेरबदल कर सकते हैं।</li>
        <li>उम्मीदवार संबंधित अनुभाग सारांश को प्रश्न पैलेट के ऊपर प्रत्येक अनुभाग में दिखाई देने वाली किंवदंती के भाग के रूप में देख सकते हैं।</li>
    </ol>

<!-- Checkbox with Label -->
    <div class="check_button">
        <label for="agree">
            <input type="checkbox" id="agree" name="agree" value="agree" onchange="hindiProceedButton(this)">
            <span class="checkbox-label">मैं नियमों और शर्तों से सहमत हूं।</span>
        </label>
    <br>

    <!-- Proceed Button -->
    <button class="btn btn-success" id="proceed" onclick="proceedIfChecked()">Proceed</button>

    <script>
        function hindiProceedButton(checkbox) {
            var proceedButton = document.getElementById("proceed");
            proceedButton.disabled = !checkbox.checked;
        }

        function proceedIfChecked() {
            var agreeCheckbox = document.getElementById("agree");
            if (agreeCheckbox.checked) {
            location.href = 'enroll_exam.php';
            } else {
            alert("कृपया नियम व शर्तों की सहमति दें।");
            }
        }
    </script>
</div>
</div>

<script>
  // Function to set the initial display language to English
  function setInitialLanguage() {
    document.getElementById('English').style.display = 'block';
    document.getElementById('Hindi').style.display = 'none';
  }
  
  // Call the function when the page loads
  window.onload = setInitialLanguage;

  // Function to change language based on user selection
  function changeLanguage() {
    var selectedLanguage = document.querySelector('.selectbox-language').value;
    if (selectedLanguage === 'English') {
      document.getElementById('English').style.display = 'block';
      document.getElementById('Hindi').style.display = 'none';
    } else if (selectedLanguage === 'Hindi') {
      document.getElementById('English').style.display = 'none';
      document.getElementById('Hindi').style.display = 'block';
    }
  }
</script>

  <?php
  }
  ?>