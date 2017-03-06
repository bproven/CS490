/* 
 *     File:        js/http.js
 *     Author:      Bob Provencher
 *     Created:     Mar 4, 2017
 *     Description: http methods
 */

function post( url, data, success, error ) {
    
    // create a json string from the request object
    var json = JSON.stringify( data );

    // create a request object
    var request = new XMLHttpRequest();
    
    // check for success function, then call
    var callSuccess = function( results, request ) {
        if ( success !== undefined && success !== null ) {
            success( results, request );
        }
    };
    
    // check for error function, then call
    var callError = function( request ) {
        if ( error !== undefined && error !== null ) {
            error( request );
        }
    };

    // attach a state change handler
    request.onreadystatechange = function() {

        // if the request is done
        if ( request.readyState === XMLHttpRequest.DONE ) {

            if ( request.status === 200 ) {

                var response = request.response;

                var results = JSON.parse( response );

                if ( results !== null ) {
                    callSuccess( results, request );
                }
                else {
                    callError( request );
                }

            }
            else {
                callError( request );
            }

        }

    };

    // open the request
    request.open( "POST", url, true );

    // set the type
    request.setRequestHeader( "Content-Type", "application/json" );

    // send the data
    request.send( json );

}


