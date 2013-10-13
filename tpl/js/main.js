function ajaxUrl(href){
	href = href.replace(baseurl, '');
	splits = href.split('/');
	splits[0] = splits[0]+'/ajax';
	return baseurl+splits.join('/');
}



DM.init = function() {
 	if (typeof(baseurl) == 'undefined') 
 		var baseurl = '';

	if ($("#archive").length > 0){
		//Для атрибутов onClick() 
		showposts = DM.UI.archive.showposts;

		DM.UI.archive.init();
	}

}

DM.UI.archive = {
	init: function(){

		$( document ).on( "click", "#showposts, .pager a, .showentrie", function( e ) {

			if ($(this).attr('id')=='showposts' && $('#posts').html().length > 0 ) {
				$('#posts').html('');
			}
			else {
				url = ajaxUrl($(this).attr('href'));
				console.log(url)
				$('#load').html('<img src="/diaryMaHb9lk/tpl/images/tomat-24.gif">');
				$.ajax({
					type: 'get',
					url: url,
					data: {},
					success: function(data) {
						$('#posts').html(data);
						$('#load').html('');
						
					}
				})
			}
			return false;

		} ); 

	
	},

	foo: function(){


	}

	


}
