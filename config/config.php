<?php

define('MESSAGE_ERROR', 'error');
define('MESSAGE_WARNING', 'warning');
define('MESSAGE_INFO', 'info');
define('MESSAGE_SUCCESS', 'success');

/**
 * Hooks
 */

$GLOBALS['TL_HOOKS']['processEfgFormData'][] = array('HeimrichHannot\EmailVoting\EmailVoting', 'generateTokenLink');
$GLOBALS['TL_HOOKS']['validateFormField'][] = array('HeimrichHannot\EmailVoting\EmailVoting', 'validateVotingEmailFormField');

/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['emailvoting_activation'] = 'HeimrichHannot\EmailVoting\ModuleEmailVotingActivation';