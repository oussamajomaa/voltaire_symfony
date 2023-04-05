let links = document.querySelectorAll('.delete-button')
links.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault()
        console.log(e.target.href)
        document.querySelector('.myModal').style.display = 'block'
        document.querySelector('.confirm-delete').addEventListener('click', () => {
            fetch(e.target.href)
        })
    })
})

