function selectList() {
    var value = parseInt(this.value);

    if(value < 1) {
        alert('creating new contact ...');
    } else if(value > 0) {
        loadContactDetails(value);
    } else {
        //TODO fix else-block

        var elements = [
            document.getElementById('contact-details'),
            document.getElementById('contact-controls')
        ];

        clearElementHTML(elements);
    }
}

function loadContactDetails(contact_id) {
    getContactDetails(contact_id, function(details) {

        var elements = [
            document.getElementById('contact-details'),
            document.getElementById('contact-controls')
        ];

        clearElementHTML(elements, function() {
            injectHTML(details, function() {
                appendContactAttachmentListeners(details['button_info']);
            });
        });
    });
}

function getContactDetails(contact_id, callback) {
    var app_id = parseInt(document.getElementById('app_id').value);

    $.post( "getContactDetails", { contact_id: contact_id, app_id: app_id})
        .done(function(data) {
            callback(JSON.parse(data));
        });
}

function clearElementHTML(elements, callback) {

    for(var i = 0; i < elements.length; i++) {
        elements[i].innerHTML = '';
    }

    callback();
}

function injectHTML(details, callback) {
    injectContactDetails(details['contact'], function() {
        injectButtonDetails(details['button_info'], function() {
            callback();
        });
    });
}

function injectContactDetails(contact_details, callback) {

    var element = document.getElementById('contact-details');
    var ul = document.createElement('ul');

    var name = document.createElement('li');
    name.innerHTML = 'Name: ' + contact_details['name'];

    var position = document.createElement('li');
    position.innerHTML = 'Position: ' + contact_details['position'];

    var phone = document.createElement('li');
    phone.innerHTML = 'Phone: ' + contact_details['phone'];

    var email = document.createElement('li');
    email.innerHTML = 'Email: ' + contact_details['email'];

    ul.appendChild(name);
    ul.appendChild(position);
    ul.appendChild(phone);
    ul.appendChild(email);

    element.appendChild(ul);

    callback();

}

function injectButtonDetails(button_details, callback) {
    var contact_controls = document.getElementById('contact-controls');

    var btn = document.createElement('p');
    var inner_text = '';
    var classNames = '';
    var button_id = '';

    if(button_details === 'attach') {
        button_id = 'attach-contact';
        classNames = 'btn btn-success';
        inner_text = 'Attach Contact';
    } else {
        button_id = 'detach-contact';
        classNames = 'btn btn-danger';
        inner_text = 'Detach Contact';
    }

    btn.id = button_id;
    btn.className = classNames;
    btn.innerHTML = inner_text;

    contact_controls.appendChild(btn);

    callback()

}

function appendContactAttachmentListeners(button_details) {
    var element = '';

    if(button_details === 'attach') {
        element = document.getElementById('attach-contact');

        if(element !== null) {
            element.addEventListener('click', attachContact);
        }

    } else {
        element = document.getElementById('detach-contact');

        if(element !== null) {
            element.addEventListener('click', detachContact);
        }

    }

}

function attachContact() {

    var contact_id = parseInt(document.getElementById('select-contact').value);

    if(contact_id > 0) {
        attachContactQuery(contact_id, function() {
            storeApplicationState(function() {
                location.reload();
            });
        });
    }

}

function attachContactQuery(contact_id, callback) {
    $.post("attachContact", {contact_id : contact_id}).done(function(result) {
        callback(result);
    });
}

function detachContact() {

    var contact_id = parseInt(document.getElementById('select-contact').value);

    if(contact_id > 0) {
        detachContactQuery(contact_id, function() {
            storeApplicationState(function() {
                location.reload();
            });
        });
    }

}

function detachContactQuery(contact_id, callback) {
    $.post("detachContact", {contact_id : contact_id}).done(function() {
        callback();
    });
}

function storeApplicationState(callback) {

    var object = {
        'company' : document.getElementById('company').value,
        'position' : document.getElementById('position').value,
        'recruitment' : document.getElementById('recruitment').value,
        'notes' : document.getElementById('notes').value,
        'applied' : document.getElementById('applied').value,
        'due_date' : document.getElementById('due_date').value,
        'follow_up' : document.getElementById('follow_up').value
    }

    $.post("storeApplicationState", {app_state : object})
        .done(function() {
            callback();
        });

}

function init() {
    var element = document.getElementById('select-contact');
    if(element !== null) {
        element.addEventListener('change', selectList);
    }
}

window.onload = function() {
    init();
}