jQuery( document ).ready( function() {

var TFQuickAdd = new function TFQuickAdd() {

	var self = this;
	
	// Events
	jQuery( '.add-new-h2' ).click( function(e) {
		e.preventDefault();
		
		self.getNewPostRow( function( rowData ) {
			self.insertRowIntoDOM( rowData );
		} );
		
		
	} );
	
	this.getNewPostRow = function( callback ) {
		
		var params = { action: 'tf_get_new_post_row', post_type:document.location.href.match(/post_type=([^#|&]+)/)[1] }
		jQuery.get(ajaxurl, params, function(r) {
			callback(r);
		} );
	}
	
	this.insertRowIntoDOM = function(rowdata) {
	
		jQuery( 'tbody#the-list' ).prepend( rowdata );
		jQuery( 'tbody#the-list' ).find('tr:first').addClass('new-quick-add-item').find( '.editinline' ).click();
	
	}
	
	// support hash bang
	if( window.location.hash == '#quick-add-new' )
		jQuery( '.add-new-h2' ).click();

}

} );