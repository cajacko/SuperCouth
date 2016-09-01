/**
 * Make the home url available in all JavaScript files
 */
function getHomeUrl() {
	var doc = document.getElementById( 'html' );
 
	return doc.dataset.homeUrl; 
}