document.getElementById('alertForm').addEventListener('submit', function(event) {
  event.preventDefault();

  // Get user input
  const alertDate = new Date(document.getElementById('alertDate').value);
  const phoneNumber = document.getElementById('phoneNumber').value.trim();

  // Validate the date
  if (isNaN(alertDate.getTime())) {
    alert('Please enter a valid date.');
    return;
  }

  // Set the time to 5:30 AM
  alertDate.setHours(15);
  alertDate.setMinutes(0);
  alertDate.setSeconds(0);

  // Calculate time difference in milliseconds
  const currentTime = new Date();
  const timeDiff = alertDate.getTime() - currentTime.getTime();

  // Schedule the alert
  if (timeDiff > 0) {
    setTimeout(function() {
      // This is where you would typically send an SMS alert using an API
      // For simplicity, we'll just show a browser notification
      const notificationMessage = `Alert: Sending message to ${phoneNumber}!`;
      new Notification('Scheduled Alert', { body: notificationMessage });
    }, timeDiff);
    
    alert(`Alert scheduled successfully for ${alertDate.toLocaleString()}.`);
    // Optionally clear the form
    document.getElementById('alertDate').value = '';
    document.getElementById('phoneNumber').value = '';
  } else {
    alert('Please enter a future date.');
  }
});
