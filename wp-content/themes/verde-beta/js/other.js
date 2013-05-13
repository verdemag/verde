var gOverride = {
	urlBase: 'http://gridder.andreehansson.se/releases/latest/',
	gColor: '#FF0000',
	gColumns: 12,
	gOpacity: 0.1,
	pEnabled: false,
	setupEnabled: false,
	invert: true
};

var WePay = WePay || {};
WePay.load_widgets = WePay.load_widgets || function() { };
WePay.widgets = WePay.widgets || [];
WePay.widgets.push( {object_id: 11912,widget_type: "donation_campaign",anchor_id: "wepay_widget_anchor_50f8893bb9c9c",widget_options: {donor_chooses: true,allow_cover_fee: true,enable_recurring: true,allow_anonymous: true,button_text: "Help keep Verde running!"}});
if (!WePay.script) {
	WePay.script = document.createElement('script');
	WePay.script.type = 'text/javascript';
	WePay.script.async = true;
	WePay.script.src = 'https://static.wepay.com/min/js/widgets.v2.js';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(WePay.script, s);
} else if (WePay.load_widgets) {
	WePay.load_widgets();
}

/* function showGrid() {
 javascript:(function(){document.body.appendChild(document.createElement('script')).src='http://gridder.andreehansson.se/releases/latest/960.gridder.js';})();
 }*/

function genWidgets() {
	var tjs, fjs;
	var ffjs = document.getElementsByTagName('script')[0];
	var p=/^http:/.test(document.location)?'http':'https';
	if (document.getElementById('twitter-wjs'))
		tjs = document.createElement('script');
	if (document.getElementById('facebook-jssdk'))
		fjs = document.createElement('script');
	tjs.id = 'twitter-wjs';
	fjs.id = 'facebook-jssdk';
	tjs.src = p+"://platform.twitter.com/widgets.js";
	fjs.src = p+"://connect.facebook.net/en_US/all.js#xfbml=1";

	ffjs.parentNode.insertBefore(tjs, ffjs);
	ffjs.parentNode.insertBefore(fjs, ffjs);
}

genWidgets();
