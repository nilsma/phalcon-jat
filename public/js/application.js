function deleteApplication() {
    if(confirm('Please confirm application deletion')) {
        var application_id = document.getElementById('app_id').value;
        deleteApplicationQuery(application_id, function(result) {
            if(result) {
                location.href = 'overview';
            } else {
                alert('Something went wrong while deleting contact');
            }
        });
    }
}

function deleteApplicationQuery(application_id, callback) {
    $.post("delete", { app_id: application_id}).done(function(result) {
        callback(result);
    });
}

function init() {
    var element = document.getElementById('application-delete');
    if(element !== null) {
        element.addEventListener('click', deleteApplication);
    }
}

window.onload = function() {
    init();
}