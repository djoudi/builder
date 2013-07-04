<?php 
// Display when no creds are stored for this CRM, allow user to enter them OR sign-up for a new account.
//
// NOTE: $id string and $info array should be defined by the script including this one... 
?>
<div class="integrate-crm-box">
	<div class="enter-creds-box">
		<span>Enter your API Key:</span>
		<input id="<?php echo $id; ?>_api_key" class="api-key-field" type="text" />
		<a href="#" id="integrate_<?php echo $id; ?>" class="integrate-button">Integrate</a>
	</div>
	<div class="cred-lookup-box">
		<span> Don't know your API key?
			<a href="<?php echo $info["cred_lookup_url"]; ?>" class="api-lookup" target="blank">Find it here</a>
		</span>
	</div>
	<div class="sign-up-box">
		<span>Don't have an account with provider?
			<a href="<?php echo $info["referral_url"]; ?>" target="_blank">Sign-up here</a>
		</span>
	</div>
</div>