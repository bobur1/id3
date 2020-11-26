// // delete selected records
// $('#delete_records').on('click', function (e) {
//     var product = [];
//     $(".prod_checkbox:checked").each(function () {
//         product.push($(this).data('prod-id'));
//     });
//     if (product.length <= 0) {
//         alert("Please select records.");
//     } else {
//         WRN_PROFILE_DELETE = "Are you sure you want to delete " + (product.length > 1 ? "these" : "this") + " row?";
//         var checked = confirm(WRN_PROFILE_DELETE);
//         if (checked == true) {
//             var selected_values = product.join(",");
//             $.ajax({
//                 type: "POST",
//                 url: "../classes/actionHandler.php",
//                 cache: false,
//                 data: 'prod_id=' + selected_values,
//                 success: function (response) {
//                 // remove deleted product rows
//                     var prod_ids = response.split(",");
//                     for (var i = 0; i < prod_ids.length; i++) {
//                         $("#prod" + prod_ids[i]).remove();
//                     }
//                 }
//             });
//         }
//     }
// });


// switcher options
// hide and show depend on Type Switcher selects option
$("#switcher").change(function() {
    switch($(this).val()) {
        case "dvd":
            $('#dvd').show();
            $('#size').attr('required', '');
            $('#size').attr('data-error', 'This field is required.');
            $('#book').hide();
            $('#weight').removeAttr('required');
            $('#weight').removeAttr('data-error');
            $('#furniture').hide();
            $('#height').removeAttr('required');
            $('#height').removeAttr('data-error');
            $('#width').removeAttr('required');
            $('#width').removeAttr('data-error');
            $('#length').removeAttr('required');
            $('#length').removeAttr('data-error');
            //alert("dvd");
            break;
        case "book":
            $('#book').show();
            $('#weight').attr('required', '');
            $('#weight').attr('data-error', 'This field is required.');
            $('#dvd').hide();
            $('#size').removeAttr('required');
            $('#size').removeAttr('data-error');
            $('#furniture').hide();
            $('#height').removeAttr('required');
            $('#height').removeAttr('data-error');
            $('#width').removeAttr('required');
            $('#width').removeAttr('data-error');
            $('#length').removeAttr('required');
            $('#length').removeAttr('data-error');
            //alert("Book");
            break;
        case "furniture":
            $('#furniture').show();
            $('#height').attr('required', '');
            $('#height').attr('data-error', 'This field is required.');
            $('#width').attr('required', '');
            $('#width').attr('data-error', 'This field is required.');
            $('#length').attr('required', '');
            $('#length').attr('data-error', 'This field is required.');
            $('#book').hide();
            $('#weight').removeAttr('required');
            $('#weight').removeAttr('data-error');
            $('#dvd').hide();
            $('#size').removeAttr('required');
            $('#size').removeAttr('data-error');
            //alert("Furniture");
            break;
            default:

            $('#book').hide();
            $('#dvd').hide();
            $('#furniture').hide();
            $('#weight').removeAttr('required');
            $('#weight').removeAttr('data-error');
            $('#size').removeAttr('required');
            $('#size').removeAttr('data-error');
            $('#height').removeAttr('required');
            $('#height').removeAttr('data-error');
            $('#width').removeAttr('required');
            $('#width').removeAttr('data-error');
            $('#length').removeAttr('required');
            $('#length').removeAttr('data-error');

    }
});
$("#switcher").trigger("change");


