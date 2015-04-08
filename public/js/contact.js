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
        var contact_id = this.parentNode.parentNode.parentNode.childNodes[3].childNodes[11].value;
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

function addBackground() {
    var classes = this.className.split(" ");
    var cls;

    for(var i = 0; i < classes.length; i++) {
        if(classes[i] === 'delete-item') {
            cls = 'btn-danger';
        } else if(classes[i] === 'edit-item') {
            cls = 'btn-warning';
        } else if(classes[i] === 'cancel-item') {
            cls = 'btn-warning';
        } else if(classes[i] === 'save-item') {
            cls = 'btn-success';
        } else {
            //do nothing
        }
    }

    $(this).addClass(cls);
}

function removeBackground() {
    var classes = this.className.split(" ");
    var cls;

    for(var i = 0; i < classes.length; i++) {
        if(classes[i] === 'delete-item') {
            cls = ' btn-danger';
        } else if(classes[i] === 'edit-item') {
            cls = ' btn-warning';
        } else if(classes[i] === 'cancel-item') {
            cls = ' btn-warning';
        } else if(classes[i] === 'save-item')  {
            cls = ' btn-success';
        } else {
            //do nothing
        }
    }

    $(this).removeClass(cls);
}

function init() {
    var elements = document.getElementsByClassName('delete-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseenter', addBackground);
        }
    }

    var elements = document.getElementsByClassName('cancel-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseenter', addBackground);
        }
    }

    var elements = document.getElementsByClassName('save-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseenter', addBackground);
        }
    }

    var elements = document.getElementsByClassName('edit-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseenter', addBackground);
        }
    }

    var elements = document.getElementsByClassName('delete-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseleave', removeBackground);
        }
    }

    var elements = document.getElementsByClassName('edit-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseleave', removeBackground);
        }
    }

    var elements = document.getElementsByClassName('cancel-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseleave', removeBackground);
        }
    }

    var elements = document.getElementsByClassName('save-item');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('mouseleave', removeBackground);
        }
    }

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
    init();
}