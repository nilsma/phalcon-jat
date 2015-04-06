function selectList() {
    var contact_id = parseInt(document.getElementById('select-contact').value);

    if(contact_id === 0) {
        alert('creating new contact ...');
    } else if(contact_id > 0) {
        attachContact(contact_id);
    } else {
        // do nothing
    }
}

function showContactDetails(contact_id) {
    alert('test');
}

function attachContact(contact_id) {
    getContactDetails(contact_id, function(contact) {
        checkExistence(contact_id, function(existence) {
            resetSelectList(function() {

                if(!existence) {
                    injectHTML(contact, function() {
                        addContactListeners();
                    });
                } else {
                    //do nothing
                }

            });
        });
    });
}

function checkExistence(contact_id, callback) {
    var lis = document.querySelectorAll('ul#contacts-list li');
    var exists = false;

    if(lis.length > 0) {

        for(var i = 0; i < lis.length; i++) {
            if(contact_id == lis[i].id) {
                exists = true;
            }
        }

    }

    callback(exists);

}

function getContactDetails(contact_id, callback) {
    $.post("getContactDetails", { contact_id: contact_id}).done(function(result) {
        callback(JSON.parse(result));
    });
}

function injectHTML(object, callback) {
    var contacts_list = document.getElementById('contacts-list');

    var li = document.createElement('li');
    li.id = object['id'];
    li.className = 'bg-success';

    var div1 = document.createElement('div');
    li.appendChild(div1);

    var span1 = document.createElement('span');
    span1.className = 'contact-name';
    span1.innerHTML = '<a href="#">' + object['name'] + '</a>';

    if(object['position'].length > 0) {

        span1.innerHTML += ' (' + object['position'] + ')';

    }

    div1.appendChild(span1);

    var div2 = document.createElement('div');
    li.appendChild(div2);

    var button = document.createElement('button');
    button.type = 'button';
    button.className = 'btn btn-danger btn-xs contact-remove';
    button.innerHTML = 'remove';

    div2.appendChild(button);

    contacts_list.appendChild(li);

    callback();

}

function resetSelectList(callback) {
    $("#select-contact").val(-1);
    callback();
}

function notifyContactName() {
    var contact_id = parseInt(this.parentNode.parentNode.id);

    getContactDetails(contact_id, function(contact) {
        var string = 'Name: ' + contact['name'] + "\n";
        string += 'Position: ' + contact['position'] + "\n";
        string += 'Email: ' + contact['email'] + "\n";
        string += 'Phone: ' + contact['phone'] + "\n";
        string += 'Notes: ' + contact['notes'] + "\n";

        alert(string);
    });

}

function detachContact() {
    var child = this.parentNode.parentNode;
    var parent = child.parentNode;
    parent.removeChild(child);

    /*
    var lis = document.querySelectorAll('ul#contacts-list li');

    if(lis.length < 1) {

        var element = document.getElementById('contacts-list');

        var li = document.createElement('li');
        li.innerHTML = 'You have not attached any contacts yet.';

        element.appendChild(li);

    }
    */

}

function addContactListeners() {
    var elements = document.getElementsByClassName('contact-name');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', notifyContactName);
        }
    }

    var elements = document.getElementsByClassName('contact-remove');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', detachContact);
        }
    }
}

function saveApplication() {
    var contacts = new Array();
    var lis = document.querySelectorAll('ul#contacts-list li');

    for (var i = 0; i < lis.length; i++) {
        contacts.push(lis[i].id);
    }

    writeApplication(contacts, function() {
        location.href = 'overview';
    });
}

function writeApplication(contacts, callback) {
    var application_id = parseInt(document.getElementById('app_id').value);

    if(application_id == 'undefined') {
        application_id = null;
    }

    $.post("save", {
        app_id: application_id,
        company: document.getElementById('company').value,
        position: document.getElementById('position').value,
        recruitment: document.getElementById('recruitment').value,
        notes: document.getElementById('notes').value,
        applied: document.getElementById('applied').value,
        due_date: document.getElementById('due_date').value,
        follow_up: document.getElementById('follow_up').value,
        contacts: contacts
    }).done(function() {
        callback();
    });
}

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

function showContactDetails() {
    var contact_id = this.parentNode.childNodes[1].value;

    getContactDetails(contact_id, function(contact) {
        var details = 'Name: ' + contact['name'] + "\n";
        details += 'Position: ' + contact['position'] + "\n";
        details += 'Email: ' + contact['email'] + "\n";
        details += 'Phone: ' + contact['phone'] + "\n";
        details += 'Notes: ' + contact['notes'];

        alert(details);
    });

}

function init() {
    var elements = document.getElementsByClassName('contact-remove');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', detachContact);
        }
    }

    var elements = document.getElementsByClassName('attachment-details');
    if(elements.length > 0) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', showContactDetails);
        }
    }

    var element = document.getElementById('application-save');
    if(element !== null) {
        element.addEventListener('click', saveApplication);
    }

    var element = document.getElementById('application-delete');
    if(element !== null) {
        element.addEventListener('click', deleteApplication);
    }

    var element = document.getElementById('select-contact');
    if(element !== null) {
        element.addEventListener('change', selectList);
    }
}

window.onload = function() {
    init();
}