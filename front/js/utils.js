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
