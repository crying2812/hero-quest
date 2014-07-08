function setCards(action, post_id){
	//fetch nonce
	var nonce = jQuery('.current-quest').data('nonce');
	
	//Set which cards have been used or not!
	jQuery.ajax({
		type : "post",
		dataType : "json",
		url : hq_ajax.ajaxurl,
		data : {action: "ajax_set_cards", todo: action, nonce: nonce, post_id: post_id},
		success: function(response) {
			if(response.type === "error") {//Lets get crackin on them markers
				jQuery('.entry').append('<p>Ooops! Something went wrong there! Quickly, find a blacksmith to fix the issues!</p>');
			}else{
				
			}
		}
	});
}

function resetCards(){
	//fetch nonce
	var nonce = jQuery('.current-quest').data('nonce');
	
	//Set which cards have been used or not!
	jQuery.ajax({
		type : "post",
		dataType : "json",
		url : hq_ajax.ajaxurl,
		data : {action: "ajax_reset_cards", nonce: nonce},
		success: function(response) {
			if(response.type === "error") {//Lets get crackin on them markers
				jQuery('.entry').append('<p>Ooops! Something went wrong there! Quickly, find a blacksmith to fix the issues!</p>');
			}else{
				jQuery('.card').each(function(){
					jQuery(this).removeClass('used');
				});
			}
		}
	});
}


jQuery(document).ready(function (){

	//make sure the cards have equal heights to avoid layout issues
	//jQuery('.card').matchHeight();
	jQuery('.reset-cards').click(function(e){
		e.preventDefault();
		if(confirm('Are you sure?')){
			resetCards();
		}
		
	});
	
	
	jQuery('.card').click(function(){
		var action = 'add';
		var post_id = jQuery(this).data('id');
		if(jQuery(this).is('.used')){
			jQuery(this).removeClass('used');
			action = 'remove';
		}else{
			jQuery(this).addClass('used');
			action = 'add';
		}
		
		setCards(action, post_id);
	});
	
	//Smooth scrolling
	jQuery('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') || location.hostname === this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				jQuery('html,body').animate({
					scrollTop: target.offset().top
				}, 500);
				return false;
			}
		}
	});
	
	
});


