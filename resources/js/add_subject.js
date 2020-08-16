var count =  1;
function addItem() {
    var item = $('<tr>', {
        id: 'item' + count,
    });
    var column_title = $('<td>');
    var title = $('<input>', {
        type: 'text',
        name: 'titleSubject[]',
        class: 'border-0 w-100',
        required: true,
    });
    var column_time = $('<td>');
    var time = $('<input>', {
        type: 'number',
        name: 'timeSubject[]',
        class: 'border-0 w-100',
        min: 2,
        required: true,
    });
    var column_delete = $('<td>');
    var delete_item = $('<button>', {
        class: 'btn red btn-xs',
        onclick : "deleteItem('item" + count + "')",
    });
    var delete_content = "delete";
    count++;
    column_title.append(title);
    column_time.append(time);
    delete_item.append(delete_content);
    column_delete.append(delete_item);
    item.append(column_title);
    item.append(column_time);
    item.append(column_delete);
    $('#subjects').append(item);
}
function deleteItem(itemIndex) {
    var query = "tr[id='" + itemIndex + "']";
    $(query).remove();
}
