<?php namespace Kloos\Saas\Classes\Helper;

use System\Classes\PluginManager;
use October\Rain\Support\Traits\Singleton;

class ResolverHelper
{
    use Singleton;

    protected $resolvers = [];

    public function init()
    {
        // Loop through all the resolvers available
        $this->registerResolvers();
    }

    protected function registerResolver($resolver)
    {
        if (!in_array($resolver, $this->resolvers)) {
            $this->resolvers[] = $resolver;
        }
    }

    protected function registerResolvers()
    {
        foreach (PluginManager::instance()->getAllPlugins() as $code => $plugin) {
            if (method_exists($plugin, 'registerResolvers')) {
                $resolvers = $plugin->registerResolvers();

                foreach ($resolvers as $resolver) {
                    $this->registerResolver($resolver);
                }
            }
        }
    }

    public function getOptions()
    {
        $options = [];

        foreach ($this->resolvers as $resolver) {
            $options[$resolver] = $resolver;
        }

        return $options;
    }
}