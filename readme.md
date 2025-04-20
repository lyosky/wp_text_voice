# 文本转语音插件

## 功能概述
- 文章内容语音朗读功能（基于Web Speech API）
- 支持后台控制语音参数：语言、语速、音高、音量
- 自动在文章底部生成播放控制面板
- 支持自定义内容容器CSS类名

## 安装说明
1. 下载插件zip包
2. 进入WordPress后台 → 插件 → 安装插件 → 上传插件
3. 激活插件
4. 进入 设置 → TTS设置 进行参数配置

## 使用说明
在文章内容中自动添加以下控制面板：
```html
<div class="tts-container">
  <div class="tts-controls">
    <button class="tts-play">播放</button>
    <button class="tts-pause">暂停</button>
    <button class="tts-stop">停止</button>
  </div>
</div>
```

## 参数配置指南
1. **默认语言**：设置语音合成语言（如zh-CN）
2. **语速**：0.1（最慢）到10（最快）
3. **音高**：0（最低）到2（最高）
4. **音量**：0（静音）到1（最大）
5. **内容容器Class**：指定需要朗读的内容区域CSS类名

## 浏览器兼容性
✅ Chrome 33+  
✅ Edge 79+  
✅ Safari 7+  
❌ 移动端浏览器部分支持

## 版本记录
### 1.0.0 (2025-4-20)
- 初始发布版本
- 实现基础语音合成功能
- 添加后台控制面板