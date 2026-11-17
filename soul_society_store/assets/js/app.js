document.querySelectorAll('[data-confirm]').forEach(el=>el.addEventListener('click',e=>{if(!confirm(el.dataset.confirm))e.preventDefault()}));
document.querySelectorAll('.quantity-input').forEach(el=>el.addEventListener('change',()=>{if(el.value<1)el.value=1}));
