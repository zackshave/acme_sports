(function (Drupal) {
  'use strict';

  Drupal.behaviors.slideToggle = {
    attach: function (context) {

      // get all accordion buttons
      let toggles = context.querySelectorAll('.js-accordion-toggle');

      // loop through accordion toggle buttons
      toggles.forEach(function (toggle) {

        // get child unordered list as sibling of current accordion toggle
        let container = toggle.nextElementSibling;

        // listen for click events on accordion toggle
        toggle.addEventListener('click', function () {

          if (!container.classList.contains('open')) {

            // if accordion panel is closed (not open) then close all other panels that may be open
            let openToggles = context.querySelectorAll('.js-accordion-toggle.open');
            openToggles.forEach(function (openToggle) {
              openToggle.classList.remove('open');
              openToggle.setAttribute('aria-expanded', 'false');
              let openContainer = openToggle.nextElementSibling;
              openContainer.style.height = '0px';
              openContainer.addEventListener('transitionend', function () {
                openContainer.classList.remove('open');
              }, {
                once: true
              });
            });

            // if accordion panel is closed (not open) then change it to it's open state
            this.classList.add('open');
            this.setAttribute('aria-expanded', 'true');
            container.classList.add('open');
            container.style.height = 'auto';
            var height = container.clientHeight + 'px';
            container.style.height = '0px';
            setTimeout(function () {
              container.style.height = height;
            }, 0);
          }
          else {

            // if accordion panel is open then change it to it's closed state
            this.classList.remove('open');
            this.setAttribute('aria-expanded', 'false');
            container.style.height = '0px';
            container.addEventListener('transitionend', function () {
              container.classList.remove('open');
            }, {
              once: true
            });
          }
        });
      });
    }
  };
}(Drupal));

