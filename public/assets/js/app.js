var itemModel = function(items ) {
    this.items = ko.observableArray(items);
    this.itemToAdd = ko.observable("");
    this.addItem = function(target) {
        var type = $(target).closest('div').attr('data-type');
        if (this.itemToAdd() != "") {
            var data = {
                    'twitter': this.itemToAdd(),
                    'type': type
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

