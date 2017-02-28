/* 
 *     File:        tests.js
 *     Author:      Bob Provencher
 *     Created:     Feb 27, 2017
 *     Description: cookie unit tests
 */

QUnit.test( 'makeCookiePart', function( assert ) {
    var s = makeCookiePart( 'name', 25 );
    assert.equal( s, 'name=25' );
});

QUnit.test( 'parseCookiePart', function( assert ) {
    var actual = {};
    var part = 'name=25';
    parseCookiePart( actual, part );
    assert.equal( actual.name, 25 );
});

QUnit.test( 'parseCookieStringToObject', function( assert ) {
    var cookieString = 'name1=23;name2=value2';
    var object = parseCookieStringToObject( cookieString );
    assert.equal( object.name1, 23 );
    assert.equal( object.name2, 'value2' );
});

QUnit.test( 'makeCookieStringFromObject', function( assert ) {
    var object = { name1: 23, name2: "value2" };
    var actual = makeCookieStringFromObject( object );
    assert.equal( actual, 'name1=23;name2=value2' );
});

QUnit.test( 'setCookieToString', function( assert ) {
    var actual = setCookieToString( 'name2', '30' );
    var exp = 'name2=30;path=/';
    assert.equal( actual, exp );
});

QUnit.test( 'getCookieFromString', function( assert ) {
    var s = 'name1=28;name2=56;name3=value3';
    assert.equal( getCookieFromString( 'name1', s ), '28' );
    assert.equal( getCookieFromString( 'name2', s ), '56' );
    assert.equal( getCookieFromString( 'name3', s ), 'value3' );
});

QUnit.test( 'saveStudent', function( assert ) {
    var student = {
        id: '123456',
        ucid: 'rap9'
    };
    saveStudent( student );
    assert.equal( getCookie( 'studentId' ), '123456' );
    assert.equal( getCookie( 'studentUcid'), 'rap9' );
});

QUnit.test( 'saveInstructor', function( assert ) {
    var instructor = {
        id: '234567',
        ucid: 'tej1'
    };
    saveInstructor( instructor );
    assert.equal( getCookie( 'instructorId' ), '234567' );
    assert.equal( getCookie( 'instructorUcid'), 'tej1' );
});

QUnit.test( 'getStudent', function( assert ) {
    var exp = {
        id: '123456',
        ucid: 'rap9'
    };
    saveStudent( exp );
    var actual = getStudent();
    assert.equal( actual.id, exp.id );
    assert.equal( actual.ucid, exp.ucid );
});

QUnit.test( 'getInstructor', function( assert ) {
    var exp = {
        id: '234567',
        ucid: 'tej1'
    };
    saveInstructor( exp );
    var actual = getInstructor();
    assert.equal( actual.id, exp.id );
    assert.equal( actual.ucid, exp.ucid );
});

