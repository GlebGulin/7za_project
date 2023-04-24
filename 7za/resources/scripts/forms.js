/* 
 * 14.09.2003 ralf kramer <rk@belisar.de>
 * A collection of functions for validating html form contents
 *
 */

 
/**
 * Throws an alert if any of the mandatory field is empty
 *
 * The param mandatory_fields contains the id's of all mandatory fields.
 *
 * @author  Ralf Kramer
 * @param   string  mandatory_fields:  a list of mandatory form fields seperated by a whitespace
 * @return  boolean
 */
function hasEmptyFields( mandatory_fields, check_passwords, message )
{ 
    if( check_passwords )
        if( hasInvalidPasswords() )
            return true;
    
    field_array = mandatory_fields.split( " ");
    empty_fields = "";
    for( i = 0; i < field_array.length; i++ )
    {
        var field = document.getElementById( field_array[i] );
        if( field.value == "" )
        {
            field.style.border = '1px dotted red';
            empty_fields = empty_fields + field_array[i];
        }
        else
            field.style.border = '1px dotted green';  
    }    
    
    if( empty_fields.length > 2 )
    {
        alert( message );
        return true;
    }
    
    return false;
}

function hasInvalidPasswords()
{
    var password            = document.getElementById( 'password' );
    var confirm_password    = document.getElementById( 'confirm_password' );
    
    if( password.value != confirm_password.value  )
    {
        password.style.border           = '1px dotted red';
        confirm_password.style.border   = '1px dotted red';
        
        alert( 'Die Passwörter stimmen nicht überein' );
        return true;
    }    
    
    return false;
   
}

function isNumber( element )
{
    element = document.getElementById( element );
    
    if( element.value.match( '^[0-9]*$' ) == null )
    {
        this.isShown = true
        alert( 'Bitte geben Sie hier nur Zahlen ein.\n Andere Zeichen oder Buchstaben können nicht verarbeitet werden' );
        
        element.style.border    = '1px dotted red';
        element.value           = '';
        element.focus();
    }
    else
    {
        if( this.isShown )
            msisdn.style.border = '1px dotted green';
    }
}

function redirect( url )
{
    window.location.href = url;
}

function confirmDelete( url, question )
{
    if( confirm( question ) )
        window.location.href = url;
}