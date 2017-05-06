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

function formatGrade( grade ) {
    return grade.toFixed( 1 );
}

function getGrade( score, possible ) {
    return formatGrade( 100.0 * score / possible ) + ' %';
}

function makeIds( self, name, prefix ) {
    if ( prefix === null || prefix === undefined ) {
        prefix = "cs490";
    }
    self[ name + "Id" ]             = prefix + "-" + name.toLowerCase() + "-id";
    self[ name + "FormId" ]         = prefix + "-" + name.toLowerCase() + "-form-id";
    self[ name + "ListId" ]         = prefix + "-" + name.toLowerCase() + "-list-id";
    self[ name + "ErrorId" ]        = prefix + "-" + name.toLowerCase() + "-error-id";
    self[ name + "ListEmptyId" ]    = prefix + "-" + name.toLowerCase() + "-list-empty-id";
    self[ name + "ListHeaderId" ]   = prefix + "-" + name.toLowerCase() + "-list-header-id";
}
