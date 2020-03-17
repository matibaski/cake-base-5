<?php
declare(strict_types=1);

namespace Cake\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Session;
use Cake\Utility\Inflector;
use Exception;

class ToastComponent extends Component
{

    protected $_defaultConfig = [
        'key' => 'toast',
        'element' => 'default',
        'params' => [],
        'clear' => false,
        'duplicate' => true,
    ];

    public function set($message, array $options = []): void
    {
        $options += (array)$this->getConfig();

        if ($message instanceof Exception) {
            if (!isset($options['params']['code'])) {
                $options['params']['code'] = $message->getCode();
            }
            $message = $message->getMessage();
        }

        if (isset($options['escape']) && !isset($options['params']['escape'])) {
            $options['params']['escape'] = $options['escape'];
        }

        [$plugin, $element] = pluginSplit($options['element']);

        if ($plugin) {
            $options['element'] = $plugin . '.toast/' . $element;
        } else {
            $options['element'] = 'toast/' . $element;
        }

        $messages = [];
        if (!$options['clear']) {
            $messages = (array)$this->getSession()->read('Toast.' . $options['key']);
        }

        if (!$options['duplicate']) {
            foreach ($messages as $existingMessage) {
                if ($existingMessage['message'] === $message) {
                    return;
                }
            }
        }

        $messages[] = [
            'message' => $message,
            'key' => $options['key'],
            'element' => $options['element'],
            'params' => $options['params'],
        ];

        $this->getSession()->write('Toast.' . $options['key'], $messages);
    }

    public function __call(string $name, array $args): void
    {
        $element = Inflector::underscore($name);

        if (count($args) < 1) {
            throw new InternalErrorException('Toast message missing.');
        }

        $options = ['element' => $element];

        if (!empty($args[1])) {
            if (!empty($args[1]['plugin'])) {
                $options = ['element' => $args[1]['plugin'] . '.' . $element];
                unset($args[1]['plugin']);
            }
            $options += (array)$args[1];
        }

        $this->set($args[0], $options);
    }

    protected function getSession(): Session
    {
        return $this->getController()->getRequest()->getSession();
    }
}
