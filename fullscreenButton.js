// David 27/03/25  Allows Fullscreen button on a webpage to work in browsers while offering alternate icons/images for the fullscreen button itself.
document.addEventListener('DOMContentLoaded', function() {
    const fullscreenButton = document.getElementById('BUTTON_NAME_HERE');
    const fullscreenIcon = document.getElementById('BUTTON_ICON_NAME_HERE');

    fullscreenButton.addEventListener('click', toggleFullscreen);

    function toggleFullscreen() {
        if (!document.fullscreenElement &&
            !document.mozFullScreenElement &&
            !document.webkitFullscreenElement &&
            !document.msFullscreenElement) {
            // Enter fullscreen
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
            // Icon change will now be handled by the fullscreenchange event listener
        } else {
            // Exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            // Icon change will now be handled by the fullscreenchange event listener
        }
    }

    // Listen for the fullscreenchange event
    document.addEventListener('fullscreenchange', updateFullscreenButton);
    document.addEventListener('mozfullscreenchange', updateFullscreenButton);
    document.addEventListener('webkitfullscreenchange', updateFullscreenButton);
    document.addEventListener('msfullscreenchange', updateFullscreenButton);

    function updateFullscreenButton() {
        if (document.fullscreenElement ||
            document.mozFullScreenElement ||
            document.webkitFullscreenElement ||
            document.msFullscreenElement) {
            // In fullscreen
            fullscreenIcon.src = 'ICON_SOURCE_HERE';
            fullscreenIcon.alt = 'Exit Fullscreen';
        } else {
            // Not in fullscreen
            fullscreenIcon.src = 'ICON_SOURCE_HERE';
            fullscreenIcon.alt = 'Enter Fullscreen';
        }
    }
});
