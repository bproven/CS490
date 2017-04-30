/* 
 *     File:    utils.js
 *     Author:  Bob Provencher
 *     Created: Apr 1, 2017
 */

function isEmpty( value ) {
    return value === undefined || value === null;
}

function isTrue( value ) {
    return value == true;
}

function boolToString( value ) {
    return isTrue( value ) ? "yes" : "no";
}

function isEmptyString( s ) {
    return isEmpty( s ) || s.length === 0;
}

function contains( s, sub ) {
    var result = true;                      // default: s is not empty and sub is empty
    if ( isEmptyString( s ) ) {             // if s is empty
        result = isEmptyString( sub );      // result is true if sub is empty
    }
    else if ( !isEmptyString( sub ) ) {     // neither is empty
        result = s.toLowerCase().indexOf( sub.toLowerCase() ) >= 0;
    }
    else {
        // s is not empty, and sub is empty.  take default of true.
    }
    return result;
}