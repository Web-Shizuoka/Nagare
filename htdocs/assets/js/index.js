"use strict";

/* ===================================================
  // �n���o�[�K�[���j���[
==================================================== */
const mobile_menu_btn = document.getElementById('mobile_menu_btn');
const main_contents = document.getElementById('main_contents');
const mobile_menu = document.getElementById('mobile_menu');
const modal_overlay = document.getElementById('modal_overlay');
mobile_menu_btn.addEventListener('click', function() {
  mobile_menu_btn.classList.toggle('clicked');
  main_contents.classList.toggle('contents_hide');
  mobile_menu.classList.toggle('contents_show');
  modal_overlay.classList.toggle('modal_overlay');
});

const mobile_menu_click = document.getElementsByClassName('mobile_menu_click');
for( var $i = 0; $i < mobile_menu_click.length; $i++ ) {
  mobile_menu_click[$i].onclick = function () {
    mobile_menu_btn.classList.toggle('clicked');
    main_contents.classList.toggle('contents_hide');
    mobile_menu.classList.toggle('contents_show');
    modal_overlay.classList.toggle('modal_overlay');
  }
}

jQuery(function ($) {
  /* ===================================================
  // Barba setting
  ==================================================== */
  
  Barba.Pjax.Dom.wrapperId = 'ch';
  Barba.Pjax.Dom.containerClass = 'c-ch';
  Barba.Pjax.init();
  Barba.Prefetch.init(); //dispatcher settings
  
  Barba.Pjax.originalPreventCheck = Barba.Pjax.preventCheck;
  Barba.Pjax.preventCheck = function(evt, element) {
    if(element){
      if (!element.getAttribute('href')) {
        return false;
      }
      // �O�������N��target="_blank"��
      var site_url = location.protocol + '//' + location.host;
      if (!element.href.startsWith(site_url)) {
        element.setAttribute('target','_blank');
        return false;
      }
      // �A���J�[�����N�ł��蓯��y�[�W�łȂ����barba��L����
      var url = location.protocol + '//' + location.host + location.pathname;
      var extract_hash = element.href.replace(/#.*$/,"");
      if (element.href.startsWith(location.protocol + '//' + location.host)) {
        if (element.href.indexOf('#') > -1 && extract_hash != url ){
          return true;
        }
      }
      // �g���q���Y������ꍇ��target="_blank"��
      if (/\.(xlsx?|docx?|pptx?|pdf|jpe?g|png|gif|svg)/.test(element.href.toLowerCase())) {
        element.setAttribute('target','_blank');
        return false;
      }
      // �Y���N���X�ɑ����Ă����Barba�𖳌���
      var ignoreClasses = ['ab-item','nagare-no-barba'];
      for (var i = 0; i < ignoreClasses.length; i++) {
        if (element.classList.contains(ignoreClasses[i])) {
          return false;
        }
      }
      if (!Barba.Pjax.originalPreventCheck(evt, element)) {
        return false;
      }
      return true;
    }
  };

  Barba.Dispatcher.on('newPageReady', function (currentStatus, oldStatus, container, newPageRawHTML) {
    //header rewrite
    if (Barba.HistoryManager.history.length === 1) {
      return;
    }

    var head = document.head;
    var newPageRawHead = newPageRawHTML.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0];
    var newPageHead = document.createElement('head');
    newPageHead.innerHTML = newPageRawHead;
    var removeHeadTags = ["meta[name='description']", "meta[property^='og']", "meta[name^='twitter']", "meta[itemprop]", "link[itemprop]", "link[rel='prev']", "link[rel='next']", "link[rel='canonical']"].join(',');
    var headTags = head.querySelectorAll(removeHeadTags);

    for (var i = 0; i < headTags.length; i++) {
      head.removeChild(headTags[i]);
    }

    var newHeadTags = newPageHead.querySelectorAll(removeHeadTags);

    for (var _i = 0; _i < newHeadTags.length; _i++) {
      head.appendChild(newHeadTags[_i]);
    }

    var newPageRawLogo1 = newPageRawHTML.match(/<div id="logo"[^>]*>([\s\S.]*?)<\/div>/i)[1];
    $("#logo").html(newPageRawLogo1);
    
    let gam_opt_divs = ['div-gpt-ad-1572933303259-0', 'div-gpt-ad-1572933415196-0', 'div-gpt-ad-1572933511534-0']; //����������Ă������K�pID���Z�b�g���܂��B
    requestAnimationFrame(function () {
      googletag.cmd.push(function () {
        googletag.pubads().refresh(gptAdSlots); //�L���̍X�V
        for(var opt_div in gam_opt_divs){
          googletag.display(opt_div);  //�L���̍ĕ\��
        }
      });
    });
  }); //unique settings
  
  // call clearAllGAMSlots in linkClicked event
  Barba.Dispatcher.on('linkClicked', function (el) {
    if (!window.googletag) {
      requestAnimationFrame(function () {
        googletag.cmd.push(function () {
           googletag.pubads().clear();
        });
      });
    }
  });
  

  //高橋追記
  //サイドバーの位置追従
  $(window).scroll(function(){
    var scroll =$(window).scrollTop();
    if(scroll >= 80){
      $('.sidebar').addClass('is-fixed');
    } else {
      $('.sidebar').removeClass('is-fixed');
    }
  });

}); // all function
