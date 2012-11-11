(function ($) {
	var load = function (el, form, tabName) {
		el.html('Loading...');

		el.load(form.attr('action').replace('EditForm', 'FastTab'), {
			TabName: tabName
		}, function () {
			if(typeof tinyMCE != 'undefined'){
				el.find('textarea.htmleditor').each(function () {
					var id = this.id;
					setTimeout(function () {
						tinyMCE.execCommand("mceAddControl", true, id);
					}, 100);
				});
			}
		});
	};
	$('.DataObjectManager-popup,#Form_EditForm,#ModelAdminPanel').undelegate('.FastTab', 'click.FastTab');
	$('.DataObjectManager-popup,#Form_EditForm,#ModelAdminPanel').delegate('.FastTab', 'click.FastTab', function () {
		var el = $(this);
		if (!el.hasClass('FastTabLoaded')) {
			el.addClass('FastTabLoaded');
			load( $( el.attr('data-id') ), el.closest('form'), el.attr('data-name') );
		}
	});
	$('.current .FastTab').livequery(function () {
		var el = $(this);
		if (!el.hasClass('FastTabLoaded')) {
			el.addClass('FastTabLoaded');
			load( $( el.attr('data-id') ), el.closest('form'), el.attr('data-name') );
		}
	});
})(jQuery);