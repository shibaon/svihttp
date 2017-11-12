<?php

namespace Svi\HttpBundle\Forms;

class PasswordField extends Field
{

	public function getViewParameters()
	{
		return parent::getViewParameters() + [
			'inputType' => 'password',
		];
	}

} 