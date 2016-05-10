(function ($) {
	var FRONTENDEDIT = {

		init: function () {
			this.initAlerts();
		},
		initAlerts: function () {
			$('.formhybrid-list .delete, .frontendedit-list .delete').on('click', function(event) {
				if (typeof Bootstrapper !== 'undefined')
				{
					var $this = $(this);

					event.preventDefault();

					Bootstrapper.confirm($this.data('message'), function() {
						window.location.href = $this.attr('href');
					});
				}
			});
		}
	};

	$(document).ready(function () {
		FRONTENDEDIT.init();
	});

})(jQuery);