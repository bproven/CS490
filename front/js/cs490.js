/* 
 *     File:    tests.js
 *     Author:  Bob
 *     Created: Feb 27, 2017
 */

function saveStudent( student ) {
    setCookie( 'studentId', student.id );
    setCookie( 'studentUcid', student.ucid );
}

function saveInstructor( ins ) {
    setCookie( 'instructorId', ins.id );
    setCookie( 'instructorUcid', ins.ucid );
}

function getStudent() {
    return { 
        id: getCookie( 'studentId' ),
        ucid: getCookie( 'studentUcid' )
    };
}

function getInstructor() {
    return { 
        id: getCookie( 'instructorId' ),
        ucid: getCookie( 'instructorUcid' )
    };
}
