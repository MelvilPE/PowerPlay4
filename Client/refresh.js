var refreshMilliseconds = 2000;

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

window.onload = timedRefresh(refreshMilliseconds);