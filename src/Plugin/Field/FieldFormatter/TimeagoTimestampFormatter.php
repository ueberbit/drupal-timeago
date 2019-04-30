<?php

namespace Drupal\timeago\Plugin\Field\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\TimestampFormatter;

/**
 * Plugin implementation of the 'timeago_timestamp' formatter.
 *
 * @FieldFormatter(
 *   id = "timeago_timestamp",
 *   label = @Translation("Timeago.js"),
 *   field_types = {
 *     "timestamp",
 *     "created",
 *     "changed",
 *   }
 * )
 */
class TimeagoTimestampFormatter extends TimestampFormatter {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $date_format = $this->getSetting('date_format');
    $custom_date_format = '';
    $timezone = $this->getSetting('timezone') ?: NULL;
    $langcode = NULL;

    // If an RFC2822 date format is requested, then the month and day have to
    // be in English. @see http://www.faqs.org/rfcs/rfc2822.html
    if ($date_format === 'custom' && ($custom_date_format = $this->getSetting('custom_date_format')) === 'r') {
      $langcode = 'en';
    }

    foreach ($items as $delta => $item) {
      $iso_date = $this->dateFormatter->format($item->value, 'custom', "Y-m-d\TH:i:s", 'UTC', $langcode) . 'Z';

      $elements[$delta] = [
        '#theme' => 'time',
        '#text' => $this->dateFormatter->format($item->value, $date_format, $custom_date_format, $timezone, $langcode),
        '#html' => FALSE,
        '#attributes' => [
          'datetime' => $iso_date,
          'class' => [
            'timeago'
          ]
        ],
        '#attached' => [
          'library' => [
            'timeago/timeago',
            'timeago/timeago.locale.de'
          ],
          'drupalSettings' => [
            'timeago' => [
              'cutoff' => 1000 * 60 * 60 * 24 * 2 // two days.
            ]
          ]
        ],
        '#cache' => [
          'contexts' => [
            'timezone',
          ],
        ],
      ];
    }

    return $elements;
  }

}
