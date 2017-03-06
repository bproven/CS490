/* 
 *     File:        js/ui.js
 *     Author:      Bob Provencher
 *     Created:     Mar 4, 2017
 *     Description: UI code
 */

function showError( id, error, time, onTimer ) {
    var elem = document.getElementById( id );
    displayLabel( elem, true, error );
    if ( time !== undefined || time !== null || time <= 0 ) {
        time = 3000;
    }
    setTimeout( function() {
        elem.style.display = 'none';
        if ( onTimer !== undefined && onTimer !== null ) {
            onTimer();
        }
    }, time );
}

function displayLabel( elem, show, text ) {
    elem.style.display = show ? 'block' : 'none';
    elem.innerHTML = text;
}

function displayLabelById( id, show, text ) {
    var elem = document.getElementById( id );
    displayLabel( elem, show, text );
}

function verifyNotBlank( value, errorId, errorText ) {
    var result = !( value === undefined || value === null || value.length === 0 );
    if ( !result ) {
        showError( errorId, errorText );
    }
    return result;
}

function verifyFieldsNotBlank( object, fields ) {
    var result = true;
    fields.forEach( function( field ) {
        result = result && verifyNotBlank( object[ field ], field + "-error", field + " cannot be blank" );
    });
    return result;
}

function onPostError( request ) {
    showError( "page-error", "Error: Status Code " + request.status + ", " + request.statusText + " '" + request.response + "'", 3000 );
};
