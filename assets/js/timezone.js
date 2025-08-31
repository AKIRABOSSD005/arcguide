document.addEventListener("DOMContentLoaded", function () {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;

    // Disable Google login until timezone is stored
    const googleBtn = document.querySelector('.btn-google');
    googleBtn.disabled = true;

    // Send timezone to PHP session
    fetch('../functions/setTimezone.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'visitorTimezone=' + encodeURIComponent(tz)
    })
    .then(() => {
        googleBtn.disabled = false; // enable button
        console.log('Timezone saved in session:', tz);
    })
    .catch(err => console.error('Timezone save error:', err));
});
