(function ($) {
	var FRONTENDEDIT = {

		init: function () {
			this.initAlerts();
		},
		initAlertify: function(labelOK, labelCancel) {
			alertify.set({
				labels: {
					ok     : labelOK,
					cancel : labelCancel
				}
			});
		},
		initAlerts: function () {
			FRONTENDEDIT.initAlertify('Ja', 'Nein');

			$('.frontendedit-list .remove').on('click', function(event) {
				var $this = $(this);

				event.preventDefault();

				alertify.confirm($this.data('message'), function (e) {
					if (e) {
						window.location.href = $this.attr('href');
					}
				});
			});
		}
	};

	$(document).ready(function () {
		FRONTENDEDIT.init();
	});

})(jQuery);