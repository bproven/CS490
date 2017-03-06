/* 
 *     File:        js/cookies.js
 *     Author:      Bob Provencher
 *     Created:     Feb 27, 2017
 *     Description: basic cookie manipulation for session
 */

/** 
 * make name=value cookie part 
 * @param {String} cname  - the name portion of the name value pair
 * @param {String} cvalue - the value portion of th ename value pair
 * @returns {String} the name=value string
 */
function makeCookiePart( cname, cvalue ) {
    return cname + '=' + cvalue;
};

/** 
 * parse a cookie part and add it to the result object
 * @param {object} result - the object to add the new property to
 * @param {String} part   - the part or name-value pair to add to the object
 */
function parseCookiePart( result, part ) {
    var parts = part.split( '=' );
    result[ parts[ 0 ] ] = parts[ 1 ];
}

/**
 * parse a cookie string to an object
 * @param {type} cookieString
 * @returns {object} the object representing the cookie string
 */
function parseCookieStringToObject( cookieString ) {
    var result = {};
    var decodedCookie = decodeURIComponent( cookieString );
    var cookies = decodedCookie.split(';');
    for ( var i = 0; i < cookies.length; i++ ) {
        var part = cookies[ i ];
        part = part.trim();
        parseCookiePart( result, part );
    }
    return result;
}

/**
 * make a cookie string from an object
 * @param {object} cookies object
 * @returns {String} a string representing the cookie object
 */
function makeCookieStringFromObject( cookies ) {
    
    var s = '';
    
    for ( var elem in cookies ) {
        if ( s !== '' ) {
            s = s + ';';
        }
        s = s + makeCookiePart( elem, cookies[ elem ] );
    }
    
    return s;
    
}

/**
 * 
 * @param {String} cname
 * @param {String} cvalue
 * @returns {String}
 */
function setCookieToString( cname, cvalue ) {
    var cookieObject = {};
    cookieObject[ cname ] = cvalue;
    cookieObject[ 'path' ] = '/';
    return makeCookieStringFromObject( cookieObject );
}

/**
 * 
 * @param {String} cname
 * @param {String} cookieString
 * @returns {getCookieFromString.cookieObject|parseCookieStringToObject.result|object}
 */
function getCookieFromString( cname, cookieString ) {
    var cookieObject = parseCookieStringToObject( cookieString );
    return cookieObject[ cname ];
}

/**
 * 
 * @returns {object}
 */
function getCookieObject() {
    return parseCookieStringToObject( document.cookie );
}

/**
 * 
 * @param {String} cname
 * @param {String} cvalue
 */
function setCookie( cname, cvalue ) {
    document.cookie = setCookieToString( cname, cvalue );
}

/**
 * 
 * @param {String} cname
 * @returns {String}
 */
function getCookie( cname ) {
    return getCookieFromString( cname, document.cookie );
}

