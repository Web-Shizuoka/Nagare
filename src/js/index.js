import jQuery from "jquery";
const $ = jQuery;

$(function(){
    $('dt').click(function(){
      $(this).next('dd').slideToggle();
      $(this).next('dd').toggleClass('is-open');
    });
});