@if(Request::route()->getName() == 'detail')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId="+app_id;
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
@endif

@if(Request::is('contact'))
<script type="text/javascript" src="{{ URL::asset('assets/classie/classie.js') }}"></script>
@endif
<script type="text/javascript" src="{{ elixir('js/all.js') }}"></script>
<!--<script type="text/javascript" src="{{ elixir('js/scripts.js') }}"></script>-->
<script type="text/javascript" src="{{ URL::asset('assets/js/scripts.js?v=1.0.0') }}"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?callback=initialize&libraries=places" async defer></script>-->

<script type="text/javascript">
	$(document).ready(function() {
		var contdesc = $("#content-description");
		var contdescHTML = contdesc.html();
		var shortcodepattern = new RegExp(/\[(\w+)(\s(\w+)="(\w+)")+\]/, 'g');
		if(!contdescHTML){
			return;
		}

		var fndshortcode = contdescHTML.match(shortcodepattern);
		if( ( null !== fndshortcode ) && ( fndshortcode.length > 0 ) ){
			var shortcodetext = fndshortcode.join();
			$.ajax({
			  method: "POST",
			  url: "http://welovepro.com/utility/fbphotocode",
			  data: { shtcd: shortcodetext }
			})
			  .done(function( data ) {
				var rest = jQuery.parseJSON( data );
				if( rest.res == 'OK' && rest.data.length > 0 ){
					for(var lp=0; lp<rest.data.length; lp++){
						/* console.log( rest.data[lp].key );
						console.log( rest.data[lp].rpl ); */
						contdescHTML = contdescHTML.replace( rest.data[lp].key, rest.data[lp].rpl );
					}
				contdesc.html( contdescHTML );
				}
			  });
		}
	});
</script>

<!--- GoogleAnalytics --->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-7620437-1', 'auto');
  ga('send', 'pageview');

</script>
