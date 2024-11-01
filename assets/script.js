setInterval(function(){
  let textarea = document.getElementsByTagName('textarea');
  Array.from(textarea).forEach(function(e){
    if(e.hasAttribute('maxlength')){
      let maxlength = e.getAttribute('maxlength');
      if(e.value.length > maxlength){
        e.value = e.value.substr(0, maxlength);
      }
    }
  });
}, 100);
