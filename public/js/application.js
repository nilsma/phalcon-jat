function saveContactModalCreate() {
    getContactElements(function(contact) {
        resetContactModalElements(function() {
            saveContact(contact, function(contact_id) {
                contact.id = contact_id;
                appendContactToSelect(contact, function() {
                    attachContact(contact_id);
                    exitContactModalCreate();
                });
            });
        });
    });
}

function appendContactToSelect(contact, callback) {
    var options = document.getElementById('select-contact').options;

    options[options.length] = new Option(contact['name'], contact['id']);

    callback();
}

function getContactElements(callback) {
    var details = new Object();
    details.name = document.getElementById('contact-modal-create-name').value;
    details.position = document.getElementById('contact-modal-create-position').value;
    details.email = document.getElementById('contact-modal-create-email').value;
    details.phone = document.getElementById('contact-modal-create-phone').value;
    details.notes = document.getElementById('contact-modal-create-notes').value;
    callback(details);
}

function resetContactModalElements(callback) {

    document.getElementById('contact-modal-create-name').value = '';
    document.getElementById('contact-modal-create-position').value = '';
    document.getElementById('contact-modal-create-email').value = '';
    document.getElementById('contact-modal-create-phone').value = '';
    document.getElementById('contact-modal-create-notes').value = '';

    callback();

}

function saveContact(elements, callback) {
    $.post("/contacts/save", {
        name: elements['name'],
        position: elements['position'],
        email: elements['email'],
        phone: elements['phone'],
        notes: elements['notes']
    }).done(function(contact_id) {
        callback(JSON.parse(contact_id));
    });
}

function exitContactModalCreate() {
    resetSelectList(function() {
        $('#contact-modal-create').modal('hide');
    });
}

function selectList() {
    var contact_id = parseInt(document.getElementById('select-contact').value);

    if(contact_id === 0) {
        $('#contact-modal-create').modal('show');
    } else if(contact_id > 0) {
        attachContact(contact_id);
    } else {
        // do nothing
    }
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

        var hidden_id;
        for(var i = 0; i < lis.length; i++) {

            hidden_id = lis[i].childNodes[0].childNodes[0].value;

            if(contact_id == hidden_id) {
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
    li.className = 'bg-success';

    var div1 = document.createElement('div');
    li.appendChild(div1);

    var hidden = document.createElement('input');
    hidden.setAttribute('type', 'hidden');
    hidden.setAttribute('value', object['id']);
    div1.appendChild(hidden);

    var span1 = document.createElement('span');
    span1.className = 'contact-name';
    span1.innerHTML = '<a class="attachment-details">' + object['name'] + '</a>';

    if(object['position'].length > 0) {

        var br = document.createElement('br');
        span1.appendChild(br);

        var span2 = document.createElement('span');
        span2.className = 'hidden-xs';
        span2.innerHTML += ' (' + object['position'] + ')';
        span1.appendChild(span2);
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

function detachContact() {
    var child = this.parentNode.parentNode;
    var parent = child.parentNode;
    parent.removeChild(child);
}

function addContactListeners() {
    var elements = document.getElementsByClassName('contact-remove');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', detachContact);
        }
    }

    var elements = document.getElementsByClassName('attachment-details');
    if(elements !== null) {
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', showContactDetails);
        }
    }
}

//TODO refactor to include application logic/values from writeapplication method
function saveApplication() {
    var contacts = [];
    var lis = document.querySelectorAll('ul#contacts-list li');

    if(lis.length > 0) {
        var contact_id;
        for (var i = 0; i < lis.length; i++) {
            contact_id = lis[i].childNodes[0].childNodes[0].value;
            contacts.push(contact_id);
        }
    }

    writeApplication(contacts, function() {
        location.href = 'overview';
    });

}

function writeApplication(contacts, callback) {
    var element = document.getElementById('app_id');

    if(element != null) {
        $.post("save", {
            app_id: parseInt(element.value),
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
    } else {
        $.post("save", {
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
}

function deleteOverviewApplication() {
    if(confirm('Please confirm application deletion')) {
        var application_id = this.parentNode.parentNode.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[9].value;
        deleteApplicationQuery(application_id, function(result) {
            if(result) {
                location.reload();
            }
        });
    }
}

function deleteApplication() {
    if(confirm('Please confirm application deletion')) {
        var application_id = document.getElementById('app_id').value;
        deleteApplicationQuery(application_id, function(result) {
            if(result) {
                location.href = 'overview';
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

    var contact_id = this.parentNode.parentNode.childNodes[0].value;

    getContactDetails(contact_id, function(contact) {
        insertContactModalValues(contact, function() {
            $('#contact-modal-presentation').modal('show');
        });
    });
}

function insertContactModalValues(contact, callback) {
    var name = document.getElementById('contact-modal-presentation-name');
    var position = document.getElementById('contact-modal-presentation-position');
    var email = document.getElementById('contact-modal-presentation-email');
    var phone = document.getElementById('contact-modal-presentation-phone');
    var notes = document.getElementById('contact-modal-presentation-notes');

    name.value = contact['name'];
    position.value = contact['position'];
    email.value = contact['email'];
    phone.value = contact['phone'];
    notes.value = contact['notes'];

    callback();
}

function init() {

    var elements = document.getElementsByClassName('date-field');
    if(elements.length > 0) {
        for(var i = 0; i < elements.length; i++) {
            $(elements[i]).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        }
    }

    var element = document.getElementById('save-contact-modal-create');
    if(element !== null) {
        element.addEventListener('click', saveContactModalCreate);
    }

    var element = document.getElementById('exit-contact-modal-create');
    if(element !== null) {
        element.addEventListener('click', exitContactModalCreate);
    }

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

    var element = document.getElementById('save-application');
    if(element !== null) {
        element.addEventListener('click', saveApplication);
    }

    var element = document.getElementById('application-delete');
    if(element !== null) {
        element.addEventListener('click', deleteApplication);
    }

    var elements = document.getElementsByClassName('application-overview-delete');
    for(var i = 0; i < elements.length; i++) {
        if(elements[i] !== null) {
            elements[i].addEventListener('click', deleteOverviewApplication);
        }
    }

    var element = document.getElementById('select-contact');
    if(element !== null) {
        element.addEventListener('change', selectList);
    }

}

window.onload = function() {
    mainInit(function() {
        init();
    });
}