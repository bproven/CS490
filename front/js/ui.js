/* 
 *     File:        js/ui.js
 *     Author:      Bob Provencher
 *     Created:     Mar 4, 2017
 *     Description: UI code
 */

function showError( id, error, time, onTimer ) {
    var elem = getElementById( id );
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

function display( elem, show ) {
    elem.style.display = show ? 'block' : 'none';
}

function displayById( elemId, show ) {
    var elem = getElementById( elemId );
    display( elem, show );
}

function displayLabel( elem, show, text ) {
    display( elem, show );
    elem.innerHTML = text;
}

function displayLabelById( id, show, text ) {
    var elem = getElementById( id );
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

function showTab( tabs, tabs_data, i, show ) {
    if ( i >= 0 && i < tabs.length && i < tabs_data.length ) {
        tabs[ i ].setAttribute( 'class', show ? 'active' : '' );
        tabs_data[ i ].style.display = show ? 'block' : 'none';
    }
}

function tabClick( tabs, tabs_data, oldx, newx ) {
    showTab( tabs, tabs_data, oldx, false );
    showTab( tabs, tabs_data, newx, true );
    return newx;
}

function startActivity() {
    return;
    var elem = getElementById( "activity-loading-id" );
    if ( !isEmpty( elem ) ) {
        elem.classList.remove( "hide" );
    }
}

function stopActivity() {
    return;
    var elem = getElementById( "activity-loading-id" );
    if ( !isEmpty( elem ) ) {
        elem.className = "hide";
    }
}
