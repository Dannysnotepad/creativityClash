
const form = document.getElementById('form')
const name = document.getElementById('username')
//const email = document.getElementById('email')
const password = document.getElementById('password')
const submit = document.getElementById('submit')
const nameValidator = '/^[A-Za-z]+$/'
const validate = () => {
  passwordVal = password.value
  nameVal = name.value
  /*if(nameVal.match(nameValidator) === false){
    alert('Name can only contain High and lowercase characters')
    return false
    name.focus()
  }else */if(passwordVal.length < 6 || passwordVal.length > 6){
    alert('Password can\'t be higher or lower than 6 characters')
  }
}


form.addEventListener('onsubmit', (e) => {
  e.preventDefault()
})
submit.addEventListener('click', () => {
  validate()
})