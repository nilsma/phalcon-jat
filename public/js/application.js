function selectList() {
    var value = parseInt(this.value);

    if(value < 1) {
        alert('creating new contact ...');
    } else if(value > 0) {
        loadContactDetails(value);
    } else {
        //TODO fix else-block
        var element = document.getElementById('contact-details');
        clearElementHTML(contact_details);
    }
}

function loadContactDetails(contact_id) {
    getContactDetails(contact_id, function(details) {
        var element = document.getElementById('contact-details');
        clearElementHTML(contact_details, function() {
            injectContactDetails(contact_details, details);
        });
    });
}

function getContactDetails(contact_id, callback) {
    $.post( "getcontactDetails", { contact_id: contact_id})
        .done(function(data) {
            callback(JSON.parse(data));
        });
}

function clearElementHTML(element, callback) {
    contact_details.innerHTML = '';
    callback();
}

function injectContactDetails(element, contact) {
    contact_details = document.getElementById('contact-details');
    var ul = document.createElement('ul');

    var name = document.createElement('li');
    name.innerHTML = 'Name: ' + contact['name'];

    var position = document.createElement('li');
    position.innerHTML = 'Position: ' + contact['position'];

    var phone = document.createElement('li');
    phone.innerHTML = 'Phone: ' + contact['phone'];

    var email = document.createElement('li');
    email.innerHTML = 'Email: ' + contact['email'];

    ul.appendChild(name);
    ul.appendChild(position);
    ul.appendChild(phone);
    ul.appendChild(email);

    contact_details.appendChild(ul);

}

function attachContact() {

    storeApplicationState(function() {

        var element = document.getElementById('select-contact');
        var value = parseInt(contact_details.value);

        // check if the user has actually selected a contact
        if(value > 0) {

            storeContact(value, function(result) {

                if(parseInt(result) > 0) {
                    //TODO add user feedback
                    //success
                } else {
                    //TODO add user feedback
                    //failure
                }

                location.reload();

            });

        } else {
            //TODO add user feedback
            alert('you must choose a contact first');
        }

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

function storeContact(contact_id, callback) {
    $.post("storeContact", { contact_id: contact_id})
        .done(function(data) {
            callback(data);
        });
}

function init() {
    var element = document.getElementById('select-contact');
    if(contact_details !== null) {
        contact_details.addEventListener('change', selectList);
    }

    var element = document.getElementById('attach-contact');
    if(contact_details !== null) {
        contact_details.addEventListener('click', attachContact);
    }
}

window.onload = function() {
    init();
}