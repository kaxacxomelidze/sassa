(function(){
  var iframe = document.createElement('iframe');
  iframe.src = 'http://localhost/sassa/widget';
  iframe.style.position = 'fixed';
  iframe.style.bottom = '20px';
  iframe.style.right = '20px';
  iframe.style.width = '360px';
  iframe.style.height = '480px';
  iframe.style.border = '1px solid #ddd';
  iframe.style.borderRadius = '10px';
  iframe.style.zIndex = '99999';
  document.body.appendChild(iframe);
})();
