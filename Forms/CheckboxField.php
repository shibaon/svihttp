<?php

namespace Svi\HttpBundle\Forms;

class CheckboxField extends Field
{

	public function getTemplate()
	{
		return parent::getTemplate() ? parent::getTemplate() : 'checkbox';
	}

	public function getData()
	{
		return parent::getData() ? true : false;
	}

	public function isRequireSubmit()
	{
		return false;
	}

} 