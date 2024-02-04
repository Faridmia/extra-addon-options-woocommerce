// Get all radio input elements with the specified name
let radioInputs = document.querySelectorAll('input[name="extra_item_fees"]');

radioInputs.forEach(function (radioInput) {
   
    let divElement = document.createElement('div');
    divElement.className = 'eaw-custom-div'; // You can add custom classes if needed
    radioInput.parentNode.insertBefore(divElement, radioInput);
    divElement.appendChild(radioInput);
    let labelElement = document.querySelector('label[for="' + radioInput.id + '"]');
    divElement.appendChild(labelElement);
});

let radioInputs_acc = document.querySelectorAll('input[name="eaw_accessories_fees"]');

// Iterate through each radio input
radioInputs_acc.forEach(function (radioInput) {
    let divElement = document.createElement('div');
    divElement.className = 'eaw-custom-div'; // You can add custom classes if needed
    radioInput.parentNode.insertBefore(divElement, radioInput);
    divElement.appendChild(radioInput);
    let labelElement = document.querySelector('label[for="' + radioInput.id + '"]');
    divElement.appendChild(labelElement);
});


// accordion js
jQuery(document).ready(function($) {
    let $titleTab = $('.eaw_title_tab');
    $('.eaw_accordion_item:eq(0)').find('.eaw_title_tab').addClass('active').next().stop().slideDown(300);
    $titleTab.on('click', function(e) {
    e.preventDefault();
        if ( $(this).hasClass('active') ) {
            $(this).removeClass('active');
            $(this).next().stop().slideUp(500);
            $(this).next().find('p').removeClass('show');
        } else {
            $(this).addClass('active');
            $(this).next().stop().slideDown(500);
            $(this).parent().siblings().children('.eaw_title_tab').removeClass('active');
            $(this).parent().siblings().children('.inner_content').slideUp(500);
            $(this).parent().siblings().children('.inner_content').find('p').removeClass('show');
            $(this).next().find('p').addClass('show');
        }
    });
});

