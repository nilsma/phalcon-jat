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

function deleteOverviewContact() {
    if(confirm('Please confirm contact deletion')) {
        var contact_id = this.parentNode.childNodes[1].value;
        deleteContactQuery(contact_id, function(result) {
            if(result) {
                location.reload();
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

    var elements = document.getElementsByClassName('contact-overview-delete');
    for(var i = 0; i < elements.length; i++) {
        if(elements[i] !== null) {
            elements[i].addEventListener('click', deleteOverviewContact);
        }
    }

    var element = document.getElementById('contact-delete');
    if(element !== null) {
        element.addEventListener('click', deleteContact);
    }
}

window.onload = function() {
    mainInit(function() {
        init();
    });
}