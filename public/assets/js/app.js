var itemModel = function(items) {
    this.items = ko.observableArray(items);
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
                    this.items.push(returnedData);
                    this.itemToAdd("");
                }
            });
        }
    }.bind(this);  // Ensure that "this" is always this view model

    this.markItemMet = function(item) {
        item.met = 1; // @todo: Can we do true/false?
        $.ajax({
            url: '/friends/' + item.id,
            type: 'PUT',
            data: item,
            success: function(result) {
            }
        });
    }.bind(this);

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

//    this.firstName = ko.observable(item.first_name);
//    this.lastName = ko.observable(item.last_name);
//    this.fullName = ko.computed(function() {
//        return this.firstName() + ' ' + this.lastName();
//    }, this);
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
