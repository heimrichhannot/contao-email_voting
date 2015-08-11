<?php

namespace HeimrichHannot\EmailVoting;

class ModuleEmailVotingActivation extends \Module
{
	protected $strTemplate = 'mod_emailvoting_activation';
	
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
		
			$objTemplate->wildcard = '### EMAIL VOTING AKTIVIERUNG ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;
		
			return $objTemplate->parse();
		}
		
		return parent::generate();
	}
	
	public function compile()
	{
		if (($strToken = \Input::get('token')) && ($strVotingId = \Input::get('vid')) && ($objForm = \FormModel::findByPk($strVotingId)) !== null)
		{
			$db = \Database::getInstance();
			
			$objTokenCheck =
				$db->prepare('SELECT * FROM tl_formdata_details fdt INNER JOIN tl_formdata fd ON fdt.pid=fd.id INNER JOIN tl_form f ON fd.form=f.title WHERE fdt.ff_name=? AND fdt.value=? AND f.id=?')
				->limit(1)->execute($objForm->formFieldToken, $strToken, $strVotingId);
			
			if ($objTokenCheck->numRows > 0)
			{
				// check if already activated
				$objTokenCheckActivated =
					$db->prepare('SELECT * FROM tl_formdata_details WHERE ff_name=? AND pid=?')->limit(1)->execute($objForm->formFieldActivated, $objTokenCheck->pid);
				
				if ($objTokenCheckActivated->numRows > 0)
				{
					if ($objTokenCheckActivated->value)
						$this->Template->message = array(MESSAGE_WARNING, $GLOBALS['TL_LANG']['email_voting']['tokenAlreadyUsed']);
					else
					{
						$this->Template->message = array(MESSAGE_SUCCESS, $GLOBALS['TL_LANG']['email_voting']['votingSuccessful']);
						$db->prepare('UPDATE tl_formdata_details SET value=? WHERE ff_name=? AND pid=?')->execute(time(), $objForm->formFieldActivated, $objTokenCheck->pid);
					}
				}
			}
			else
				$this->Template->message = array(MESSAGE_ERROR, $GLOBALS['TL_LANG']['email_voting']['tokenNotFound']);
		}
	}
	
}

?>