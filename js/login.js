
const form = document.getElementById('form')
const email = document.getElementById('email')
const password = document.getElementById('password')
const submit = document.getElementById('submit')
const validate = () => {
  passwordVal = password.value
  emailVal = email.value
  if(emailVal === '' || emailVal === null){
    alert('Email field can\'t be empty')
    return false
    name.focus()
  }else if(passwordVal === '' || passwordVal === null){
    alert('Password can\'t be empty')
  }
}


form.addEventListener('onsubmit', (e) => {
  e.preventDefault()
})
submit.addEventListener('click', () => {
  validate()
})