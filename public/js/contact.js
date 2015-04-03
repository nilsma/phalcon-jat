function deleteContact() {

    if(confirm('Please confirm contact deletion')) {

        var contact_id = document.getElementById('contact_id').value;
        deleteContactQuery(contact_id, function(result) {
            if(result) {
                location.href = 'overview';
            } else {
                alert('Something went wrong while deleting contact');
            }
        });

    }

}

function deleteContactQuery(contact_id, callback) {
    $.post("delete", { contact_id: contact_id}).done(function(result) {
        callback(result);
    });
}

function init() {

    var element = document.getElementById('contact-delete');
    if(element !== null) {
        element.addEventListener('click', deleteContact);
    }

}

window.onload = function() {

    init();

}