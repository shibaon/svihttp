<?php

namespace Svi\HttpBundle\Validators;

class Email extends Validator
{

	protected function isValueValid($value)
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL);
	}

} 