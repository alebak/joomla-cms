<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.media
 *
 * @copyright   (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\Fields\Media\Extension;

use Joomla\CMS\Event\CustomFields\BeforePrepareFieldEvent;
use Joomla\CMS\Form\Form;
use Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin;
use Joomla\Event\SubscriberInterface;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Fields Media Plugin
 *
 * @since  3.7.0
 */
final class Media extends FieldsPlugin implements SubscriberInterface
{
    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   5.3.0
     */
    public static function getSubscribedEvents(): array
    {
        return array_merge(parent::getSubscribedEvents(), [
            'onCustomFieldsBeforePrepareField' => 'beforePrepareField',
        ]);
    }

    /**
     * Transforms the field into a DOM XML element and appends it as a child on the given parent.
     *
     * @param   \stdClass    $field   The field.
     * @param   \DOMElement  $parent  The field node parent.
     * @param   Form         $form    The form.
     *
     * @return  ?\DOMElement
     *
     * @since   4.0.0
     */
    public function onCustomFieldsPrepareDom($field, \DOMElement $parent, Form $form)
    {
        $fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

        if (!$fieldNode) {
            return $fieldNode;
        }

        $fieldNode->setAttribute('type', 'accessiblemedia');

        if ($this->getApplication()->getIdentity()->authorise('core.create', 'com_media')) {
            $fieldNode->setAttribute('disabled', 'false');
        }

        return $fieldNode;
    }

    /**
     * Before prepares the field value.
     *
     * @param   BeforePrepareFieldEvent $event    The event instance.
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function beforePrepareField(BeforePrepareFieldEvent $event): void
    {
        $field = $event->getField();

        // Check if the field should be processed by us
        if (!$this->isTypeSupported($field->type)) {
            return;
        }

        // Check if the field value is an old (string) value
        $field->value = $this->checkValue($field->value);
    }

    /**
     * Before prepares the field value.
     *
     * @param   string  $value  The value to check.
     *
     * @return  array  The checked value
     *
     * @since   4.0.0
     */
    private function checkValue($value)
    {
        json_decode($value);

        if (json_last_error() === JSON_ERROR_NONE) {
            return (array) json_decode($value, true);
        }

        return ['imagefile' => $value, 'alt_text' => ''];
    }
}
