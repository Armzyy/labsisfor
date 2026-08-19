function hideLoader() {
    let myloader = document.getElementById('loader-wrapper');
    if (myloader) {
        myloader.classList.add('fade');
        setTimeout(function() {
            myloader.style.display = 'none';
        }, 500);
    }
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    hideLoader();
} else {
    document.addEventListener('DOMContentLoaded', hideLoader);
    window.addEventListener('load', hideLoader);
}

// Safety fallback: guaranteed dismissal after 1s even if other assets fail
setTimeout(hideLoader, 1000);