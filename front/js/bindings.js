/* 
 *     File:    bindings.js
 *     Author:  Bob Provencher
 *     Created: Mar 1, 2017
 */

/**
 * Creates an exam DOM element suitable for insertion and returns it
 * @param {type} exam
 * @param {type} onclick
 * @returns {Element|createExamElement.tr}
 */
function createExamElement( exam, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = exam.examId;
    elem.innerHTML = exam.examName;
    elem.onclick = onclick;
    
    td = document.createElement( "td" );
    tr.appendChild( td );
    elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = exam.examId;
    elem.innerHTML = "Release Scores";
    elem.onclick = releaseScores;
    
    return tr;
    
}

function getQuestion( questionId ) {
    return questions.find( function( elem ) {
        return elem.questionId === questionId;
    });
}

function createExamQuestionElement( examquestion, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    tr.appendChild( td );
    var elem = document.createElement( "a" );
    td.appendChild( elem );
    elem.href = "#";
    elem.id = examquestion.questionId;
    elem.innerHTML = getQuestion( examquestion.questionId ).functionName;
    elem.onclick = onclick;
    
    return tr;
    
}

function getFunctionSignature( question ) {
    
    var parms = [ question.argument1, question.argument2, question.argument3, question.argument4 ];
    var sig = "";
    
    var i = 1;
    
    parms.forEach( function( parm ) {
       if ( parm !== null && parm.length > 0 ) {
           if ( sig !== "" ) {
               sig = sig + ", ";
           }
           sig = sig + parm + " arg" + i;
           i++;
       } 
    });

    return  question.returnType + " " + question.functionName +  "( " + sig + " )";

}

function getQuestionTraits( question ) {
    
    var sig = "";
    
    var has = [ "If", "While", "For", "Recursion" ];
    
    has.forEach( function( h ) {
        var propName = "has" + h;
        var value = question[ propName ];
        if ( value != false ) {
            if ( sig !== "" ) {
                sig = sig + ", ";
            }
            sig = sig + h.toLowerCase();
        }
    });
    
    var diffs = [ "Easy", "Medium", "Hard" ];
    
    var diff = diffs[ question.difficulty ];
    
    if ( sig !== "" ) {
        sig = sig + ", ";
    }
    
    sig = sig + diff;
    
    return sig;
    
}

function createQuestionElement( question, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    var elem = document.createElement( "a" );
    elem.href = "#";
    elem.id = question.questionId;
    elem.innerHTML = question.functionName;
    elem.onclick = onclick;
    td.appendChild( elem );
    tr.appendChild( td );
    
    td = document.createElement( "td" );
    elem = document.createElement( "label" );
    elem.innerHTML = question.question;
    td.appendChild( elem );
    tr.appendChild( td );
    
    td = document.createElement( "td" );
    elem = document.createElement( "label" );
    elem.innerHTML = getFunctionSignature( question );
    td.appendChild( elem );
    tr.appendChild( td );
    
    td = document.createElement( "td" );
    elem = document.createElement( "label" );
    elem.innerHTML = getQuestionTraits( question );
    td.appendChild( elem );
    tr.appendChild( td );
    
    td = document.createElement( "td" );
    elem = document.createElement( "a" );
    elem.href = "#";
    elem.id = question.questionId;
    elem.innerHTML = "Add to Exam";
    elem.onclick = addToExam;
    td.appendChild( elem );
    tr.appendChild( td );
    
    return tr;
    
}

function createTestcaseSignature( testcase ) {
    
    var args = [ testcase.argument1, testcase.argument2, testcase.argument3, testcase.argument4 ];
    var sig = "";
    
    args.forEach( function( arg ) {
       if ( arg !== null && arg.length > 0 ) {
           if ( sig !== "" ) {
               sig = sig + ", ";
           }
           sig = sig + arg;
       } 
    });

    return  testcase.returnValue + " == function( " + sig + " )";

}

function createTestcaseElement( testcase, onclick ) {
    
    var tr = document.createElement( "tr" );
    
    var td = document.createElement( "td" );
    var elem = document.createElement( "a" );
    elem.href = "#";
    elem.id = testcase.testCaseId;
    elem.innerHTML = createTestcaseSignature( testcase );
    elem.onclick = onclick;
    td.appendChild( elem );
    tr.appendChild( td );
    
    return tr;
    
}

function createAndAddElement( elem, onclick, create, parent ) {
    var domElem = create( elem, onclick );
    parent.appendChild( domElem );
}

function createAndAddElementById( elem, onclick, create, parentId ) {
    var parent = document.getElementById( parentId );
    createAndAddElement( elem, onclick, create, parent );
}

function createAndAddElements( elems, onclick, create, parent ) {
    elems.forEach( function( elem ) {
        createAndAddElement( elem, onclick, create, parent );
    });
};

function createAndAddElementsById( elems, onclick, create, parentId ) {
    var parent = document.getElementById( parentId );
    createAndAddElements( elems, onclick, create, parent );
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
    var parent = document.getElementById( parentId );
    clearElements( parent, tag );
}

function createAndReplaceElementsById( parentId, tag, elems, onclick, create ) {
    var parent = document.getElementById( parentId );
    clearElements( parent, tag );
    createAndAddElements( elems, onclick, create, parent );
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

function formToObjectById( formId ) {
    var form = document.getElementById( formId );
    return formToObject( form );
}
