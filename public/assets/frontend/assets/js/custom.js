$(document).ready(function(){
    $('.marquee ul').on('mouseover', function() {
      $(this).css('animation-play-state', 'paused');
    });
  
    $('.marquee ul').on('mouseout', function() {
      $(this).css('animation-play-state', 'running');
    });
  });
  