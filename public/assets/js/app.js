var SimpleListModel = function(items) {
    this.items = ko.observableArray(items);
    this.itemToAdd = ko.observable("");
    this.addItem = function() {
        if (this.itemToAdd() != "") {
            var data = { 'twitter': this.itemToAdd() },
                that = this;

            $.post("/friends", data, function(returnedData) {
                that.items.push({
                    twitter: that.itemToAdd(),
                    first_name: '',
                    last_name: '',
                    id: returnedData.id
                }); // Adds the item. Writing to the "items" observableArray causes any associated UI to update.
                that.itemToAdd(""); // Clears the text box, because it's bound to the "itemToAdd" observable
            });
        }
    }.bind(this);  // Ensure that "this" is always this view model

    this.remove = function (item) {
        this.items.remove(item);
        console.log(item);
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
//    SimpleListModel.items(data);
    ko.applyBindings(new SimpleListModel(data));
});

