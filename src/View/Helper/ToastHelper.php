<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;

use Cake\View\Helper;
use UnexpectedValueException;

/**
 * ToastHelper class to render toast messages.
 *
 * After setting messages in your controllers with ToastComponent, you can use
 * this class to output your toast messages in your views.
 */
class ToastHelper extends Helper
{
    /**
     * Used to render the message set in ToastComponent::set()
     *
     * In your template file: $this->Toast->render('somekey');
     * Will default to toast if no param is passed
     *
     * You can pass additional information into the toast message generation. This allows you
     * to consolidate all the parameters for a given type of toast message into the view.
     *
     * ```
     * echo $this->Toast->render('toast', ['params' => ['name' => $user['User']['name']]]);
     * ```
     *
     * This would pass the current user's name into the toast message, so you could create personalized
     * messages without the controller needing access to that data.
     *
     * Lastly you can choose the element that is used for rendering the toast message. Using
     * custom elements allows you to fully customize how toast messages are generated.
     *
     * ```
     * echo $this->Toast->render('toast', ['element' => 'my_custom_element']);
     * ```
     *
     * If you want to use an element from a plugin for rendering your toast message
     * you can use the dot notation for the plugin's element name:
     *
     * ```
     * echo $this->Toast->render('toast', [
     *   'element' => 'MyPlugin.my_custom_element',
     * ]);
     * ```
     *
     * If you have several messages stored in the Session, each message will be rendered in its own
     * element.
     *
     * @param string $key The [Toast.]key you are rendering in the view.
     * @param array $options Additional options to use for the creation of this toast message.
     *    Supports the 'params', and 'element' keys that are used in the helper.
     * @return string|null Rendered toast message or null if toast key does not exist
     *   in session.
     * @throws \UnexpectedValueException If value for toast settings key is not an array.
     */
    public function render(string $key = 'toast', array $options = []): ?string
    {
        $session = $this->_View->getRequest()->getSession();

        if (!$session->check("Toast.$key")) {
            return null;
        }

        $toast = $session->read("Toast.$key");
        if (!is_array($toast)) {
            throw new UnexpectedValueException(sprintf(
                'Value for toast setting key "%s" must be an array.',
                $key
            ));
        }
        $session->delete("Toast.$key");

        $out = '';
        foreach ($toast as $message) {
            $message = $options + $message;
            $out .= $this->_View->element($message['element'], $message);
        }

        return $out;
    }

    /**
     * Event listeners.
     *
     * @return array
     */
    public function implementedEvents(): array
    {
        return [];
    }
}
