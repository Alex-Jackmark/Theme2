jQuery(document).ready(function () {
	jQuery("#userMenuCollapse").click(function () {
		jQuery("#cart-container").toggle();
		jQuery("#meta-container").toggleClass("collapsedSmall");
		jQuery("#meta-subContainer").toggleClass("dropped");
		jQuery(".fa").toggleClass("fa-chevron-up");
		jQuery(".fa").toggleClass("fa-chevron-down");
		jQuery(".tester").toggleClass("collapsedLarge");
		jQuery(".myAccountItem").toggleClass("hiddenItem");
		jQuery(".logOutItem").toggleClass("hiddenItem");
	});
});
