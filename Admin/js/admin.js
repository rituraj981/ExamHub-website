/* global bootstrap: false */
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
      new bootstrap.Tooltip(tooltipTriggerEl)
    })
  })()
  
   // Get the dropdown menu element
   var dropdownMenu = document.querySelector('.dropdown-menu');

   // Get the dropdown toggle button element
   var dropdownToggle = document.querySelector('.dropdown-toggle');

   // Toggle the dropdown menu when the toggle button is clicked
   dropdownToggle.addEventListener('click', function() {
       if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
           dropdownMenu.style.display = 'block';
       } else {
           dropdownMenu.style.display = 'none';
       }
   });

   // Close the dropdown menu when clicking outside of it
   document.addEventListener('click', function(event) {
       if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
           dropdownMenu.style.display = 'none';
       }
   });

 // JavaScript code to toggle sidebar width and show/hide sidebar
 function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (window.innerWidth <= 340) {
        if (sidebar.style.display === 'none' || sidebar.style.display === '') {
            sidebar.style.display = 'block';
        } else {
            sidebar.style.display = 'none';
        }
    } else if (window.innerWidth <= 640) {
        sidebar.classList.add('active');
    } else {
        sidebar.classList.remove('active');
    }
}

// Event listener for window resize
window.addEventListener('resize', toggleSidebar);

// Initial check
toggleSidebar();

document.addEventListener("DOMContentLoaded", function() {
    // Get all navigation links
    var navLinks = document.querySelectorAll('.nav-link');

    // Get all panels
    var panels = document.querySelectorAll('section, .Dashboard-panel, .student-panel, .exam_panel, .view-result-panel');

    // Function to show the corresponding panel when a tab is clicked
    function showPanel(event) {
        event.preventDefault();

        // Hide all panels
        panels.forEach(function(panel) {
            panel.style.display = 'none';
        });

        // Get the ID of the panel to show
        var targetId = this.getAttribute('href').substring(1);

        // Show the corresponding panel
        var targetPanel = document.getElementById(targetId);
        if (targetPanel) {
            targetPanel.style.display = 'block';
        }
    }

    // Add click event listener to each navigation link
    navLinks.forEach(function(navLink) {
        navLink.addEventListener('click', showPanel);
    });

    // Show all panels initially
    panels.forEach(function(panel) {
        panel.style.display = 'block';
    });
});