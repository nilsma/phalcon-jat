function getIconBackgroundClass(element, callback) {
    var classes = element.className.split(" ");
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

    callback(cls);
}

function addBackground() {
    var element = this;
    getIconBackgroundClass(element, function(cls) {
        $(element).addClass(cls);
    });
}

function removeBackground() {
    var element = this;
    getIconBackgroundClass(element, function(cls) {
        $(element).removeClass(cls);
    });
}

function addIconHoverListeners(array) {
    array.forEach(function(entry) {
        var elements = document.getElementsByClassName(entry);
        if(elements !== null) {
            for(var i = 0; i < elements.length; i++) {
                elements[i].addEventListener('mouseenter', addBackground);
                elements[i].addEventListener('mouseleave', removeBackground);
            }
        }
    });
}

/**
 * main-init method called from application.js and contact.js on window.load,
 * to ensure functionality shared between application.js and contact.js is loaded before callback
 * which in turn runs the file-specific (application.js and contact.js) init method
 * @param callback
 */
function mainInit(callback) {
    var classes = ['delete-item', 'edit-item', 'cancel-item', 'save-item'];
    addIconHoverListeners(classes);

    callback();
}