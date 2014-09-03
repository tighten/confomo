var conferenceId = $('[data-conference-id]').data('conference-id'),
	confRoutePrefix = '/api/conferences/' + conferenceId + '/friends/';

var Item = function(item) {
    for (var prop in item) {
        this[prop] = item[prop];
    }
    this.met = ko.observable(item.met);
    this.type = ko.observable(item.type);
    this.notes = ko.observable(item.notes);

    this.markThisItemMet = function() {
        item.met = item.met == 1 ? 0 : 1;
        $.ajax({
            url: confRoutePrefix + item.id,
            type: 'PUT',
            data: item,
            context: this,
            success: function(result) {
                this.met(item.met);
            }
        });
    };

    this.approveSuggested = function() {
        var new_type = item.type.replace(/_suggested/g, '');
        item.type = new_type;

        $.ajax({
            url: confRoutePrefix + item.id,
            type: 'PUT',
            data: item,
            context: this,
            success: function(result) {
                this.type(new_type);
            }
        });
    };

    this.addNotesPopup = function(targ, e) {
        var $target = $(e.target);
        $target.closest('li').find('.add-notes-popover').toggle();
    };

    this.hideNotesPopup = function(targ, e) {
        var $target= $(e.target);
        $target.closest('li').find('.add-notes-popover').toggle();
    };

    this.addNotes = function(form) {
        item.notes = this.notes();
        console.log(item);
        $.ajax({
            url: confRoutePrefix + item.id,
            type: 'PUT',
            data: item,
            context: this,
            success: function(result) {
                $(form).closest('.add-notes-popover').toggle();
            }
        });
    };
};

var itemModel = function(items) {
    var in_items = [];
    for (var item in items) {
        in_items.push(new Item(items[item]));
    }

    this.items = ko.observableArray(in_items);
    this.itemToAdd = ko.observable("");
    this.addItem = function(target) {
        var type = $(target).closest('div').attr('data-type'),
	    met = type == 'new' ? '1' : '0',
	    twitter_regex = new RegExp(/(^|[^@\w])@(\w{1,15})\b/);

        if (this.itemToAdd() != "") {
	    if ( ! twitter_regex.test('@' + this.itemToAdd())) {
		alert('Bad twitter handle');
		return;
	    }

            var data = {
                    'twitter': this.itemToAdd(),
                    'type': type,
                    'met': met
                };

            $.ajax({
                url: confRoutePrefix,
                type: 'POST',
                data: data,
                context: this,
                success: function(returnedData) {
                    this.items.push(new Item(returnedData));
                    this.itemToAdd("");
		},
		error: function(returnedData) {
		    alert('There was an error!');
                }
            });
        }
    }.bind(this);

    this.remove = function (item) {
        $.ajax({
            url: confRoutePrefix + item.id,
            type: 'DELETE',
            context: this,
            success: function(result) {
                this.items.remove(item);
            }
        });
    }.bind(this);
};

if ($('#old-friends').length && $('#new-friends').length) {
    $.getJSON(confRoutePrefix, function(data) {
        // @todo sort to put suggested first
        oldFriends = ko.utils.arrayFilter(data, function(item) {
            return item.type.indexOf('old') > -1;
        });
        newFriends = ko.utils.arrayFilter(data, function(item) {
            return item.type.indexOf('new') > -1;
        });

        ko.applyBindings(new itemModel(oldFriends), document.getElementById('old-friends'));
        ko.applyBindings(new itemModel(newFriends), document.getElementById('new-friends'));
    });
}
