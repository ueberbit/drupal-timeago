(function ($) {
  Drupal.behaviors.timeago = {
    attach: function (context, settings) {
      $.extend($.timeago.settings, settings.timeago);
      $('abbr.timeago, span.timeago, time.timeago', context).timeago();
    }
  };
})(jQuery);
