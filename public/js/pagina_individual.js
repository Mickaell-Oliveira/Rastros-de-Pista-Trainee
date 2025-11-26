document.addEventListener('DOMContentLoaded', () => {
    const interactiveButtons = document.querySelectorAll('.Interacoes button:nth-child(-n+3)');

    const likeButton = document.querySelector('.Interacoes button:nth-child(1)');
    const dislikeButton = document.querySelector('.Interacoes button:nth-child(2)');
    
    const colorClasses = ['color-green', 'color-red', 'color-yellow', 'color-white'];
    let colorIndex = 0; 
    function resetIcon(button) {
        const icon = button.querySelector('i');
        colorClasses.forEach(c => icon.classList.remove(c));
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
    }

    interactiveButtons.forEach(button => {
        button.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const isColored = colorClasses.some(c => icon.classList.contains(c));

        this.classList.remove('clicked');
        setTimeout(() => {
            this.classList.add('clicked');
         }, 10);

         if (isColored) {

             resetIcon(this);
         } else {

              if (this === likeButton && dislikeButton.querySelector('i').classList.contains('fa-solid')) {

                   resetIcon(dislikeButton);
            } else if (this === dislikeButton && likeButton.querySelector('i').classList.contains('fa-solid')) {
                resetIcon(likeButton);
             }

            const currentColorClass = colorClasses[colorIndex];
                
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');

             icon.classList.add(currentColorClass);
             colorIndex = (colorIndex + 1) % colorClasses.length;
        }
      });
 });
});