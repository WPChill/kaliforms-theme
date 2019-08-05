<script src="https://f.convertkit.com/ckjs/ck.5.js"></script>

<form id="formkit-form" action="https://app.convertkit.com/forms/985370/subscriptions" class="seva-form formkit-form p-4 mb-4" method="post" data-sv-form="985370" data-uid="6f03210fb1" data-format="inline" data-version="5" data-options="{&quot;settings&quot;:{&quot;after_subscribe&quot;:{&quot;action&quot;:&quot;message&quot;,&quot;redirect_url&quot;:&quot;&quot;,&quot;success_message&quot;:&quot;Success! Now check your email to confirm your subscription.&quot;},&quot;return_visitor&quot;:{&quot;action&quot;:&quot;custom_content&quot;,&quot;custom_content&quot;:&quot;You're already subscribed! :)&quot;},&quot;recaptcha&quot;:{&quot;enabled&quot;:true}}}" min-width="400 500 600 700 800">
	<div data-style="minimal">
		<h5 class="formkit-header text-center" data-element="header">Want to stay in the loop?</h5>
		<div data-element="subheader" class="formkit-subheader text-center">
			<p>Sign up to join 3,000+ others that have joined us for WordPress news, tutorials, education and more...</p>
		</div>
		<ul class="formkit-alert formkit-alert-error" data-element="errors" data-group="alert"></ul>
		<div data-element="fields" data-stacked="true" class="seva-fields formkit-fields">
			<!-- <p class="formkit-field">
				<input class="formkit-input" aria-label="First Name" name="fields[first_name]" required="" placeholder="First Name" type="text">
			</p> -->
			<p class="formkit-field">
				<input class="formkit-input" name="email_address" placeholder="Your email address" required="" type="text">
			</p>
			<p class="formkit-field" style="font-size:14px; color: #ababb3;">
				<input id="gdpr-confirm" type="checkbox" value="false" required>
   				<label for="gdpr-confirm">I hereby confirm that I would like Kali Forms to deliver more information about their products, WordPress news and more to me by email</label>
			</p>
			<button data-element="submit" class="formkit-submit button button--small mb-0">
				<div class="formkit-spinner">
					<div></div>
					<div></div>
					<div></div>
				</div>
				<span>Subscribe</span>
			</button>
		</div>
		<!-- <div data-element="guarantee" class="formkit-guarantee">
			<p>We won't send you spam. Unsubscribe at any time.</p>
		</div> -->
	</div>
</form>

<script>
try {
	for (i = 0; i < window.localStorage.length; i++) {
	key = window.localStorage.key(i);
    if ( key.slice(0,12) === "cksubscribed") {
		var form = document.getElementById('formkit-form');
		form.style.display = "none";
    }
}
} catch(e) {}
</script>