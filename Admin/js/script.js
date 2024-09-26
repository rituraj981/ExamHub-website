// Get the input element, search button, and close button
const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');
const closeButton = document.getElementById('closeButton');

// Add event listener to input field to detect Enter key press
searchInput.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') {
    // Trigger search action here
    alert('Search action triggered');
  }
});

// Add event listener to search button to trigger search action
searchButton.addEventListener('click', function() {
  // Trigger search action here
  alert('Search action triggered');
});

// Add event listener to close button to clear input field
closeButton.addEventListener('click', function() {
  searchInput.value = ''; // Clear the input field
});

// Add a button after every 5th row
window.onload = function() {
  var table = document.getElementById('exam_data_table');
  var rows = table.getElementsByTagName('tr');
  for (var i = 1; i < rows.length; i++) {
    if (i % 5 === 0) {
      var buttonCell = rows[i].insertCell(-1);
      var button = document.createElement('button');
      button.innerHTML = 'Button';
      button.className = 'custom-button'; // Add your custom button class here
      buttonCell.appendChild(button);
    }
  }
};


