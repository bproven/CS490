/* 
 *     File:        js/bindings.js
 *     Author:      Bob Provencher
 *     Created:     Mar 1, 2017
 *     Description: binds objects to DOM elements, without jquery
 */

function createAndAddElement( elem, create, parent ) {
    var domElem = create( elem );
    parent.appendChild( domElem );
}

function createAndAddElementById( elem, create, parentId ) {
    var parent = getElementById( parentId );
    createAndAddElement( elem, create, parent );
}

function createAndAddElements( elems, create, parent ) {
    elems.forEach( function( elem ) {
        createAndAddElement( elem, create, parent );
    });
};

function createAndAddElementsById( elems, create, parentId ) {
    var parent = getElementById( parentId );
    createAndAddElements( elems, create, parent );
}

function clearElements( parent, tag ) {
    var nodes = parent.children;
    var length = nodes.length;
    for ( var i = length - 1; i >= 0; i-- ) {
        var node = nodes[ i ];
        if ( node.nodeType === Node.ELEMENT_NODE ) {
            if ( node.tagName.toLowerCase() === tag.toLowerCase() ) {
                parent.removeChild( node );
            }
        }
    }
}

function clearElementsById( parentId, tag ) {
    var parent = getElementById( parentId );
    clearElements( parent, tag );
}

function createAndReplaceElementsById( parentId, tag, elems, create ) {
    var parent = getElementById( parentId );
    clearElements( parent, tag );
    createAndAddElements( elems, create, parent );
}

function formToObject( form ) {
    var object = {};
    for ( var i = 0; i < form.elements.length; i++ ) {
        var elem = form.elements[ i ];
        if ( elem.type === 'checkbox' || elem.type === 'radio' ) {
            object[ elem.id ] = elem.checked;
        } 
        else if ( elem.type !== 'button' ) {
            object[ elem.id ] = elem.value;
        }
    }
    return object;
}

function formNameToObject( form ) {
    var object = {};
    for ( var i = 0; i < form.elements.length; i++ ) {
        var elem = form.elements[ i ];
        if ( elem.type === 'checkbox' || elem.type === 'radio' ) {
            object[ elem.name ] = elem.checked;
        } 
        else if ( elem.type !== 'button' ) {
            object[ elem.name ] = elem.value;
        }
    }
    return object;
}

function formToObjectById( formId ) {
    var form = getElementById( formId );
    return formToObject( form );
}

function formNameToObjectById( formId ) {
    var form = getElementById( formId );
    return formNameToObject( form );
}

function formToObjectArray( form ) {
    var array = [];
    for ( var i = 0; i < form.elements.length; i++ ) {
        var elem = form.elements[ i ];
        var item = { id: elem.id, name: elem.name, value: elem.value };
        array.push( item );
    }
    return array;
}

function formToObjectArrayById( formId ) {
    var form = getElementById( formId );
    return formToObjectArray( form );
}