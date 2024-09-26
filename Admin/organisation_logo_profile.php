<?php

//Dashboard_Panel.php

include('Admin_panel.php');

?>
<style>
   body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
    }

    .container {
        /* max-width: 600px; */
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .section {
        margin-bottom: 20px;
    }

    .section label {
        font-weight: bold;
    }

    .content {
        margin-top: 10px;
    }

    .content p {
        margin: 5px 0;
    }

    .content input[type="text"], .content select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .content button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .content button:hover {
        background-color: #0056b3;
    }

    .package {
        font-weight: bold;
    }

    .hidden {
        display: none;
    }
    .field-group {
    margin-bottom: 15px;
    }

    .field-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .field-group input[type="text"],
    .field-group select {
        width: calc(100% - 40px);
        padding: 8px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .color-btn {
        padding: 8px;
        border: 1px solid #ccc;
        background-color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    .color-icon {
        font-size: 16px;
    }

    .hidden {
        display: none;
    }

    .field-group {
        margin-bottom: 15px;
    }

    .field-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .field-group input[type="text"] {
        width: calc(100% - 10px);
        padding: 8px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .field-group label input[type="radio"] {
        margin-left: 10px;
        margin-right: 5px;
    }

    .language-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .language-btn {
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #f4f4f4;
        border-radius: 4px;
        cursor: pointer;
    }

    .language-btn.selected {
        background-color: #dcdcdc;
        font-weight: bold;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .update-btn {
        background-color: #0066cc;
        color: white;
    }

    .cancel-btn {
        background-color: #cc0000;
        color: white;
    }

</style>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Organisation Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="Admin_panel.php">Home</a></li>
          <li class="breadcrumb-item active"><a href="organisation_profile.php">Organisation Profile</a></li>
          <li class="breadcrumb-item active">Organisation Logo Profile</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <h2>Edit Logo and Theme</h2>
            <div class="section">
                <input type="radio" id="organizationLogo" name="logoTheme" checked>
                <label for="organizationLogo">Organization Logo</label>
                <div class="content">
                    <p>Your selected package: <span class="package">Free</span></p>
                    <label for="orgName">Organization name:</label>
                    <input type="text" id="orgName" name="orgName" value="JD Developer" readonly>
                    <br><br>
                    <label for="orgLogo">Organization Logo:</label>
                    <button id="uploadLogoBtn">Update Logo</button>
                    <input type="file" id="orgLogo" name="orgLogo" style="display:none;">
                    <br><br>
                    <label for="logoDimension">Organization Logo dimension:</label>
                    <select id="logoDimension">
                        <option value="horizontal">Horizontal</option>
                        <option value="vertical">Vertical</option>
                    </select>
                    <br><br>
                    <label for="bannerImage">Organization banner Image:</label>
                    <button id="uploadBannerBtn">Upload Banner Image</button>
                    <input type="file" id="bannerImage" name="bannerImage" style="display:none;">
                </div>
            </div>
        </div>
        <br>
        <div class="container">
        <h2>Edit Background and Label Color</h2>
        <div class="section">
            <input type="radio" id="backgroundLabelColor" name="colorTheme" checked>
            <label for="backgroundLabelColor">Background and Label Color</label>
            <div class="content">
                <div class="field-group">
                    <label for="loginBgColor">Login Back ground Color:</label>
                    <input type="text" id="loginBgColor" name="loginBgColor" value="#9c27b0">
                    <button class="color-btn" data-target="loginBgColor"><i class="color-icon">🎨</i></button>
                </div>
                <div class="field-group">
                    <label for="footerBgColor">Footer Back ground Color:</label>
                    <input type="text" id="footerBgColor" name="footerBgColor" value="#9c27b0">
                    <button class="color-btn" data-target="footerBgColor"><i class="color-icon">🎨</i></button>
                </div>
                <div class="field-group">
                    <label for="headerBgColor">Header Back ground Color:</label>
                    <input type="text" id="headerBgColor" name="headerBgColor" value="#1721FF">
                    <button class="color-btn" data-target="headerBgColor"><i class="color-icon">🎨</i></button>
                </div>
                <div class="field-group">
                    <label for="footerLabelColor">Footer Label Color:</label>
                    <input type="text" id="footerLabelColor" name="footerLabelColor" value="#9c27b0">
                    <button class="color-btn" data-target="footerLabelColor"><i class="color-icon">🎨</i></button>
                </div>
                <div class="field-group">
                    <label for="headerLabelColor">Header Label Color:</label>
                    <input type="text" id="headerLabelColor" name="headerLabelColor" value="#9c27b0">
                    <button class="color-btn" data-target="headerLabelColor"><i class="color-icon">🎨</i></button>
                </div>
                <div class="field-group">
                    <label for="footerLabel">Footer Label:</label>
                    <input type="text" id="footerLabel" name="footerLabel" placeholder="Footer Label">
                </div>
                <div class="field-group">
                    <label for="pageTitle">Page Title:</label>
                    <input type="text" id="pageTitle" name="pageTitle" placeholder="Page Title">
                </div>
                <div class="field-group">
                    <label for="loginPageNote">Login Page Note:</label>
                    <input type="text" id="loginPageNote" name="loginPageNote" placeholder="Login Page Note">
                </div>
                <div class="field-group">
                    <label for="loginNoteFont">Login Note Font:</label>
                    <select id="loginNoteFont" name="loginNoteFont">
                        <option value="Arial">Arial</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Helvetica">Helvetica</option>
                    </select>
                </div>
                <div class="field-group">
                    <label for="loginNoteSize">Login Note Size:</label>
                    <input type="text" id="loginNoteSize" name="loginNoteSize" value="10px">
                </div>
                <div class="field-group">
                    <label for="loginNoteColor">Login Note Color:</label>
                    <input type="text" id="loginNoteColor" name="loginNoteColor" value="#9c27b0">
                    <button class="color-btn" data-target="loginNoteColor"><i class="color-icon">🎨</i></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const colorBtns = document.querySelectorAll('.color-btn');

        colorBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetInput = document.getElementById(this.dataset.target);
                const colorPicker = document.createElement('input');
                colorPicker.type = 'color';
                colorPicker.value = targetInput.value;

                colorPicker.addEventListener('input', function() {
                    targetInput.value = colorPicker.value;
                });

                colorPicker.click();
            });
        });

        // Toggle the visibility of the section
        const backgroundLabelColorRadio = document.getElementById('backgroundLabelColor');
        const content = document.querySelector('.content');

        backgroundLabelColorRadio.addEventListener('change', function() {
            if (backgroundLabelColorRadio.checked) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        });

        // Minimize or expand the section
        const sectionHeader = document.querySelector('.section > label');
        sectionHeader.addEventListener('click', function() {
            content.classList.toggle('hidden');
        });
    });
    </script>
 <div class="container">
        <h2>Domain Settings</h2>
        <div class="section">
            <input type="radio" id="domainSettings" name="settings" checked>
            <label for="domainSettings">Domain Settings</label>
            <div class="content">
                <div class="field-group">
                    <label for="candidateDomain">Candidate Domain:</label>
                    <input type="text" id="candidateDomain" name="candidateDomain" placeholder=".eklavvya.com">
                </div>
                <div class="field-group">
                    <label for="candidateUrl">Candidate URL:</label>
                    <input type="text" id="candidateUrl" name="candidateUrl" placeholder=".eklavvya.com/?ID=110986">
                </div>
                <div class="field-group">
                    <label>Candidate Mobile No. Optional:</label>
                    <label>
                        <input type="radio" name="candidateMobile" value="Yes"> Yes
                    </label>
                    <label>
                        <input type="radio" name="candidateMobile" value="No" checked> No
                    </label>
                </div>
                <div class="field-group">
                    <label>Enable Regional Exam User Interface:</label>
                    <div class="language-options">
                        <button class="language-btn selected">English</button>
                        <button class="language-btn">हिंदी (Hindi)</button>
                        <button class="language-btn">عربى (Arabic)</button>
                        <button class="language-btn">Français (French)</button>
                        <button class="language-btn">मराठी (Marathi)</button>
                        <button class="language-btn">Кыргызча (Kyrgyz)</button>
                        <button class="language-btn">española (Spanish)</button>
                        <button class="language-btn">Azərbaycan (Azerbaijani)</button>
                        <button class="language-btn">Русский (Russian)</button>
                    </div>
                </div>
                <div class="button-group">
                    <button class="btn update-btn">Update</button>
                    <button class="btn cancel-btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageBtns = document.querySelectorAll('.language-btn');

            languageBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    languageBtns.forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>

    </div>
</div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const uploadLogoBtn = document.getElementById('uploadLogoBtn');
    const orgLogoInput = document.getElementById('orgLogo');
    const uploadBannerBtn = document.getElementById('uploadBannerBtn');
    const bannerImageInput = document.getElementById('bannerImage');
    
    uploadLogoBtn.addEventListener('click', function() {
        orgLogoInput.click();
    });
    
    uploadBannerBtn.addEventListener('click', function() {
        bannerImageInput.click();
    });

    // Toggle the visibility of the section
    const orgLogoRadio = document.getElementById('organizationLogo');
    const content = document.querySelector('.content');

    orgLogoRadio.addEventListener('change', function() {
        if (orgLogoRadio.checked) {
            content.classList.remove('hidden');
        } else {
            content.classList.add('hidden');
        }
    });

    // Minimize or expand the section
    const sectionHeader = document.querySelector('.section > label');
    sectionHeader.addEventListener('click', function() {
        content.classList.toggle('hidden');
    });
});

</script>

<?php include('footer.php'); ?>
