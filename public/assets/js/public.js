var itemModel = function() {
	this.itemToAdd = ko.observable("");

	this.addItem = function(target) {
		var type = $(target).closest('div').attr('data-type');

		if (this.itemToAdd() != "") {

			var data = {
				'twitter': this.itemToAdd(),
				'type': type
			};

			$.ajax({
				url: window.location.pathname + '/friends/suggested',
				type: 'POST',
				data: data,
				context: this,
				success: function(returnedData) {
					$(target).find('.addItem-message').html('Suggested!');
					this.itemToAdd("");
				},
				error: function() {
					$(target).find('.addItem-message').html('There was an error!');
				}
			});
		}
	}.bind(this);
};

ko.applyBindings(new itemModel(), document.getElementById('old-friends'));
ko.applyBindings(new itemModel(), document.getElementById('new-friends'));