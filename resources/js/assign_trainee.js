var checkboxes = [];
$("body").on("change", '.checkbox-class', function(checkbox){
    var id = checkbox.target.id;
    var arrPos = checkboxes.indexOf(id);
    if(arrPos > -1 && !checkbox.currentTarget.checked){
        checkboxes.splice(arrPos,1);
    }
    else if (checkbox.currentTarget.checked)
    {
        checkboxes.push(id);
    }
    $("#idOfHiddenInput").val(checkboxes);
});
