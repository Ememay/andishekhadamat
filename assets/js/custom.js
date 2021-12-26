/*delete button for dashboard*/
if (document.querySelector('body').classList.contain = 'dashboard') {



    /*calls*/

    let callDeleteButton = document.querySelectorAll('.call-Delete-Button');
    callDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از حذف "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })


    /*performers*/
    let performerDeleteButton = document.querySelectorAll('.perfomer-delete-button');
    performerDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از حذف "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })
}




/*delete button for calls*/
if (document.querySelector('body').classList.contain = 'calls') {

    let callDeleteButton = document.querySelectorAll('.call-delete-button');
    callDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از حذف "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })
}




/*delete button for performers*/
if (document.querySelector('body').classList.contain = 'performers') {

    let performerDeleteButton = document.querySelectorAll('.performer-delete-button');
    performerDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از حذف "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })
}



/*delete button for services*/
if (document.querySelector('body').classList.contain = 'services') {

    let serviceDeleteButton = document.querySelectorAll('.service-delete-button');
    serviceDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از حذف "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })
}


/*toggle password in setting*/
if (document.querySelector('body').classList.contain = 'setting') {
    function togglepass() {
        var x = document.getElementById("pasword-input");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
}



/*recycle-button*/
if (document.querySelector('body').classList.contain = 'trashbin') {

    let serviceDeleteButton = document.querySelectorAll('.recycle-button');
    console.log(serviceDeleteButton);

    serviceDeleteButton.forEach(btn => {
        btn.addEventListener('click', (b) => {
            console.log('fds');
            let name = b.target.getAttribute('data-name');
            let yesOrNo = confirm(' از بازگرداندن "' + name + '" مطمعن هستید ؟ ');
            if (yesOrNo == true) {
                let deletePath = b.target.getAttribute('href');
                window.location.href = deletePath;
            }
        })
    })
}