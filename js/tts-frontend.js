(function($){
  'use strict';

  $(document).ready(function(){
    // 初始化语音合成对象
    const synth = window.speechSynthesis;
    let utterance = null;
    
    // 获取后台设置参数
    const ttsSettings = window.ttsOptions || {};

    // 控制按钮事件
    $('.tts-play').on('click', function() {
      if (!synth) {
        alert('您的浏览器不支持语音合成功能');
        return;
      }

      const content = $(ttsSettings.content_class).text().trim();

      if (!content) {
        console.log('未找到要播放的内容,请检查配置是否正确.'.ttsSettings.content_class);
        return;
      }

      // 创建新的语音实例
      utterance = new SpeechSynthesisUtterance(content);
      
      // 应用设置参数
      utterance.lang = ttsSettings.lang || 'zh-CN';
      utterance.voiceURI = ttsSettings.voice || '';
      utterance.rate = ttsSettings.rate || 1;
      utterance.pitch = ttsSettings.pitch || 1;
      utterance.volume = ttsSettings.volume || 1;

      // 播放控制
      utterance.onend = function() {
        $('.tts-play').prop('disabled', false);
        $('.tts-pause, .tts-stop').prop('disabled', true);
      };
      synth.speak(utterance);
      $(this).prop('disabled', true);
      $('.tts-pause, .tts-stop').prop('disabled', false);
    });

    $('.tts-pause').on('click', function() {
      if (synth.speaking && !synth.paused) {
        synth.pause();
        $(this).text('继续');
      } else if (synth.paused) {
        synth.resume();
        $(this).text('暂停');
      }
    });

    $('.tts-stop').on('click', function() {
      synth.cancel();
      $('.tts-play').prop('disabled', false);
      $('.tts-pause, .tts-stop').prop('disabled', true);
      $('.tts-pause').text('暂停');
    });

    // 移动端触摸事件支持
    if ('ontouchstart' in window) {
      $('.tts-controls button').css('padding', '12px 20px');
    }
  });
})(jQuery);