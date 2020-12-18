<?php namespace Kloos\Saas\Classes\Extend;

use Event;
use Backend\Widgets\Form;
use Kloos\Saas\Classes\Tenant;

class RelatedModel
{
    public function subscribe()
    {
        Event::listen('backend.form.extendFields', function (Form $formWidget) {
            if ($formWidget->isNested) {
                return;
            }

            $matchedModel = false;

            foreach (Tenant::instance()->getModels() as $model) {
                if ($model instanceof $formWidget->model) {
                    $matchedModel = true;
                }
            }

            if (!$matchedModel) {
                return;
            }

            $fields = [
                'tenants' => [
                    'label' => 'Tenant',
                    'type' => 'relation',
                    'span' => 'left',
                    'permissions' => 'kloos.saas.manage_tenancies',
                ],
            ];

            $formWidget->addFields($fields);
        });
    }
}