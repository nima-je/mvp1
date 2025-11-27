(function($){
  // tab switcher
  $('.tab-nav button').on('click', function(){
    const target = $(this).data('target');
    $(this).addClass('active').siblings().removeClass('active');
    $(target).addClass('active').siblings('.tab-panel').removeClass('active');
  });

  // simple countdown
  $('[data-countdown]').each(function(){
    const el = $(this);
    const end = new Date(el.data('countdown')).getTime();
    const timer = setInterval(function(){
      const now = new Date().getTime();
      const distance = end - now;
      if (distance < 0) { clearInterval(timer); el.text('تمام شد'); return; }
      const hours = Math.floor((distance % (1000*60*60*24))/(1000*60*60));
      const minutes = Math.floor((distance % (1000*60*60))/(1000*60));
      const seconds = Math.floor((distance % (1000*60))/1000);
      el.text(hours + 'ساعت ' + minutes + 'دقیقه ' + seconds + 'ثانیه');
    }, 1000);
  });
})(jQuery);
