var Item = function(item) {
    for (prop in item) {
        this[prop] = item[prop];
    }
    this.met = ko.observable(item.met);

    this.markThisItemMet = function() {
        item.met = item.met == 1 ? 0 : 1;
        $.ajax({
            url: '/friends/' + item.id,
            type: 'PUT',
            data: item,
            context: this,
            success: function(result) {
                this.met(item.met);
            }
        });
    }
};

var itemModel = function(items) {
    // Convert item arrays to Item objects.. not necessary but
    // hopefully eventually useful
    in_items = [];
    for (item in items) {
        in_items.push(new Item(items[item]));
    }

    this.items = ko.observableArray(in_items);
    this.itemToAdd = ko.observable("");
    this.addItem = function(target) {
        var type = $(target).closest('div').attr('data-type'),
            met = type == 'new' ? '1' : '0';

        if (this.itemToAdd() != "") {
            var data = {
                    'twitter': this.itemToAdd(),
                    'type': type,
                    'met': met
                };

            $.ajax({
                url: '/friends',
                type: 'POST',
                data: data,
                context: this,
                success: function(returnedData) {
                    this.items.push(new Item(returnedData));
                    this.itemToAdd("");
                }
            });
        }
    }.bind(this); // Ensure that "this" is always this view model

    this.remove = function (item) {
        $.ajax({
            url: '/friends/' + item.id,
            type: 'DELETE',
            context: this,
            success: function(result) {
                this.items.remove(item);
            }
        });
    }.bind(this);
};

if ($('#old-friends').length && $('#new-friends').length) {
    $.getJSON("/friends", function(data) {
        oldFriends = ko.utils.arrayFilter(data, function(item) {
            return item.type == 'old';
        });
        newFriends = ko.utils.arrayFilter(data, function(item) {
            return item.type == 'new';
        });

        ko.applyBindings(new itemModel(oldFriends), document.getElementById('old-friends'));
        ko.applyBindings(new itemModel(newFriends), document.getElementById('new-friends'));
    });
}
