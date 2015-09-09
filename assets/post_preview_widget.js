jQuery(document).ajaxComplete(function() {
    jpp_init_post_title_autocomplete();
	jpp_init_post_type_change();
});

function jpp_init_post_title_autocomplete(){
	jQuery('input.jpp_post_preview_post_title.noinit').autocomplete({
		minLength: 1,
		source: function( request, response ) {
			var input = this.element;
			var form = jQuery(this.element).parents('div.jpp_form_controls');
			var post_type_control = jQuery(form).find('select.jpp_post_preview_post_type');
			var data = {
				action: 'jpp_widget_post_preview_autocomplete',
				post_type: post_type_control.val(),
				term: request.term
			};
			jQuery.post(ajaxurl, data, response);
		},
		select: function( event, ui ) {
			var control = jQuery(this);
			var form = control.parents('div.jpp_form_controls');
			control.val( ui.item.label );
			form.find('select.jpp_post_preview_post_type').val( ui.item.post_type );
			form.find('input.jpp_post_preview_post_id').val( ui.item.post_id );
			
			jpp_update_widget_post_preview_title(control);
		}
	})
	.removeClass('noinit');
}

function jpp_init_post_type_change(){
	jQuery('select.jpp_post_preview_post_type').change(function(){
		var form = jQuery(this).parents('div.jpp_form_controls');
		
		// clean up AC field
		form.find('input.jpp_post_preview_post_title').val('');
		form.find('input.jpp_post_preview_post_id').val('');
		jpp_update_widget_post_preview_title( this );
	})
	.removeClass('noinit');
}

function jpp_update_widget_post_preview_title( control ){
	var form = jQuery(control).parents('div.jpp_form_controls');
	var post_type = form.find('select.jpp_post_preview_post_type option:selected').text();
	var post_title = form.find('input.jpp_post_preview_post_title').val();
	form.find('input.jpp_post_preview_widget_title').val(post_type + ': ' + post_title);
}
