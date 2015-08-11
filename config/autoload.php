<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Email_voting
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'HeimrichHannot\EmailVoting\ModuleEmailVotingActivation' => 'system/modules/email_voting/modules/ModuleEmailVotingActivation.php',

	// Classes
	'HeimrichHannot\EmailVoting\EmailVoting'                 => 'system/modules/email_voting/classes/EmailVoting.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_emailvoting_activation' => 'system/modules/email_voting/templates',
));
