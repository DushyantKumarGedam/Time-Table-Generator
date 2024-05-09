function generateTimetable() {
    // Use AJAX (e.g., XMLHttpRequest or fetch) to communicate with the server
    // and execute the PHP script.
    // Here, I'll use fetch for simplicity.

    fetch('/generate_timetable.php') // assuming your server listens on this endpoint
        .then(response => response.text())
        .then(data => {
            document.getElementById('timetableOutput').innerText = data;
        })
        .catch(error => console.error('Error:', error));
}
