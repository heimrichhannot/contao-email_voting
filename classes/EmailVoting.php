<?php

namespace HeimrichHannot\EmailVoting;

class EmailVoting extends \Frontend
{

	public function validateVotingEmailFormField(\Widget $objWidget, $intId)
	{
		if (($objForm = \FormModel::findBy('alias', str_replace('auto_', '', $intId))) !== null && $objForm->maxVoteCount)
		{
			// check if a voting from the mail address already exists
			$db = \Database::getInstance();
				
			$objEmailCheck =
				$db->prepare('SELECT * FROM tl_formdata_details fdt INNER JOIN tl_formdata fd ON fdt.pid=fd.id INNER JOIN tl_form f ON fd.form=f.title WHERE fdt.ff_name=? AND fdt.value=? AND f.alias=?')
				->execute('email', $objWidget->value, $objForm->alias);
				
			if ($objEmailCheck->numRows > 0 && $objEmailCheck->numRows >= $objForm->maxVoteCount)
			{
				$objWidget->addError(sprintf($GLOBALS['TL_LANG']['email_voting']['maxVoteCount'], $objForm->maxVoteCount));
			}
		}
		return $objWidget;
	}
	
	public function generateTokenLink($arrToSave, &$arrFiles, $intOldId, &$arrForm, $arrLabels)
	{
		$this->arrSubmitted = $arrToSave;
		
		// generate token & token link
		if (($objForm = \FormModel::findByPk($arrForm['id'])) !== null && ($objPageActivation = \PageModel::findByPk($objForm->jumpTo_activation)) !== null)
		{
			$strToken = md5(uniqid(mt_rand(), true));
			$this->arrSubmitted[$objForm->formFieldToken] = $strToken;
			
			$strTokenLink = rtrim(\Environment::get('base'), '/') . '/' . $this->generateFrontendUrl($objPageActivation->row()) . '?token=' . $strToken . '&vid=' . $arrForm['id'];
			$this->arrSubmitted[$objForm->formFieldTokenLink] = $strTokenLink;
		}
		
		// add recipient if field's been checked
		if ($this->arrSubmitted[$objForm->formFieldNewsletter] == 'yes' && $this->arrSubmitted['email'])
			$this->addRecipient($this->arrSubmitted['email'], deserialize($objForm->newsletters, true), $objForm->newsletterSubscribeMailText, $objForm->newsletterSubscribeJumpTo);
		
		return $this->arrSubmitted;
	}
	
	private function addRecipient($email, $arrChannels, $strMailText, $intJumpTo) {
		$varInput = \Idna::encodeEmail($email);
	
		// Get the existing active subscriptions
		$arrSubscriptions = array();
		if (($objSubscription = \NewsletterRecipientsModel::findBy(array("email=? AND active=1"), $varInput)) !== null)
		{
			$arrSubscriptions = $objSubscription->fetchEach('pid');
		}
	
		$arrNew = array_diff($arrChannels, $arrSubscriptions);
	
		// Return if there are no new subscriptions
		if (!is_array($arrNew) || empty($arrNew))
			return;
	
		// Remove old subscriptions that have not been activated yet
		if (($objOld = \NewsletterRecipientsModel::findBy(array("email=? AND active=''"), $varInput)) !== null)
		{
			while ($objOld->next())
			{
				$objOld->delete();
			}
		}
	
		$time = time();
		$strToken = md5(uniqid(mt_rand(), true));
	
		// Add the new subscriptions
		foreach ($arrNew as $id)
		{
			$objRecipient = new \NewsletterRecipientsModel();
	
			$objRecipient->pid = $id;
			$objRecipient->tstamp = $time;
			$objRecipient->email = $varInput;
			$objRecipient->active = '';
			$objRecipient->addedOn = $time;
			$objRecipient->ip = $this->anonymizeIp(\Environment::get('ip'));
			$objRecipient->token = $strToken;
			$objRecipient->confirmed = '';
	
			$objRecipient->save();
		}
	
		// Get the channels
		$objChannel = \NewsletterChannelModel::findByIds($arrChannels);
	
		// Prepare the e-mail text
		$strText = str_replace('##token##', $strToken, $strMailText);
		$strText = str_replace('##domain##', \Environment::get('host'), $strText);
		//$strText = str_replace('##link##', \Environment::get('base') . \Environment::get('request') . (($GLOBALS['TL_CONFIG']['disableAlias'] || strpos(\Environment::get('request'), '?') !== false) ? '&' : '?') . 'token=' . $strToken, $strText);
		$objPageConfirm = \PageModel::findByPk($intJumpTo);
		if ($objPageConfirm === null)
			$this->log('Newsletter confirmation page not found, id: ' . $intJumpTo, __CLASS__ . ":" . __METHOD__, TL_NEWSLETTER);
		$strText = str_replace('##link##', rtrim(\Environment::get('base'), '/') . '/' . $this->generateFrontendUrl($objPageConfirm->row()) . '?token=' . $strToken, $strText);
		$strText = str_replace(array('##channel##', '##channels##'), implode("\n", $objChannel->fetchEach('title')), $strText);
	
		// Activation e-mail
		$objEmail = new \Email();
		$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
		$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
		$objEmail->subject = sprintf($GLOBALS['TL_LANG']['MSC']['nl_subject'], \Environment::get('host'));
		$objEmail->text = $strText;
		$objEmail->sendTo($varInput);
	}

}