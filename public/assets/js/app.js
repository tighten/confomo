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
                    this.items.push(returnedData); // Adds the item. Writing to the "items" observableArray causes any associated UI to update.
                    this.itemToAdd(""); // Clears the text box, because it's bound to the "itemToAdd" observable
                }
            });
        }
    }.bind(this);  // Ensure that "this" is always this view model

    this.remove = function (item) {
        this.items.remove(item);
        $.ajax({
            url: '/friends/' + item.id,
            type: 'DELETE',
            success: function(result) {
                console.log(result);
            }
        });
    }.bind(this);
};

$.getJSON("/friends", function(data) {
//    oldFriendsModel.items(data);
    oldFriends = ko.utils.arrayFilter(data, function(item) {
        return item.type == 'old';
    });
    newFriends = ko.utils.arrayFilter(data, function(item) {
        return item.type == 'new';
    });

    ko.applyBindings(new itemModel(oldFriends), document.getElementById('old-friends'));
    ko.applyBindings(new itemModel(newFriends), document.getElementById('new-friends'));
});

