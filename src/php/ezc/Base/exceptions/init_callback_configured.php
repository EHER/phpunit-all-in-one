<?php
/**
 * File containing the ezcBaseInitCallbackConfiguredException class
 *
 * @package Base
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcBaseInitCallbackConfiguredException is thrown when you try to assign a
 * callback clasname to an identifier, while there is already a callback class
 * configured for this identifier.
 *
 * @package Base
 * @version //autogen//
 */
class ezcBaseInitCallbackConfiguredException extends ezcBaseException
{
    /**
     * Constructs a new ezcBaseInitCallbackConfiguredException.
     *
     * @param string $identifier
     * @param string $originalCallbackClassName
     */
    function __construct( $identifier, $originalCallbackClassName )
    {
        parent::__construct( "The '{$identifier}' is already configured with callback class '{$originalCallbackClassName}'." );
    }
}
?>
