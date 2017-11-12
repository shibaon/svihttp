<?php
namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\HttpBundle\BundleTrait;
use Svi\HttpBundle\Forms\Form;

class FormService extends AppContainer
{
    use BundleTrait;

	public function createForm(array $parameters = [])
	{
		return new Form($this->app, $parameters);
	}

} 