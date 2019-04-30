<?php

namespace Drupal\timeago\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\datetime\Plugin\Field\FieldFormatter\DateTimeDefaultFormatter;

/**
 * Plugin implementation of the 'Default' formatter for 'datetime' fields.
 *
 * @FieldFormatter(
 *   id = "timeago_default",
 *   label = @Translation("Timeago.js"),
 *   field_types = {
 *     "datetime"
 *   }
 * )
 */
class TimeagoFormatter extends DateTimeDefaultFormatter {

  protected function buildDateWithIsoAttribute(DrupalDateTime $date) {
    $build = parent::buildDateWithIsoAttribute($date);
    $build['#attributes']['class'][] = 'timeago';
    $build['#attached']['library'][] = 'timeago/timeago';
    $build['#attached']['library'][] = 'timeago/timeago.locale.de';
    $build['#attached']['drupalSettings']['timeago'] = [
      'cutoff' => 1000 * 60 * 60 * 24 * 2 // two days.
    ];
    return $build;
  }

}
