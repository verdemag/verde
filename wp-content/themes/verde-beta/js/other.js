var gOverride = {
    urlBase: 'http://gridder.andreehansson.se/releases/latest/',
    gColor: '#FF0000',
    gColumns: 12,
    gOpacity: 0.1,
    pEnabled: false,
    setupEnabled: false,
    invert: true
}

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

!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
		if(!d.getElementById(id)){
				js=d.createElement(s);
				js.id=id;
				js.src=p+"://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js,fjs);
		}
}(document,"script","twitter-wjs");

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
