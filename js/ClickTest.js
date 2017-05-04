jQuery(document).ready(function () {
	jQuery("#userMenuCollapse").click(function () {
		if (jQuery(window).width() >= 801){	
			jQuery(".cart-container").toggleClass("hide");
		}	
		jQuery("#meta-container").toggleClass("collapsedSmall");
		jQuery("#meta-subContainer").toggleClass("dropped");
		jQuery(".fa:first").toggleClass("fa-chevron-up");
		jQuery(".fa:first").toggleClass("fa-chevron-down");
		jQuery(".tester").toggleClass("collapsedLarge");
		jQuery(".myAccountItem").toggleClass("hiddenItem");
		jQuery(".logOutItem").toggleClass("hiddenItem");
	});
});
