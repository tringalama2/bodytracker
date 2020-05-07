
/*
function showModal(selector) {
  $(selector).addClass('is-active');
}
function hideModal(selector) {
  $(selector).removeClass('is-active');
}
*/

document.querySelector('#open-modal').addEventListener('click', function(event) {
  event.preventDefault();
  var modal = document.querySelector('.modal');  // assuming you have only 1
  var html = document.querySelector('html');
  modal.classList.add('is-active');
  html.classList.add('is-clipped');

  modal.querySelector('.modal-background').addEventListener('click', function(e) {
    e.preventDefault();
    modal.classList.remove('is-active');
    html.classList.remove('is-clipped');
  });

  modal.querySelector('.modal-cancel').addEventListener('click', function(e) {
    e.preventDefault();
    modal.classList.remove('is-active');
    html.classList.remove('is-clipped');
  });
});

$(function() {
console.log( "ready!" );

});
