<?php

$dca = &$GLOBALS['TL_DCA']['tl_form'];

$dca['palettes']['default'] = str_replace('allowTags', 'allowTags,addVoting', $dca['palettes']['default']);
$dca['palettes']['__selector__'][] = 'addVoting';
$dca['subpalettes']['addVoting'] = 'jumpTo_activation,maxVoteCount,formFieldActivated,formFieldToken,formFieldTokenLink,formFieldNewsletter,newsletters,newsletterSubscribeMailText,newsletterSubscribeJumpTo';

$dca['fields']['addVoting'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['addVoting'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$dca['fields']['jumpTo_activation'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['jumpTo_activation'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('mandatory'=>true, 'fieldType'=>'radio', 'tl_class' => 'clr long'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
);

$dca['fields']['maxVoteCount'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['maxVoteCount'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'default'				  => '0',
	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'rgxp' => 'digit', 'tl_class' => 'w50'),
	'sql'                     => "varchar(255) NOT NULL default '0'"
);

$dca['fields']['formFieldActivated'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['formFieldActivated'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'eval'					  => array('mandatory'=>true, 'tl_class' => 'w50', 'includeBlankOption' => true),
	'sql'                     => "varchar(255) NOT NULL default ''",
	'options_callback'		  => array('tl_email_voting_form', 'getFormFields')
);

$dca['fields']['formFieldToken'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['formFieldToken'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'eval'					  => array('mandatory'=>true, 'tl_class' => 'w50', 'includeBlankOption' => true),
	'sql'                     => "varchar(255) NOT NULL default ''",
	'options_callback'		  => array('tl_email_voting_form', 'getFormFields')
);

$dca['fields']['formFieldTokenLink'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['formFieldTokenLink'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'eval'					  => array('mandatory'=>true, 'tl_class' => 'w50', 'includeBlankOption' => true),
	'sql'                     => "varchar(255) NOT NULL default ''",
	'options_callback'		  => array('tl_email_voting_form', 'getFormFields')
);

$dca['fields']['formFieldNewsletter'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['formFieldNewsletter'],
	'inputType'               => 'select',
	'exclude'                 => true,
	'eval'					  => array('tl_class' => 'w50', 'includeBlankOption' => true),
	'sql'                     => "varchar(255) NOT NULL default ''",
	'options_callback'		  => array('tl_email_voting_form', 'getCheckBoxFormFields')
);

$dca['fields']['newsletters'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['newsletters'],
	'exclude'			=> true,
	'inputType'			=> 'checkboxWizard',
	'options_callback'  => array('Newsletter', 'getNewsletters'),
	'eval'              => array('multiple' => true, 'tl_class' => 'w50 clr'),
	'sql'               => "blob NULL"
);

$dca['fields']['newsletterSubscribeMailText'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['newsletterSubscribeMailText'],
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'                    => array('style'=>'height:120px', 'decodeEntities'=>true, 'alwaysSave'=>true, 'tl_class' => 'clr'),
	'sql'                     => "text NULL"
);

$dca['fields']['newsletterSubscribeJumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form']['newsletterSubscribeJumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array('fieldType' => 'radio'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'",
	'relation'                => array('type'=>'belongsTo', 'load'=>'lazy')
);

class tl_email_voting_form extends Backend {
	
	public function getFormFields() {
		$objFormField = \FormFieldModel::findBy(array('pid=?'), array(\Input::get('id')));
		$arrOptions = array();
		if ($objFormField !== null) {
			while ($objFormField->next()) {
				if ($objFormField->name)
					$arrOptions[] = $objFormField->name;
			}
		}
		return $arrOptions;
	}
	
	public function getCheckBoxFormFields() {
		$objFormField = \FormFieldModel::findBy(array('pid=?', 'type=?'), array(\Input::get('id'), 'checkbox'));
		$arrOptions = array();
		if ($objFormField !== null) {
			while ($objFormField->next()) {
				if ($objFormField->name)
					$arrOptions[] = $objFormField->name;
			}
		}
		return $arrOptions;
	}
	
}