

// console.log('javascript working good');
const btnEditComment = document.querySelectorAll('.edit-button');


btnEditComment.forEach((btn) => {
    btn.addEventListener('click' , () => {
       if(  btn.nextElementSibling.classList.contains('hidden')) {
            btn.nextElementSibling.classList.remove('hidden');
       } else {
            btn.nextElementSibling.classList.add('hidden');
       }
    })
})