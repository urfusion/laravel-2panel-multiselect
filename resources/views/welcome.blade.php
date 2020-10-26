<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles -->
        <script src="https://use.fontawesome.com/ca8f7d677b.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{asset('css/style.css')}}" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="jumbotron text-center">
            <h1>Two-panel multiselect</h1>
        </div>
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <label>Add Item:</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="add_item" name="add_item" placeholder="Add Item">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-xs btn-primary" id="add_item_button" title="Add">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Available Items:</label>
                        <select name="from" id="multiselect" class="form-control" size="8">
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label>Actions</label>
                        <div class="col-md-6">
                            <button type="button" id="multiselect_rightSelected" class="btn btn-success" title="Move to right"><i class="fa fa-angle-right"></i></button>
                        </div>
                        <br />
                        <div class="col-md-6">
                            <button type="button" id="multiselect_leftSelected" class="btn btn-success"title="Move to left"><i class="fa fa-angle-left"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Selected Items:</label>
                        <select name="to" id="multiselect_to" class="form-control" size="8">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous"></script>
        <script src="{{asset('js/multiselect.js')}}"></script>
        <script type="text/javascript">
//laravel base url
var APP_URL = {!! json_encode(url('/')) !!}
$(function () {
    //multiselect plugin
    $('#multiselect').multiselect({
        //on click move to right button
        moveToRight: function (Multiselect, options, event) {
            //check value is not empty
            if (options.val() != '') {
                //appent option in another list box
                $('#multiselect_to').append($('<option>', {
                    value: options.val(),
                    text: options.val()
                }));
                //remove from option from current list box
                $("#multiselect option[value='" + options.val() + "']").remove();
                $.ajax({
                    type: "GET",
                    url: APP_URL + "/items/selected",
                    data: {
                        name: options.val()
                    },
                    success: function (response) {
                        if (response.status) {
                            console.log('Selected Item Updated');
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        alert("An error occered, " + errorThrown);
                    }
                });
            }
        },
        //on click move to right button
        moveToLeft: function (Multiselect, options, event) {
            //check value is not empty
            if (options.val() != '') {
                //appent option in another list box
                $('#multiselect').append($('<option>', {
                    value: options.val(),
                    text: options.val()
                }));
                //remove from option from current list box
                $("#multiselect_to option[value='" + options.val() + "']").remove();
                $.ajax({
                    type: "GET",
                    url: APP_URL + "/items/un-selected",
                    data: {
                        name: options.val()
                    },
                    success: function (response) {
                        if (response.status) {
                            console.log('Un-selected Item Updated');
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        alert("An error occered, " + errorThrown);
                    }
                });
            }
        }
    });

    //show items according to their status in respective select boxes
    function getItems() {
        $.ajax({
            type: "GET",
            url: APP_URL + "/items",
            success: function (response) {
                if (response.length > 0) {
                    $.each(response, function (i, item) {
                        if (item.is_selected == 0) {
                            $('#multiselect').append($('<option>', {
                                value: item.name,
                                text: item.name
                            }));
                        } else {
                            $('#multiselect_to').append($('<option>', {
                                value: item.name,
                                text: item.name
                            }));
                        }
                    });
                }
            },
            error: function (xhr, status, errorThrown) {
                alert("An error occered, " + errorThrown);
            }
        });
    }

    //call this function on page load
    getItems();

    //on click add_item_button add item in items select box
    $('#add_item_button').click(function (e) {
        e.preventDefault();
        var item = $('#add_item').val();
        var exists = false;
        if (item != '') {
            //validation check item is already exists or not
            $('#multiselect option').each(function () {
                if (this.value == item) {
                    exists = true;
                    alert('This item already exists.');
                }
            });

            //validation check item is already exists or not
            $('#multiselect_to option').each(function () {
                if (this.value == item) {
                    exists = true;
                    alert('This item already exists.');
                }
            });

            //execute the condition according to the valdiation
            if (exists == false) {
                $.ajax({
                    type: "GET",
                    url: APP_URL + "/items/create",
                    data: {
                        name: item
                    },
                    success: function (response) {
                        if (response.status) {
                            $('#multiselect').append($('<option>', {
                                value: item,
                                text: item
                            }));
                            $('#add_item').val('');
                        }
                    },
                    error: function (xhr, status, errorThrown) {
                        alert("An error occered, " + errorThrown);
                    }
                });
            }
        }
    });
});
        </script>
    </body>
</html>
