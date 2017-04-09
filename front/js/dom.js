/* 
 *     File:    js/dom.js
 *     Author:  Bob Provencher
 *     Created: Apr 1, 2017
 */

function asTableCell( elem ) {
    return elem.tagName.toLowerCase() === "td" ? elem : createTableCell( elem );
}

function appendChild( parent, child ) {
    if ( !isEmpty( parent ) && !isEmpty( child ) ) {
        if ( parent.tagName.toLowerCase() === "tr" ) {
            parent.appendChild( asTableCell( child ) );
        }
        else {
            parent.appendChild( child );
        }
    }
}

function createAnchor( href, id, innerHTML, onclick, parent ) {
    
    var elem = document.createElement( "a" );
    
    elem.href = href;
    elem.id = id;
    elem.innerHTML = innerHTML;
    elem.onclick = onclick;
    
    appendChild( parent, elem );
    
    return elem;
    
}

function createInput( id, type, name, value, parent ) {
    
    var elem = document.createElement( "input" );
    
    elem.id = id;
    elem.type = type;
    elem.name = name;
    elem.value = value;
    
    appendChild( parent, elem );
    
    return elem;

}

function createCheckbox( id, name, checked, parent ) {
    
    var elem = createInput( id, "checkbox", name, null, parent );
    
    elem.checked = checked;
    
    return elem;
    
}

function createLabel( id, text, parent ) {
    
    var elem = document.createElement( "label" );
    
    elem.id = id;
    elem.innerHTML = text;
    
    appendChild( parent, elem );
    
    return elem;
    
}

function createTextArea( id, cols, rows, parent ) {
    
    var elem = document.createElement( "textarea" );
    
    elem.id = id;
    elem.cols = cols;
    elem.rows = rows;
    
    appendChild( parent, elem );
    
    return elem;
    
}

function createTableCell( child, parent ) {
    
    var td = document.createElement( "td" );
    
    appendChild( td, child );
    appendChild( parent, td );
    
    return td;
    
}

function createTableRow( childElem ) {

    var tr = document.createElement( "tr" );
    
    appendChild( tr, childElem );
    
    return tr;

}

function createOption( id, text ) {
    
    var option = document.createElement( "option" );
    
    option.id = id;
    option.value = id;
    option.innerHTML = text;
    
    return option;
    
}
