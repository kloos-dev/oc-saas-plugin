<?php namespace Kloos\Saas\Classes;

class ExtendFormFields
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

            // Extend fields
            $fields = [
                'tenancies' => [
                    'label' => 'Tenancy',
                    'type' => 'relation',
                    'span' => 'left',
                    'permissions' => 'kloos.multitenancy.manage_tenancies',
                ],
            ];

            $formWidget->addFields($fields);
        });
    }
}